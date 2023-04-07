<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdeaDocuments extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'file_path',
        'file_name',
        'idea_id',
    ];

    public function idea()
    {
        return $this->belongsTo(Idea::class);
    }
}
