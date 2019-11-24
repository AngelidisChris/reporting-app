<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'title',
        'image'
    ];

    public function profileImage()
    {
        $imagePath = ($this->image) ?  $this->image : 'profile/profile_pic.png';

        return  '/storage/' . $imagePath;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
