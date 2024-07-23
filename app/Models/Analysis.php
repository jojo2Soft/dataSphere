<?php

namespace App\Models;

use App\Models\User;
use App\Models\Rating;
use App\Models\Comment;
use App\Models\Dataset;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Analysis extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'user_id','dataset_id'];

      // Relation inverse avec User
      public function user()
      {
          return $this->belongsTo(User::class);
      }
  
      // Relation inverse avec Dataset
      public function dataset()
      {
          return $this->belongsTo(Dataset::class);
      }
  
      // Relation avec les commentaires
      public function comments()
      {
          return $this->hasMany(Comment::class);
      }
  
      // Relation avec les notes
      public function ratings()
      {
          return $this->hasMany(Rating::class);
      }
}
