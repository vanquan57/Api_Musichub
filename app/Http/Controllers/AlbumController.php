<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listAlbums = Album::all();
        $artists = Artist::all();
        return view('albums')->with([
            'title' => 'Manage Albums',
            'listAlbums' => $listAlbums,
            'artists' =>$artists
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
            Album::create([
                'name' => $request->input('nameAlbum'),
                'artistId' => $request->input('artistId'),
                'avatarUrl' => $request->input('avatarUrl')
            ]);
            return redirect()->back();
        }
    }
    public function getImageAlbums(){
        $APP_ANDROID_URL = env('APP_ANDROID_URL');
        $listAlbums = Album::all();

        $imageAlbums =  $listAlbums->map(function($imageAlbum) use ($APP_ANDROID_URL){
            return [
                'id' => $imageAlbum->id,
                'name' => $imageAlbum->name,
                'avatarUrl' => "http://".$APP_ANDROID_URL.":8000/storage/".$imageAlbum->avatarUrl
            ];
        });
        return response()->json($imageAlbums);
        
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
}
