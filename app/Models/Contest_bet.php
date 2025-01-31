<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contest_bet extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id',
        'user_id',
        'contest_id',

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

        'user_id'            => '=',
        'contest_id'         => '=',

        'contest.name'       => 'like',
        'contest.created_at' => 'like',
        'contest.status'       => 'like',
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
