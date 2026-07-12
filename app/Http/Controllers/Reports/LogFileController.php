<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class LogFileController extends Controller
{
    public function index()
    {
        if (!file_exists(storage_path('logs'))) {
            return [];
        }

        $logFiles = File::allFiles(storage_path('logs'));

        // Sort files by modified time DESC
        usort($logFiles, function ($a, $b) {
            return -1 * strcmp($a->getMTime(), $b->getMTime());
        });

        return view('reports.log-files', compact('logFiles'));
    }

    public function show($fileName)
    {
        // Sanitize filename to prevent path traversal
        $safeFileName = basename($fileName);
        
        // Validate that it's actually a log file
        if (!preg_match('/^laravel-(\d{4}-\d{2}-\d{2})\.log$/', $safeFileName)) {
            return 'Invalid file name.';
        }

        if (file_exists(storage_path('logs/'.$safeFileName))) {
            return response()->file(storage_path('logs/'.$safeFileName), ['content-type' => 'text/plain']);
        }

        return 'Invalid file name.';
    }

    public function download($fileName)
    {
        // Sanitize filename to prevent path traversal
        $safeFileName = basename($fileName);
        
        // Validate that it's actually a log file
        if (!preg_match('/^laravel-(\d{4}-\d{2}-\d{2})\.log$/', $safeFileName)) {
            return 'Invalid file name.';
        }

        if (file_exists(storage_path('logs/'.$safeFileName))) {
            return response()->download(storage_path('logs/'.$safeFileName), env('APP_ENV').'.'.$safeFileName);
        }

        return 'Invalid file name.';
    }
}
