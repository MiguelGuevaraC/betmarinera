<?php
namespace App\Models;

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
        'names'       => 'like',
        'description' => 'like',
        'status'      => 'like',
        'category_id' => '=',
        'contest_id'  => '=',
    ];

    /**
     * Campos de ordenación disponibles.
     */
    const sorts = [
        'id'     => 'desc',
        'names'  => 'desc',
        'status' => 'desc',

    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function consultarstatus($category_id, $user_id, $contestan_id)
    {
        // Consultar en la tabla 'bets' si hay un registro que coincida con los 3 parámetros
        $bet = Bet::where('category_id', $category_id)
                  ->where('user_id', $user_id)
                  ->where('contestant_id', $contestan_id)
                  ->first();
    
        // Si se encuentra una apuesta, retornamos 'True', si no, 'False'
        return $bet ? true : false;
    }
    public function getbet($category_id, $user_id, $contestan_id)
    {
        // Consultar en la tabla 'bets' si hay un registro que coincida con los 3 parámetros
        $bet = Bet::where('category_id', $category_id)
                  ->where('user_id', $user_id)
                  ->where('contestant_id', $contestan_id)
                  ->first();
    
        // Si se encuentra una apuesta, retornamos 'True', si no, 'False'
        return $bet ? $bet : null;
    }
}
