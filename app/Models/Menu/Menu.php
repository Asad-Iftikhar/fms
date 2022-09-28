<?php

namespace App\Models\Menu;

/**
 * App\Models\Menu\Menu
 *
 * @property int $id
 * @property int $parent_id
 * @property string $title
 * @property string $localization
 * @property string $url
 * @property int $position
 * @property int $menu_group_id
 * @property-read \Illuminate\Database\Eloquent\Collection|Group[] $groups
 * @property-read \App\Models\Menu\MenuGroup $menugroup
 * @property-read \Illuminate\Database\Eloquent\Collection|Permission[] $permissions
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu query()
 * @mixin \Eloquent
 */

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Models\Base;
use App\Models\Users\Groups\Group;
use App\Models\Users\Roles\Permission;

class Menu extends Base {

    protected $table = 'menus';
    public $timestamps = false;
    protected $fillable = array('parent_id', 'title', 'url', 'position', 'menu_group_id', 'localization');


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions() {
        return $this->belongsToMany( Permission::class, 'menu_user_permissions', 'menu_id', 'permission_id' )->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menugroup() {
        return $this->belongsTo( MenuGroup::class );
    }

    /**
     * @return bool
     */
    public function HasUserPermissions() {
        if ( $this->permissions->count() > 0 ) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     *
     */
    public function CheckUserVisibility() {
        if ( $this->HasUserPermissions() ) {
            if ( Auth::guest() ) {
                return false;
            }

            $MenuPermissions = $this->permissions->pluck( 'id' )->all();
            if ( !is_null( $MenuPermissions ) && !empty( $MenuPermissions ) ) {
                if ( Auth::user()->canById( $MenuPermissions ) ) {
                    return true;
                }
            }
            return false;
        }
        return true;
    }

    /**
     * @param $newmenuorder
     */
    public static function saveMenuPostion($newmenuorder) {
        foreach ( $newmenuorder as $position => $menuid ) {
            $menuitem = self::query()->find( $menuid['id'] );
            $menuitem->position = $position;
            $menuitem->parent_id = 0;
            if ( $menuitem->save() ) {
                if ( isset( $menuid['children'] ) ) {
                    self::saveSubMenuPostion( $menuid['children'], $menuid['id'] );
                }
            }
        }
    }

    /**
     * @param $newmenuorder
     * @param $parentid
     */
    public static function saveSubMenuPostion($newmenuorder, $parentid) {

        foreach ( $newmenuorder as $position => $menuid ) {
            $menuitem = self::query()->find( $menuid['id'] );
            $menuitem->position = $position;
            $menuitem->parent_id = $parentid;
            if ( $menuitem->save() ) {
                if ( isset( $menuid['children'] ) ) {
                    self::saveSubMenuPostion( $menuid['children'], $menuid['id'] );
                }
            }
        }
    }

    /**
     * @return bool|null
     *
     */
    public function deleteMenu() {
        $menuid = $this->id;
        //Delete Any Children of Menu First
        $children = self::where( 'parent_id', '=', $menuid )->get();
        if ( !is_null( $children ) ) {
            foreach ( $children as $child ) {
                $child->deleteMenu();
            }
        }
        try {
            return $this->delete();
        } catch (\Exception $e) {
            report( $e );
            return false;
        }
    }

    public function title(): Attribute {
        return new Attribute(
            get: function ($title) {
                if ( locale()->getLocale() == settings()->get( 'DefaultLocale', 'en' ) ) {
                    return $title;
                }
                $Value = $this->hasLocalization( locale()->getLocale() );
                if ( !empty( $Value ) ) {
                    return $Value;
                } else {
                    return $title;
                }
            }
        );
    }

    public function getTranslationHtml($locale) {
        $html =
            '<div class="row">
                            <div class="small-12 columns">
                                <span>' . $this->title . '
                                <i data-text="' . $this->title . '" data-locale="' . $locale . '" data-key="' . $this->id . '" class="TranslateButton icon-translate"></i>
                                </span>
                                <br>';
        if ( $value = $this->hasLocalization( $locale ) ) {
            $html .= '<input data-id="' . $this->id . '" value="' . $value . '" type="text" name="MenuItem_' . $this->id . '" id="MenuItem_' . $this->id . '">';
        } else {
            $html .= '<input data-id="' . $this->id . '" value="" type="text" name="MenuItem_' . $this->id . '" id="MenuItem_' . $this->id . '">';
        }
        $html .= '</div></div>';
        return $html;
    }

    public function setLocalization($locale, $value) {
        $LocaleList = (!empty( $this->localization ) ? json_decode( $this->localization, true ) : array());

        if ( filled( $value ) ) {
            $LocaleList[$locale] = security()->RemoveAllSpaceEntities( $value );
        } else {
            Arr::forget( $LocaleList, $locale );
        }

        $this->localization = json_encode( $LocaleList );
        $this->save();
    }


    public function hasLocalization($locale) {
        $LocaleList = (!empty( $this->localization ) ? json_decode( $this->localization, true ) : array());

        return Arr::get( $LocaleList, $locale, null );
    }
}

