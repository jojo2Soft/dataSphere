<?php

namespace App\Models;

use App\Models\Dataset;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Column extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'type', 'dataset_id'];

    // Relation avec le modèle Dataset
    public function dataset()
    {
        return $this->belongsTo(Dataset::class);
    }
}
