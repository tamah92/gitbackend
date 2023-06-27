<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use App\Models\UserSettings;

class UserSettingsCatagories extends Model
{
    use HasFactory, HasApiTokens;
    protected $guard = 'catagories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'settings_id',
        'catagory_id',
    ];

    public function usersettings()
    {
        return $this->belongsTo(UserSettings::class);
    }
}
