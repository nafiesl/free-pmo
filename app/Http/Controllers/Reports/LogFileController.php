<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;

class LogFileController extends Controller
{
    public function index()
    {
        if (!file_exists(storage_path('logs'))) {
            return [];
        }

        $logFiles = \File::allFiles(storage_path('logs'));

        // Sort files by modified time DESC
        usort($logFiles, function ($a, $b) {
            return -1 * strcmp($a->getMTime(), $b->getMTime());
        });

        return view('reports.log-files', compact('logFiles'));
    }
}
