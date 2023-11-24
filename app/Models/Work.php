<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;
    protected $with = ['proposal'];
    protected $fillable = ['proposal_id','is_progress','is_review','is_pending','is_completed'];
    public function proposal(){
        return $this->belongsToMany(Proposal::class);
    }
}
