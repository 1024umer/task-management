<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Education extends Model
{
    use HasFactory;
    protected $fillable = ['school_name','degree','area_study','start_date','end_date','user_id'];
    protected $with = ['user'];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
