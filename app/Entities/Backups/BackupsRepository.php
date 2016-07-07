<?php

namespace App\Entities\Backups;

use App\Entities\Options\Option;
use BackupManager\Filesystems\Destination;
use BackupManager\Manager;
use League\Flysystem\FileExistsException;
use League\Flysystem\FileNotFoundException;
use Storage;

/**
* Backups Repository Class
*/
class BackupsRepository
{
    protected $storage;
    protected $storageType;

    public function __construct()
    {
        $this->storageType = 'local';
        $this->storage = Storage::disk($this->storageType);
    }

    public function getAllFiles()
    {
        $backups = \File::allFiles(storage_path('app/backup/db'));

        // Sort files by modified time DESC
        usort($backups, function($a, $b) {
            return -1 * strcmp($a->getMTime(), $b->getMTime());
        });

        return $backups;
    }

    public function create($backupData)
    {
        $manager = app()->make(Manager::class);
        $fileName = $backupData['file_name'] ?: date('Y-m-d_Hi');
        try {
            $manager->makeBackup()->run('mysql', [
                    new Destination($this->storageType, 'backup/db/' . $fileName)
                ], 'gzip');

            return $fileName;

        } catch (FileExistsException $e) {
            flash()->error('Database tidak dapat dibackup dengan Nama File yang sama.');
            return false;
        }
    }

    public function restore($fileName)
    {
        try {
            $manager = app()->make(Manager::class);
            $manager->makeRestore()->run($this->storageType, 'backup/db/' . $fileName, 'mysql', 'gzip');
            return true;

        } catch (FileNotFoundException $e) {
            flash()->error('Tidak dapat mengembalikan Database.');
            return false;
        }
    }

    public function delete($fileName)
    {
        if ($this->storage->has('backup/db/' . $fileName)) {
            $this->storage->delete('backup/db/' . $fileName);

            return true;
        }

        return false;
    }

    public function proccessBackupFileUpload($req)
    {
        $file = $req->file('backup_file');

        if ($this->storage->has('backup/db/' . $file->getClientOriginalName())) {
            flash()->error('Upload file gagal, terdapat Nama File yang sama.');
            return false;
        }

        $result = $this->storage->put('backup/db/' . $file->getClientOriginalName(), file_get_contents($file));

        return $result;
    }
}