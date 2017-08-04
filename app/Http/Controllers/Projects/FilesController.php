<?php

namespace App\Http\Controllers\Projects;

use App\Entities\Projects\File;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use File as FileSystem;

class FilesController extends Controller
{
    private $fileableTypes = [
        'projects' => 'App\Entities\Projects\Project',
    ];

    public function index(Request $request, $fileableId)
    {
        $editableFile = null;
        $fileableType = $request->segment(1); // projects, features
        $modelName = $this->getModelName($fileableType);
        $modelShortName = $this->getModelShortName($modelName);
        $model = $modelName::findOrFail($fileableId);
        $files = $model->files;

        if (in_array($request->get('action'), ['edit', 'delete']) && $request->has('id')) {
            $editableFile = File::find($request->get('id'));
        }

        return view($fileableType.'.files', [$modelShortName => $model, 'files' => $files, 'editableFile' => $editableFile]);
    }

    public function create(Request $request, $fileableId)
    {
        $this->validate($request, [
            'fileable_type'        => 'required',
            'file'        => 'required|file|max:10000',
            'title'       => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);

        $fileableExist = array_search($request->get('fileable_type'), $this->fileableTypes);

        if ($fileableExist) {
            $file = $this->proccessPhotoUpload($request->except('_token'), $request->get('fileable_type'), $fileableId);

            if ($file->exists)
                flash()->success('Upload file berhasil.');
            else
                flash()->error('Upload file gagal, coba kembali.');
        } else
            flash()->error('Upload file gagal, coba kembali.');

        return back();
    }

    public function show($fileId)
    {
        $file = File::find($fileId);

        if ($file && file_exists(storage_path('app/public/files/'.$file->filename))) {
            $extension = FileSystem::extension('public/files/'.$file->filename);
            return response()->download(storage_path('app/public/files/'.$file->filename), $file->title.'.'.$extension);
        }

        flash(trans('file.not_found'), 'danger');

        if (\URL::previous() != \URL::current()) {
            return back();
        }

        return redirect()->home();
    }

    public function update(Request $request, File $file)
    {
        $file->title = $request->get('title');
        $file->description = $request->get('description');
        $file->save();

        flash(trans('file.updated'), 'success');

        $resourceName = array_search($file->fileable_type, $this->fileableTypes);

        return redirect()->route($resourceName.'.files', $file->fileable_id);
    }

    private function proccessPhotoUpload($data, $fileableType, $fileableId)
    {
        $file = $data['file'];
        $fileName = $file->hashName();

        $fileData['fileable_id'] = $fileableId;
        $fileData['fileable_type'] = $fileableType;
        $fileData['filename'] = $fileName;
        $fileData['title'] = $data['title'];
        $fileData['description'] = $data['description'];
        \DB::beginTransaction();
        // dd(is_dir(storage_path('app/public/files')));
        if (env('APP_ENV') == 'testing') {
            $file->store('public/files', 'avatar');
        } else {
            $file->store('public/files');
        }
        // $file->move(storage_path('app/public/files'));
        $file = File::create($fileData);
        \DB::commit();

        return $file;
    }


    public function getModelName($fileableType)
    {
        return isset($this->fileableTypes[$fileableType]) ? $this->fileableTypes[$fileableType] : false;
    }

    public function getModelShortName($modelName)
    {
        return strtolower((new \ReflectionClass($modelName))->getShortName());
    }
}
