<?php

namespace App\Mail;

use App\Models\Bet;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BetSummaryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userBets;
    public $contest;

    // Constructor para pasar las apuestas del usuario y el concurso
    public function __construct($userBets, $contest)
    {
        $this->userBets = $userBets;
        $this->contest = $contest;
    }

    public function build()
    {
        return $this->subject('Resumen de tus Apuestas')
                    ->view('emails.bet_summary')
                    ->with([
                        'userBets' => $this->userBets,
                        'contest' => $this->contest,
                    ]);
    }
}
