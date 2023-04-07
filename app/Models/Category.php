<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function ideas()
    {
        return $this->hasMany(Idea::class);
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
                })
                ->when(isset($filters['d']) && $filters['d'] != null, function ($subq) use ($filters) {
                    $subq->whereHas('publisher_department', function ($tq) use ($filters) {
                        $tq->where('name', urldecode($filters['d']));
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
                })
                ->when(isset($filters['d']) && $filters['d'] != null, function ($subq) use ($filters) {
                    $subq->whereHas('publisher_department', function ($tq) use ($filters) {
                        $tq->where('name', urldecode($filters['d']));
                    });
                });
            }
        ])
        ->get();
    }
}
