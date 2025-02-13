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

        // ===== ===== ===== ===== =====  Jabatan
        $this->call(JabatanSeed::class);
        


        // ===== ===== ===== ===== =====  Administrator  User 
        $admin = User::factory()->create([
            'name'     => 'Administrator',
            'username' => 'admin',
            'email'    => 'admin@mail.com'
        ]);

        \App\Models\UserDetail::factory()->create([
            'user_id'    => $admin->id,
            'jabatan_id' => \App\Models\Jabatan::where('nama', 'Kepala Unit Sistem Informasi Dan Teknologi')->first()->id
        ]);

        $admin->assignRole('administrator');

        // ===== ===== ===== ===== =====  Komite Mutu User
        $mutu = User::factory(3)->create();
        $mutu->each(function ($user, $index) {
            $user->assignRole('komite-mutu');

            \App\Models\UserDetail::factory()->create([
                'user_id'    => $user->id,
                'jabatan_id' => $index > 0 ? \App\Models\Jabatan::where('nama', 'Komite Mutu')->first()->id : \App\Models\Jabatan::where('nama', 'Ketua Komite Mutu')->first()->id
            ]);
        });

        $meMutu = User::factory()->create([
            'name'     => 'Komite Mutu',
            'username' => 'komite-mutu',
            'email'    => 'komite.mutu@mail.com'
        ]);

        \App\Models\UserDetail::factory()->create([
            'user_id' => $meMutu->id,
        ]);

        $meMutu->assignRole('komite-mutu');

        // ===== ===== ===== ===== =====  Pelapor User
        $pelapor = User::factory(10)->create();
        $pelapor->each(function ($user) {
            $user->assignRole('pelapor');

            \App\Models\UserDetail::factory()->create([
                'user_id' => $user->id,
            ]);
        });

        // ===== ===== ===== ===== =====  Pelapor Lainnya
        $me = User::factory()->create([
            'name'     => 'Pelapor',
            'username' => 'pelapor',
            'email'    => 'pelapor@mail.com'
        ]);

        \App\Models\UserDetail::factory()->create([
            'user_id' => $me->id,
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
