<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasFactory;
    protected $table = 'users';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = ['username', 'email', 'member', 'password','provider', 'providerId', 'avatarUrl'];

    public function comments(){
        return $this->hasMany(Comment::class, 'userId');
    }
    public function likes(){
        return $this->hasMany(Song::class, 'user_song_likes', 'user_id', 'song_id')->withTimestamps();;
    }
    public function playlist(){
        return $this->hasMany(Playlist::class, 'userId');
    }

}
