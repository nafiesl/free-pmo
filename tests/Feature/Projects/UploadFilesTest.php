<?php

namespace Tests\Feature\Projects;

use App\Entities\Projects\Project;
use Tests\TestCase;

class UploadFilesTest extends TestCase
{
    /** @test */
    public function user_can_upload_document_to_a_project()
    {
        $user = $this->adminUserSigningIn();
        $project = factory(Project::class)->create(['owner_id' => $user->id]);
        $this->visit(route('projects.files', $project->id));
        $this->seeElement('form', ['id' => 'upload-file']);
        $this->seeElement('input', ['id' => 'file']);
        $this->seeElement('input', ['type' => 'submit', 'value' => trans('file.upload')]);

        $this->attach(storage_path('app/guitar-640.jpg'), 'file');
        $this->type('Judul file', 'title');
        $this->type('Deskripsi file yang diuplod.', 'description');
        $this->press(trans('file.upload'));

        $this->assertCount(1, $project->files);

        $this->seeInDatabase('files', [
            'fileable_id' => $project->id,
            'fileable_type' => 'App\Entities\Projects\Project',
            'title' => 'Judul file',
            'description' => 'Deskripsi file yang diuplod.',
        ]);

        $file = $project->files->first();
        $filePath = storage_path('app/public/files/' . $file->filename);
        $this->assertFileExistsThenDelete($filePath, 'File doesn\'t exists.');
    }
}
