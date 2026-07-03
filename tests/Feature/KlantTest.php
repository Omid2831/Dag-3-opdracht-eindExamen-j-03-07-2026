<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class KlantTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Set up tests.
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Unauthenticated users cannot view clients.
     */
    public function test_unauthenticated_cannot_access_klanten_index(): void
    {
        $response = $this->get(route('admin.klanten'));
        $response->assertRedirect(route('login'));
    }

    /**
     * Customers (role 'klant') cannot view the customers list.
     */
    public function test_non_admin_cannot_access_klanten_index(): void
    {
        $klantUser = User::where('role', 'klant')->first();
        if (!$klantUser) {
            $klantUser = User::create([
                'name' => 'Test Customer',
                'email' => 'customer@test.com',
                'password' => bcrypt('password'),
                'role' => 'klant',
            ]);
        }

        $response = $this->actingAs($klantUser)->get(route('admin.klanten'));
        $response->assertStatus(403);
    }

    /**
     * Owners (role 'eigenaar') can view the customers list.
     */
    public function test_admin_can_access_klanten_index_and_see_seeded_customers(): void
    {
        $eigenaar = User::where('role', 'eigenaar')->first();
        if (!$eigenaar) {
            $eigenaar = User::create([
                'name' => 'Test Owner',
                'email' => 'owner@test.com',
                'password' => bcrypt('password'),
                'role' => 'eigenaar',
            ]);
        }

        $response = $this->actingAs($eigenaar)->get(route('admin.klanten'));
        $response->assertStatus(200);
        $response->assertSee('Overzicht klanten');
        
        // Assert we see at least Ahmed Mansouri (ID 4 in createscript)
        $response->assertSee('Ahmed Mansouri');
    }

    /**
     * Check filtering by postcode.
     */
    public function test_admin_can_filter_klanten_by_postcode(): void
    {
        $eigenaar = User::where('role', 'eigenaar')->first();

        // Search for Ahmed Mansouri's postcode: 3511KV
        $response = $this->actingAs($eigenaar)->get(route('admin.klanten', ['postcode' => '3511KV']));
        $response->assertStatus(200);
        $response->assertSee('Ahmed Mansouri');
        $response->assertDontSee('Jan Jansen'); // Jan has postcode 3572BC

        // Search for a postcode that doesn't exist
        $response2 = $this->actingAs($eigenaar)->get(route('admin.klanten', ['postcode' => '9999ZZ']));
        $response2->assertStatus(200);
        $response2->assertSee('Er zijn geen klanten bekend die de geselecteerde postcode hebben');
    }

    /**
     * Check customer details page.
     */
    public function test_admin_can_view_klant_details(): void
    {
        $eigenaar = User::where('role', 'eigenaar')->first();

        // Ahmed Mansouri has Klant Id 4
        $response = $this->actingAs($eigenaar)->get(route('admin.klanten.show', 4));
        $response->assertStatus(200);
        $response->assertSee('Klantdetail');
        $response->assertSee('Ahmed Mansouri');
        $response->assertSee('KL-2026-004');
        $response->assertSee('ahmed.mansouri@icloud.com');
    }

    /**
     * Check updating customer details successfully.
     */
    public function test_admin_can_update_klant_details_successfully(): void
    {
        $eigenaar = User::where('role', 'eigenaar')->first();

        $response = $this->actingAs($eigenaar)->put(route('admin.klanten.update', 4), [
            'Naam' => 'Ahmed Mansouri Updated',
            'Bijzonderheden' => 'Nieuwe bijzonderheden',
            'Straatnaam' => 'Winkel van Sinkelstraat',
            'Huisnummer' => 5,
            'Toevoeging' => 'B',
            'Postcode' => '3511KV',
            'Plaats' => 'Utrecht',
            'Email' => 'ahmed.updated@icloud.com',
            'Mobiel' => '+31 6 1234 61 74',
        ]);

        $response->assertRedirect(route('admin.klanten'));
        $response->assertSessionHas('success', 'Klantgegevens bijgewerkt.');

        // Assert DB matches
        $clientDetails = DB::select('CALL SP_Klant_ReadById(?)', [4]);
        $this->assertNotEmpty($clientDetails);
        $this->assertEquals('Ahmed', $clientDetails[0]->Voornaam);
        $this->assertEquals('Mansouri Updated', $clientDetails[0]->Achternaam);
        $this->assertEquals('ahmed.updated@icloud.com', $clientDetails[0]->ContactEmail);
        $this->assertEquals(5, $clientDetails[0]->Huisnummer);
        $this->assertEquals('B', $clientDetails[0]->Toevoeging);
    }

    /**
     * Check that we cannot update a client with an email address already used by another customer.
     */
    public function test_admin_cannot_update_klant_with_duplicate_email(): void
    {
        $eigenaar = User::where('role', 'eigenaar')->first();

        // Ahmed Mansouri (Id 4) tries to set email to jan.jansen@outlook.com (already in use by Jan Jansen, Id 2)
        $response = $this->actingAs($eigenaar)->from(route('admin.klanten.edit', 4))
            ->put(route('admin.klanten.update', 4), [
                'Naam' => 'Ahmed Mansouri',
                'Bijzonderheden' => 'Wil strakke fade.',
                'Straatnaam' => 'Winkel van Sinkelstraat',
                'Huisnummer' => 4,
                'Toevoeging' => null,
                'Postcode' => '3511KV',
                'Plaats' => 'Utrecht',
                'Email' => 'jan.jansen@outlook.com', // Duplicate
                'Mobiel' => '+31 6 1234 61 74',
            ]);

        $response->assertRedirect(route('admin.klanten.edit', 4));
        $response->assertSessionHas('error', 'Klantgegevens zijn niet bijgewerkt.');
        $response->assertSessionHasErrors(['Email' => 'Het e-mailadres is al in gebruik']);
    }
}
