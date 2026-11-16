<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Ensure the EduConnect home page renders all main sections and dynamic statistics.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response
            ->assertStatus(200)
            ->assertSee('Pendidikan tumbuh dari koneksi')
            ->assertSee('Ruang belajar yang tepat,')
            ->assertSee('masa depan yang dekat.')
            ->assertSee('Satu ekosistem, banyak cara untuk membuat perubahan.')
            ->assertSee('Saya ingin belajar')
            ->assertSee('Saya ingin membantu')
            ->assertSee('Saya mengelola ruang')
            ->assertSee('Ruang belajar untuk setiap langkah.')
            ->assertSee('Dari mencari ruang hingga menciptakan dampak.')
            ->assertSee('Ada banyak cara untuk ikut membuka akses pendidikan.')
            ->assertSee('Menghubungkan kesempatan, membuka masa depan.');
    }

    /**
     * Ensure the featured places section displays the empty state when no places exist.
     */
    public function test_the_home_page_displays_empty_state_when_no_places_are_available(): void
    {
        $response = $this->get('/?empty=1');

        $response
            ->assertStatus(200)
            ->assertSee('Tempat belajar sedang disiapkan');
    }
}
