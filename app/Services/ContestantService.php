<?php
namespace App\Services;

use App\Models\Contestant;

class ContestantService
{

    public function getContestantById(int $id): ?Contestant
    {
        return Contestant::find($id);
    }

    public function createContestant(array $data): Contestant
    {
        return Contestant::create($data);
    }

    public function updateContestant($Contestant, array $data): Contestant
    {
        $Contestant->update($data);
        return $Contestant;
    }
  
    public function destroyById($id)
    {
  
        $Contestant = Contestant::find($id);

        if (! $Contestant) {
            return false;
        }
        return $Contestant->delete(); // Devuelve true si la eliminación fue exitosa
    }

}
