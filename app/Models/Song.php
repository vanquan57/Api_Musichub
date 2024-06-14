<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;
    protected $table = 'songs';
    protected $fillable = [
        'name',
        'lyrics',
        'avatarUrl',
        'songUrl',
        'numPlay',
        'numDownloads',
        'artistId',
        'albumId',
        'genreId',
    ];
    public function genre(){
        return $this->belongsTo(Genre::class, 'genreId');
    }
    public function artist(){
        return $this->belongsTo(Artist::class, 'artistId');
    }
    public function album(){
        return $this->belongsTo(Album::class, 'albumId');
    }
    public function comments(){
        return $this->hasMany(Comment::class, 'songId');
    }
    public function likes(){
        return $this->belongsToMany(User::class, 'user_song_likes', 'song_id', 'user_id')->withTimestamps();;
    }

    public function playlistSongs(){
        return $this->belongsToMany(Playlist::class, 'playlistSongs', 'songId', 'playlistId')->withTimestamps();
    }
}
