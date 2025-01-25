<?php
namespace App\Services;

use App\Models\Bet;
use App\Models\Category;
use App\Models\Contest;
use App\Models\Contest_bet;
use Illuminate\Support\Facades\Auth;

class ContestService
{

    public function getContestById(int $id): ?Contest
    {
        return Contest::find($id);
    }

    public function createContest(array $data): Contest
    {
        return Contest::create($data);
    }

    public function updateContest($Contest, array $data): Contest
    {
        $Contest->update($data);
        return $Contest;
    }

    public function updateContestStatusFinalizado($Contest, array $data): Contest
    {
        $Contest->status = "Finalizado";
        $Contest->save();
        return $Contest;
    }
    public function updateContestStatusActivo($Contest, array $data): Contest
    {
        $Contest->status = "Activo";
        $Contest->save();
        return $Contest;
    }
    public function getCategories(int $id)
    {
        $contest = Contest::find($id);
        if (! $contest) {
            return response()->json([]);
        }
        $categories = $contest->categories()->get()->toArray();
        return response()->json($categories);
    }

    public function destroyById($id)
    {
        $Contest = Contest::find($id);

        if (! $Contest) {
            return false;
        }
        return $Contest->delete(); // Devuelve true si la eliminación fue exitosa
    }

    public function confirmBet($id): Contest
    {
                                          // Buscar las apuestas relacionadas con el ID proporcionado
        $contest    = Contest::find($id); // Asegúrate de que 'Contest' sea el nombre correcto de tu modelo para concursos

        $categories = $contest->categories ?? [];

        $contest_bet= Contest_bet::create([
            "user_id"    => Auth::user()->id,
            "contest_id" => $id,
        ]);
        // Iterar sobre cada apuesta y actualizar el estado a "Confirmado"
        foreach ($categories as $cate) {

            $cat = Category::find($cate->id);
            if ($cate->bet()) {
                $bet         = Bet::find($cat->bet()->id);
                $bet->status = 'Confirmado'; // Asegúrate de tener un campo `status` en tu tabla `bets`
                $bet->contest_bet_id= $contest_bet->id; // Asegúrate de tener un campo `status` en tu tabla `bets`
                $bet->save();
            }
        }

        return $contest;
    }

}
