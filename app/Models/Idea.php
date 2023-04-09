<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Idea extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'academic_year_id',
        'category_id',
        'user_id',
        'publisher_department_id',
        'title',
        'description',
        'anonymous',
        'posted_at',
        'qa_c_read',
    ];

    public function academic_year()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function publisher_department()
    {
        return $this->belongsTo(Department::class);
    }

    public function comments()
    {
        return $this->hasMany(IdeaComments::class);
    }

    public function documents()
    {
        return $this->hasMany(IdeaDocuments::class);
    }

    public function like_unlikes()
    {
        return $this->hasMany(IdeaLikeUnlike::class);
    }

    public function views()
    {
        return $this->hasMany(IdeaView::class);
    }

    public function scopeIdeaWithFilter($query, $filters = [], $no_filter = false, $user_id = null)
    {
        return $query->when(!isset($filters['a']) && $no_filter == false, function($q) {
                $q->whereHas('academic_year', function ($q) {
                    $q->where('final_closure_date', '>=', Carbon::now());
                });
            })
            ->where('posted_at', '!=', null)
            ->when($user_id != null, function($q) use ($user_id) {
                is_array($user_id) ?
                $q->whereIn('user_id',$user_id) : $q->where('user_id',$user_id);
            })
            ->when(!isset($filters['a']) && $no_filter == false, function($q) {
                $q->whereHas('academic_year', function($subq) {
                    AcademicYear::whereDate('final_closure_date', '>=', Carbon::now())->latest()->first() ?
                    $subq->where('id', AcademicYear::whereDate('final_closure_date', '>=', Carbon::now())->latest()->first()->id) : '';
                });
            })
            ->when(isset($filters['a']) && $filters['a'] != null, function ($subq) use ($filters) {
                $subq->whereHas('academic_year', function ($tq) use ($filters) {
                    $tq->where('academic_year', urldecode($filters['a']));
                });
            })
            ->when(isset($filters['c']) && $filters['c'] != null, function ($subq) use ($filters) {
                $subq->whereHas('category', function ($subq) use ($filters) {
                    $subq->where('name', urldecode($filters['c']));
                });
            })
            ->when(isset($filters['d']) && $filters['d'] != null, function ($subq) use ($filters) {
                $subq->whereHas('publisher_department', function ($subq) use ($filters) {
                    $subq->where('name', urldecode($filters['d']));
                });
            })
            ->when(isset($filters['sortby']) && $filters['sortby'] == 'latest_idea', function ($subq) {
                $subq->orderByDesc('posted_at');
            })
            ->when(isset($filters['sortby']) && $filters['sortby'] == 'most_popular', function ($subq) {
                $subq->select('ideas.*', DB::raw('(SELECT SUM(CASE WHEN like_unlike = 1 THEN 1 WHEN like_unlike = 0 THEN -1 ELSE 0 END) FROM idea_like_unlikes WHERE idea_id = ideas.id) AS popularity_score'))
                    ->orderBy('popularity_score', 'desc');
            })
            ->when(isset($filters['sortby']) && $filters['sortby'] == 'most_viewed', function ($subq) {
                $subq->withCount('views')->orderByDesc('views_count');
            })
            ->when(!isset($filters['sortby']) || $filters['sortby'] == null, function ($subq) {
                $subq->orderByDesc('posted_at');
            });
    }

    public function scopeIdeaReportWithFilter($query, $last_academic_year = null, $filters = [], $department_id = null)
    {
        return $query->where('posted_at', '!=', null)
            ->when($department_id != null, function ($q) use ($department_id) {
                $q->where('publisher_department_id', $department_id);
            })
            ->when(count($filters) == 0, function ($q) use ($last_academic_year) {
                $q->whereHas('academic_year', function($subq) use ($last_academic_year) {
                    $last_academic_year ?
                    $subq->where('id', $last_academic_year->id) : '';
                });
            })
            ->when(count($filters) > 0, function ($q) use ($filters) {
                $q->when(isset($filters['academic_years']), function ($subq) use ($filters) {
                    $subq->whereIn('academic_year_id', $filters['academic_years']);
                })
                    ->when(isset($filters['categories']), function ($subq) use ($filters) {
                        $subq->whereIn('category_id', $filters['categories']);
                    })
                    ->when(isset($filters['departments']), function ($subq) use ($filters) {
                        Auth::user()->hasAnyRole(['Admin','QA Manager']) ? $subq->whereIn('publisher_department_id', $filters['departments']) : '';
                    })
                    ->when(isset($filters['date_range']), function ($subq) use ($filters) {
                        $subq->whereBetween('posted_at', [Carbon::parse(explode('~', $filters['date_range'])[0]), Carbon::parse(explode('~', $filters['date_range'])[1])]);
                    })
                    ->when(isset($filters['status']) && $filters['status'] == 'open', function ($subq) {
                        $subq->whereHas('academic_year', function ($tq) {
                            $tq->whereDate('final_closure_date', '>=', Carbon::now());
                        });
                    })
                    ->when(isset($filters['status']) && $filters['status'] == 'expired', function ($subq) {
                        $subq->whereHas('academic_year', function ($tq) {
                            $tq->whereDate('final_closure_date', '<', Carbon::now());
                        });
                    })
                    ->when(isset($filters['post_type']) && $filters['post_type'] == 'author', function ($subq) {
                        $subq->where('anonymous', 0);
                    })
                    ->when(isset($filters['post_type']) && $filters['post_type'] == 'anonymous', function ($subq) {
                        $subq->where('anonymous', 1);
                    })
                    ->when(isset($filters['idea_without_comment']) && $filters['idea_without_comment'] == 'on', function ($subq) use ($filters) {
                        $subq->whereDoesntHave('comments');
                    });
            })
            ->paginate(10);
    }
}
