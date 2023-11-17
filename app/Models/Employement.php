<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employement extends Model
{
    use HasFactory;
    protected $fillable =['company_name','designation','city','country_id','start_date','end_date','description','is_working','user_id'];
    protected $with = ['user','country'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function country(){
        return $this->belongsTo(Country::class);
    }
}
