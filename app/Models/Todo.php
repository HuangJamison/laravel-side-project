<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;
        /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'content',
        'assigner',
        'deadline',
        'is_completed',
        'completed_at',
        'is_deleted',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $dates = ['updated_at', 'created_at'];
}
