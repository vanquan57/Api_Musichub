<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $primaryKey = 'id';
    protected $fillable = ['userId', 'songId', 'comment'];
    public function user(){
        return $this->belongsTo(User::class, 'userId');
    }
    public function song(){
        return $this->belongsTo(Song::class, 'songId');
    }
}
