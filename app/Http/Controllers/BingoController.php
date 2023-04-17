<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Card;

class BingoController extends Controller
{
    public function getCards(Request $request)
    {
        $game = Game::where('is_finish', false)->first();

        if(! $game) {
            $game = Game::forceCreate([
                "rolled_numbers" => json_encode([]),
            ]);

            $cards = [];

            foreach (array(1, 2, 3, 4, 5) as $v) {
                Card::forceCreate([
                    "game_id" =>  $game->id,
                    "b" => json_encode($this->generateColumnNumbers(1, 15)),
                    "i" => json_encode($this->generateColumnNumbers(16, 30)),
                    "n" => json_encode($this->generateColumnNumbers(31, 45)),
                    "g" => json_encode($this->generateColumnNumbers(46, 60)),
                    "o" => json_encode($this->generateColumnNumbers(61, 75)),
                ]);
            }

            $game = Game::where('id', $game->id)->first();

        }

        return response()->json([ "data" => $game ], 200);
    }

    public function generateColumnNumbers($min, $max)
    {
        $cols = [];
        $numbers = [];

        foreach (array(1, 2, 3, 4, 5) as $value) {
            do {
                $number = rand($min, $max);
            } while (in_array($number, $numbers));

            array_push($numbers, $number);
            array_push($cols, [
                "number" => $number,
                "position" => $value,
                "is_crossout" => false
            ]);
        }

        return $cols;
    }

    public function rollNumber(Request $request)
    {
        $game = Game::where('is_finish', false)->first();

        $numbers = $game->rolled_numbers;

        do {
            $number = rand(1, 75);
        } while (in_array($number, $numbers));


        array_push($numbers, $number);

        $game->rolled_numbers = json_encode($numbers);
        $game->save();

        return response()->json([
            "data" => [
                "game" => $game,
                "number" => $number,
                "letter" => $this->checkLetter($number)
            ]
        ]);
    }

    public function crossoutNumber(Request $request)
    {
        $card = $request->card_number;
        $number = $request->number;
        $id = $request->id;

        $letter = $this->checkLetter($number);

        $card = Card::where('id', $id)->first();

        $game = Game::where('id', $card->game_id)->first();

        if(! in_array($number, $game->rolled_numbers)) {
            return response()->json("Invalid crossout number.", 422);
        }

        if($letter == 'B') {
            $numbers = array_map(function($arg) use ($number) {
                $arg = (object) $arg;

                if($arg->number == $number) {
                    $arg->is_crossout = true;
                }

                return $arg;
            }, $card->b);

            $numbers = json_encode($numbers);

            $card->b = $numbers;

            $card->save();
        }

        if($letter == 'I') {
            $numbers = array_map(function($arg) use ($number) {
                $arg = (object) $arg;

                if($arg->number == $number) {
                    $arg->is_crossout = true;
                }

                return $arg;
            }, $card->i);

            $numbers = json_encode($numbers);

            $card->i = $numbers;

            $card->save();
        }

        if($letter == 'N') {
            $numbers = array_map(function($arg) use ($number) {
                $arg = (object) $arg;

                if($arg->number == $number) {
                    $arg->is_crossout = true;
                }

                return $arg;
            }, $card->n);

            $numbers = json_encode($numbers);

            $card->n = $numbers;

            $card->save();
        }

        if($letter == 'G') {
            $numbers = array_map(function($arg) use ($number) {
                $arg = (object) $arg;

                if($arg->number == $number) {
                    $arg->is_crossout = true;
                }

                return $arg;
            }, $card->g);

            $numbers = json_encode($numbers);

            $card->g = $numbers;

            $card->save();
        }

        if($letter == 'O') {
            $numbers = array_map(function($arg) use ($number) {
                $arg = (object) $arg;

                if($arg->number == $number) {
                    $arg->is_crossout = true;
                }

                return $arg;
            }, $card->o);

            $numbers = json_encode($numbers);

            $card->o = $numbers;

            $card->save();
        }

        $game = $game->refresh();

        return response()->json($game);
    }

    public function checkLetter($number)
    {
        if($number > 0 && $number <= 15) {
            return 'B';
        }

        if($number > 15 && $number <= 30) {
            return 'I';
        }

        if($number > 30 && $number <= 45) {
            return 'N';
        }

        if($number > 45 && $number <= 60) {
            return 'G';
        }

        if($number > 60 && $number <= 75) {
            return 'O';
        }
    }
}
