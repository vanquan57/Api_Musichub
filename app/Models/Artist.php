<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;
    protected $table = 'artists';
    protected $fillable = ['name', 'avatarUrl'];

    public function albums(){
        return $this->hasMany(Album::class);
    }
    public function songs(){
        return $this->hasMany(Song::class, 'artistId');
    }
    public function musicVideos(){
        return $this->hasMany(MusicVideo::class, 'artistId');
    }
    
}
