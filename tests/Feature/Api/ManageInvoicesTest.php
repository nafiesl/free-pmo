<?php

namespace Tests\Feature\Api;

use App\Entities\Invoices\Invoice;
use App\Entities\Projects\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManageInvoicesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_list_invoices()
    {
        $user = $this->createUser('admin');
        factory(Invoice::class)->create();

        $this->getJson(route('api.invoices.index'), [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
    }

    /** @test */
    public function admin_can_show_invoice()
    {
        $user = $this->createUser('admin');
        $invoice = factory(Invoice::class)->create();

        $this->getJson(route('api.invoices.show', $invoice), [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
        $this->seeJson(['number' => $invoice->number]);
    }

    /** @test */
    public function admin_can_create_invoice_with_items()
    {
        $user = $this->createUser('admin');
        $project = factory(Project::class)->create();

        $this->postJson(route('api.invoices.store'), [
            'project_id' => $project->id,
            'date' => '2026-09-01',
            'due_date' => '2026-09-30',
            'items' => [
                ['description' => 'Design', 'amount' => 500000],
                ['description' => 'Development', 'amount' => 1500000],
            ],
            'discount' => 100000,
            'discount_notes' => 'Discount special',
            'notes' => 'Invoice notes',
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(201);
        $this->seeJson(['message' => __('invoice.created')]);
        $this->seeInDatabase('invoices', ['amount' => 1900000]);
    }

    /** @test */
    public function admin_can_update_invoice()
    {
        $user = $this->createUser('admin');
        $invoice = factory(Invoice::class)->create();

        $this->patchJson(route('api.invoices.update', $invoice), [
            'project_id' => $invoice->project_id,
            'date' => '2026-09-01',
            'due_date' => null,
            'items' => [
                ['description' => 'Maintenance', 'amount' => 800000],
            ],
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
        $this->seeJson(['message' => __('invoice.updated')]);
        $this->seeInDatabase('invoices', ['id' => $invoice->id, 'amount' => 800000]);
    }

    /** @test */
    public function admin_can_delete_invoice()
    {
        $user = $this->createUser('admin');
        $invoice = factory(Invoice::class)->create();

        $this->deleteJson(route('api.invoices.destroy', $invoice), [], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
        $this->seeJson(['message' => __('invoice.deleted')]);
        $this->dontSeeInDatabase('invoices', ['id' => $invoice->id]);
    }

    /** @test */
    public function worker_cannot_create_invoice()
    {
        $user = $this->createUser('worker');
        $project = factory(Project::class)->create();

        $this->postJson(route('api.invoices.store'), [
            'project_id' => $project->id,
            'date' => '2026-09-01',
            'items' => [
                ['description' => 'Design', 'amount' => 500000],
            ],
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(403);
    }

    /** @test */
    public function unauthenticated_user_cannot_access_invoices()
    {
        $this->getJson(route('api.invoices.index'));

        $this->seeStatusCode(401);
    }
}
