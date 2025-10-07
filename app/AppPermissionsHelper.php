<?php

namespace App;

use App\Models\Attachment;
use Exception;
use Illuminate\Support\Facades\Route;

class AppPermissionsHelper
{
    /*
        :::::::: IMPORTANT NOTE ::::::::

        all permission should have postfix as one of the following
        _access
        _add
        _edit
        _delete
    */
    public static function getPermissions()
    {
        $permissions = [
            'User Management Module' => [
                'Manage' => 'user_management_access',
            ],
            'Settings Module' => [
                'Menu settings' => 'settings_menu_access',
                'Constants' => 'settings_constants_access',

            ],


        ];

        // Main Settings module permissions
        $permissions[config('modules.settings.plural_name')] = config('modules.settings.permissions');

        // General Settings permissions
        $permissions[config('modules.settings.children.general.plural_name')] = config('modules.settings.children.general.permissions');
        $permissions[config('modules.sliders.plural_name')] = config('modules.sliders.permissions');
        $permissions[config('modules.attachments.plural_name')] = config('modules.attachments.permissions');

        //  categories permissions (child of restaurants)
        $permissions[config('modules.categories.plural_name')] = config('modules.categories.permissions');
        $permissions[config('modules.coupons.plural_name')] = config('modules.coupons.permissions');
        $permissions[config('modules.addresses.plural_name')] = config('modules.addresses.permissions');
        $permissions[config('modules.products.plural_name')] = config('modules.products.permissions');
        $permissions[config('modules.why_choose_us.plural_name')] = config('modules.why_choose_us.permissions');
        $permissions[config('modules.customer_rates.plural_name')] = config('modules.customer_rates.permissions');
        $permissions[config('modules.how_we_works.plural_name')] = config('modules.how_we_works.permissions');
        $permissions[config('modules.articles_types.plural_name')] = config('modules.articles_types.permissions');
        $permissions[config('modules.articles.plural_name')] = config('modules.articles.permissions');
        $permissions[config('modules.articles.children.article_contents.plural_name')] = config('modules.articles.children.article_contents.permissions');
        $permissions[config('modules.services.plural_name')] = config('modules.services.permissions');
        $permissions[config('modules.sucess_stories.plural_name')] = config('modules.sucess_stories.permissions');
        $permissions[config('modules.videos.plural_name')] = config('modules.videos.permissions');
        $permissions[config('modules.faq.plural_name')] = config('modules.faq.permissions');

        $permissionFlatten = collect($permissions)->unique()->flatten(1);
        self::CheckMiddlewares($permissionFlatten);

        return $permissions;
    }

    private static function CheckMiddlewares($usedPermissions)
    {

        $routes = Route::getRoutes()->getRoutesByName();
        $remove = [
            'sanctum.csrf-cookie',
            'ignition.healthCheck',
            'ignition.executeSolution',
            'ignition.updateConfig',
            'login',
            'authenticate',
            'logout',
            'home',
            'setLanguage',
        ];

        $routes = array_diff_key($routes, array_flip($remove));
        // $routeNames = array_keys($routes);

        $routesAndPermissions = [];

        foreach ($routes as $route) {
            $routeMiddleware = collect($route->action['middleware']);
            $filtered = $routeMiddleware->filter(function ($value, $key) {
                if (strpos($value, 'permission:') === 0) {
                    return $value;
                }
            })->map(function ($item, $key) {
                $permission = substr($item, 11);
                $permissions = explode('|', $permission);

                return $permissions;
            })->flatten(1);
            // dd($filtered);
            foreach ($filtered as $permissionMiddleware) {
                // code...
                array_push($routesAndPermissions, $permissionMiddleware);
            }
        }
        $routesAndPermissions = collect($routesAndPermissions)->unique();
        if ($routesAndPermissions->diff($usedPermissions)->count() > 0) {

            $diff = $routesAndPermissions->diff($usedPermissions)->toArray();
            throw new Exception("Please Check AppPermissionsHelper.php file \n middleware used in web routes aren't included!" . implode(',', $diff));
        }
    }
}
