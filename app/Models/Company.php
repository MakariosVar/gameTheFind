<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public function getOriginalLogo($id)
    {
        if (!empty($logo = Image::where(['image_type' => Image::COMPANY_IMAGE])->where(['object_id' => $id])->get()->toArray())) {
            return $logo;
        } else {
            return "";
        }
    }
    public function getUnamedLogo($id)
    {
        if (!empty($logo = Image::where(['image_type' => Image::COMPANY_IMAGE])->where(['object_id' => $id])->get())) {
            if ($this->hasNameOnLogo == null) {
                return $logo->toArray();
            } else {
                if ($this->unnamed_logo_id != null) {
                    return Image::find($this->unnamed_logo_id)->toArray();
                }
            }
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
