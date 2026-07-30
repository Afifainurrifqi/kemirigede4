<?php

namespace Tests\Unit;

use App\Services\NomorSuratService;
use PHPUnit\Framework\TestCase;

class NomorSuratServiceTest extends TestCase
{
    private NomorSuratService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new NomorSuratService();
    }

    public function test_format_kode_472(): void
    {
        $this->assertSame(
            '472/001/409.47.5/2026',
            $this->service->format('ktp_kematian', 1, 2026)
        );
    }

    public function test_kode_berbeda_memiliki_format_sendiri(): void
    {
        $this->assertSame(
            '471/001/409.47.5/2026',
            $this->service->format('numpang_kk', 1, 2026)
        );
    }

    public function test_leading_zero_tidak_hilang(): void
    {
        $this->assertSame(
            '005/003/409.47.5/2026',
            $this->service->format('undangan', 3, 2026)
        );

        $this->assertSame(
            '090/002/409.47.5/2026',
            $this->service->format('sppd', 2, 2026)
        );
    }

    public function test_placeholder_sebelum_disetujui(): void
    {
        $this->assertSame(
            '472/.../409.47.5/2026',
            $this->service->placeholder('sptjm_kematian', 2026)
        );
    }

    public function test_jenis_dinamis_dapat_memakai_override(): void
    {
        $this->assertSame(
            '470/001/409.47.5/2026',
            $this->service->format(
                'kuasa',
                1,
                2026,
                ['kode_jenis_surat' => '470']
            )
        );
    }

    public function test_status_dinormalisasi(): void
    {
        $this->assertTrue($this->service->isAcceptedAndVerified([
            'status_surat' => 'Di terima',
            'status_verif' => 'Terverifikasi',
        ]));

        $this->assertFalse($this->service->isAcceptedAndVerified([
            'status_surat' => 'Di terima',
            'status_verif' => 'Belum Verifikasi',
        ]));
    }
}
