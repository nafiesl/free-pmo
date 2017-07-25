<?php

namespace Tests\Unit\Models;

use App\Entities\Payments\Payment;
use App\Entities\Projects\Feature;
use App\Entities\Projects\Project;
use App\Entities\Projects\Task;
use App\Entities\Subscriptions\Subscription;
use App\Entities\Users\User;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    /** @test */
    public function it_has_many_features()
    {
        $project = factory(Project::class)->create();
        $feature = factory(Feature::class)->create(['project_id' => $project->id]);
        $this->assertTrue($project->features instanceOf Collection);
        $this->assertTrue($project->features->first() instanceOf Feature);
    }

    /** @test */
    public function it_has_many_main_features()
    {
        $project = factory(Project::class)->create();
        $feature = factory(Feature::class)->create(['project_id' => $project->id, 'type_id' => 1]);
        $this->assertTrue($project->mainFeatures instanceOf Collection);
        $this->assertTrue($project->mainFeatures->first() instanceOf Feature);
    }

    /** @test */
    public function it_has_many_additional_features()
    {
        $project = factory(Project::class)->create();
        $feature = factory(Feature::class)->create(['project_id' => $project->id, 'type_id' => 2]);
        $this->assertTrue($project->additionalFeatures instanceOf Collection);
        $this->assertTrue($project->additionalFeatures->first() instanceOf Feature);
    }

    /** @test */
    public function it_has_feature_tasks()
    {
        $project = factory(Project::class)->create();
        $feature = factory(Feature::class)->create(['project_id' => $project->id, 'type_id' => 2]);
        $tasks = factory(Task::class, 2)->create(['feature_id' => $feature->id]);
        $this->assertTrue($project->tasks instanceOf Collection);
        $this->assertTrue($project->tasks->first() instanceOf Task);
    }

    /** @test */
    public function it_has_many_payments()
    {
        $project = factory(Project::class)->create();
        $payment = factory(Payment::class)->create(['project_id' => $project->id]);
        $this->assertTrue($project->payments instanceOf Collection);
        $this->assertTrue($project->payments->first() instanceOf Payment);
    }

    /** @test */
    public function it_has_many_subscriptions()
    {
        $project = factory(Project::class)->create();
        $subscription = factory(Subscription::class)->create(['project_id' => $project->id]);
        $this->assertTrue($project->subscriptions instanceOf Collection);
        $this->assertTrue($project->subscriptions->first() instanceOf Subscription);
    }

    /** @test */
    public function it_belongs_to_a_customer()
    {
        $project = factory(Project::class)->create();
        $this->assertTrue($project->customer instanceOf User);
    }

    /** @test */
    public function it_has_cash_in_total_method()
    {
        $project = factory(Project::class)->create();
        $payments = factory(Payment::class, 2)->create(['project_id' => $project->id, 'in_out' => 1, 'amount' => 20000]);
        $this->assertEquals(40000, $project->cashInTotal());
    }

    /** @test */
    public function it_has_cash_out_total_method()
    {
        $project = factory(Project::class)->create();
        $payments = factory(Payment::class, 2)->create(['project_id' => $project->id, 'in_out' => 0, 'amount' => 10000]);
        factory(Payment::class)->create(['project_id' => $project->id, 'in_out' => 1, 'amount' => 10000]);
        $this->assertEquals(20000, $project->cashOutTotal());
    }

    /** @test */
    public function it_has_feature_overall_progress_method()
    {
        $project = factory(Project::class)->create();

        $feature = factory(Feature::class)->create(['project_id' => $project->id, 'type_id' => 1, 'price' => 2000]);
        factory(Task::class)->create(['feature_id' => $feature->id, 'progress' => 20]);

        $feature = factory(Feature::class)->create(['project_id' => $project->id, 'type_id' => 1, 'price' => 3000]);
        factory(Task::class)->create(['feature_id' => $feature->id, 'progress' => 30]);

        $feature = factory(Feature::class)->create(['project_id' => $project->id, 'type_id' => 1, 'price' => 1500]);
        factory(Task::class)->create(['feature_id' => $feature->id, 'progress' => 100]);

        $feature = factory(Feature::class)->create(['project_id' => $project->id, 'type_id' => 1, 'price' => 1500]);
        factory(Task::class)->create(['feature_id' => $feature->id, 'progress' => 100]);

        $this->assertEquals(53.75, $project->getFeatureOveralProgress());
    }

    /** @test */
    public function it_returns_0_on_feature_overall_progress_method_if_all_feature_is_free()
    {
        $project = factory(Project::class)->create();

        factory(Feature::class)->create(['project_id' => $project->id, 'type_id' => 1, 'price' => 0]);
        factory(Feature::class)->create(['project_id' => $project->id, 'type_id' => 1, 'price' => 0]);
        factory(Feature::class)->create(['project_id' => $project->id, 'type_id' => 1, 'price' => 0]);
        factory(Feature::class)->create(['project_id' => $project->id, 'type_id' => 1, 'price' => 0]);

        $this->assertEquals(0, $project->getFeatureOveralProgress());
    }
}
