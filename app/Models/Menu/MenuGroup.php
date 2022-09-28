<?php

namespace App\Models\Menu;

/**
 * App\Models\Menu\MenuGroup
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Menu\Menu[] $menu
 * @method static \Illuminate\Database\Eloquent\Builder|MenuGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuGroup query()
 * @mixin \Eloquent
 */

use App\Models\Base;
use Helpers\MenuTree;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MenuGroup extends Base {

    protected $table = 'menu_groups';
    public $timestamps = false;
    protected $menuItems;
    protected $menuHTML = '';
    protected $parentMenuIds = array();


    const DIVIDER = '---';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function menu() {
        return $this->hasMany( Menu::class )->orderBy( 'position' );
    }

    /**
     * @return Menu|\Illuminate\Database\Eloquent\Model|\Illuminate\Support\Collection
     */
    public function MenuItemsByGroup() {
        return $this->menu;
    }

    /**
     * @param $name
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public static function getMenuByNameItems($name) {
        return self::query()->with( 'menu.permissions', 'menu.groups' )->where( 'slug', '=', $name )->first();
    }

    /**
     * @param $name
     * @return mixed
     *
     */
    public static function getMenuByName($name) {
        $CacheID = 0;
        if ( Auth::check() ) {
            $CacheID = Auth::user()->id;
        }
        return Cache::tags( 'MenuCache' )->remember( 'menu.BuildMenu_' . $name . '.User_' . $CacheID, now()->addDay(), function () use ($name) {
            /** @var self $menugroup */
            $menugroup = self::getMenuByNameItems( $name );
            if ( !is_null( $menugroup ) || !empty( $menugroup ) ) {
                return $menugroup->buildMenu();
            }
            return '';
        } );
    }

    /**
     * @param $name
     * @return mixed
     *
     */
    public static function getFooterMenuByName($name) {
        $CacheID = 0;
        if ( Auth::check() ) {
            $CacheID = Auth::user()->id;
        }
        return Cache::tags( 'MenuCache' )->remember( 'menu.FooterMenu_' . $name . '.User_' . $CacheID, now()->addDay(), function () use ($name) {
            $MenuHtml = '';
            if ( $MenuGroup = self::getMenuByNameItems( $name ) ) {
                $MenuItems = $MenuGroup->menu->filter( function ($MenuItem) {
                    if ( $MenuItem->parent_id == 0 ) {
                        return true;
                    }
                    return false;
                } );
                foreach ( $MenuItems as $MenuItem ) {
                    /** @var Menu $MenuItem */
                    if ( $MenuItem->CheckUserVisibility() ) {
                        $MenuHtml .= '<li><a target="_blank" href="' . e( $MenuItem->url ) . '">' . e( $MenuItem->title ) . '</a></li>';
                    }
                }
            }
            return $MenuHtml;
        } );
    }


    /**
     * @return string
     */
    public function generateSlug() {
        $HexSlug = uniqid();
        $slugQuery = DB::table( 'menu_groups' )->where( 'slug', '=', $HexSlug );

        $slugCount = $slugQuery->count();
        if ( $slugCount == 0 ) {
            return $HexSlug;
        }
        // get reverse order and get first
        $lastSlugNumber = intval( str_replace( $HexSlug . '-', '', $slugQuery->orderBy( 'slug', 'desc' )->first()->slug ) );

        return $HexSlug . '-' . ($lastSlugNumber + 1);

    }


    /**
     * @return string
     *
     */
    public function buildMenu() {

        $menu_items = $this->MenuItemsByGroup();

        //create an array of parent_menu_ids to search through and find out if the current items have an children
        foreach ( $menu_items as $parentId ) {
            $this->parentMenuIds[] = $parentId->parent_id;
        }
        //assign the menu items to the global array to use in the function
        $this->menuItems = $menu_items;

        $this->generate_menu( 0 );

        return $this->menuHTML;


    }

    //recursive function that prints categories as a nested html unordered list

    /**
     * @param $parent
     *
     */
    public function generate_menu($parent) {
        foreach ( $this->menuItems as $MenuItem ) {
            /** @var Menu $MenuItem */
            if ( $MenuItem->CheckUserVisibility() ) {
                // Set  dividers
                if ( $MenuItem->url === self::DIVIDER ) {
                    $this->menuHTML .= '<li class="divider"></li>';
                } else {

                    if ( $MenuItem->parent_id == $parent ) {

                        if ( $MenuItem->parent_id == 0 && in_array( $MenuItem->id, $this->parentMenuIds ) ) {
                            $this->menuHTML .= '<li class="has-dropdown"><a href="' . e( $MenuItem->url ) . '">' . e( $MenuItem->title ) . '</a>';
                            $this->menuHTML .= '<ul class="dropdown">';
                            $this->generate_menu( $MenuItem->id );
                            $this->menuHTML .= '</ul>';
                            $this->menuHTML .= '</li>';
                        } else if ( $MenuItem->parent_id != 0 && in_array( $MenuItem->id, $this->parentMenuIds ) ) {
                            $this->menuHTML .= '<li class="has-dropdown"><a href="' . e( $MenuItem->url ) . '">' . e( $MenuItem->title ) . '</a>';
                            $this->menuHTML .= '<ul class="dropdown">';
                            $this->generate_menu( $MenuItem->id );
                            $this->menuHTML .= '</ul>';
                            $this->menuHTML .= '</li>';
                        } else {
                            $this->menuHTML .= '<li><a href="' . e( $MenuItem->url ) . '">' . e( $MenuItem->title ) . '</a></li>';
                        }
                    }
                }
            }
        }
    }

    /**
     * @return array|null|string
     */
    public function buildSortMenu() {

        $menu_items = $this->MenuItemsByGroup();

        if ( $menu_items ) {
            $tree = new MenuTree;

            foreach ( $menu_items as $menu_item ) {
                // Set vertical dividers
                if ( $menu_item->url === self::DIVIDER ) {
                    $tree->add_row(
                        $menu_item->id, $menu_item->parent_id, ' id="menu_' . $menu_item->id . '" class="dd-item dd3-item no-nesting" data-id="' . $menu_item->id . '"', '<div class="dd-handle dd3-handle">&nbsp;</div> <div class="dd3-content">' . $menu_item->title . '</span>
            <div class="dd-actions">
            <a href="' . url( 'admin/menus/' . $this->id . '/single/' . $menu_item->id . '/delete' ) . '" class="button radius button-inline tiny button-outline-red deletemenuitem">Delete</a>
            </div>
            </div>'
                    );
                } else {
                    $tree->add_row(
                        $menu_item->id, $menu_item->parent_id, ' id="menu_' . $menu_item->id . '" class="dd-item dd3-item" data-id="' . $menu_item->id . '"', '<div class="dd-handle dd3-handle">&nbsp;</div> <div class="dd3-content"><span id="title_' . $menu_item->id . '">' . $menu_item->title . '</span>
            <div class="dd-actions">
            <a href="' . url( 'admin/menus/' . $this->id . '/single/' . $menu_item->id . '/edit' ) . '"  class="button button-outline-teal radius button-inline tiny" title="Edit Menu">Edit</a>
            <a href="' . url( 'admin/menus/' . $this->id . '/single/' . $menu_item->id . '/delete' ) . '" class="button radius button-inline tiny button-outline-red deletemenuitem">Delete</a>
            </div>
            </div>'
                    );
                }
            }

            return $tree->generate_list();
        } else {
            return 'There Are No Menu Items to Display';
        }
    }

}
