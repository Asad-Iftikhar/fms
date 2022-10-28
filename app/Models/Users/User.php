<?php

namespace App\Models\Users;

use App\Models\Base;
use App\Models\Fundings\FundingCollection;
use App\Models\Media\Media;
use App\Models\Users\Roles\Role;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class User extends Base implements AuthenticatableContract, HasLocalePreference
{
    use \Illuminate\Auth\Authenticatable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'first_name',
        'last_name',
        'password',
        'phone',
        'gender',
        'joining_date',
        'reminder_code',
        'activation_code',
        'activated',
        'disabled',
        'avatar',
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

    public function avatarImage() {
        return $this->belongsTo(Media::class,'avatar');
    }

    public function fundingCollectionsUser() {
        return $this->hasMany(FundingCollection::class,'user_id');
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
     * Reset Change Password token.
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
     * Get User Permissions Array
     *
     * @return array
     */
    public function getUserPermissions() {
        $ThisUser = $this;
        try {
            $UserRoles = $ThisUser->roles;
            $UserPermissions = [];
            foreach ( $UserRoles as $UserRole ) {
                foreach ( $UserRole->permissions as $permission ) {
                    $UserPermissions[$permission->id] = $permission->name;
                }
            }
            return $UserPermissions;
        } catch (\Exception $e) {
            return [];
        }
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

    /**
     * Get User Avatar
     *
     * @return string
     */
    public function getUserAvatar() {

        if ($this->avatar) {
            return $this->avatarImage->url_file;
        } else {
            // on the base of gender return default avatar
            if ($this->gender == 'female') {
                return asset('assets/images/faces/3.jpg');
            }
        }
        return asset('assets/images/faces/2.jpg');
    }

    /**
     * Get User Status
     *
     * @return string
     */
    public function getUserActiveStatus() {

        if ($this->activated) {
            return '<span class="badge bg-success">Active</span>';
        } else {
            return '<span class="badge bg-danger">Inactive</span>';
        }
    }

    /**
     * Get User Change Status Buttons
     *
     * @return string
     */
    public function getChangeStatusButton() {

        if ($this->activated) {
            return '<a href="'.url('admin/users/change-status/'.$this->id).'" class="btn btn-sm btn-outline-danger">Deactivate</a>';
        } else {
            return '<a href="'.url('admin/users/change-status/'.$this->id).'" class="btn btn-sm btn-outline-success">Activate</a>';
        }
    }

    /**
     * Full name as a link
     * @return string
     */
    public function linkWithFullName() {

        if ($this->trashed()) {
            # if user deleted then no need to show its link
            return $this->getFullName();
        } else {
            // if user not deleted
            return '<a href="'.url("admin/users/edit").'/'. $this->id .'" type="button">' . $this->getFullName() . '</a>';
        }
    }

    /**
     * Full name
     * @return string
     */
    public function getFullName() {
        if (is_null($this->firstname) && is_null($this->lastname)) {
            return 'N/A';
        }
        return $this->firstname . ' ' . $this->lastname;
    }


}
