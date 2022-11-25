<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    public function categoryName()
    {
        $category = Category::where(['id' => $this->category_id])->get()->toArray();
        return isset($category[0]['name']) ? $category[0]['name'] : [];
    }

    public function getFirstImage()
    {
        $images = Image::where(['image_type' => Image::GAME_IMAGE])->where(['object_id' => $this->id])->get()->toArray();
        return isset($images[0]) ? $images[0] : [];
    }

    public function getAllImage()
    {
        $images = Image::where(['image_type' => Image::GAME_IMAGE])->where(['object_id' => $this->id])->get()->toArray();
        return isset($images) ? $images : [];
    }

    public function getRandomImage()
    {
        $images = Image::where(['image_type' => Image::GAME_IMAGE])->where(['object_id' => $this->id])->get()->toArray();
        return $images[array_rand($images)];
    }

    public function getTags() 
    {
        $gameTags = GamesTag::where(['game_id' => $this->id])->get();
        foreach ($gameTags as $gameTag){
            $tags[] = Tag::where(['id' => $gameTag->tag_id])->get()->toArray();
        }        
        return isset($tags) ? $tags : [];
    }

    public function getCompanies() 
    {
        $gameCompanies = GamesCompany::where(['game_id' => $this->id])->get();
        foreach ($gameCompanies as $gameCompany){
            $companies[] = Company::where(['id' => $gameCompany->company_id])->get()->toArray();
        }
        return isset($companies) ? $companies : [];
    }
}
