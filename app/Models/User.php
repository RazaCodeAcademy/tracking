<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;

// use facades here
use Carbon\Carbon;


class User extends Authenticatable
{
    use Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 
        'first_name', 
        'last_name', 
        'username', 
        'email', 
        'date_of_birth', 
        'gender', 
        'placement',  
        'city',  
        'pass',  
        'zip_code',  
        'phone_number', 
        'cnic', 
        'payment_process', 
        'promoter_id', 
        'password',  
        'account_type',  
        'is_approved'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'pass'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // protected $appends = ['saved', 'shortListed', 'applied'];

    // public function getSavedAttribute(){
    //     return $this->isSavedListed()
    // }

    public function get_name(){
        if(!empty($this->first_name) && !empty($this->last_name)){
            return $this->first_name.' '.$this->last_name;
        }else{
            return "Guest User";
        }
    }

    public function account_bal()
    {
        return $this->hasOne(AccountType::class, 'id', 'account_type');
    }



    public function get_notification()
    {
        return $this->hasMany(Notification::class, 'notifiable_id', 'id')->where('read_at', null)->orderBy('created_at', 'desc');
    }
    
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'state_id', 'id');
    }
    
    public function city()
    {
        return $this->belongsTo(City::class, 'city_name', 'id');
    }
    
    public function photos(){
        return $this->hasMany(Photo::class, 'parent_id', 'id')->where('parent_type', User::class);

    }

    public function get_image()
    {
        $image = !empty($this->photos->sortByDesc('created_at')->first());
        $image = $image ? $this->photos->sortByDesc('created_at')->first()->path : '';
        if(!empty($image) && file_exists(public_path().'/storage/'.$image)){
            return asset('public/storage/'.$image);
        }else{
            return asset('public/app-assets/images/portrait/small/avatar-s-19.png');
        }
    }
    

    public function getLastLogin(){
        return $this->last_login != null ? Carbon::parse($this->last_login)->diffForHumans() : 'N/A';
    }

    
    public function promoter()
    {
        return $this->hasMany(UserPromoter::class, 'promoter_id', 'id');
    }
    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'sender_id', 'id');
    }

    public function get_promoter(){
        return $this->belongsTo(User::class, 'promoter_id', 'id');
    }
    
}