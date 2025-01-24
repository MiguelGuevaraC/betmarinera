<?php
namespace App\Services;

use App\Models\Contest;

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

}
