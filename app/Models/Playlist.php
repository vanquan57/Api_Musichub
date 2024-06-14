<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;
    protected $table = 'playlists';
    protected $fillable = [
        'userId',
        'name',
        'description',
        'avatarUrl',
    ];
    public function user(){
        return $this->belongsTo(User::class, 'userId');
    }
    public function playlistSongs(){
        return $this->belongsToMany(Song::class, 'playlistSongs', 'playlistId', 'songId')->withTimestamps();
    }
}
