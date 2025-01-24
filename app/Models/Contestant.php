<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contestant extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id',
        'names',
        'description',
        'status',
        'category_id',
        'contest_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $hidden = [

        'created_at',
        'updated_at',
        'deleted_at',
    ];
    const filters = [
        'names' => 'like',
        'description' => 'like',
        'status' => 'like',
        'category_id' => '=',
        'contest_id' => '=',
    ];

    /**
     * Campos de ordenación disponibles.
     */
    const sorts = [
        'id' => 'desc',
        'names' => 'desc',
        'status' => 'desc',
       
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
