<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    protected $appends = ['image_url'];
    protected $with = ['country','role'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'role_id',
        'email',
        'password',
        'country_id',
        'phone',
        'skill_id',
        'college',
        'about_me',
        'dob',
        'gender',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function country(){
        return $this->belongsTo(Country::class);
    }
    public function image(){
        return $this->morphOne(File::class,'fileable');
    }
    public function getImageUrlAttribute(){
        if($this->image){
            return asset($this->image->url);
        }else{
            return 'https://randomuser.me/api/portraits/med/men/75.jpg';
        }
    }
    public function role(){
        return $this->belongsTo(Role::class);
    }
    public function skills(){
        // $skill = json_decode($this->skill_id);
        // return Skill::where('id',$skill)->get();
        return null;
    }
}
