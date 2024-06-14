<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\MusicVideo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MusicVideoController extends Controller
{
    public function index()
    {
        $artists = Artist::all();
        $musicVideos = MusicVideo::all();
        return view('musicvideo')->with(
            [
                'title' => 'Music Video Management',
                'artists' => $artists,
                'musicVideos' => $musicVideos
            ]
        );
    }
    public function store(Request $request){
        if (!empty($request->input())) {
            MusicVideo::create([
                'name' => $request->input('nameMv'),
                'avatarUrl' => $request->input('avatarUrl') ? $request->input('avatarUrl') : null,
                'videoUrl' => $request->input('mvUrl'),
                'numPlay' => 0,
                'numDownloads' => 0,
                'artistId' => $request->input('artistId'),
            ]);
            return redirect()->route('musicVideos');
        }
    }
    public function getAllMusicVideo(){
        $musicVideos = MusicVideo::all();
        Carbon::setLocale('vi');
        $APP_ANDROID_URL = env('APP_ANDROID_URL');
        $musicVideosResult = $musicVideos->map(function ($musicVideo) use ($APP_ANDROID_URL) {
            $timeCreated = Carbon::parse($musicVideo->created_at);
            $currentTime = Carbon::now();
            return [
                'id' => $musicVideo->id,
                'name' => $musicVideo->name,
                'avatarUrl' => "http://".$APP_ANDROID_URL.":8000/storage/".$musicVideo->avatarUrl,
                'videoUrl' => "http://".$APP_ANDROID_URL.":8000/storage/".$musicVideo->videoUrl,
                'numPlay' => $musicVideo->numPlay,
                'numDownloads' => $musicVideo->numDownloads,
                'artist' => $musicVideo->artist->name,
                'avatarArtistUrl' =>"http://".$APP_ANDROID_URL.":8000/storage/".$musicVideo->artist->avatarUrl,
                'dateCreated' =>  $timeCreated->diffForHumans($currentTime)
            ];
        });
        return response()->json($musicVideosResult);
    }
}
