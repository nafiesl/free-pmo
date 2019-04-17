<?php

namespace Tests\Feature\Partners;

use Tests\TestCase;
use App\Entities\Partners\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageVendorsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_vendor_list_in_vendor_index_page()
    {
        $vendor1 = factory(Vendor::class)->create(['name' => 'Testing name']);
        $vendor2 = factory(Vendor::class)->create(['name' => 'Testing name']);

        $this->adminUserSigningIn();
        $this->visit(route('vendors.index'));
        $this->see($vendor1->name);
        $this->see($vendor2->name);
    }

    /** @test */
    public function user_can_create_a_vendor()
    {
        $this->adminUserSigningIn();
        $this->visit(route('vendors.index'));

        $this->click(trans('vendor.create'));
        $this->seePageIs(route('vendors.index', ['action' => 'create']));

        $this->submitForm(trans('vendor.create'), [
            'name'    => 'Vendor 1 name',
            'notes'   => 'Vendor 1 notes',
            'website' => 'https://example.com',
        ]);

        $this->see(trans('vendor.created'));
        $this->seePageIs(route('vendors.index'));

        $this->seeInDatabase('vendors', [
            'name'    => 'Vendor 1 name',
            'notes'   => 'Vendor 1 notes',
            'website' => 'https://example.com',
        ]);
    }

    /** @test */
    public function user_can_edit_a_vendor_within_search_query()
    {
        $this->adminUserSigningIn();
        $vendor = factory(Vendor::class)->create(['name' => 'Testing 123']);

        $this->visit(route('vendors.index', ['q' => '123']));
        $this->click('edit-vendor-'.$vendor->id);
        $this->seePageIs(route('vendors.index', ['action' => 'edit', 'id' => $vendor->id, 'q' => '123']));

        $this->submitForm(trans('vendor.update'), [
            'name'      => 'Vendor 1 name',
            'notes'     => 'Vendor 1 notes',
            'website'   => 'https://example.com',
            'is_active' => 0,
        ]);

        $this->see(trans('vendor.updated'));
        $this->seePageIs(route('vendors.index', ['q' => '123']));

        $this->seeInDatabase('vendors', [
            'name'      => 'Vendor 1 name',
            'notes'     => 'Vendor 1 notes',
            'website'   => 'https://example.com',
            'is_active' => 0,
        ]);
    }

    /** @test */
    public function user_can_delete_a_vendor()
    {
        $this->adminUserSigningIn();
        $vendor = factory(Vendor::class)->create();

        $this->visit(route('vendors.index', ['action' => 'edit', 'id' => $vendor->id]));
        $this->click('del-vendor-'.$vendor->id);
        $this->seePageIs(route('vendors.index', ['action' => 'delete', 'id' => $vendor->id]));

        $this->seeInDatabase('vendors', [
            'id' => $vendor->id,
        ]);

        $this->press(trans('app.delete_confirm_button'));

        $this->see(trans('vendor.deleted'));
        $this->dontSeeInDatabase('vendors', [
            'id' => $vendor->id,
        ]);
    }
}
