<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $artists = Artist::all();
        return view('artists')->with([
            'title' => 'Manager Artists',
            'listArtists' =>$artists
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!empty($request->input())){
            Artist::create([
                'name' =>$request->input('nameArtist'),
                'avatarUrl' =>$request->input('avatarUrl')
            ]);
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function getArtists(){
        $APP_ANDROID_URL = env('APP_ANDROID_URL');
        $artists = Artist::all();
        $artists = $artists->map(function($artist) use ($APP_ANDROID_URL){
            return [
                'id' => $artist->id,
                'name' => $artist->name,
                'avatarUrl' => "http://".$APP_ANDROID_URL.":8000/storage/".$artist->avatarUrl
            ];
        });
        return response()->json($artists);

    }
}
