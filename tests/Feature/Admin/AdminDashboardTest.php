<?php

namespace Tests\Feature\Admin;

use App\Models\Kullanici;
use App\Models\Bayi;
use App\Models\Siparis;
use App\Models\Urun;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Test admin kullanıcısı oluştur
        $this->admin = Kullanici::factory()->create([
            'rol' => 'admin',
            'email' => 'admin@test.com'
        ]);
    }

    /** @test */
    public function admin_dashboard_route_requires_authentication()
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function admin_dashboard_requires_admin_role()
    {
        $user = Kullanici::factory()->create(['rol' => 'bayi']);
        
        $response = $this->actingAs($user)->get('/admin/dashboard');
        $response->assertStatus(403);
    }

    /** @test */
    public function admin_can_access_dashboard()
    {
        $response = $this->actingAs($this->admin)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
    }

    /** @test */
    public function dashboard_shows_correct_statistics()
    {
        // Test verisi oluştur
        Kullanici::factory()->count(5)->create();
        Bayi::factory()->count(3)->create();
        Urun::factory()->count(10)->create();
        Siparis::factory()->count(7)->create();

        $response = $this->actingAs($this->admin)->get('/admin/dashboard');
        
        $response->assertStatus(200);
        $response->assertViewHas('stats');
        
        $stats = $response->viewData('stats');
        
        $this->assertEquals(6, $stats['toplam_kullanici']); // 5 + 1 admin
        $this->assertEquals(3, $stats['toplam_bayi']);
        $this->assertEquals(10, $stats['toplam_urun']);
        $this->assertEquals(7, $stats['toplam_siparis']);
    }

    /** @test */
    public function dashboard_includes_recent_orders()
    {
        // Son siparişleri oluştur
        $siparisler = Siparis::factory()->count(3)->create();
        
        $response = $this->actingAs($this->admin)->get('/admin/dashboard');
        
        $response->assertStatus(200);
        $response->assertViewHas('stats');
        
        $stats = $response->viewData('stats');
        $this->assertCount(3, $stats['son_siparisler']);
    }

    /** @test */
    public function dashboard_shows_quick_actions()
    {
        $response = $this->actingAs($this->admin)->get('/admin/dashboard');
        
        $response->assertStatus(200);
        $response->assertSee('Hızlı Aksiyonlar');
        $response->assertSee('Yeni Ürün');
        $response->assertSee('Bayi Yönetimi');
        $response->assertSee('Kategori Yönetimi');
        $response->assertSee('Site Ayarları');
    }
}



