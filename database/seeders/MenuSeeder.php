<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Menu = [
            [
                'name' => 'لوحة التحكم',
                'name_en' => 'Dashboard',
                'name_he' => 'Dashboard',
                'route' => 'home',
                'icon_svg' => getSvgIcon('dashboard'),
                'order' => 1,
                'permission_name' => 'dashboard_access',
            ],
        ];

        $config = config('modules.settings');
        $Menu[] = [
            'name' => t($config['plural_name'], [], 'ar'),
            'name_en' => t($config['plural_name'], [], 'en'),
            'name_he' => t($config['plural_name'], [], 'he'),
            'route' => null,
            'icon_svg' => getSvgIcon('settings'),
            'order' => 5,
            'permission_name' => $config['permissions']['view'],
            'subRoutes' => [
                [
                    'name' => t($config['children']['general']['plural_name'], [], 'ar'),
                    'name_en' => t($config['children']['general']['plural_name'], [], 'en'),
                    'name_he' => t($config['children']['general']['plural_name'], [], 'he'),
                    'route' => $config['children']['general']['full_route_name'] . '.index',
                    'icon_svg' => '',
                    'order' => 2,
                    'permission_name' => $config['children']['general']['permissions']['view'],
                ],

            ],
        ];



        $Menu[] = [

            'name' => t(config('modules.sliders.plural_name'), [], 'ar'),
            'name_en' => t(config('modules.sliders.plural_name'), [], 'en'),
            'name_he' => t(config('modules.sliders.plural_name'), [], 'he'),
            'route' => null,
            'icon_svg' => '<i class="fas fa-sliders-h"></i>', // FontAwesome icon for sliders
            'order' => 5,
            'permission_name' => config('modules.sliders.permissions.view'),
            'route' => config('modules.sliders.full_route_name') . '.index',
        ];

        $Menu[] = [
            'name' => t(config('modules.categories.plural_name'), [], 'ar'),
            'name_en' => t(config('modules.categories.plural_name'), [], 'en'),
            'name_he' => t(config('modules.categories.plural_name'), [], 'he'),
            'route' => null,
            'icon_svg' => '<i class="fa fa-th-large"></i>',
            'order' => 6,
            'permission_name' => config('modules.categories.permissions.view'),
            'route' => config('modules.categories.full_route_name') . '.index',
        ];
        $Menu[] = [
            'name' => t(config('modules.coupons.plural_name'), [], 'ar'),
            'name_en' => t(config('modules.coupons.plural_name'), [], 'en'),
            'name_he' => t(config('modules.coupons.plural_name'), [], 'he'),
            'route' => null,
            'icon_svg' => '<i class="fa fa-percent"></i>',
            'order' => 6,
            'permission_name' => config('modules.coupons.permissions.view'),
            'route' => config('modules.coupons.full_route_name') . '.index',
        ];

        $Menu[] = [
            'name' => t(config('modules.addresses.plural_name'), [], 'ar'),
            'name_en' => t(config('modules.addresses.plural_name'), [], 'en'),
            'name_he' => t(config('modules.addresses.plural_name'), [], 'he'),
            'route' => null,
            'icon_svg' => '<i class="fa fa-th-large"></i>',
            'order' => 6,
            'permission_name' => config('modules.addresses.permissions.view'),
            'route' => config('modules.addresses.full_route_name') . '.index',
        ];
        $Menu[] = [
            'name' => t(config('modules.products.plural_name'), [], 'ar'),
            'name_en' => t(config('modules.products.plural_name'), [], 'en'),
            'name_he' => t(config('modules.products.plural_name'), [], 'he'),
            'route' => null,
            'icon_svg' => '<i class="fa fa-th-large"></i>',
            'order' => 6,
            'permission_name' => config('modules.products.permissions.view'),
            'route' => config('modules.products.full_route_name') . '.index',
        ];

        $Menu[] = [

            'name' => t(config('modules.why_choose_us.plural_name'), [], 'ar'),
            'name_en' => t(config('modules.why_choose_us.plural_name'), [], 'en'),
            'name_he' => t(config('modules.why_choose_us.plural_name'), [], 'he'),
            'route' => null,
            'icon_svg' => '<i class="fas fa-question"></i>', // FontAwesome icon for sliders
            'order' => 5,
            'permission_name' => config('modules.why_choose_us.permissions.view'),
            'route' => config('modules.why_choose_us.full_route_name') . '.index',
        ];
        $Menu[] = [
            'name' => t(config('modules.customer_rates.plural_name'), [], 'ar'),
            'name_en' => t(config('modules.customer_rates.plural_name'), [], 'en'),
            'name_he' => t(config('modules.customer_rates.plural_name'), [], 'he'),
            'route' => null,
            'icon_svg' => '<i class="fas fa-star"></i>', // FontAwesome icon for sliders
            'order' => 5,
            'permission_name' => config('modules.customer_rates.permissions.view'),
            'route' => config('modules.customer_rates.full_route_name') . '.index',
        ];
        $Menu[] = [
            'name' => t(config('modules.how_we_works.plural_name'), [], 'ar'),
            'name_en' => t(config('modules.how_we_works.plural_name'), [], 'en'),
            'name_he' => t(config('modules.how_we_works.plural_name'), [], 'he'),
            'route' => null,
            'icon_svg' => '<i class="fas fa-tasks"></i>', // FontAwesome icon for sliders
            'order' => 5,
            'permission_name' => config('modules.how_we_works.permissions.view'),
            'route' => config('modules.how_we_works.full_route_name') . '.index',
        ];
        $Menu[] = [
            'name' => t(config('modules.articles_types.plural_name'), [], 'ar'),
            'name_en' => t(config('modules.articles_types.plural_name'), [], 'en'),
            'name_he' => t(config('modules.articles_types.plural_name'), [], 'he'),
            'route' => null,
            'icon_svg' => '<i class="fas fa-file-alt"></i>', // FontAwesome icon for sliders
            'order' => 5,
            'permission_name' => config('modules.articles_types.permissions.view'),
            'route' => config('modules.articles_types.full_route_name') . '.index',
        ];
        $Menu[] = [
            'name' => t(config('modules.articles.plural_name'), [], 'ar'),
            'name_en' => t(config('modules.articles.plural_name'), [], 'en'),
            'name_he' => t(config('modules.articles.plural_name'), [], 'he'),
            'route' => null,
            'icon_svg' => '<i class="fas fa-file-alt"></i>', // FontAwesome icon for sliders
            'order' => 5,
            'permission_name' => config('modules.articles.permissions.view'),
            'route' => config('modules.articles.full_route_name') . '.index',
        ];

        $Menu[] = [

            'name' => t(config('modules.services.plural_name'), [], 'ar'),
            'name_en' => t(config('modules.services.plural_name'), [], 'en'),
            'name_he' => t(config('modules.services.plural_name'), [], 'he'),
            'route' => null,
            'icon_svg' => '<i class="fas fa-cogs"></i>', // FontAwesome icon for sliders
            'order' => 5,
            'permission_name' => config('modules.services.permissions.view'),
            'route' => config('modules.services.full_route_name') . '.index',
        ];
        $Menu[] = [
            'name' => t(config('modules.sucess_stories.plural_name'), [], 'ar'),
            'name_en' => t(config('modules.sucess_stories.plural_name'), [], 'en'),
            'name_he' => t(config('modules.sucess_stories.plural_name'), [], 'he'),
            'route' => null,
            'icon_svg' => '<i class="fas fa-star"></i>', // FontAwesome icon for sucess stories
            'order' => 5,
            'permission_name' => config('modules.sucess_stories.permissions.view'),
            'route' => config('modules.sucess_stories.full_route_name') . '.index',
        ];
        $Menu[] = [
            'name' => t(config('modules.videos.plural_name'), [], 'ar'),
            'name_en' => t(config('modules.videos.plural_name'), [], 'en'),
            'name_he' => t(config('modules.videos.plural_name'), [], 'he'),
            'route' => null,
            'icon_svg' => '<i class="fas fa-video"></i>', // FontAwesome icon for videos
            'order' => 5,
            'permission_name' => config('modules.videos.permissions.view'),
            'route' => config('modules.videos.full_route_name') . '.index',
        ];
        $Menu[] = [
            'name' => t(config('modules.faq.plural_name'), [], 'ar'),
            'name_en' => t(config('modules.faq.plural_name'), [], 'en'),
            'name_he' => t(config('modules.faq.plural_name'), [], 'he'),
            'route' => null,
            'icon_svg' => '<i class="fas fa-question"></i>', // FontAwesome icon for faq
            'order' => 5,
            'permission_name' => config('modules.faq.permissions.view'),
            'route' => config('modules.faq.full_route_name') . '.index',
        ];



        $Menu[] = [
            'name' => t(config('modules.about_office.plural_name'), [], 'ar'),
            'name_en' => config('modules.about_office.plural_name'),
            'name_he' => config('modules.about_office.plural_name'),
            'route' => null,
            'icon_svg' => '<i class="fas fa-building"></i>', // FontAwesome icon for videos
            'order' => 5,
            'permission_name' => config('modules.about_office.permissions.view'),
            'route' => config('modules.about_office.full_route_name') . '.index',
        ];
        $Menu[] = [
            'name' => t(config('modules.contact_us.plural_name'), [], 'ar'),
            'name_en' => config('modules.contact_us.plural_name'),
            'name_he' => config('modules.contact_us.plural_name'),
            'route' => null,
            'icon_svg' => '<i class="fas fa-envelope"></i>', // FontAwesome icon for videos
            'order' => 5,
            'permission_name' => config('modules.contact_us.permissions.view'),
            'route' => config('modules.contact_us.full_route_name') . '.index',
        ];
        $Menu[] = [
            'name' => t(config('modules.real_results.plural_name'), [], 'ar'),
            'name_en' => config('modules.real_results.plural_name'),
            'name_he' => config('modules.real_results.plural_name'),
            'route' => null,
            'icon_svg' => '<i class="fas fa-chart-line"></i>', // FontAwesome icon for videos
            'order' => 5,
            'permission_name' => config('modules.real_results.permissions.view'),
            'route' => config('modules.real_results.full_route_name') . '.index',
        ];

        DB::table('menus')->delete();

        foreach ($Menu as $menuItem) {
            // dd($menuItem);
            $parent = Menu::updateOrCreate([
                'name' => $menuItem['name'],
                'name_en' => $menuItem['name_en'],
                'name_he' => $menuItem['name_he'],
                'route' => $menuItem['route'],
                'icon_svg' => $menuItem['icon_svg'],
                'order' => $menuItem['order'],
                'permission_name' => $menuItem['permission_name'],
            ]);
            if (isset($menuItem['subRoutes'])) {
                foreach ($menuItem['subRoutes'] as $subMenu) {
                    Menu::updateOrCreate([
                        'name' => $subMenu['name'],
                        'name_en' => $subMenu['name_en'],
                        'name_he' => $subMenu['name_he'],
                        'route' => $subMenu['route'],
                        'icon_svg' => $subMenu['icon_svg'],
                        'order' => $subMenu['order'],
                        'permission_name' => $subMenu['permission_name'],
                        'parent_id' => $parent->id,
                    ]);
                }
            }
        }

        $this->command->info('Menu created successfully!');
    }
}
