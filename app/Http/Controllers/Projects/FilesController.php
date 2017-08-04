<?php

namespace App\Http\Controllers\Projects;

use App\Entities\Projects\File;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class FilesController extends Controller
{
    private $fileableTypes = [
        'projects' => 'App\Entities\Projects\Project',
    ];

    public function index(Request $request, $fileableId)
    {
        $fileableType = $request->segment(1); // projects, features
        $modelName = $this->getModelName($fileableType);
        $modelShortName = $this->getModelShortName($modelName);
        $model = $modelName::findOrFail($fileableId);
        $files = $model->files;

        return view($fileableType.'.files', [$modelShortName => $model, 'files' => $files]);
    }

    public function create(Request $request, $fileableId)
    {
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

    private function proccessPhotoUpload($data, $fileableType, $fileableId)
    {
        // dd(get_class_methods($data['files']));
        $file = $data['files'];
        // $fileName = md5(uniqid(rand(), true)).'.'.$file->getClientOriginalExtension();
        $fileName = $file->hashName();
        // dd($fileName);

        $fileData['fileable_id'] = $fileableId;
        $fileData['fileable_type'] = $fileableType;
        $fileData['filename'] = $fileName;
        $fileData['title'] = $data['title'];
        $fileData['description'] = $data['description'];
        \DB::beginTransaction();
        // dd(is_dir(storage_path('app/public/files')));
        $file->storeAs('public/files', $fileName);
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
