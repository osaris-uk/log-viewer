<?php

namespace OsarisUk\LogViewer\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

class LogViewerController extends Controller
{
    public function index(Request $request, $file = null)
    {
        if ($file == null) {
            $file = $this->getLatestLog();
        }

        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        // Create a new Laravel collection from the array data
        $itemCollection = collect($this->getLogContents($file));

        // Define how many items we want to be visible in each page
        $perPage = 10;

        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();

        // Create our paginator and pass it to the view
        $paginatedItems = new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);

        // set url path for generted links
        $paginatedItems->setPath($request->url());

        return view('log-viewer::log', [
            'allLogs' => $this->getLogs(),
            'log' => $paginatedItems,
            'currentLog' => $file,
            'colors' => self::$levelColors
        ]);
    }

    public static $levelColors = [
        'EMERGENCY' => 'dark',
        'ALERT'     => 'primary',
        'CRITICAL'  => 'danger',
        'ERROR'     => 'danger',
        'WARNING'   => 'warning',
        'NOTICE'    => 'secondary',
        'INFO'      => 'info',
        'DEBUG'     => 'success',
    ];

    public function getLogs($count = 20)
    {
        $files = glob(storage_path('logs/*'));
        $files = array_combine($files, array_map('filemtime', $files));
        arsort($files);

        $files = array_map('basename', array_keys($files));

        return array_slice($files, 0, $count);
    }

    public function getLatestLog()
    {
        $logs = $this->getLogs();

        return current($logs);
    }

    public function getLogContents($file)
    {
        if(file_exists(storage_path('logs/' . $file))) {
            $raw = file_get_contents(storage_path('logs/' . $file));
        } else {
            $raw = null;
        }

        $logs = preg_split('/\[(\d{4}(?:-\d{2}){2} \d{2}(?::\d{2}){2})\] (\w+)\.(\w+):((?:(?!{"exception").)*)?/', trim($raw), -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

        foreach ($logs as $index => $log) {
            if (preg_match('/^\d{4}/', $log)) {
                break;
            } else {
                unset($logs[$index]);
            }
        }

        if (empty($logs)) {
            return [];
        }

        foreach (array_chunk($logs, 5) as $log) {
            $parsed[] = [
                'time'  => $log[0] ?? '',
                'env'   => $log[1] ?? '',
                'level' => $log[2] ?? '',
                'info'  => $log[3] ?? '',
                'trace' => isset($log[4]) ? ltrim($log[4]) : '',
            ];
        }

        rsort($parsed);

        return $parsed;
    }
}
