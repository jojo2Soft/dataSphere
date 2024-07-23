<?php

namespace App\Models;

use App\Models\File;
use App\Models\User;
use App\Models\Column;
use App\Models\Rating;
use App\Models\Comment;
use App\Models\Analysis;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dataset extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'user_id'];

  // Relation avec les colonnes
  public function columns()
  {
      return $this->hasMany(Column::class);
  }

  // Relation avec les fichiers
  public function files()
  {
      return $this->hasMany(File::class);
  }

  // Relation avec les analyses
  public function analyses()
  {
      return $this->hasMany(Analysis::class, 'user_id');
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

  // Relation inverse avec User
  public function user()
  {
      return $this->belongsTo(User::class);
  }

}
