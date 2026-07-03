<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Set up tests to run with database seeding.
     *
     * @var bool
     */
    protected bool $seed = true;

    /**
     * Test if the owner can view all products.
     *
     * @return void
     */
    public function test_owner_can_view_all_products(): void
    {
        $owner = User::where('email', 'eigenaar@kniplokettiko.nl')->first();

        // Page 1
        $response = $this->actingAs($owner)
            ->get(route('admin.producten'));

        $response->assertOk()
            ->assertSee('Baardolie Cedar')
            ->assertSee('Color Creme 6.1')
            ->assertSee('Color Creme 7.43')
            ->assertSee('Developer 6 Procent')
            ->assertDontSee('Hydrating Shampoo')
            ->assertSee('Gevonden producten - 10 product(en)');

        // Page 2
        $response2 = $this->actingAs($owner)
            ->get(route('admin.producten', ['page' => 2]));

        $response2->assertOk()
            ->assertSee('Heat Protect Spray')
            ->assertSee('Hydrating Shampoo')
            ->assertSee('Matte Styling Clay')
            ->assertSee('Repair Conditioner')
            ->assertDontSee('Baardolie Cedar');

        // Page 3
        $response3 = $this->actingAs($owner)
            ->get(route('admin.producten', ['page' => 3]));

        $response3->assertOk()
            ->assertSee('Scalp Balance Masker')
            ->assertSee('Strong Hold Gel')
            ->assertDontSee('Hydrating Shampoo');
    }

    /**
     * Test filtering products by category.
     *
     * @return void
     */
    public function test_owner_can_filter_products_by_category(): void
    {
        $owner = User::where('email', 'eigenaar@kniplokettiko.nl')->first();

        // Filter by Categorie 1 (Haarverzorging)
        $response = $this->actingAs($owner)
            ->get(route('admin.producten', ['category_id' => 1]));

        $response->assertOk()
            ->assertSee('Hydrating Shampoo')
            ->assertSee('Baardolie Cedar')
            ->assertSee('Repair Conditioner')
            ->assertSee('Scalp Balance Masker')
            ->assertDontSee('Matte Styling Clay')
            ->assertSee('Gevonden producten - 4 product(en)');
    }

    /**
     * Test filter with empty category (Accessoires - category 4) returns empty state message.
     *
     * @return void
     */
    public function test_owner_filters_category_with_no_products(): void
    {
        $owner = User::where('email', 'eigenaar@kniplokettiko.nl')->first();

        // Filter by Categorie 4 (Accessoires, which has no products)
        $response = $this->actingAs($owner)
            ->get(route('admin.producten', ['category_id' => 4]));

        $response->assertOk()
            ->assertSee('Er zijn geen producten bekend binnen de geselecteerde categorie')
            ->assertSee('Gevonden producten - 0 product(en)');
    }

    /**
     * Test viewing product details.
     *
     * @return void
     */
    public function test_owner_can_view_product_details(): void
    {
        $owner = User::where('email', 'eigenaar@kniplokettiko.nl')->first();

        // View Hydrating Shampoo (Id 1)
        $response = $this->actingAs($owner)
            ->get(route('admin.producten.show', 1));

        $response->assertOk()
            ->assertSee('Productdetail')
            ->assertSee('Hydrating Shampoo')
            ->assertSee('Tiko Care')
            ->assertSee('0871234500001');
    }

    /**
     * Test viewing non-existent product details redirects back.
     *
     * @return void
     */
    public function test_viewing_non_existent_product_redirects(): void
    {
        $owner = User::where('email', 'eigenaar@kniplokettiko.nl')->first();

        $response = $this->actingAs($owner)
            ->get(route('admin.producten.show', 999));

        $response->assertRedirect(route('admin.producten'))
            ->assertSessionHas('error', 'Product niet gevonden.');
    }

    /**
     * Test editing a product's expiration date form.
     *
     * @return void
     */
    public function test_owner_can_view_edit_expiration_form(): void
    {
        $owner = User::where('email', 'eigenaar@kniplokettiko.nl')->first();

        $response = $this->actingAs($owner)
            ->get(route('admin.producten.edit', 1));

        $response->assertOk()
            ->assertSee('Product wijzigen')
            ->assertSee('Hydrating Shampoo')
            ->assertSee('Nieuwe houdbaarheidsdatum');
    }

    /**
     * Test updating product expiration date successfully within 7 days.
     *
     * @return void
     */
    public function test_owner_can_update_expiration_date_successfully(): void
    {
        $owner = User::where('email', 'eigenaar@kniplokettiko.nl')->first();

        // Hydrating Shampoo expiration is '2027-07-01'. Let's extend it by 5 days: '2027-07-06'.
        $response = $this->actingAs($owner)
            ->post(route('admin.producten.update', 1), [
                'Nieuwe_houdbaarheidsdatum' => '2027-07-06',
            ]);

        $response->assertRedirect(route('admin.producten.show', 1))
            ->assertSessionHas('success', 'Houdbaarheidsdatum bijgewerkt');

        $this->assertDatabaseHas('Product', [
            'Id' => 1,
            'Houdbaarheidsdatum' => '2027-07-06',
        ]);
    }

    /**
     * Test update fails if the date is extended by more than 7 days.
     *
     * @return void
     */
    public function test_update_fails_if_date_extended_by_more_than_seven_days(): void
    {
        $owner = User::where('email', 'eigenaar@kniplokettiko.nl')->first();

        // Hydrating Shampoo expiration is '2027-07-01'. Extend by 10 days to '2027-07-11'.
        $response = $this->actingAs($owner)
            ->from(route('admin.producten.edit', 1))
            ->post(route('admin.producten.update', 1), [
                'Nieuwe_houdbaarheidsdatum' => '2027-07-11',
            ]);

        $response->assertRedirect(route('admin.producten.edit', 1))
            ->assertSessionHasErrors(['Nieuwe_houdbaarheidsdatum'])
            ->assertSessionHas('error', 'Gegevens niet bijgewerkt');

        // Check DB was NOT updated
        $this->assertDatabaseHas('Product', [
            'Id' => 1,
            'Houdbaarheidsdatum' => '2027-07-01',
        ]);
    }

    /**
     * Test update fails if the date is set in the past relative to the current expiration date.
     *
     * @return void
     */
    public function test_update_fails_if_date_is_in_the_past(): void
    {
        $owner = User::where('email', 'eigenaar@kniplokettiko.nl')->first();

        // Hydrating Shampoo expiration is '2027-07-01'. Set to '2027-06-30'.
        $response = $this->actingAs($owner)
            ->from(route('admin.producten.edit', 1))
            ->post(route('admin.producten.update', 1), [
                'Nieuwe_houdbaarheidsdatum' => '2027-06-30',
            ]);

        $response->assertRedirect(route('admin.producten.edit', 1))
            ->assertSessionHasErrors(['Nieuwe_houdbaarheidsdatum'])
            ->assertSessionHas('error', 'Gegevens niet bijgewerkt');
    }
}
