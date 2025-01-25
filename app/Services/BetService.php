<?php
namespace App\Services;

use App\Models\Bet;
use Illuminate\Support\Facades\Auth;

class BetService
{

    public function getBetById(int $id): ?Bet
    {
        return Bet::find($id);
    }

    public function createBet(array $data): Bet
    {
        return Bet::create($data);
    }

    public function updateBet($Bet, array $data): Bet
    {
        $Bet->update($data);
        return $Bet;
    }

    public function createOrUpdateBet($Bet, array $data): Bet
    {
        // Validar los datos de entrada

        // Usamos updateOrCreate para manejar tanto la creación como la actualización de forma eficiente
        $bet = Bet::updateOrCreate(
            [
                'user_id'     => Auth::user()->id,
                'category_id' => $data['category_id'],
            ],
            [
                'contestant_id' => $data['contestant_id'],
            ]
        );
        

        
        return $bet;
    }

    public function destroyById($id)
    {
        $Bet = Bet::find($id);

        if (! $Bet) {
            return false;
        }
        return $Bet->delete(); // Devuelve true si la eliminación fue exitosa
    }

}
