<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingUpdateRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdminSettingController extends Controller
{
    private const KEYS = [
        'company_name',
        'company_tagline',
        'company_email',
        'company_phone',
        'company_whatsapp',
        'company_address',
        'company_city',
        'company_country',
        'company_google_maps_url',
        'company_working_hours',
        'social_linkedin',
        'social_facebook',
        'social_instagram',
        'social_x',
        'social_youtube',
    ];

    public function edit(Request $request)
    {
        $this->authorizeSettingsAccess($request);

        $settings = Setting::query()
            ->whereIn('key', self::KEYS)
            ->get()
            ->keyBy('key');

        $values = [];
        foreach (self::KEYS as $key) {
            $values[$key] = optional($settings->get($key))->value;
        }

        return view('admin.settings.edit', compact('values'));
    }

    public function update(SettingUpdateRequest $request)
    {
        $this->authorizeSettingsAccess($request);

        $data = $request->validated();

        foreach (self::KEYS as $key) {
            $value = array_key_exists($key, $data) ? $data[$key] : null;

            Setting::query()->updateOrCreate(
                ['key' => $key],
                ['value' => $value === '' ? null : $value]
            );
        }

        Cache::forget('site_settings');
        Cache::forget('top_categories');

        return redirect()->route('admin.settings.edit')->with('success', 'Settings updated successfully.');
    }

    private function authorizeSettingsAccess(Request $request): void
    {
        $this->authorize('viewAdmin', $request->user());

        if (!$request->user()->isSuperAdmin() && !$request->user()->isAdmin()) {
            abort(403);
        }
    }
}