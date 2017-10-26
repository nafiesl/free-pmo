<?php

namespace Tests\Feature;

use App\Entities\Partners\Customer;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase as TestCase;

class ManageCustomersTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_see_customer_list_in_customer_index_page()
    {
        $customer1 = factory(Customer::class)->create();
        $customer2 = factory(Customer::class)->create();

        $this->adminUserSigningIn();
        $this->visit(route('customers.index'));
        $this->see($customer1->name);
        $this->see($customer2->name);
    }

    /** @test */
    public function user_can_create_a_customer()
    {
        $this->adminUserSigningIn();
        $this->visit(route('customers.index'));

        $this->click(trans('customer.create'));
        $this->seePageIs(route('customers.index', ['action' => 'create']));

        $this->submitForm(trans('customer.create'), [
            'name' => 'Customer 1 name',
            'email' => 'customer1@mail.com',
            'phone' => '081234567890',
            'pic' => 'Nama PIC Customer',
            'address' => 'Alamat customer 1',
            'notes' => '',
        ]);

        $this->seePageIs(route('customers.index'));

        $this->seeInDatabase('customers', [
            'name' => 'Customer 1 name',
            'email' => 'customer1@mail.com',
            'phone' => '081234567890',
            'pic' => 'Nama PIC Customer',
            'address' => 'Alamat customer 1',
            'notes' => null,
        ]);
    }

    /** @test */
    public function user_can_edit_a_customer_within_search_query()
    {
        $this->adminUserSigningIn();
        $customer = factory(Customer::class)->create(['name' => 'Testing 123']);

        $this->visit(route('customers.index', ['q' => '123']));
        $this->click('edit-customer-'.$customer->id);
        $this->seePageIs(route('customers.index', ['action' => 'edit', 'id' => $customer->id, 'q' => '123']));

        $this->submitForm(trans('customer.update'), [
            'name' => 'Customer 1 name',
            'email' => 'customer1@mail.com',
            'phone' => '081234567890',
            'pic' => 'Nama PIC Customer',
            'address' => 'Alamat customer 1',
            'notes' => '',
            'is_active' => 0,
        ]);

        $this->seePageIs(route('customers.index', ['q' => '123']));

        $this->seeInDatabase('customers', [
            'name' => 'Customer 1 name',
            'email' => 'customer1@mail.com',
            'phone' => '081234567890',
            'pic' => 'Nama PIC Customer',
            'address' => 'Alamat customer 1',
            'notes' => null,
            'is_active' => 0,
        ]);
    }

    /** @test */
    public function user_can_delete_a_customer()
    {
        $this->adminUserSigningIn();
        $customer = factory(Customer::class)->create();

        $this->visit(route('customers.index', [$customer->id]));
        $this->click('del-customer-'.$customer->id);
        $this->seePageIs(route('customers.index', ['action' => 'delete', 'id' => $customer->id]));

        $this->seeInDatabase('customers', [
            'id' => $customer->id,
        ]);

        $this->press(trans('app.delete_confirm_button'));

        $this->dontSeeInDatabase('customers', [
            'id' => $customer->id,
        ]);
    }
}
