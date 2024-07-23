<?php

namespace App\Models;

use App\Models\User;
use App\Models\Analysis;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rating extends Model
{
    use HasFactory;
    protected $fillable = ['score', 'user_id', 'analysis_id'];

    // Relation inverse avec User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation inverse avec Analysis
    public function analysis()
    {
        return $this->belongsTo(Analysis::class);
    }
}
