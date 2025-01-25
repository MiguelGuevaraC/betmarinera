<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id',
        'name',
        'description',
        'status',
        'contest_id',
        'contestantwin_id',
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
        'name'        => 'like',
        'description' => 'like',
        'status'      => 'like',
        'contest_id'  => "=",
        "contestant_win.names"=> 'like',
    ];

    /**
     * Campos de ordenación disponibles.
     */
    const sorts = [
        'id'     => 'desc',
        'name'   => 'desc',
        'status' => 'desc',

    ];

    public function contest()
    {
        return $this->belongsTo(Contest::class, 'contest_id');
    }

    public function contestants()
    {
        return $this->hasMany(Contestant::class);
    }
    public function contestant_win()
    {
        return $this->belongsTo(Contestant::class,'contestantwin_id');
    }

    public function bet()
    {
        return Bet::where('user_id', Auth::user()->id)
            ->where('category_id', $this->id) // Usar el ID de la categoría actual
            ->latest('created_at')            // Obtener la última apuesta
            ->first();
    }

}
