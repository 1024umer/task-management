<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;
    protected $with = ['user','task','proposal_images'];
    protected $fillable = ['duration','amount','cover','user_id','task_id'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function task(){
        return $this->belongsTo(Task::class);
    }
    public function proposal_images()
    {
        return $this->morphMany(File::class, 'fileable')->where('table_name', 'proposal');
    }
}
