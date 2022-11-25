<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public function getLogo($id)
    {
        if (!empty($logo = Image::where(['image_type' => Image::COMPANY_IMAGE])->where(['object_id' => $id])->get()->toArray())) {
            return $logo;
        } else {
            return "";
        }
    }

    public function games()
    {
        $gamesIds = GamesCompany::where(['company_id' => $this->id])->get();
        $games = [];
        foreach ($gamesIds as $game) {
            $id = $game->game_id;
            $games[] = Game::find($id);
        }
        return $games;
    }
}
