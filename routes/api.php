<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\MusicVideoController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('account')->group(function () {
    Route::post('/login', [UsersController::class, 'login']);
    Route::post('/loginWithGoogle', [UsersController::class, 'login']);
    Route::post('/register', [UsersController::class, 'store']);
    Route::get('/getUserById', [UsersController::class, 'getUserById']);
    Route::post('/activateAccount', [UsersController::class, 'activateAccount']);
    Route::post('/updateAccount', [UsersController::class, 'updateAccount']);
    Route::post('/updatePasswordAccount', [UsersController::class, 'updatePasswordAccount']);
    Route::get('/verificationCode', [UsersController::class, 'sentEmailVerification'])->where('email', '[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}');
});

Route::prefix('musichub')->group(function () {
    Route::get('/', function () {
        return view('home')->with([
            'title' => 'Music Hub'
        ]);
    })->name('home');

    Route::prefix('songs')->group(function () {
        Route::get('/', [SongController::class, 'index'])->name('songs');
        Route::post('/', [SongController::class, 'store'])->name('songStore');
        // Mobile
        Route::get('/getNewReleaseSong', [SongController::class, 'getNewReleaseSong']);
        Route::get('/getZingchartSong', [SongController::class, 'getZingchartSong']);
        Route::get('/getSongById', [SongController::class, 'getSongById']);
        Route::get('/getTop5SongInZingchart', [SongController::class, 'getTop5SongInZingchart']);
        Route::get('/getAllSongInAlbum', [SongController::class, 'getAllSongInAlbum']);
        Route::get('/getAllSongInArtist', [SongController::class, 'getAllSongInArtist']);
        Route::get('/getHeardRecentlys', [SongController::class, 'getHeardRecentlys'])->where('title', '.*');
        Route::put('/updateNumberOfHeard', [SongController::class, 'updateNumberOfHeard']);
        Route::put('/loveSong', [SongController::class, 'loveSong']);
        Route::put('/unLoveSong', [SongController::class, 'unLoveSong']);
        Route::get('/isLoved', [SongController::class, 'isLoved']);
        Route::get('/getLoveSong', [SongController::class, 'getLoveSong']);
        Route::get('/checkSongIsMyPlaylist', [SongController::class, 'checkSongIsMyPlaylist']);
        Route::delete('/removeSongFromPlaylist', [SongController::class, 'removeSongFromPlaylist']);
    });
    Route::prefix('playlist')->group(function () {
        Route::post('/create', [PlaylistController::class, 'create']);
        Route::get('/getAllPlayListByUserId',[PlaylistController::class, 'getAllPlayListByUserId']);
        Route::post('/removePlaylistById', [PlaylistController::class, 'removePlaylistById']);
        Route::post('/addSongToPlaylist', [PlaylistController::class, 'addSongToPlaylist']);
        Route::get('/getAllSongByPlaylistId', [PlaylistController::class, 'getAllSongByPlaylistId']);
    });
    Route::prefix('musicvideo')->group(function () {
        Route::get('/', [MusicVideoController::class, 'index'])->name('musicVideos');
        Route::post('/', [MusicVideoController::class, 'store'])->name('musicVideoStore');
        // Mobile
        Route::get('/getAllMusicVideo', [MusicVideoController::class, 'getAllMusicVideo']);
    });

    Route::prefix('albums')->group(function () {
        Route::get('/', [AlbumController::class, 'index'])->name('albums');
        Route::post('/', [AlbumController::class, 'store'])->name('albumStore');
        // Mobile
        Route::get('/getImageAlbums', [AlbumController::class, 'getImageAlbums']);
    });
    Route::prefix('genres')->group(function () {
        Route::get('/', [GenreController::class, 'index'])->name('genres');
        Route::post('/', [GenreController::class, 'store'])->name('genresStore');
    });
    Route::prefix('artists')->group(function () {
        Route::get('/', [ArtistController::class, 'index'])->name('artists');
        Route::post('/', [ArtistController::class, 'store'])->name('artistStore');
        // Mobile
        Route::get('/getArtist', [ArtistController::class, 'getArtists']);
    });
    
    Route::prefix('users')->group(function () {
        Route::get('/', [UsersController::class, 'index'])->name('users');
    });
    Route::prefix('comment')->group(function (){
        Route::get('/getAllCommentSong', [CommentController::class, 'getAllCommentSong']);
        Route::post('/addComment', [CommentController::class, 'addComment']);
    });
});

Route::post('/upload', [UploadController::class, 'store']);
