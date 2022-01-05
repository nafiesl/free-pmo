<?php

namespace Tests\Feature\Projects;

use App\Entities\Projects\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Storage;
use Tests\TestCase;

class UploadFilesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_upload_document_to_a_project()
    {
        Storage::fake(config('filesystem.default'));
        $user = $this->adminUserSigningIn();
        $project = factory(Project::class)->create();
        $this->visit(route('projects.files', $project->id));
        $this->seeElement('form', ['id' => 'upload-file']);
        $this->seeElement('input', ['id' => 'file']);
        $this->seeElement('input', ['type' => 'submit', 'value' => __('file.upload')]);

        $this->attach(UploadedFile::fake()->create('avatar.txt'), 'file');
        $this->type('Judul file', 'title');
        $this->type('Deskripsi file yang diuplod.', 'description');
        $this->press(__('file.upload'));

        $this->assertCount(1, $project->files);

        $this->seeInDatabase('files', [
            'fileable_id'   => $project->id,
            'fileable_type' => 'projects',
            'title'         => 'Judul file',
            'description'   => 'Deskripsi file yang diuplod.',
        ]);

        $file = $project->files->first();
        Storage::assertExists('public/files/'.$file->filename);
    }

    /** @test */
    public function user_can_edit_document_file_on_a_project()
    {
        Storage::fake(config('filesystem.default'));
        $user = $this->adminUserSigningIn();
        $project = factory(Project::class)->create();

        $this->visit(route('projects.files', [$project->id]));

        $this->attach(UploadedFile::fake()->image('avatar.jpg'), 'file');
        $this->type('Judul file', 'title');
        $this->type('Deskripsi file yang diuplod.', 'description');
        $this->press(__('file.upload'));

        $this->assertCount(1, $project->files);

        $file = $project->files->first();

        $this->visit(route('projects.files', [$project->id, 'id' => $file->id, 'action' => 'edit']));
        $this->seePageIs(route('projects.files', [$project->id, 'action' => 'edit', 'id' => $file->id]));

        $this->type('Edit Judul file', 'title');
        $this->type('Edit Deskripsi file yang diuplod.', 'description');
        $this->press(__('file.update'));

        $this->seePageIs(route('projects.files', [$project->id]));

        $this->seeInDatabase('files', [
            'fileable_id'   => $project->id,
            'fileable_type' => 'projects',
            'title'         => 'Edit Judul file',
            'description'   => 'Edit Deskripsi file yang diuplod.',
        ]);

        Storage::assertExists('public/files/'.$file->filename);
    }

    /** @test */
    public function user_can_delete_document_file_on_a_project()
    {
        Storage::fake(config('filesystem.default'));
        $user = $this->adminUserSigningIn();
        $project = factory(Project::class)->create();

        $this->visit(route('projects.files', $project));

        $this->attach(UploadedFile::fake()->image('avatar.jpg'), 'file');
        $this->type('Judul file', 'title');
        $this->type('Deskripsi file yang diuplod.', 'description');
        $this->press(__('file.upload'));

        $this->assertCount(1, $project->files);

        $file = $project->files->first();
        Storage::assertExists('public/files/'.$file->filename);

        $this->visit(route('projects.files', $project));
        $this->click('delete-file-'.$file->id);
        $this->seePageIs(route('projects.files', [$project, 'action' => 'delete', 'id' => $file->id]));

        $this->press(__('app.delete_confirm_button'));

        $this->seePageIs(route('projects.files', $project));
        $this->seeText(__('file.deleted'));
        $this->dontSeeInDatabase('files', ['id' => $file->id]);
        Storage::assertMissing('public/files/'.$file->filename);
    }
}
