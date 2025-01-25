<?php
namespace App\Http\Controllers;

use App\Http\Requests\BetRequest\StoreUpdateBetRequest;
use App\Http\Resources\BetResource;
use App\Services\BetService;
use App\Services\ContestService;
use Illuminate\Http\Request;

class BetController extends Controller
{
    protected $betService;
    protected $contestService;

    public function __construct(BetService $betService, ContestService $contestService)
    {
        $this->betService     = $betService;
        $this->contestService = $contestService;
    }

    public function createupdatebet(StoreUpdateBetRequest $request, $id_bet)
    {
        $validatedData = $request->validated();

        $bet = null;
        if ($id_bet == 'null') {
            $bet = null;
        } else {
            $bet = $this->betService->getBetById($id_bet);
        }
        $bet = $this->betService->createOrUpdateBet($bet, $validatedData);

        return new BetResource($bet);
    }



}
