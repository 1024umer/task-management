<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $with = ['user','project_cover','project_file'];
    protected $appends = ['project_cover','project_file'];

    protected $fillable = ['title','description','start_date','end_date','budget','user_id'];
    public function project_cover(){
        return $this->hasMany(File::class, 'fileable_id', 'id')->where('table_name', 'project_cover');
    }
    public function project_file(){
        return $this->hasMany(File::class, 'fileable_id', 'id')->where('table_name', 'project_file');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function getProjectCoverAttribute()
    {
        if($this->image){
            return asset($this->image->url);
        }else{
            return '';
        }
    }
    public function getProjectFileAttribute()
    {
        if($this->image){
            return asset($this->image->url);
        }else{
            return '';
        }
    }
}
