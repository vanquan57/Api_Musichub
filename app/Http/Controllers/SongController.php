<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Genre;
use App\Models\Playlist;
use App\Models\Song;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Env;
use Illuminate\Support\Facades\Log;

class SongController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $genres = Genre::all();
        $artists = Artist::all();
        $albums = Album::all();
        $songs = Song::all();
        return view('songs')->with(
            [
                'title' => 'Song Management',
                'genres' => $genres,
                'artists' => $artists,
                'albums' => $albums,
                'songs' => $songs
            ]
        );
    }


    public function store(Request $request)
    {
        if (!empty($request->input())) {
            Song::create([
                'name' => $request->input('nameSong'),
                'lyrics' => $request->input('lyrics') ? $request->input('lyrics') : null,
                'avatarUrl' => $request->input('avatarUrl') ? $request->input('avatarUrl') : null,
                'songUrl' => $request->input('songUrl'),
                'numPlay' => 0,
                'numDownloads' => 0,
                'artistId' => $request->input('artistId'),
                'albumId' => $request->input('albumId'),
                'genreId' => $request->input('genreId')
            ]);
            return redirect()->route('songs');
        }
    }

    public function updateNumberOfHeard(Request $request)
    {
        $song = Song::find($request->input('songId'));
        if ($song) {
            $song->numPlay = $song->numPlay + 1;
            $song->save();
        }
    }

    public function getNewReleaseSong(Request $request)
    {
        $result = null;
        if ($request->input('limit') == 'all') {
            $songs = Song::all();
            $songsResult = $this->jsonSongResult($songs);
            $result = $songsResult;
        } else if ($request->input('limit') == 'vietNam') {
            // get all data from song excluded us-uk
            $excludedId = 7;
            $songs = Song::whereNotIn('genreId', [$excludedId])->get();
            $songsResult = $this->jsonSongResult($songs);
            $result = $songsResult;
        } else if ($request->input('limit') == 'us-uk') {
            // get all data from song us-uk
            $us_ukId = 7;
            $songs = Song::where('genreId', $us_ukId)->get();
            $songsResult = $this->jsonSongResult($songs);
            $result = $songsResult;
        }
        return response()->json($result);
    }

    public function getZingchartSong()
    {
        $songs = Song::orderByDesc('numPlay')->get();
        $songsResult = $this->jsonSongResult($songs);
        return response()->json($songsResult);
    }
    public function getTop5SongInZingchart()
    {
        $songs = Song::orderByDesc('numPlay')->take(5)->get();
        $songsResult = $this->jsonSongResult($songs);
        return response()->json($songsResult);
    }
    public function getAllSongInAlbum(Request $request)
    {
        $album = Album::find($request->input('albumId'));
        $songs = $album->songs;
        $songsResult = $this->jsonSongResult($songs);
        return response()->json($songsResult);
    }
    public function getAllSongInArtist(Request $request)
    {
        $artist = Artist::find($request->input('artistId'));
        $songs = $artist->songs;
        $songsResult = $this->jsonSongResult($songs);
        return response()->json($songsResult);
    }
    public function getSongById(Request $request)
    {
        $song = Song::find($request->input('songId'));
        $APP_ANDROID_URL = env('APP_ANDROID_URL');
        $timeCreated = Carbon::parse($song->created_at);
        $currentTime = Carbon::now();
        $songResult = [
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
            'dateRelease' => $currentTime->diffForHumans($timeCreated)
        ];
        return response()->json($songResult);
    }

    public function getHeardRecentlys(Request $request)
    {
        Log::info($request->input('title'));
        $songsResult = null;
        if ($request->input('title') == 'Zingchat Những Bài Hát Mới Phát Hành') {
            $songs = Song::all();
            $songsFilter = $songs->filter(function ($song) {
                $current_date = date('Y-m-d');
                $current_datetime = new DateTime($current_date);
                $database_datetime = new DateTime($song->created_at);
                $interval = $database_datetime->diff($current_datetime);
                $days_diff = $interval->format('%a');
                return $days_diff < 10;
            });
            $songsResult = $this->jsonSongResultHaveFilter($songsFilter);
        } else if ($request->input('title') == "Nhạc Buồn") {
            $songs = Song::all();
            $songsFilter = $songs->filter(function ($song) {
                return $song->genreId == 4 || $song->genreId == 6;
            });
            $songsResult = $this->jsonSongResultHaveFilter($songsFilter);
        } else if ($request->input('title') == "Song Ca Cùng V-Pop") {
            $songs = Song::all();
            $songsFilter = $songs->filter(function ($song) {
                return $song->genreId == 1;
            });
            $songsResult = $this->jsonSongResultHaveFilter($songsFilter);
        } else if ($request->input('title') == "Những Bài Hát Gây Nghiện") {
            $songs = Song::all();
            $songsFilter = $songs->filter(function ($song) {
                return $song->numPlay > 10;
            });
            $songsResult = $this->jsonSongResultHaveFilter($songsFilter);
        } else if ($request->input('title') == "100 V-Pop US-UK") {
            $songs = Song::all();
            $songsFilter = $songs->filter(function ($song) {
                return $song->genreId == 1 || $song->genreId == 7;
            });


            $songsResult = $this->jsonSongResultHaveFilter($songsFilter);
        }

        return response()->json($songsResult);
    }
    public function jsonSongResultHaveFilter($songs)
    {
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
                'dateRelease' => $currentTime->diffForHumans($timeCreated)
            ];
        });

        $songsResult = $songsResult->values();
        return $songsResult;
    }

    public function jsonSongResult($songs)
    {
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
        return $songsResult;
    }
    public function loveSong(Request $request)
    {
        $songId = $request->input('songId');
        $userId = $request->input('userId');
        $song = Song::find($songId);


        $song->likes()->attach($userId);
        return response()->json([
            'success' => true
        ]);
    }
    public function unLoveSong(Request $request)
    {
        $songId = $request->input('songId');
        $userId = $request->input('userId');
        $song = Song::find($songId);
        $song->likes()->detach($userId);
        return response()->json([
            'success' => true
        ]);
    }
    public function isLoved(Request $request)
    {
        $songId = $request->input('songId');
        $userId = $request->input('userId');
        $song = Song::find($songId);
        $isLoved = $song->likes()->where('user_id', $userId)->exists();
        if ($isLoved) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }
    public function getLoveSong(Request $request){
        $userId = $request->input('userId');
        $songs = Song::whereHas('likes', function($query) use ($userId){
            $query->where('user_id', $userId);
        })->get();
        $songResults = $this->jsonSongResult($songs);
        return response()->json($songResults);
    }
    public function checkSongIsMyPlaylist(Request $request){
        $songId = $request->input('songId');
        $userId = $request->input('userId');
        
        // check row in table pivot playlistSongs
        $playlist = Playlist::where('userId', $userId)
        ->whereHas('playlistSongs', function($query) use ($songId) {
            $query->where('songId', $songId);
        })
        ->first();
        if($playlist){
            return response()->json([
                'id' => $playlist->id,
                'name' => $playlist->name
            ]);
        }
        return response()->json(null);
        
    }
    public function removeSongFromPlaylist(Request $request){
        $songId = $request->input('songId');
        $playlistId = $request->input('playlistId');
        $playlist = Playlist::find($playlistId);
        
        $detached = $playlist->playlistSongs()->detach($songId);
        if($detached){
            return response()->json([
                'success' => true
            ]);
        }
        

    }
}
