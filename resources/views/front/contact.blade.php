@extends('front.layout')

@section('title', 'Contact')

@section('meta_description', 'Contact NINGBO PASAFEITE for industrial sourcing, engineering equipment, automation products, raw materials, quotations, technical requirements, and delivery coordination.')

@section('meta_image', asset('assets/images/hero.jpg'))

@section('canonical', route('contact'))

@section('content')
<section class="bg-white">
    <div class="container-max py-20 lg:py-24">
        <div class="max-w-4xl">
            <h1 data-reveal class="text-4xl font-black leading-tight tracking-[-0.04em] text-slate-950 md:text-6xl">
                Send your technical requirement.
            </h1>

            <p data-reveal class="mt-5 max-w-2xl text-lg leading-relaxed text-slate-600">
                Share product details, technical scope, quantity, destination, and timeline. We will review your request and respond with clear next steps.
            </p>
        </div>
    </div>
</section>

<section class="section relative overflow-hidden bg-slate-50">
    <div class="absolute -right-32 top-24 h-96 w-96 rounded-full bg-[#015ea4]/8 blur-3xl" data-parallax="80"></div>
    <div class="absolute -left-32 bottom-20 h-96 w-96 rounded-full bg-[#711726]/6 blur-3xl" data-parallax="60"></div>

    <div class="container-max relative">
        <div class="grid gap-5 md:grid-cols-3">
            @if(!empty($settings['company_email']))
                <div data-reveal class="card lift p-7">
                    <div class="section-kicker">EMAIL</div>
                    <a href="mailto:{{ $settings['company_email'] }}" class="mt-3 block break-all text-lg font-black text-[#015ea4]">
                        {{ $settings['company_email'] }}
                    </a>
                    <p class="mt-3 text-sm leading-relaxed text-slate-600">
                        Best for documents, specifications, attachments, and formal inquiries.
                    </p>
                </div>
            @endif

            @if(!empty($settings['company_phone']))
                <div data-reveal class="card lift p-7">
                    <div class="section-kicker">PHONE</div>
                    <a href="tel:{{ preg_replace('/\s+/', '', $settings['company_phone']) }}" class="mt-3 block text-lg font-black text-[#015ea4]">
                        {{ $settings['company_phone'] }}
                    </a>
                    <p class="mt-3 text-sm leading-relaxed text-slate-600">
                        Useful for quick clarification and coordination follow-up.
                    </p>
                </div>
            @endif

            @if(!empty($settings['company_whatsapp']))
                <div data-reveal class="card lift p-7">
                    <div class="section-kicker">WHATSAPP</div>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['company_whatsapp']) }}" target="_blank" rel="noopener noreferrer" class="mt-3 block text-lg font-black text-[#015ea4]">
                        {{ $settings['company_whatsapp'] }}
                    </a>
                    <p class="mt-3 text-sm leading-relaxed text-slate-600">
                        Fast exchange for photos, labels, shipment notes, and quick updates.
                    </p>
                </div>
            @endif
        </div>

        <div class="mt-12 grid gap-10 lg:grid-cols-12">
            <div class="lg:col-span-7">
                <div data-reveal class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-2xl shadow-slate-900/8">
                    <div class="section-kicker">INQUIRY FORM</div>

                    <h2 class="mt-3 text-2xl font-black text-slate-950 md:text-3xl">
                        Tell us what you need.
                    </h2>

                    <p class="mt-3 text-sm leading-relaxed text-slate-600">
                        Include technical scope, target capacity, standards, destination, and required timeline. Clear input helps us respond faster.
                    </p>

                    <form class="mt-8 grid gap-4" method="POST" action="{{ route('contact.store') }}">
                        @csrf

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="text-sm font-bold text-slate-800">Name</label>
                                <input name="name" value="{{ old('name') }}" class="field mt-1" required placeholder="Enter your name">
                                @error('name')<div class="mt-1 text-sm text-[#711726]">{{ $message }}</div>@enderror
                            </div>

                            <div>
                                <label class="text-sm font-bold text-slate-800">Email</label>
                                <input name="email" type="email" value="{{ old('email') }}" class="field mt-1" required placeholder="Example.com">
                                @error('email')<div class="mt-1 text-sm text-[#711726]">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="text-sm font-bold text-slate-800">Phone</label>
                                <input name="phone" value="{{ old('phone') }}" class="field mt-1 phone-input" placeholder="Enter phone number">
                                @error('phone')<div class="mt-1 text-sm text-[#711726]">{{ $message }}</div>@enderror
                            </div>

                            <div>
                                <label class="text-sm font-bold text-slate-800">Company</label>
                                <input name="company" value="{{ old('company') }}" class="field mt-1" placeholder="Enter company name">
                                @error('company')<div class="mt-1 text-sm text-[#711726]">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div>
                            <label class="text-sm font-bold text-slate-800">Subject</label>
                            <input name="subject" value="{{ old('subject', 'General inquiry') }}" class="field mt-1">
                            @error('subject')<div class="mt-1 text-sm text-[#711726]">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label class="text-sm font-bold text-slate-800">Message</label>
                            <textarea name="message" rows="7" class="field mt-1" required placeholder="Enter your message">{{ old('message') }}</textarea>
                            @error('message')<div class="mt-1 text-sm text-[#711726]">{{ $message }}</div>@enderror
                        </div>

                        <button class="btn btn-primary w-full sm:w-auto" type="submit">
                            Send Inquiry
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div data-reveal class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-xl shadow-slate-900/5">
                    <div class="section-kicker">WHAT HAPPENS NEXT?</div>

                    <div class="mt-5 grid gap-4 text-sm text-slate-700">
                        @foreach ([
                            ['title' => '1. Review', 'text' => 'We check your scope, standards, quantity, and required deliverables.'],
                            ['title' => '2. Clarify', 'text' => 'If needed, we request missing technical parameters or application details.'],
                            ['title' => '3. Respond', 'text' => 'You receive structured next steps, sourcing direction, or proposal timeline.'],
                        ] as $step)
                            <div class="rounded-2xl bg-slate-50 p-5">
                                <div class="font-black text-slate-950">{{ $step['title'] }}</div>
                                <p class="mt-2 leading-relaxed text-slate-600">{{ $step['text'] }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 rounded-2xl bg-slate-950 p-6 text-white">
                        <div class="text-xs font-black uppercase tracking-[0.22em] text-white/55">INQUIRY CHECKLIST</div>

                        <ul class="mt-4 grid gap-3 text-sm text-white/72">
                            <li>• Capacity or quantity requirements</li>
                            <li>• Applicable standards or specifications</li>
                            <li>• Destination country or port</li>
                            <li>• Target delivery timeline</li>
                        </ul>
                    </div>

                    @if(!empty($settings['company_google_maps_url']))
                        <div class="mt-6">
                            <a href="{{ $settings['company_google_maps_url'] }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary w-full">
                                Open in Google Maps
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@push('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "ContactPage",
    "name": "Contact {{ $settings['company_name'] ?? 'NINGBO PASAFEITE' }}",
    "url": "{{ route('contact') }}",
    "description": "Contact us for industrial sourcing, technical inquiries, quotations, and delivery coordination.",
    "mainEntity": {
        "@type": "Organization",
        "name": "{{ $settings['company_name'] ?? 'NINGBO PASAFEITE' }}",
        "email": "{{ $settings['company_email'] ?? '' }}",
        "telephone": "{{ $settings['company_phone'] ?? '' }}"
    }
}
</script>
@endpush
@endsection