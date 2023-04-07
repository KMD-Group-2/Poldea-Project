<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staffs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'address',
        'phone',
        'photo',
        'department_id',
        'position_id',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function ideaCount()
    {
        return DB::table('users')
                ->join('ideas', 'ideas.user_id', '=', 'users.id')
                ->whereIn('users.id', $this->users()->pluck('id'))
                ->selectRaw('count(ideas.id) as count')
                ->pluck('count')
                ->sum();
    }

    public function commentCount()
    {
        return DB::table('users')
            ->join('idea_comments','users.id','idea_comments.user_id')
            ->whereIn('users.id', $this->users()->pluck('id'))
            ->selectRaw('count(idea_comments.id) as count')
            ->pluck('count')
            ->sum();
    }
}
