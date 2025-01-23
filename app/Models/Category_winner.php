<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category_winner extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id',
        'status',
        'contest_id',
        'contestant_id',
        'category_id',
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

    ];

    /**
     * Campos de ordenación disponibles.
     */
    const sorts = [
        'id' => 'desc',
        'status' => 'desc',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function contest()
    {
        return $this->belongsTo(Contest::class, 'contest_id');
    }
    public function contestant()
    {
        return $this->belongsTo(Contestant::class, 'contestant_id');
    }
}
