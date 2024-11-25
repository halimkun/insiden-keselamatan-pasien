<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // call other seeders
        $this->call(PermissionAndRoles::class);

        // ===== ===== ===== ===== =====  Administrator  User 
        // Administrator user
        $adm = User::factory()->create([
            'name'     => 'Administrator',
            'username' => 'admin',
            'email'    => 'admin@mail.com'
        ]);

        // assign role
        $adm->assignRole('administrator');

        // ===== ===== ===== ===== =====  Komite Mutu User
        $kmtu = [
            [
                'name'     => 'Komite Mutu 1',
                'username' => 'komitemutu1',
                'email'    => 'komitemutu1@mail.com'
            ],
            [
                'name'     => 'Komite Mutu 2',
                'username' => 'komitemutu2',
                'email'    => 'komitemutu2@mail.com'
            ],
        ];

        foreach ($kmtu as $user) {
            $u = User::factory()->create($user);
            $u->assignRole('komite-mutu');
        }

        // ===== ===== ===== ===== =====  Direksi User
        $drksi = [
            [
                'name'     => 'Direksi 1',
                'username' => 'direksi1',
                'email'    => 'direksi1@mail.com'
            ],
            [
                'name' => 'Direksi 2',
                'username' => 'direksi2',
                'email' => 'direksi2@mail.com',
            ],
        ];
        
        foreach ($drksi as $user) {
            $u = User::factory()->create($user);
            $u->assignRole('direksi');
        }

        // ===== ===== ===== ===== =====  Pelapor User
        $u = User::factory(5)->create();
        $u->each(function ($user) {
            $user->assignRole('pelapor');
        });
    }
}
