<?php

namespace Tests\Feature\Partners;

use App\Entities\Partners\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManageCustomersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_customer_list_in_customer_index_page()
    {
        $user = $this->adminUserSigningIn();
        $customer1 = factory(Customer::class)->create();
        $customer2 = factory(Customer::class)->create();

        $this->visit(route('customers.index'));
        $this->see($customer1->name);
        $this->see($customer2->name);
    }

    /** @test */
    public function user_can_create_a_customer()
    {
        $user = $this->adminUserSigningIn();
        $this->visit(route('customers.index'));

        $this->click(__('customer.create'));
        $this->seePageIs(route('customers.create'));

        $this->submitForm(__('customer.create'), [
            'name' => 'Customer 1 name',
            'email' => 'customer1@mail.com',
            'phone' => '081234567890',
            'pic' => 'Nama PIC Customer',
            'address' => 'Alamat customer 1',
            'website' => 'https://example.com',
            'notes' => '',
        ]);

        $this->see(__('customer.created'));

        $this->seeInDatabase('customers', [
            'name' => 'Customer 1 name',
            'email' => 'customer1@mail.com',
            'phone' => '081234567890',
            'pic' => 'Nama PIC Customer',
            'address' => 'Alamat customer 1',
            'website' => 'https://example.com',
            'notes' => null,
        ]);
    }

    /** @test */
    public function user_can_edit_a_customer()
    {
        $user = $this->adminUserSigningIn();
        $customer = factory(Customer::class)->create(['name' => 'Testing 123']);

        $this->visit(route('customers.show', [$customer->id]));
        $this->click('edit-customer-'.$customer->id);
        $this->seePageIs(route('customers.edit', [$customer->id]));

        $this->submitForm(__('customer.update'), [
            'name' => 'Customer 1 name',
            'email' => 'customer1@mail.com',
            'phone' => '081234567890',
            'pic' => 'Nama PIC Customer',
            'address' => 'Alamat customer 1',
            'website' => 'https://example.com',
            'notes' => '',
            'is_active' => 0,
        ]);

        $this->seePageIs(route('customers.show', $customer->id));

        $this->seeInDatabase('customers', [
            'name' => 'Customer 1 name',
            'email' => 'customer1@mail.com',
            'phone' => '081234567890',
            'pic' => 'Nama PIC Customer',
            'address' => 'Alamat customer 1',
            'website' => 'https://example.com',
            'notes' => null,
            'is_active' => 0,
        ]);
    }

    /** @test */
    public function user_can_delete_a_customer()
    {
        $user = $this->adminUserSigningIn();
        $customer = factory(Customer::class)->create();

        $this->visit(route('customers.edit', [$customer->id]));
        $this->click('del-customer-'.$customer->id);
        $this->seePageIs(route('customers.edit', [$customer->id, 'action' => 'delete']));

        $this->seeInDatabase('customers', [
            'id' => $customer->id,
        ]);

        $this->press(__('app.delete_confirm_button'));

        $this->dontSeeInDatabase('customers', [
            'id' => $customer->id,
        ]);
    }
}
