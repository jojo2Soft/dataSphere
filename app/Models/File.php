<?php

namespace App\Models;

use App\Models\Dataset;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class File extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'path', 'dataset_id'];

     // Relation inverse avec Dataset
     public function dataset()
     {
         return $this->belongsTo(Dataset::class);
     }
}
