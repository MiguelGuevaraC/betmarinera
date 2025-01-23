<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contestant_win extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id',

        'user_id',
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

    ];

    /**
     * Campos de ordenación disponibles.
     */
    const sorts = [
        'id' => 'desc',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function contest()
    {
        return $this->belongsTo(Contest::class, 'contest_id');
    }

}
