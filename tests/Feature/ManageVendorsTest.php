<?php

namespace Tests\Feature;

use App\Entities\Partners\Vendor;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase as TestCase;

class ManageVendorsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_see_vendor_list_in_vendor_index_page()
    {
        $vendor1 = factory(Vendor::class)->create(['name' => 'Testing name', 'description' => 'Testing 123']);
        $vendor2 = factory(Vendor::class)->create(['name' => 'Testing name', 'description' => 'Testing 456']);

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

        $this->type('Vendor 1 name', 'name');
        $this->type('Vendor 1 description', 'description');
        $this->press(trans('vendor.create'));

        $this->see(trans('vendor.created'));
        $this->seePageIs(route('vendors.index'));

        $this->seeInDatabase('vendors', [
            'name'        => 'Vendor 1 name',
            'description' => 'Vendor 1 description',
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

        $this->type('Vendor 1 name', 'name');
        $this->type('Vendor 1 description', 'description');
        $this->press(trans('vendor.update'));

        $this->see(trans('vendor.updated'));
        $this->seePageIs(route('vendors.index', ['q' => '123']));

        $this->seeInDatabase('vendors', [
            'name'        => 'Vendor 1 name',
            'description' => 'Vendor 1 description',
        ]);
    }

    /** @test */
    public function user_can_delete_a_vendor()
    {
        $this->adminUserSigningIn();
        $vendor = factory(Vendor::class)->create();

        $this->visit(route('vendors.index', [$vendor->id]));
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
