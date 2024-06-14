<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;
    protected $table = 'albums';
    protected $fillable = ['name', 'artistId', 'avatarUrl'];

    public function artist(){
        return $this->belongsTo(Artist::class, 'artistId');
    }
    public function songs(){
        return $this->hasMany(Song::class, 'albumId');
    }

}
