<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MusicVideo extends Model
{
    use HasFactory;
    protected $table = 'music_videos';
    protected $fillable = [
        'name',
        'avatarUrl',
        'videoUrl',
        'numPlay',
        'numDownloads',
        'artistId',
    ];
    public function artist(){
        return $this->belongsTo(Artist::class, 'artistId');
    }
}
