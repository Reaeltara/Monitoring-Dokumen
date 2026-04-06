<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['name' => 'Author'],
            [
                'password' => 'BlueDragon102',
                'is_admin' => true,
            ]
        );

        Document::whereNull('user_id')->update([
            'user_id' => $admin->id,
        ]);
    }
}
