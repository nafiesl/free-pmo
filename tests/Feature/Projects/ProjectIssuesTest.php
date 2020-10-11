<?php

namespace Tests\Feature\Projects;

use App\Entities\Projects\Issue;
use App\Entities\Projects\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectIssuesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_project_issues()
    {
        $this->adminUserSigningIn();
        $project = factory(Project::class)->create();
        $issue = factory(Issue::class)->create([
            'project_id' => $project->id,
            'title'      => 'The issue title.',
            'body'       => 'This is a project issue body.',
        ]);

        $this->visitRoute('projects.issues.index', $project);
        $this->seeRouteIs('projects.issues.index', $project);

        $this->seeText('The issue title.');
    }

    /** @test */
    public function admin_can_add_issue_to_a_project()
    {
        $admin = $this->adminUserSigningIn();
        $project = factory(Project::class)->create();

        $this->visitRoute('projects.issues.create', $project);

        $this->submitForm(__('issue.create'), [
            'title'       => 'First Issue.',
            'body'        => 'First Issue description.',
            'priority_id' => 1,
            'pic_id'      => $admin->id,
        ]);

        $this->seePageIs(route('projects.issues.index', $project));
        $this->see(__('issue.created'));

        $this->seeInDatabase('issues', [
            'project_id'  => $project->id,
            'title'       => 'First Issue.',
            'body'        => 'First Issue description.',
            'priority_id' => 1,
            'pic_id'      => $admin->id,
            'creator_id'  => $admin->id,
        ]);
    }

    /** @test */
    public function user_can_view_an_issue_detail()
    {
        $this->adminUserSigningIn();
        $project = factory(Project::class)->create();
        $issue = factory(Issue::class)->create([
            'project_id' => $project->id,
            'title'      => 'The issue title.',
            'body'       => 'This is a project issue body.',
        ]);

        $this->visitRoute('projects.issues.show', [$project, $issue]);
        $this->seeText($issue->title);
        $this->seeText($issue->body);
    }

    /** @test */
    public function user_can_edit_issue()
    {
        $this->adminUserSigningIn();
        $project = factory(Project::class)->create();
        $issue = factory(Issue::class)->create([
            'project_id' => $project->id,
            'title'      => 'The issue title.',
            'body'       => 'This is a project issue body.',
        ]);

        $this->visitRoute('projects.issues.show', [$project, $issue]);
        $this->seeElement('a', ['id' => 'edit-issue-'.$issue->id]);
        $this->click('edit-issue-'.$issue->id);
        $this->seeRouteIs('projects.issues.edit', [$project, $issue]);

        $this->submitForm(__('issue.update'), [
            'title' => 'First Issue.',
            'body'  => 'This is a project issue body.',
        ]);

        $this->seePageIs(route('projects.issues.show', [$project, $issue]));
        $this->see(__('issue.updated'));

        $this->seeInDatabase('issues', [
            'id'         => $issue->id,
            'project_id' => $project->id,
            'title'      => 'First Issue.',
            'body'       => 'This is a project issue body.',
        ]);
    }

    /** @test */
    public function user_can_delete_issue()
    {
        $this->adminUserSigningIn();
        $project = factory(Project::class)->create();
        $issue = factory(Issue::class)->create([
            'project_id' => $project->id,
        ]);

        $this->visitRoute('projects.issues.edit', [$project, $issue]);
        $this->seeElement('a', ['id' => 'delete-issue-'.$issue->id]);

        $this->click('delete-issue-'.$issue->id);

        $this->seePageIs(route('projects.issues.edit', [$project, $issue, 'action' => 'delete']));
        $this->seeElement('button', ['id' => 'delete-issue-'.$issue->id]);

        $this->press('delete-issue-'.$issue->id);

        $this->seePageIs(route('projects.issues.index', $project));
        $this->seeText(__('issue.deleted'));

        $this->dontSeeInDatabase('issues', [
            'id' => $issue->id,
        ]);
    }

    /** @test */
    public function user_can_assign_someone_to_an_issue_as_pic()
    {
        $this->adminUserSigningIn();
        $worker = $this->createUser('worker');
        $issue = factory(Issue::class)->create();

        $this->visitRoute('projects.issues.show', [$issue->project, $issue]);
        $this->submitForm(__('issue.update'), [
            'pic_id' => $worker->id,
        ]);
        $this->seeRouteIs('projects.issues.show', [$issue->project, $issue]);
        $this->seeText(__('issue.updated'));

        $this->seeInDatabase('issues', [
            'id'     => $issue->id,
            'pic_id' => $worker->id,
        ]);
    }

    /** @test */
    public function user_can_remove_pic_assignment()
    {
        $this->adminUserSigningIn();
        $worker = $this->createUser('worker');
        $issue = factory(Issue::class)->create(['pic_id' => $worker->id]);

        $this->visitRoute('projects.issues.show', [$issue->project, $issue]);
        $this->submitForm(__('issue.update'), [
            'pic_id' => '',
        ]);
        $this->seeRouteIs('projects.issues.show', [$issue->project, $issue]);
        $this->seeText(__('issue.updated'));

        $this->seeInDatabase('issues', [
            'id'     => $issue->id,
            'pic_id' => null,
        ]);
    }

    /** @test */
    public function user_can_change_issue_status()
    {
        $this->adminUserSigningIn();
        $worker = $this->createUser('worker');
        $issue = factory(Issue::class)->create();

        $this->visitRoute('projects.issues.show', [$issue->project, $issue]);
        $this->submitForm(__('issue.update'), [
            'status_id' => 2, // resolved
            'pic_id'    => $worker->id,
        ]);
        $this->seeRouteIs('projects.issues.show', [$issue->project, $issue]);
        $this->seeText(__('issue.updated'));

        $this->seeInDatabase('issues', [
            'id'        => $issue->id,
            'pic_id'    => $worker->id,
            'status_id' => 2, // resolved
        ]);
    }

    /** @test */
    public function user_can_change_issue_priority()
    {
        $this->adminUserSigningIn();
        $worker = $this->createUser('worker');
        $issue = factory(Issue::class)->create();

        $this->visitRoute('projects.issues.show', [$issue->project, $issue]);
        $this->submitForm(__('issue.update'), [
            'priority_id' => 2, // major
            'status_id'   => 2, // resolved
            'pic_id'      => $worker->id,
        ]);
        $this->seeRouteIs('projects.issues.show', [$issue->project, $issue]);
        $this->seeText(__('issue.updated'));

        $this->seeInDatabase('issues', [
            'id'          => $issue->id,
            'pic_id'      => $worker->id,
            'priority_id' => 2, // major
            'status_id'   => 2, // resolved
        ]);
    }
}
