<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Unit;
use App\Models\Insiden;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UnitKerjaTest extends TestCase
{
    /**
     * Test: Dapat membuat unit kerja dengan mass assignment
     */
    public function test_dapat_membuat_unit_kerja_dengan_mass_assignment()
    {
        $data = ['nama_unit' => 'Unit A'];

        $unitKerja = Unit::create($data);

        $this->assertEquals('Unit A', $unitKerja->nama_unit);
    }

    /**
     * Test: Dapat memiliki banyak insiden
     */
    public function test_dapat_memiliki_banyak_insiden()
    {
        $unitKerja = Unit::factory()->create();

        $insiden1 = Insiden::factory()->create([
            'pasien_id'        => \App\Models\Pasien::factory()->create()->id,
            'jenis_insiden_id' => \App\Models\JenisInsiden::get()->random()->id,
            'unit_id'          => $unitKerja->id,
            'created_by'       => \App\Models\User::factory()->create()->id,
        ]);

        $insiden2 = Insiden::factory()->create([
            'pasien_id'        => \App\Models\Pasien::factory()->create()->id,
            'jenis_insiden_id' => \App\Models\JenisInsiden::get()->random()->id,
            'unit_id'          => $unitKerja->id,
            'created_by'       => \App\Models\User::factory()->create()->id,
        ]);

        $insiden = Insiden::where('unit_id', $unitKerja->id)->get();
        
        $this->assertGreaterThanOrEqual(2, $insiden->count());
        $this->assertTrue($insiden->contains($insiden1));
        $this->assertTrue($insiden->contains($insiden2));
    }

    /**
     * Test: Dapat menghapus unit kerja secara soft delete
     */
    public function test_dapat_menghapus_unit_kerja_dengan_soft_delete()
    {
        $unitKerja = Unit::factory()->create();
        $unitKerja->delete();

        $this->assertTrue($unitKerja->trashed());
    }

    /**
     * Test: Dapat mengembalikan unit kerja yang dihapus secara soft delete
     */
    public function test_dapat_mengembalikan_unit_kerja_yang_dihapus_dengan_soft_delete()
    {
        $unitKerja = Unit::factory()->create();
        $unitKerja->delete();

        $this->assertTrue($unitKerja->trashed());

        $unitKerja->restore();

        $this->assertFalse($unitKerja->trashed());
    }

    /**
     * Test: Melempar error untuk mass assignment yang tidak valid
     */
    public function test_melempar_error_field_tidak_valid()
    {
        $this->expectException(QueryException::class);

        $unitKerja = Unit::create(['invalid_field' => 'Invalid Value']);
    }

    /**
     * Test: Dapat memfilter unit kerja berdasarkan nama
     */
    public function test_dapat_memfilter_unit_kerja_berdasarkan_nama()
    {
        Unit::factory()->create(['nama_unit' => 'Unit A']);
        Unit::factory()->create(['nama_unit' => 'Unit B']);

        $unitKerja = Unit::where('nama_unit', 'Unit A')->first();

        $this->assertNotNull($unitKerja);
        $this->assertEquals('Unit A', $unitKerja->nama_unit);
    }

    /**
     * Test: Memiliki timestamp untuk created_at dan updated_at
     */
    public function test_memiliki_timestamp_untuk_created_at_dan_updated_at()
    {
        $unitKerja = Unit::factory()->create();

        $this->assertNotNull($unitKerja->created_at);
        $this->assertNotNull($unitKerja->updated_at);
    }

    /**
     * Test: Memvalidasi atribut unit kerja
     */
    public function test_memvalidasi_atribut_unit_kerja()
    {
        $unitKerja = new Unit();
        $unitKerja->nama_unit = ''; // Field kosong yang harus divalidasi

        $this->assertFalse($unitKerja->save());
    }
}
