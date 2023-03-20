<?php

namespace EscolaLms\TopicTypeGift\Database\Seeders;

use EscolaLms\TopicTypeGift\Enum\TopicTypeGiftProjectPermissionEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TopicTypeGiftPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Role::findOrCreate('admin', 'api');
        $student = Role::findOrCreate('student', 'api');

        foreach (TopicTypeGiftProjectPermissionEnum::getValues() as $permission) {
            Permission::findOrCreate($permission, 'api');
        }

        $admin->givePermissionTo(TopicTypeGiftProjectPermissionEnum::getValues());

        $student->givePermissionTo([
            TopicTypeGiftProjectPermissionEnum::CREATE_OWN_QUIZ_ATTEMPT,
            TopicTypeGiftProjectPermissionEnum::LIST_OWN_QUIZ_ATTEMPT,
            TopicTypeGiftProjectPermissionEnum::READ_OWN_QUIZ_ATTEMPT,
        ]);
    }
}
