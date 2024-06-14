<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    public function index()
    {
    }
    public function create(Request $request)
    {
        $userId = $request->input('userId');
        $namePlaylist = $request->input('namePlaylist');
        $isCreated = Playlist::create([
            'userId' => $userId,
            'name' => $namePlaylist,
            'description' => null,
            'avatarUrl' => null
        ]);
        if ($isCreated) {
            $playlists = Playlist::where('userId', $userId)->get();
            $playlistResponse = $playlists->map(function ($playlist) {
                return [
                    'id' => $playlist->id,
                    'name' => $playlist->name,
                ];
            });
            return response()->json($playlistResponse);
        }
    }
    public function getAllPlayListByUserId(Request $request)
    {
        $userId = $request->input('userId');
        $playlists = Playlist::where('userId', $userId)->get();
        $playlistResponse = $playlists->map(function ($playlist) {
            return [
                'id' => $playlist->id,
                'name' => $playlist->name,
            ];
        });
        return response()->json($playlistResponse);
    }
    public function removePlaylistById(Request $request)
    {
        $userId = $request->input('userId');
        $playlistId = $request->input('playlistId');
        $isDeleted = Playlist::where('userId', $userId)->where('id', $playlistId)->delete();
        if ($isDeleted) {
            return response()->json(['success' => true]);
        }
    }
    public function addSongToPlaylist(Request $request)
    {
        $playlistId = $request->input('playlistId');
        $songId = $request->input('songId');
        $playlist = Playlist::find($playlistId);
        if ($playlist) {
            $playlist->playlistSongs()->attach($songId);
            return response()->json(['success' => true]);
        }
    }
    public function getAllSongByPlaylistId(Request $request)
    {
        $playlistId = $request->input('playlistId');
        $playlist = Playlist::find($playlistId);
        if ($playlist) {
            $songs = $playlist->playlistSongs;
            $APP_ANDROID_URL = env('APP_ANDROID_URL');
            Carbon::setLocale('vi');
            $songsResult = $songs->map(function ($song) use ($APP_ANDROID_URL) {
                $timeCreated = Carbon::parse($song->created_at);
                $currentTime = Carbon::now();
                return [
                    'id' => $song->id,
                    'name' => $song->name,
                    'lyrics' => $song->lyrics,
                    'avatarUrl' => "http://" . $APP_ANDROID_URL . ":8000/storage/" . $song->avatarUrl,
                    'songUrl' => "http://" . $APP_ANDROID_URL . ":8000/storage/" . $song->songUrl,
                    'numPlay' => $song->numPlay,
                    'numDownloads' => $song->numDownloads,
                    'artist' => $song->artist->name,
                    'album' => $song->album->name,
                    'genre' => $song->genre->name,
                    'dateRelease' => $timeCreated->diffForHumans($currentTime)
                ];
            });
            return response()->json($songsResult);
        }
    }
}
