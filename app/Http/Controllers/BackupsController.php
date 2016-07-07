<?php

namespace App\Http\Controllers;

use App\Http\Requests\Backups\CreateRequest;
use App\Http\Requests\Backups\BackupUploadRequest;
use App\Http\Requests\Backups\DeleteRequest;
use App\Http\Controllers\Controller;
use App\Entities\Backups\BackupsRepository;

use Illuminate\Http\Request;

class BackupsController extends Controller {

	private $repo;

	public function __construct(BackupsRepository $repo)
	{
	    $this->repo = $repo;
	}

	public function index(Request $req)
	{
		$backups = $this->repo->getAllFiles();
		return view('backups.index',compact('backups'));
	}

	public function restore($fileName)
	{
		return view('backups.restore', compact('fileName'));
	}

	public function postRestore(Request $req, $fileName)
	{
		$result = $this->repo->restore($fileName);

		if ($result)
			flash()->success('Database berhasil dikembalikan dengan file ' . $fileName);

		return redirect()->route('backups.index');
	}

	public function store(CreateRequest $req)
	{
		$fileName = $this->repo->create($req->except('_token'));

		if ($fileName)
			flash()->success('Backup berhasil dilakukan, nama File : ' . $fileName);

		return redirect()->route('backups.index');
	}

	public function delete($fileName)
	{
		return view('backups.delete', compact('fileName'));
	}

	public function destroy(Request $req, $fileName)
	{
		$result = $this->repo->delete($fileName);

		if ($result)
			flash()->success('File ' . $fileName . ' berhasil dihapus.');
		else
			flash()->error('File ' . $fileName . ' gagal dihapus.');

		return redirect()->route('backups.index');
	}

	public function upload(BackupUploadRequest $req)
	{
		$result = $this->repo->proccessBackupFileUpload($req);
		if ($result)
			flash()->success('Upload file berhasil.');

		return redirect()->route('backups.index');
	}

	public function download($fileName)
	{
		return response()->download(storage_path('app') . '/backup/db/'.$fileName);
	}

}
