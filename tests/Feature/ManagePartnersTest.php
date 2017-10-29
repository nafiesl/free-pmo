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
        $user     = $this->adminUserSigningIn();
        $partner1 = factory(Partner::class)->create(['owner_id' => $user->agency->id]);
        $partner2 = factory(Partner::class)->create(['owner_id' => $user->agency->id]);

        $this->visit(route('partners.index'));
        $this->see($partner1->name);
        $this->see($partner2->name);
    }

    /** @test */
    public function user_can_create_a_partner()
    {
        $user = $this->adminUserSigningIn();
        $this->visit(route('partners.index'));

        $this->click(trans('partner.create'));
        $this->seePageIs(route('partners.create'));

        $this->submitForm(trans('partner.create'), [
            'name'    => 'Partner 1 name',
            'type_id' => 1,
            'email'   => 'partner1@mail.com',
            'phone'   => '081234567890',
            'pic'     => 'Nama PIC Partner',
            'address' => 'Alamat partner 1',
            'notes'   => '',
        ]);

        $this->see(trans('partner.created'));

        $this->seeInDatabase('partners', [
            'name'     => 'Partner 1 name',
            'type_id'  => 1,
            'email'    => 'partner1@mail.com',
            'phone'    => '081234567890',
            'pic'      => 'Nama PIC Partner',
            'address'  => 'Alamat partner 1',
            'notes'    => null,
            'owner_id' => $user->agency->id,
        ]);
    }

    /** @test */
    public function user_can_edit_a_partner()
    {
        $user    = $this->adminUserSigningIn();
        $partner = factory(Partner::class)->create(['owner_id' => $user->agency->id, 'name' => 'Testing 123']);

        $this->visit(route('partners.show', [$partner->id]));
        $this->click('edit-partner-'.$partner->id);
        $this->seePageIs(route('partners.edit', [$partner->id]));

        $this->submitForm(trans('partner.update'), [
            'name'      => 'Partner 1 name',
            'type_id'   => 2,
            'email'     => 'partner1@mail.com',
            'phone'     => '081234567890',
            'pic'       => 'Nama PIC Partner',
            'address'   => 'Alamat partner 1',
            'notes'     => '',
            'is_active' => 0,
        ]);

        $this->seePageIs(route('partners.show', $partner->id));

        $this->seeInDatabase('partners', [
            'name'      => 'Partner 1 name',
            'type_id'   => 2,
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
        $user    = $this->adminUserSigningIn();
        $partner = factory(Partner::class)->create(['owner_id' => $user->agency->id]);

        $this->visit(route('partners.edit', [$partner->id]));
        $this->click('del-partner-'.$partner->id);
        $this->seePageIs(route('partners.edit', [$partner->id, 'action' => 'delete']));

        $this->seeInDatabase('partners', [
            'id' => $partner->id,
        ]);

        $this->press(trans('app.delete_confirm_button'));

        $this->dontSeeInDatabase('partners', [
            'id' => $partner->id,
        ]);
    }
}
