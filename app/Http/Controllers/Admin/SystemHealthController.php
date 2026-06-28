<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\TestMail;

class SystemHealthController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:super_admin']);
    }

    public function index()
    {
        $health = [
            'database' => $this->checkDatabase(),
            'storage' => $this->checkStorage(),
            'mail' => $this->checkMail(),
            'cache' => $this->checkCache(),
            'environment' => $this->checkEnvironment(),
        ];

        return view('admin.system-health.index', compact('health'));
    }

    private function checkDatabase()
    {
        try {
            DB::connection()->getPdo();
            return [
                'status' => 'ok',
                'message' => 'Database connection successful',
                'details' => [
                    'connection' => config('database.default'),
                    'driver' => config('database.connections.' . config('database.default') . '.driver'),
                ]
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Database connection failed: ' . $e->getMessage(),
                'details' => []
            ];
        }
    }

    private function checkStorage()
    {
        try {
            $linkExists = file_exists(public_path('storage'));
            $writable = is_writable(storage_path('app'));
            
            return [
                'status' => ($linkExists && $writable) ? 'ok' : 'error',
                'message' => $linkExists 
                    ? ($writable ? 'Storage link exists and is writable' : 'Storage directory not writable')
                    : 'Storage link missing - run php artisan storage:link',
                'details' => [
                    'link_exists' => $linkExists,
                    'writable' => $writable,
                ]
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Storage check failed: ' . $e->getMessage(),
                'details' => []
            ];
        }
    }

    private function checkMail()
    {
        try {
            $config = [
                'default' => config('mail.default'),
                'host' => config('mail.mailers.smtp.host'),
                'port' => config('mail.mailers.smtp.port'),
                'encryption' => config('mail.mailers.smtp.encryption'),
                'from' => config('mail.from.address'),
            ];

            return [
                'status' => 'ok',
                'message' => 'Mail configuration loaded',
                'details' => $config
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Mail configuration error: ' . $e->getMessage(),
                'details' => []
            ];
        }
    }

    private function checkCache()
    {
        try {
            cache()->put('health_check', 'test', 60);
            $value = cache()->get('health_check');
            cache()->forget('health_check');

            return [
                'status' => ($value === 'test') ? 'ok' : 'error',
                'message' => ($value === 'test') ? 'Cache system working' : 'Cache system not working',
                'details' => [
                    'driver' => config('cache.default'),
                ]
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Cache check failed: ' . $e->getMessage(),
                'details' => []
            ];
        }
    }

    private function checkEnvironment()
    {
        $env = app()->environment();
        $debug = config('app.debug');
        
        return [
            'status' => ($env === 'production' && !$debug) ? 'warning' : 'ok',
            'message' => sprintf(
                'Environment: %s, Debug: %s',
                $env,
                $debug ? 'ON (should be OFF in production)' : 'OFF'
            ),
            'details' => [
                'environment' => $env,
                'debug' => $debug,
                'timezone' => config('app.timezone'),
            ]
        ];
    }

    public function testMail(Request $request)
    {
        try {
            Mail::to(config('mail.from.address'))->send(new TestMail());
            return back()->with('success', 'Test email sent successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Test email failed: ' . $e->getMessage());
        }
    }

    public function clearCache()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('view:clear');
            Artisan::call('route:clear');
            
            return back()->with('success', 'All caches cleared successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Cache clear failed: ' . $e->getMessage());
        }
    }
}
