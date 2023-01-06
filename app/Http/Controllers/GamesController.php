<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Game;
use App\Models\GamesTag;
use App\Models\GamesCompany;
use App\Models\Company;
use App\Models\Tag;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image as InterventionImage;

class GamesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $games = Game::orderBy('id', 'desc')->get();
        foreach ($games as $game) {
            $game->image = $game->getAllImage();
        }
        foreach ($games as $game) {
            $game->category = $game->categoryName();
        }
        $categories = Category::all();
        $games->toArray();

        $nameQuery = false;
        $categoryQuery=false;

        return view('games/index', compact('games' , 'nameQuery', 'categoryQuery', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();
        $categories = Category::all()->toArray();
        array_unshift($categories, ['id' => null , 'name' => 'stauros']);
        $companies = Company::all();
        return view('/games/create', compact('tags', 'categories', 'companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'gameName' => ['required', 'max:60'],
            'category' => ['integer', 'required'],
            'tags' => 'required',
            'companies' => 'required',
            'release_date' => 'date',
            'gameImage1' => ['image', 'required', 'max:2048'],
            'gameImage2' => ['image', 'nullable', 'max:2048'],
            'gameImage3' => ['image', 'nullable', 'max:2048'],
            'gameImage4' => ['image', 'nullable', 'max:2048'],
            'gameImage5' => ['image', 'nullable']
        ]);
        if ($validator->fails()) {
            return redirect('games/create')->withErrors($validator)->withInput();
        }

        $data = request()->validate([
            'gameName' => ['required', 'max:60'],
            'category' => ['integer', 'required'],
            'tags' => 'required',
            'companies' => 'required',
            'release_date' => 'date',
            'gameImage1' => ['image', 'required', 'max:2048'],
            'gameImage2' => ['image', 'nullable', 'max:2048'],
            'gameImage3' => ['image', 'nullable', 'max:2048'],
            'gameImage4' => ['image', 'nullable', 'max:2048'],
            'gameImage5' => ['image', 'nullable', 'max:2048'],
            'is2D' => ['nullable']
        ]);
        $game = new Game;
        
        $game->name = $data['gameName'];
        $game->category_id = $data['category'];
        $game->release_date = strtotime($data['release_date']);
        
        if (request('gameImage1')){
            $imagePath1 = request('gameImage1')->store('uploads', 'public');
            $imageInervention1 = InterventionImage::make(public_path("storage/{$imagePath1}"))->fit(1200, 1200);
        }
        if (request('gameImage2')){
            $imagePath2 = request('gameImage2')->store('uploads', 'public');
            $imageInervention2 = InterventionImage::make(public_path("storage/{$imagePath2}"))->fit(1200, 1200);
        }
        if (request('gameImage3')){
            $imagePath3 = request('gameImage3')->store('uploads', 'public');
            $imageInervention3 = InterventionImage::make(public_path("storage/{$imagePath3}"))->fit(1200, 1200);
        }
        if (request('gameImage4')){
            $imagePath4 = request('gameImage4')->store('uploads', 'public');
            $imageInervention4 = InterventionImage::make(public_path("storage/{$imagePath4}"))->fit(1200, 1200);
        }
        if (request('gameImage5')){
            $imagePath5 = request('gameImage5')->store('uploads', 'public');
            $imageInervention5 = InterventionImage::make(public_path("storage/{$imagePath5}"))->fit(1200, 1200);
        }
        if (isset($data['is2D']) && $data['is2D'] === "on") {
            $game->is2D = true;
        } else {
            $game->is2D = false;
        }
        
        if ($game->save()) {
            foreach ($data['tags'] as $tag) {
                $gameTag = new GamesTag;
                $gameTag->tag_id = $tag;
                $gameTag->game_id = $game->id;
                $gameTag->save();
            }
            foreach ($data['companies'] as $company) {
                $gameCompany = new GamesCompany;
                $gameCompany->company_id = $company;
                $gameCompany->game_id = $game->id;
                $gameCompany->save();
            }
            if (isset($imageInervention1)) {
                $imageInervention1->save();
                $image1 = new Image;
                $image1->image_path = $imagePath1;
                $image1->image_type = Image::GAME_IMAGE;
                $image1->object_id = $game->id;
                $image1->save();
            }
            if (isset($imageInervention2)) {
                $imageInervention2->save();
                $image2 = new Image;
                $image2->image_path = $imagePath2;
                $image2->image_type = Image::GAME_IMAGE;
                $image2->object_id = $game->id;
                $image2->save();
            }
            if (isset($imageInervention3)) {
                $imageInervention3->save();
                $image3 = new Image;
                $image3->image_path = $imagePath3;
                $image3->image_type = Image::GAME_IMAGE;
                $image3->object_id = $game->id;
                $image3->save();
            }
            if (isset($imageInervention4)) {
                $imageInervention4->save();
                $image4 = new Image;
                $image4->image_path = $imagePath4;
                $image4->image_type = Image::GAME_IMAGE;
                $image4->object_id = $game->id;
                $image4->save();
            }
            if (isset($imageInervention5)) {
                $imageInervention5->save();
                $image5 = new Image;
                $image5->image_path = $imagePath5;
                $image5->image_type = Image::GAME_IMAGE;
                $image5->object_id = $game->id;
                $image5->save();
            }
            
        return redirect('games/view/'.$game->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $game = Game::find($id);
        $game->images = $game->getAllImage();
        $game->tags = $game->getTags($id);
        $game->companies = $game->getCompanies($id);
        $game->toArray();

        return view('games/view', compact('game'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $game = Game::find($id);
        $game->logo = $game->getFirstImage();
        $tags = Tag::all();
        $categories = Category::all();
        $companies = Company::all();
        
        $TagsArray = $game->getTags($id);
        foreach ($TagsArray as $key => $tag) {
            $selectedTagsIds[] = $tag[0]['id']; 
        }
        !isset($selectedTagsIds) ? $selectedTagsIds = [] : '';

        $CompaniesArray = $game->getCompanies($id);
        foreach ($CompaniesArray as $key => $company) {
            $selectedCompaniesIds[] = $company[0]['id']; 
        }
        !isset($selectedCompaniesIds) ? $selectedCompaniesIds = [] : '';
        

        return view('/games/edit', compact('game', 'tags', 'categories', 'companies', 'selectedTagsIds', 'selectedCompaniesIds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = request()->validate([
            'id' => ['required', 'integer'],
            'gameName' => ['required', 'max:60'],
            'category' => ['integer', 'required'],
            'tags' => 'required',
            'companies' => 'required',
            'release_date' => 'date',
            'gameImage1' => ['image', 'nullable', 'max:2048'],
            'gameImage2' => ['image', 'nullable', 'max:2048'],
            'gameImage3' => ['image', 'nullable', 'max:2048'],
            'gameImage4' => ['image', 'nullable', 'max:2048'],
            'gameImage5' => ['image', 'nullable', 'max:2048'],
            'is2D' => ['nullable']
        ]);
        $game = Game::find($data['id']);
        
        $game->name !== $data['gameName'] ? $game->name = $data['gameName'] : null;
        $game->category_id !== $data['category'] ? $game->category_id = $data['category'] : null;
        $game->release_date !== strtotime($data['release_date']) ? $game->release_date = strtotime($data['release_date']) : null;
        
        if (request('gameImage1')){
            $imagePath1 = request('gameImage1')->store('uploads', 'public');
            $imageInervention1 = InterventionImage::make(public_path("storage/{$imagePath1}"))->fit(1200, 1200);
        }
        if (request('gameImage2')){
            $imagePath2 = request('gameImage2')->store('uploads', 'public');
            $imageInervention2 = InterventionImage::make(public_path("storage/{$imagePath2}"))->fit(1200, 1200);
        }
        if (request('gameImage3')){
            $imagePath3 = request('gameImage3')->store('uploads', 'public');
            $imageInervention3 = InterventionImage::make(public_path("storage/{$imagePath3}"))->fit(1200, 1200);
        }
        if (request('gameImage4')){
            $imagePath4 = request('gameImage4')->store('uploads', 'public');
            $imageInervention4 = InterventionImage::make(public_path("storage/{$imagePath4}"))->fit(1200, 1200);
        }
        if (request('gameImage5')){
            $imagePath5 = request('gameImage5')->store('uploads', 'public');
            $imageInervention5 = InterventionImage::make(public_path("storage/{$imagePath5}"))->fit(1200, 1200);
        }
        if (isset($data['is2D']) && $data['is2D'] === "on") {
            $game->is2D = true;
        } else {
            $game->is2D = false;
        }
        
        if ($game->save()) {
            foreach ($data['tags'] as $tag) {
                if (!GamesTag::where(['game_id' => $game->id])->where(['tag_id' => $tag])->get()->toArray()) {
                    $gameTag = new GamesTag;
                    $gameTag->tag_id = $tag;
                    $gameTag->game_id = $game->id;
                    $gameTag->save();
                }
            }
            if (GamesTag::where(['game_id' => $game->id])->where(['tag_id' => $tag])->get()->toArray()) {
                $gameTags = GamesTag::where(['game_id' => $game->id])->get();
                foreach ($gameTags as $gameTag) {
                    if (!in_array($gameTag->tag_id, $data['tags'])) {
                        $gameTag->delete();
                    }
                }
            }

            foreach ($data['companies'] as $company) {
                if (!GamesCompany::where(['game_id' => $game->id])->where(['company_id' => $company])->get()->toArray()) {
                    $gameCompany = new GamesCompany;
                    $gameCompany->company_id = $company;
                    $gameCompany->game_id = $game->id;
                    $gameCompany->save();
                }
            }
            if (GamesCompany::where(['game_id' => $game->id])->where(['company_id' => $company])->get()->toArray()) {
                $gameCompany = GamesCompany::where(['game_id' => $game->id])->get();
                foreach ($gameCompany as $gameCompany) {
                    if (!in_array($gameCompany->company_id, $data['companies'])) {
                        $gameCompany->delete();
                    }
                }
            }

            if (isset($imageInervention1)) {
                $imageInervention1->save();
                $image1 = new Image;
                $image1->image_path = $imagePath1;
                $image1->image_type = Image::GAME_IMAGE;
                $image1->object_id = $game->id;
                $image1->save();
            }
            if (isset($imageInervention2)) {
                $imageInervention2->save();
                $image2 = new Image;
                $image2->image_path = $imagePath2;
                $image2->image_type = Image::GAME_IMAGE;
                $image2->object_id = $game->id;
                $image2->save();
            }
            if (isset($imageInervention3)) {
                $imageInervention3->save();
                $image3 = new Image;
                $image3->image_path = $imagePath3;
                $image3->image_type = Image::GAME_IMAGE;
                $image3->object_id = $game->id;
                $image3->save();
            }
            if (isset($imageInervention4)) {
                $imageInervention4->save();
                $image4 = new Image;
                $image4->image_path = $imagePath4;
                $image4->image_type = Image::GAME_IMAGE;
                $image4->object_id = $game->id;
                $image4->save();
            }
            if (isset($imageInervention5)) {
                $imageInervention5->save();
                $image5 = new Image;
                $image5->image_path = $imagePath5;
                $image5->image_type = Image::GAME_IMAGE;
                $image5->object_id = $game->id;
                $image5->save();
            }
            
        return redirect('games/view/'.$game->id);
        
        }
    }
    /*
    * Render the images from specific game for remove from.
    *
    *
     */
    public function imagesForm($id)
    {
        $game = Game::find($id);
        $images = $game->getAllImage($id);

        return view('games/removeImages', compact('images', 'game')); 
    }

    /**
     * Remove images from games.
     *
     */
    public function removeimages($id)
    {
        $image = Image::find($id);
        $gameId = $image->object_id; 
        if(File::exists(public_path("storage/{$image->image_path}"))) {
            File::delete(public_path("storage/{$image->image_path}"));
            $image->delete();
        }
        $game = Game::find($gameId);
        $images = $game->getAllImage($gameId);

        return view('games/removeImages', compact('images', 'game')); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $game = Game::find($id);
        $game->delete();

        return redirect('games');
    }

    /**
     * Search based on Game's Name
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $games = [];
        $nameQuery = strtolower($request->nameQuery);
        $categoryQuery = $request->categoryQuery;
        $allgames = Game::all();
        $categories = Category::all();
        $category = Category::find($categoryQuery);
        
        foreach ($allgames as $game) {
            $game->logo = $game->getFirstImage();
            if($categoryQuery != "null") {
                if (str_contains(strtolower($game["name"]), $nameQuery) && $game["category_id"] == $categoryQuery) {
                    $games[] = $game;
                }
            } else {
                if (str_contains(strtolower($game["name"]), $nameQuery)) {
                    $games[] = $game;
                }
            }
        }
        foreach ($games as $game) {
            $game->image = $game->getAllImage();
        }

        foreach ($games as $game) {
            $game->category = $game->categoryName();
        }
        return view('games/index', compact('games','nameQuery', 'categories', 'category', 'categoryQuery'));
    }
}
