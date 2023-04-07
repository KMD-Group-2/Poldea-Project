<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    public function staffs()
    {
        return $this->hasMany(Staff::class);
    }

    public function ideas()
    {
        return $this->hasMany(Idea::class,'publisher_department_id','id');
    }

    public function scopeFilterWithCount($query, $filters = [])
    {
        return $query->whereHas(
            'ideas', function ($q) use ($filters) {
                $q->where('posted_at','!=',null)
                ->when(!isset($filters['a']), function ($subq) {
                    AcademicYear::whereDate('final_closure_date', '>=', Carbon::now())->latest()->first() ?
                    $subq->where('academic_year_id', AcademicYear::whereDate('final_closure_date', '>=', Carbon::now())->latest()->first()->id) :
                    $subq->whereHas('academic_year', function ($tq) {
                        $tq->where('final_closure_date', '>=', Carbon::now());
                    });
                })
                ->when(isset($filters['a']) && $filters['a'] != null, function ($subq) use ($filters) {
                    $subq->whereHas('academic_year', function ($tq) use ($filters) {
                        $tq->where('academic_year', urldecode($filters['a']))->where('final_closure_date', '>=', Carbon::now());
                    });
                });
            }
        )->withCount([
            'ideas' => function ($q) use ($filters) {
                $q->where('posted_at','!=',null)
                ->when(!isset($filters['a']), function ($subq) {
                    AcademicYear::whereDate('final_closure_date', '>=', Carbon::now())->latest()->first() ?
                    $subq->where('academic_year_id', AcademicYear::whereDate('final_closure_date', '>=', Carbon::now())->latest()->first()->id) :
                    $subq->whereHas('academic_year', function ($tq) {
                        $tq->where('final_closure_date', '>=', Carbon::now());
                    });
                })
                ->when(isset($filters['a']) && $filters['a'] != null, function ($subq) use ($filters) {
                    $subq->whereHas('academic_year', function ($tq) use ($filters) {
                        $tq->where('academic_year', urldecode($filters['a']))->where('final_closure_date', '>=', Carbon::now());
                    });
                });
            }
        ])
        ->get();
    }
}
