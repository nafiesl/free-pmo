<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Entities\Users\User;
use App\Entities\Projects\Issue;
use App\Entities\Projects\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IssueTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_issue_has_belongs_to_project_relation()
    {
        $issue = factory(Issue::class)->make();

        $this->assertInstanceOf(Project::class, $issue->project);
        $this->assertEquals($issue->project_id, $issue->project->id);
    }

    /** @test */
    public function an_issue_has_belongs_to_pic_relation()
    {
        $pic = $this->createUser('worker');
        $issue = factory(Issue::class)->make(['pic_id' => $pic->id]);

        $this->assertInstanceOf(User::class, $issue->pic);
        $this->assertEquals($issue->pic_id, $issue->pic->id);
    }

    /** @test */
    public function issue_pic_name_has_default_value()
    {
        $issue = factory(Issue::class)->make(['pic_id' => null]);

        $this->assertEquals(__('issue.no_pic'), $issue->pic->name);
    }

    /** @test */
    public function an_issue_has_belongs_to_creator_relation()
    {
        $issue = factory(Issue::class)->make();

        $this->assertInstanceOf(User::class, $issue->creator);
        $this->assertEquals($issue->creator_id, $issue->creator->id);
    }

    /** @test */
    public function an_issue_has_status_attribute()
    {
        $issue = factory(Issue::class)->make();

        $this->assertEquals(__('issue.open'), $issue->status);
    }
}
