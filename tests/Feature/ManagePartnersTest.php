<?php

namespace Tests\Feature;

use App\Entities\Partners\Partner;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase as TestCase;

class ManagePartnersTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_see_partner_list_in_partner_index_page()
    {
        $partner1 = factory(Partner::class)->create();
        $partner2 = factory(Partner::class)->create();

        $this->adminUserSigningIn();
        $this->visit(route('partners.index'));
        $this->see($partner1->name);
        $this->see($partner2->name);
    }

    /** @test */
    public function user_can_create_a_partner()
    {
        $this->adminUserSigningIn();
        $this->visit(route('partners.index'));

        $this->click(trans('partner.create'));
        $this->seePageIs(route('partners.index', ['action' => 'create']));

        $this->submitForm(trans('partner.create'), [
            'name'    => 'Partner 1 name',
            'email'   => 'partner1@mail.com',
            'phone'   => '081234567890',
            'pic'     => 'Nama PIC Partner',
            'address' => 'Alamat partner 1',
            'notes'   => '',
        ]);

        $this->seePageIs(route('partners.index'));

        $this->seeInDatabase('partners', [
            'name'    => 'Partner 1 name',
            'email'   => 'partner1@mail.com',
            'phone'   => '081234567890',
            'pic'     => 'Nama PIC Partner',
            'address' => 'Alamat partner 1',
            'notes'   => null,
        ]);
    }

    /** @test */
    public function user_can_edit_a_partner_within_search_query()
    {
        $this->adminUserSigningIn();
        $partner = factory(Partner::class)->create(['name' => 'Testing 123']);

        $this->visit(route('partners.index', ['q' => '123']));
        $this->click('edit-partner-'.$partner->id);
        $this->seePageIs(route('partners.index', ['action' => 'edit', 'id' => $partner->id, 'q' => '123']));

        $this->submitForm(trans('partner.update'), [
            'name'      => 'Partner 1 name',
            'email'     => 'partner1@mail.com',
            'phone'     => '081234567890',
            'pic'       => 'Nama PIC Partner',
            'address'   => 'Alamat partner 1',
            'notes'     => '',
            'is_active' => 0,
        ]);

        $this->seePageIs(route('partners.index', ['q' => '123']));

        $this->seeInDatabase('partners', [
            'name'      => 'Partner 1 name',
            'email'     => 'partner1@mail.com',
            'phone'     => '081234567890',
            'pic'       => 'Nama PIC Partner',
            'address'   => 'Alamat partner 1',
            'notes'     => null,
            'is_active' => 0,
        ]);
    }

    /** @test */
    public function user_can_delete_a_partner()
    {
        $this->adminUserSigningIn();
        $partner = factory(Partner::class)->create();

        $this->visit(route('partners.index', [$partner->id]));
        $this->click('del-partner-'.$partner->id);
        $this->seePageIs(route('partners.index', ['action' => 'delete', 'id' => $partner->id]));

        $this->seeInDatabase('partners', [
            'id' => $partner->id,
        ]);

        $this->press(trans('app.delete_confirm_button'));

        $this->dontSeeInDatabase('partners', [
            'id' => $partner->id,
        ]);
    }
}
