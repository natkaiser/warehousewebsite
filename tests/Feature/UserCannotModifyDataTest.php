<?php

namespace Tests\Feature;

use App\Models\Stock;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCannotModifyDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_store_stock_data(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->post(route('stock.store'), [
            'kode_barang' => 'SKU-1001',
            'nama_barang' => 'Produk Uji',
            'rak' => 'A-01',
            'spesifikasi' => '500ml',
            'satuan' => 'pcs',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('stocks', [
            'kode_barang' => 'SKU-1001',
        ]);
    }

    public function test_user_cannot_update_stock_data(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $stock = Stock::create([
            'kode_barang' => 'SKU-2001',
            'nama_barang' => 'Produk Lama',
            'rak' => 'B-01',
            'spesifikasi' => '250ml',
            'stok' => 0,
            'satuan' => 'pcs',
        ]);

        $response = $this->actingAs($user)->put(route('stock.update', $stock), [
            'kode_barang' => 'SKU-2001',
            'nama_barang' => 'Produk Diubah',
            'rak' => 'B-02',
            'spesifikasi' => '300ml',
            'satuan' => 'pcs',
        ]);

        $response->assertForbidden();
        $this->assertDatabaseHas('stocks', [
            'id' => $stock->id,
            'nama_barang' => 'Produk Lama',
            'rak' => 'B-01',
        ]);
    }

    public function test_user_cannot_delete_stock_data(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $stock = Stock::create([
            'kode_barang' => 'SKU-3001',
            'nama_barang' => 'Produk Hapus',
            'rak' => 'C-01',
            'spesifikasi' => '750ml',
            'stok' => 0,
            'satuan' => 'pcs',
        ]);

        $response = $this->actingAs($user)->delete(route('stock.destroy', $stock));

        $response->assertForbidden();
        $this->assertDatabaseHas('stocks', [
            'id' => $stock->id,
        ]);
    }
}
