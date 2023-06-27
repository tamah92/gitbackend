<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use App\Models\User;
use App\Models\UserSettingsCatagories;

class UserSettings extends Model
{
    use HasFactory, HasApiTokens;
    protected $guard = 'usersettings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'source_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function usersettingscatagories()
    {
        return $this->hasMany(UserSettingsCatagories::class, 'settings_id');
    }
}
