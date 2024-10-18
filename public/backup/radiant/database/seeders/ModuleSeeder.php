<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        //  Permission Array 
        $permissions = [
            [
                'module_id'     => '101',
                'name'          => 'General Setting',
                'can_add'       => 1,
                'can_edit'      => 1,
                'can_delete'    => 1,
                'can_view'      => 1,
                'allow_all'     => 1
            ],
            [
                'module_id'     => '102',
                'name'          => 'Dashboard',
                'can_add'       => 1,
                'can_edit'      => 1,
                'can_delete'    => 1,
                'can_view'      => 1,
                'allow_all'     => 1
            ],
            [
                'module_id'     => '103',
                'name'          => 'Banners',
                'can_add'       => 1,
                'can_edit'      => 1,
                'can_delete'    => 1,
                'can_view'      => 1,
                'allow_all'     => 1
            ],
            [
                'module_id'     => '104',
                'name'          => 'CMS',
                'can_add'       => 1,
                'can_edit'      => 1,
                'can_delete'    => 1,
                'can_view'      => 1,
                'allow_all'     => 1
            ],
            
            [
                'module_id'     => '105',
                'name'          => 'Home CMS',
                'can_add'       => 1,
                'can_edit'      => 1,
                'can_delete'    => 1,
                'can_view'      => 1,
                'allow_all'     => 1
            ],
            [
                'module_id'     => '106',
                'name'          => 'Testimonials',
                'can_add'       => 1,
                'can_edit'      => 1,
                'can_delete'    => 1,
                'can_view'      => 1,
                'allow_all'     => 1
            ],
            [
                'module_id'     => '107',
                'name'          => 'News lettter',
                'can_add'       => 1,
                'can_edit'      => 1,
                'can_delete'    => 1,
                'can_view'      => 1,
                'allow_all'     => 1
            ],
            [
                'module_id'     => '108',
                'name'          => 'Role',
                'can_add'       => 1,
                'can_edit'      => 1,
                'can_delete'    => 1,
                'can_view'      => 1,
                'allow_all'     => 1
            ],
            [
                'module_id'     => '109',
                'name'          => 'Sub Admin',
                'can_add'       => 1,
                'can_edit'      => 1,
                'can_delete'    => 1,
                'can_view'      => 1,
                'allow_all'     => 1
            ],
            [
                'module_id'     => '110',
                'name'          => 'Faq Category',
                'can_add'       => 1,
                'can_edit'      => 1,
                'can_delete'    => 1,
                'can_view'      => 1,
                'allow_all'     => 1
            ],
            [
                'module_id'     => '111',
                'name'          => 'Faqs',
                'can_add'       => 1,
                'can_edit'      => 1,
                'can_delete'    => 1,
                'can_view'      => 1,
                'allow_all'     => 1
            ],
            [
                'module_id'     => '112',
                'name'          => 'Event Category',
                'can_add'       => 1,
                'can_edit'      => 1,
                'can_delete'    => 1,
                'can_view'      => 1,
                'allow_all'     => 1
            ],
            [
                'module_id'     => '113',
                'name'          => 'Events',
                'can_add'       => 1,
                'can_edit'      => 1,
                'can_delete'    => 1,
                'can_view'      => 1,
                'allow_all'     => 1
            ],
            [
                'module_id'     => '114',
                'name'          => 'Bolg Category',
                'can_add'       => 1,
                'can_edit'      => 1,
                'can_delete'    => 1,
                'can_view'      => 1,
                'allow_all'     => 1
            ],
            [
                'module_id'     => '115',
                'name'          => 'Blogs',
                'can_add'       => 1,
                'can_edit'      => 1,
                'can_delete'    => 1,
                'can_view'      => 1,
                'allow_all'     => 1
            ],
            [
                'module_id'     => '116',
                'name'          => 'Doctor Description',
                'can_add'       => 1,
                'can_edit'      => 1,
                'can_delete'    => 1,
                'can_view'      => 1,
                'allow_all'     => 1
            ],
            [
                'module_id'     => '117',
                'name'          => 'Team',
                'can_add'       => 1,
                'can_edit'      => 1,
                'can_delete'    => 1,
                'can_view'      => 1,
                'allow_all'     => 1
            ],
            [
                'module_id'     => '118',
                'name'          => 'Awards',
                'can_add'       => 1,
                'can_edit'      => 1,
                'can_delete'    => 1,
                'can_view'      => 1,
                'allow_all'     => 1
            ],
            [
                'module_id'     => '119',
                'name'          => 'General Inquiries',
                'can_add'       => 1,
                'can_edit'      => 1,
                'can_delete'    => 1,
                'can_view'      => 1,
                'allow_all'     => 1
            ],
            [
                'module_id'     => '120',
                'name'          => 'Gallery',
                'can_add'       => 1,
                'can_edit'      => 1,
                'can_delete'    => 1,
                'can_view'      => 1,
                'allow_all'     => 1
            ],
            [
                'module_id'     => '121',
                'name'          => 'Newsletter Notifications',
                'can_add'       => 1,
                'can_edit'      => 1,
                'can_delete'    => 1,
                'can_view'      => 1,
                'allow_all'     => 1
            ],
            [
                'module_id'     => '122',
                'name'          => 'Become A Member Inquiries',
                'can_add'       => 1,
                'can_edit'      => 1,
                'can_delete'    => 1,
                'can_view'      => 1,
                'allow_all'     => 1
            ],
            
        ];
        

        Module::insert($permissions);
    }
}
