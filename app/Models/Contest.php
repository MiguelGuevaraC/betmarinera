<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

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
        'name'       => 'like',
        'start_date' => 'between',
        'status'     => 'like',

    ];

    /**
     * Campos de ordenación disponibles.
     */
    const sorts = [
        'id'     => 'desc',
        'name'   => 'desc',
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

    public function consultarstatusByUser(): string
    {
        $contestBet = Contest_bet::where('contest_id', $this->id)
            ->where('user_id', Auth::user()->id)
            ->first();
        $status = '';
        if ($contestBet) {
            $status = 'Apuesta Confirmada';
        } else {
            $status = 'Apuesta No Confirmada';
        }
        return $status;
    }
}
