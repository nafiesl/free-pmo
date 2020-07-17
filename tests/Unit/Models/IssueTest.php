<?php

namespace Tests\Unit\Models;

use App\Entities\Projects\Comment;
use App\Entities\Projects\Issue;
use App\Entities\Projects\Priority;
use App\Entities\Projects\Project;
use App\Entities\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

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

    /** @test */
    public function an_issue_has_status_label_attribute()
    {
        $issue = factory(Issue::class)->make();

        $this->assertEquals('<span class="badge">'.$issue->status.'</span>', $issue->status_label);
    }

    /** @test */
    public function an_issue_has_priority_attribute()
    {
        $issue = factory(Issue::class)->make();

        $this->assertEquals(__('issue.minor'), $issue->priority);
    }

    /** @test */
    public function an_issue_has_priority_label_attribute()
    {
        $issue = factory(Issue::class)->make();
        $colorClass = Priority::getColorById($issue->priority_id);

        $this->assertEquals('<span class="label label-'.$colorClass.'">'.$issue->priority.'</span>', $issue->priority_label);
    }

    /** @test */
    public function an_issue_has_many_comments_relation()
    {
        $issue = factory(Issue::class)->create();
        $comment = factory(Comment::class)->create([
            'commentable_type' => 'issues',
            'commentable_id'   => $issue->id,
        ]);

        $this->assertInstanceOf(Collection::class, $issue->comments);
        $this->assertInstanceOf(Comment::class, $issue->comments->first());
    }
}
