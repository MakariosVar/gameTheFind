<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Category;
use App\Models\Game;

class ApiController extends Controller
{
//  
    //  
        // INITIAL DATA // // // 
    // 
// 
    public function CHANGE () {

    }


//  
    //  
        // GAME MODES // // // 
    // 
// 
    public function random(){
        $games = Game::inRandomOrder()->limit(4)->get();
        $gamesArray = $games->toArray();
        foreach($gamesArray as $key => $game) {
            unset($gamesArray[$key]['updated_at']);            
            unset($gamesArray[$key]['created_at']);            
        }
        foreach ($gamesArray as $key => $game) {
            $gameObj = Game::find($game['id']);
            $gamesArray[$key]['category'] = $gameObj->categoryName();
            unset($gamesArray[$key]['category_id']);   
            
            $gamesArray[$key]['companies'] = $gameObj->getCompanies();
        }
        $selectedGame = array_rand($gamesArray);
        $selected = $gamesArray[$selectedGame]['id'];
        $imageArray = Image::where(['image_type' => Image::GAME_IMAGE])->where(['object_id' => $selected])->get();
        $image = $imageArray[rand(0 , count($imageArray) - 1)]->image_path;
        return response()->json([
            'games' => $gamesArray,
            'selected' => $selected,
            'image' => $image
        ]);
    }
}
