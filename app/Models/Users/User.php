<?php

namespace App\Models\Users;

use App\Models\Base;
use App\Models\Users\Roles\Role;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Support\Str;

class User extends Base implements AuthenticatableContract, HasLocalePreference
{
    use \Illuminate\Auth\Authenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'reminder_code',
        'activation_code',
        'activated',
        'disabled',
        'require_pw_change',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'activation_code',
        'reminder_code',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function preferredLocale() {
        return $this->locale;
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles() {
        return $this->belongsToMany( Role::class, 'role_user' )->withTimestamps();
    }

    /**
     * Checks if Reminder Code is valid
     * @param $resetCode
     * @return bool
     */
    public function checkResetPasswordCode($resetCode) {

        return ($this->reminder_code == $resetCode);
    }

    /**
     * Generates Reminder Code & Saves to DB.
     *
     * @return string $hashed
     */
    public function generateReminderKey() {
        $hashed = (string)Str::uuid();

        $this->reminder_code = $hashed;
        $this->save();
        return $hashed;
    }

    /**
     * Generates Reminder Code & Saves to DB.
     *
     * @return string $hashed
     */
    public function generateResetToken() {
        $hashed = (string)Str::uuid();
        $this->reset_token = $hashed;
        $this->save();
        return $hashed;
    }

    /**
     * Get User Role Array
     *
     * @return array
     */
    public function getUserRoles() {
        $ThisUser = $this;
        $UserRoles = [];
        foreach ( $ThisUser->roles as $UserRole ) {
            $UserRoles[$UserRole->id] = $UserRole->name;
        }
        return $UserRoles;
    }

    /**
     * @return bool
     */
    public function isSuperAdmin() {
        $UserRoles = $this->getUserRoles();
        if ( is_array( $UserRoles ) ) {
            if ( in_array( 'super_admin', $UserRoles ) ) {
                return true;
            }
        }
        return false;
    }

    /**
     * Can the User do something
     *
     * @param array|string $permissions Single permission or an array or permissions
     * @return boolean
     */
    public function can($permissions) {
        $permissions = !is_array( $permissions ) ? array($permissions) : $permissions;

        try {
            // Are we a super admin?
            if ( $this->isSuperAdmin() ) {
                return true;
            }

            $UserPermissions = $this->getUserPermissions();

            if ( is_array( $UserPermissions ) ) {
                foreach ( $permissions as $PermissionName ) {
                    if ( in_array( $PermissionName, $UserPermissions ) ) {
                        return true;
                    }
                }
            }
            return false;

        } catch (\Exception $e) {
            return false;
        }
    }

    public function getFullName($token)
    {
        return $token;
    }
}
