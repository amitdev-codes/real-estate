<?php

namespace App\Http\Controllers\Admin\Logs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Inertia\Inertia;

class SystemLogController extends Controller
{
    public function index(Request $request)
    {
        $logFiles = $this->getLogFiles();
        $selectedDate = $request->input('date', date('Y-m-d'));
        $logPath = storage_path("logs/laravel-{$selectedDate}.log");

        // Default pagination values
        $page = max(1, (int)$request->input('page', 1));
        $perPage = (int)$request->input('perPage', 10);

        if (!File::exists($logPath)) {
            return $this->emptyResponse($logFiles, $selectedDate);
        }

        $contents = File::get($logPath);
        $logs = array_filter(explode("\n", $contents));
        $logs = array_values(array_reverse($logs)); // Reset array keys after reverse

        $total = count($logs);
        $lastPage = max(1, ceil($total / $perPage));
        $page = min($page, $lastPage); // Ensure page doesn't exceed last page

        $offset = ($page - 1) * $perPage;
        $currentPageLogs = array_slice($logs, $offset, $perPage);

        $logsData = collect($currentPageLogs)->map(function ($log) {
            return $this->parseLogEntry($log);
        });

        return Inertia::render('backend/pages/logs/system-logs', [
            'logs' => $logsData,
            'logFiles' => $logFiles,
            'selectedDate' => $selectedDate,
            'resourceName' => 'system_logs',
            'pagination' => [
                'current_page' => $page,
                'total' => $total,
                'per_page' => $perPage,
                'last_page' => $lastPage,
            ],
        ]);
    }

    private function emptyResponse($logFiles, $selectedDate)
    {
        return Inertia::render('backend/pages/logs/system-logs', [
            'logs' => [],
            'logFiles' => $logFiles,
            'selectedDate' => $selectedDate,
            'pagination' => [
                'current_page' => 1,
                'total' => 0,
                'per_page' => 10,
                'last_page' => 1,
            ],
        ]);
    }

    private function getLogFiles()
    {
        $logPath = storage_path('logs');
        $files = File::files($logPath);

        return collect($files)
            ->filter(function ($file) {
                return strpos($file->getFilename(), 'laravel-') === 0;
            })
            ->map(function ($file) {
                $date = str_replace(['laravel-', '.log'], '', $file->getFilename());
                return [
                    'date' => $date,
                    'filename' => $file->getFilename(),
                ];
            })
            ->sortByDesc('date')
            ->values()
            ->all();
    }

    private function parseLogEntry($log)
    {
        $pattern = '/\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\] (\w+)\.(\w+): (.*)/';
        preg_match($pattern, $log, $matches);


        if (count($matches) === 5) {
            return [
                'timestamp' => $matches[1],
                'level' => $matches[3],
                'message' => $matches[4],
            ];
        }

        return [
            'timestamp' => '',
            'level' => '',
            'message' => $log,
        ];
    }
    public function show(Request $request)
    {
        $data=$request->query('data');
        $selectedDate = $data['date'];
        $timestamp = $data['timestamp'];
        $message = $data['message'];


        // dd($selectedDate, $timestamp, $message);

        $logPath = storage_path("logs/laravel-{$selectedDate}.log");


        if (!File::exists($logPath)) {
            return redirect()
                ->route('admin.systemLogs.index')
                ->with('error', 'Log file not found');
        }

        $contents = File::get($logPath);

        // $logs = array_filter(explode("\n", $contents));
        if(is_array($contents)){
            $logs = array_filter(explode("\n", $contents));
            $logEntry = null;
            foreach ($logs as $log) {
                $parsedLog = $this->parseLogEntry($log);
                if ($parsedLog['timestamp'] === $timestamp && $parsedLog['message'] === $message) {
                    $logEntry = $parsedLog;
                    break;
                }
            }

            if (!$logEntry) {
                return redirect()
                    ->route('admin.systemLogs.index')
                    ->with('error', 'Log entry not found');
            }

        }else{
            $logEntry['message'] = $contents;
            $logEntry['level'] = "normal";
            $logEntry['timestamp'] = $selectedDate;
        }

        // dd($logEntry,$selectedDate);

        //$logs = is_string($contents) ? array_filter(explode("\n", $contents)) : [];

        // Find the specific log entry


        return Inertia::render('backend/pages/logs/log-details', [
            'log' => $logEntry,
            'date' => $selectedDate,
            'resourceName' => 'system_logs',
            'redirectRoute' => 'admin.systemLogs.index'
        ]);
    }
}
