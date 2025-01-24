<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contest extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id',
        'name',
        'start_date',
        'end_date',
        'status',
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
        'name' => 'like',
        'start_date' => 'between',
        'status' => 'like',

    ];

    /**
     * Campos de ordenación disponibles.
     */
    const sorts = [
        'id' => 'desc',
        'name' => 'desc',
        'status' => 'desc',
       
    ];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
    public function contestants()
    {
        return $this->hasMany(Contestant::class);
    }
 
}
