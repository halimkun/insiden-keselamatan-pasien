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
        // ===== ===== ===== ===== =====  Permission and Roles
        $this->call(PermissionAndRoles::class);

        // ===== ===== ===== ===== =====  Master Data
        $this->call(MasterData::class);
        


        // ===== ===== ===== ===== =====  Administrator  User 
        $admin = User::factory()->create([
            'name'     => 'Administrator',
            'username' => 'admin',
            'email'    => 'admin@mail.com'
        ]);

        $admin->assignRole('administrator');

        // ===== ===== ===== ===== =====  Komite Mutu User
        $mutu = User::factory(3)->create();
        $mutu->each(function ($user) {
            $user->assignRole('komite-mutu');
        });

        // ===== ===== ===== ===== =====  Pelapor User
        $pelapor = User::factory(5)->create();
        $pelapor->each(function ($user) {
            $user->assignRole('pelapor');
        });

        // ===== ===== ===== ===== =====  Pelapor Lainnya
        $me = User::factory()->create([
            'name'     => 'Pelapor',
            'username' => 'pelapor',
            'email'    => 'pelapor@mail.com'
        ]);

        $me->assignRole('pelapor');


        // ===== ===== ===== ===== =====  Pasien Data
        // $this->call(PasienData::class);

        // ===== ===== ===== ===== =====  Insiden Data
        $this->call(DummyInsiden::class);

        // ===== ===== ===== ===== =====  Setting Data
        $this->call(SettingSeed::class);
    }
}
