<?php

namespace App\Http\Controllers;

use BackupManager\Filesystems\Destination;
use BackupManager\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use League\Flysystem\FileExistsException;
use League\Flysystem\FileNotFoundException;

/**
 * Database Backups Controller.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class BackupsController extends Controller
{
    /**
     * List of backup files.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (!file_exists(storage_path('app/backup/db'))) {
            $backups = [];
        } else {
            $backups = File::allFiles(storage_path('app/backup/db'));

            // Sort files by modified time DESC
            usort($backups, function ($a, $b) {
                return -1 * strcmp($a->getMTime(), $b->getMTime());
            });
        }

        return view('backups.index', compact('backups'));
    }

    /**
     * Create new backup file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'file_name' => 'nullable|max:30|regex:/^[\w._-]+$/',
        ]);

        try {
            $manager = app()->make(Manager::class);
            $fileName = $request->get('file_name') ?: date('Y-m-d_Hi');

            $manager->makeBackup()->run('mysql', [
                new Destination('local', 'backup/db/'.$fileName),
            ], 'gzip');

            flash(__('backup.created', ['filename' => $fileName.'.gz']), 'success');

            return redirect()->route('backups.index');
        } catch (FileExistsException $e) {
            flash(__('backup.not_created', ['filename' => $fileName.'.gz']), 'danger');

            return redirect()->route('backups.index');
        }
    }

/**
      * Delete a backup file from storage.
      *
      * @param  string  $fileName
      * @return \Illuminate\Routing\Redirector
      */
    public function destroy($fileName)
    {
        // Sanitize filename to prevent path traversal
        $safeFileName = basename($fileName);
        
        // Validate that it's a .gz backup file
        if (!preg_match('/^[\w._-]+\.gz$/', $safeFileName)) {
            flash(__('backup.invalid_filename', ['filename' => $fileName]), 'danger');
            return redirect()->route('backups.index');
        }

        if (file_exists(storage_path('app/backup/db/').$safeFileName)) {
            unlink(storage_path('app/backup/db/').$safeFileName);
            flash(__('backup.deleted', ['filename' => $safeFileName]), 'warning');
        } else {
            flash(__('backup.not_found', ['filename' => $safeFileName]), 'danger');
        }

        return redirect()->route('backups.index');
    }

    /**
      * Download a backup file.
      *
      * @param  string  $fileName
      * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
      */
    public function download($fileName)
    {
        // Sanitize filename to prevent path traversal
        $safeFileName = basename($fileName);
        
        // Validate that it's a .gz backup file
        if (!preg_match('/^[\w._-]+\.gz$/', $safeFileName)) {
            abort(404, 'Invalid file name');
        }

        if (file_exists(storage_path('app/backup/db/').$safeFileName)) {
            return response()->download(storage_path('app/backup/db/').$safeFileName);
        }

        abort(404, 'File not found');
    }

    /**
      * Restore database from a backup file.
      *
      * @param  string  $fileName
      * @return \Illuminate\Routing\Redirector
      */
    public function restore($fileName)
    {
        // Sanitize filename to prevent path traversal
        $safeFileName = basename($fileName);
        
        // Validate that it's a .gz backup file
        if (!preg_match('/^[\w._-]+\.gz$/', $safeFileName)) {
            flash(__('backup.invalid_filename', ['filename' => $fileName]), 'danger');
            return redirect()->route('backups.index');
        }

        try {
            $manager = app()->make(Manager::class);
            $manager->makeRestore()->run('local', 'backup/db/'.$safeFileName, 'mysql', 'gzip');
            flash(__('backup.restored', ['filename' => $safeFileName]), 'success');
        } catch (FileNotFoundException $e) {
            flash(__('backup.not_found', ['filename' => $safeFileName]), 'danger');
        }

        return redirect()->route('backups.index');
    }

    /**
     * Upload a backup file to the storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector
     */
    public function upload(Request $request)
    {
        $data = $request->validate([
            'backup_file' => 'required|mimetypes:application/gzip,application/x-gzip',
        ], [
            'backup_file.mimetypes' => 'Invalid file type, must be <strong>.gz</strong> file',
        ]);

        $file = $data['backup_file'];
        $fileName = $file->getClientOriginalName();

        if (file_exists(storage_path('app/backup/db/').$fileName) == false) {
            $file->storeAs('backup/db', $fileName);
        }

        flash(__('backup.uploaded', ['filename' => $fileName]), 'success');

        return redirect()->route('backups.index');
    }
}
