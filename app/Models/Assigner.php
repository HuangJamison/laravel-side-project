<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assigner extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'is_deleted',
        'deleted_at',
        'updated_at',
        'created_at',
    ];

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $dates = ['updated_at', 'created_at'];

    public function todos() {
        return $this->hasMany(Todo::class);
    }
}
