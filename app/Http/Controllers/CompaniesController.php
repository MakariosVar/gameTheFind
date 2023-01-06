<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Company;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as InterventionImage;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::orderBy('id', 'desc')->get();
        foreach ($companies as $company) {
            $company->logo = $company->getOriginalLogo($company->id);
        }
        $companies->toArray();
        $query = false;

        return view('companies/index', compact('companies' , 'query'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('/companies/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'companyName' => ['required', 'max:60'],
            'companyLogo' => ['image', 'nullable', 'max:2048'],
            'companyLogoUnamed' => ['image', 'nullable', 'max:2048'],
            'hasNameOnLogo' => ['nullable']
        ]);
        
        $company = new Company;
        $company->name = $data['companyName'];

        if (isset($data['hasNameOnLogo']) && $data['hasNameOnLogo'] === "on") {
            $company->hasNameOnLogo = true;
        } else {
            $company->hasNameOnLogo = false;
        }
        
        if (request('companyLogo')){
            $imagePath = request('companyLogo')->store('uploads', 'public');
            $imageInervention = InterventionImage::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
        }

        if (request('companyLogoUnamed')){
            $imagePathUnamed = request('companyLogoUnamed')->store('uploads', 'public');
            $imageInerventionUnamed = InterventionImage::make(public_path("storage/{$imagePathUnamed}"))->fit(1200, 1200);
        }

        if ($company->save()) {
            if (isset($imageInervention)) {
                $imageInervention->save();
                $image = new Image;
                $image->image_path = $imagePath;
                $image->image_type = Image::COMPANY_IMAGE;
                $image->object_id = $company->id;
                $image->save();
            }
            if (isset($imageInerventionUnamed)) {
                $imageInerventionUnamed->save();
                $image = new Image;
                $image->image_path = $imagePathUnamed;
                $image->image_type = Image::COMPANY_IMAGE;
                $image->object_id = $company->id;
                if ($image->save()) {
                    $company->unnamed_logo_id = $image->id;
                    $company->save();
                }
            }
        return redirect('companies/view/'.$company->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::find($id);
        $company->logo = $company->getOriginalLogo($company->id);
        $company->logoUnamed = $company->getUnamedLogo($company->id);
        $games = $company->games();
        $company->toArray();

        return view('companies/view', compact('company', 'games'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::find($id);
        $company->logo = $company->getOriginalLogo($company->id);
        $company->logoUnamed = $company->getUnamedLogo($company->id);

        return view('companies/edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = request()->validate([
            'id' => ['integer'],
            'companyName' => ['max:60'],
            'companyLogo' => ['image', 'nullable', 'max:2048'],
            'companyLogoUnamed' => ['image', 'nullable', 'max:2048'],
            'hasNameOnLogo' => ['nullable']
        ]);
        $company = Company::find($data['id']);

        if (!($data['companyName'] === null)) {
            $company->name = $data['companyName'];
        }

        if (isset($data['hasNameOnLogo']) && $data['hasNameOnLogo'] === "on") {
            $company->hasNameOnLogo = true;
        } else {
            $company->hasNameOnLogo = false;
        }

        if (request('companyLogo')){
            $imagePath = request('companyLogo')->store('uploads', 'public');
            $imageInervention = InterventionImage::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
        }
        
        if (request('companyLogoUnamed')){
            $imagePathUnamed = request('companyLogoUnamed')->store('uploads', 'public');
            $imageInerventionUnamed = InterventionImage::make(public_path("storage/{$imagePathUnamed}"))->fit(1200, 1200);
        }
        if ($company->save()) {
            if (isset($imageInervention)) {
                $imageInervention->save();
                $image = new Image;
                $image->image_path = $imagePath;
                $image->image_type = Image::COMPANY_IMAGE;
                $image->object_id = $company->id;
                if ($image->save()) {
                    $logos = $company->getOriginalLogo($company->id);
                    if ($logos) {
                        foreach ($logos as $logo) {
                            if ($company->unnamed_logo_id != $logo['id'] && $logo['id'] != $image->id) {
                                $imageModel = Image::find($logo['id']);
                                $imageModel->delete();
                            }
                        }
                    }
                }
            }
        }
        if (isset($imageInerventionUnamed)) {
            $imageInerventionUnamed->save();
            $image = new Image;
            $image->image_path = $imagePathUnamed;
            $image->image_type = Image::COMPANY_IMAGE;
            $image->object_id = $company->id;
            if ($image->save()) {
                $oldLogosUnamed = $company->getUnamedLogo($company->id);
                if ($oldLogosUnamed) {
                    if ($oldLogosUnamed['id'] != $image->id) {
                        $imageModel = Image::find($oldLogosUnamed['id']);
                        $imageModel->delete();
                    }
                }
                
                $company->unnamed_logo_id = $image->id;
                $company->save();
            }
        }
        return redirect('companies/view/'.$company->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::find($id);
        $company->delete();

        return redirect('companies');
    }

    /**
     * Search based on Company's Name
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $companies = [];
        $query = strtolower($request->companyQuery);
        $allcompanies = Company::all();
        
        foreach ($allcompanies as $company) {
            $company->logo = $company->getOriginalLogo($company->id);
            if (str_contains(strtolower($company["name"]), $query)) {
                $companies[] = $company;
            }
        }
        return view('companies/index', compact('companies','query'));
    }
}
