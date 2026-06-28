@extends('admin.layout')

@section('title', 'Settings')
@section('page_title', 'Settings')
@section('page_subtitle', 'Update company details and social links')

@section('content')
<form method="POST" action="{{ route('admin.settings.update') }}" class="grid gap-6 lg:grid-cols-12">
    @csrf
    @method('PATCH')

    <div class="space-y-6 lg:col-span-8">
        <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-xl shadow-slate-900/5">
            <div class="border-b border-slate-200 px-6 py-5">
                <div class="section-kicker">Company Information</div>
                <h2 class="mt-2 text-xl font-black text-slate-950">Public business details</h2>
                <p class="mt-1 text-sm text-slate-500">
                    These values are used across the website, footer, contact page, and structured data.
                </p>
            </div>

            <div class="grid gap-5 p-6 md:grid-cols-2">
                <div>
                    <label class="text-sm font-black text-slate-800">Company name</label>
                    <input class="field mt-2" name="company_name" value="{{ old('company_name', $values['company_name'] ?? '') }}">
                    <x-input-error :messages="$errors->get('company_name')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div>
                    <label class="text-sm font-black text-slate-800">Tagline</label>
                    <input class="field mt-2" name="company_tagline" value="{{ old('company_tagline', $values['company_tagline'] ?? '') }}">
                    <x-input-error :messages="$errors->get('company_tagline')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div>
                    <label class="text-sm font-black text-slate-800">Email</label>
                    <input class="field mt-2" name="company_email" value="{{ old('company_email', $values['company_email'] ?? '') }}">
                    <x-input-error :messages="$errors->get('company_email')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div>
                    <label class="text-sm font-black text-slate-800">Phone</label>
                    <input class="field mt-2" name="company_phone" value="{{ old('company_phone', $values['company_phone'] ?? '') }}">
                    <x-input-error :messages="$errors->get('company_phone')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div>
                    <label class="text-sm font-black text-slate-800">WhatsApp</label>
                    <input class="field mt-2" name="company_whatsapp" value="{{ old('company_whatsapp', $values['company_whatsapp'] ?? '') }}">
                    <x-input-error :messages="$errors->get('company_whatsapp')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div>
                    <label class="text-sm font-black text-slate-800">Working hours</label>
                    <input class="field mt-2" name="company_working_hours" value="{{ old('company_working_hours', $values['company_working_hours'] ?? '') }}" placeholder="Sun–Thu 9:00–17:00">
                    <x-input-error :messages="$errors->get('company_working_hours')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm font-black text-slate-800">Address</label>
                    <input class="field mt-2" name="company_address" value="{{ old('company_address', $values['company_address'] ?? '') }}">
                    <x-input-error :messages="$errors->get('company_address')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div>
                    <label class="text-sm font-black text-slate-800">City</label>
                    <input class="field mt-2" name="company_city" value="{{ old('company_city', $values['company_city'] ?? '') }}">
                    <x-input-error :messages="$errors->get('company_city')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div>
                    <label class="text-sm font-black text-slate-800">Country</label>
                    <input class="field mt-2" name="company_country" value="{{ old('company_country', $values['company_country'] ?? '') }}">
                    <x-input-error :messages="$errors->get('company_country')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm font-black text-slate-800">Google Maps URL</label>
                    <input class="field mt-2" name="company_google_maps_url" value="{{ old('company_google_maps_url', $values['company_google_maps_url'] ?? '') }}" placeholder="https://maps.google.com/...">
                    <x-input-error :messages="$errors->get('company_google_maps_url')" class="mt-2 text-sm text-[#711726]" />
                </div>
            </div>
        </div>

        <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-xl shadow-slate-900/5">
            <div class="border-b border-slate-200 px-6 py-5">
                <div class="section-kicker">Social Links</div>
                <h2 class="mt-2 text-xl font-black text-slate-950">Optional public links</h2>
            </div>

            <div class="grid gap-5 p-6 md:grid-cols-2">
                <div>
                    <label class="text-sm font-black text-slate-800">LinkedIn</label>
                    <input class="field mt-2" name="social_linkedin" value="{{ old('social_linkedin', $values['social_linkedin'] ?? '') }}">
                </div>

                <div>
                    <label class="text-sm font-black text-slate-800">Facebook</label>
                    <input class="field mt-2" name="social_facebook" value="{{ old('social_facebook', $values['social_facebook'] ?? '') }}">
                </div>

                <div>
                    <label class="text-sm font-black text-slate-800">Instagram</label>
                    <input class="field mt-2" name="social_instagram" value="{{ old('social_instagram', $values['social_instagram'] ?? '') }}">
                </div>

                <div>
                    <label class="text-sm font-black text-slate-800">X / Twitter</label>
                    <input class="field mt-2" name="social_x" value="{{ old('social_x', $values['social_x'] ?? '') }}">
                </div>

                <div>
                    <label class="text-sm font-black text-slate-800">YouTube</label>
                    <input class="field mt-2" name="social_youtube" value="{{ old('social_youtube', $values['social_youtube'] ?? '') }}">
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-6 lg:col-span-4">
        <div class="sticky top-24 space-y-6">
            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-xl shadow-slate-900/5">
                <div class="section-kicker">Actions</div>

                <div class="mt-5 grid gap-3">
                    <button class="btn btn-primary w-full" type="submit">
                        Save Settings
                    </button>

                    @auth
                        @if (auth()->user()->role === 'super_admin')
                            <a href="{{ route('admin.test-email.index') }}" class="btn btn-outline w-full">
                                Test Email Configuration
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-xl shadow-slate-900/5">
                <div class="section-kicker">Where Used</div>

                <div class="mt-5 grid gap-3 text-sm text-slate-600">
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 font-semibold">Footer contact information</div>
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 font-semibold">Contact page cards</div>
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 font-semibold">Email signatures and inquiry workflows</div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection