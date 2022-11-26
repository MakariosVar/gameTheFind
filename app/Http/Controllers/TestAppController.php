<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Game;

class TestAppController extends Controller
{
    public function lose(){
        return view('/testApp/lose');
    }

    public function start(){
        return view('/testApp/start');
    }
    
    public function random() {
        $games = Game::inRandomOrder()->limit(4)->get();
        $gamesArray = $games->toArray();
        $selected = array_rand($gamesArray);
        $view = view("/testApp/random", compact('games', 'selected'));
        
        return $view;
    }

    public function randomApi(){
        $games = Game::inRandomOrder()->limit(4)->get();
        $gamesArray = $games->toArray();
        $selected = array_rand($gamesArray);
        
        return response()->json([
            'games' => $gamesArray,
            'selected' => $selected,
        ]);
    }
}
