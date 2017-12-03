<?php

namespace Tests\Feature\Projects;

use App\Entities\Projects\Project;
use Illuminate\Http\UploadedFile;
use Storage;
use Tests\TestCase;

class UploadFilesTest extends TestCase
{
    /** @test */
    public function user_can_upload_document_to_a_project()
    {
        Storage::fake('avatar');
        $user = $this->adminUserSigningIn();
        $project = factory(Project::class)->create();
        $this->visit(route('projects.files', $project->id));
        $this->seeElement('form', ['id' => 'upload-file']);
        $this->seeElement('input', ['id' => 'file']);
        $this->seeElement('input', ['type' => 'submit', 'value' => trans('file.upload')]);

        $this->attach(UploadedFile::fake()->create('avatar.txt'), 'file');
        $this->type('Judul file', 'title');
        $this->type('Deskripsi file yang diuplod.', 'description');
        $this->press(trans('file.upload'));

        $this->assertCount(1, $project->files);

        $this->seeInDatabase('files', [
            'fileable_id'   => $project->id,
            'fileable_type' => 'App\Entities\Projects\Project',
            'title'         => 'Judul file',
            'description'   => 'Deskripsi file yang diuplod.',
        ]);

        $file = $project->files->first();
        Storage::disk('avatar')->assertExists('public/files/'.$file->filename);
    }

    /** @test */
    public function user_can_edit_document_file_on_a_project()
    {
        Storage::fake('avatar');
        $user = $this->adminUserSigningIn();
        $project = factory(Project::class)->create();
        // $file = factory(File::class, 'project')->create(['fileable_id' => $project->id]);
        // dd(get_class_methods((new FileFactory)->create('123.txt')));
        // $result = Storage::disk('avatar')->put('public/files', (new FileFactory)->create('123.txt'));
        // dd($result);

        $this->visit(route('projects.files', [$project->id]));

        $this->attach(UploadedFile::fake()->image('avatar.jpg'), 'file');
        $this->type('Judul file', 'title');
        $this->type('Deskripsi file yang diuplod.', 'description');
        $this->press(trans('file.upload'));

        $this->assertCount(1, $project->files);

        $file = $project->files->first();

        $this->visit(route('projects.files', [$project->id, 'id' => $file->id, 'action' => 'edit']));
        $this->seePageIs(route('projects.files', [$project->id, 'action' => 'edit', 'id' => $file->id]));

        $this->type('Edit Judul file', 'title');
        $this->type('Edit Deskripsi file yang diuplod.', 'description');
        $this->press(trans('file.update'));

        $this->seePageIs(route('projects.files', [$project->id]));

        $this->seeInDatabase('files', [
            'fileable_id'   => $project->id,
            'fileable_type' => 'App\Entities\Projects\Project',
            'title'         => 'Edit Judul file',
            'description'   => 'Edit Deskripsi file yang diuplod.',
        ]);

        Storage::disk('avatar')->assertExists('public/files/'.$file->filename);
    }
}
