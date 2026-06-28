@extends('front.layout')

@section('title', 'Services')

@section('content')
<section class="bg-white">
    <div class="container-max py-20 lg:py-24">
        <div class="max-w-4xl">
            <h1 data-reveal class="text-4xl font-black leading-tight tracking-[-0.04em] text-slate-950 md:text-6xl">
                Industrial services built for clarity, control, and delivery.
            </h1>

            <p data-reveal class="mt-5 max-w-2xl text-lg leading-relaxed text-slate-600">
                We support procurement and engineering teams with sourcing coordination, technical communication, documentation, and delivery follow-up.
            </p>

            <div data-reveal class="mt-8 flex flex-col gap-4 sm:flex-row">
                <a href="#services" class="btn btn-primary">
                    View Services
                </a>
                <a href="{{ route('contact') }}" class="btn btn-outline">
                    Start an Inquiry
                </a>
            </div>
        </div>
    </div>
</section>

<section id="services" class="section relative overflow-hidden bg-slate-50">
    <div class="container-max relative">
        <div class="flex flex-col justify-between gap-6 md:flex-row md:items-end">
            <div>
                <div data-reveal class="section-kicker">SERVICES</div>
                <h2 data-reveal class="mt-3 section-title">Professional support across the industrial delivery cycle.</h2>
                <p data-reveal class="mt-4 max-w-2xl text-slate-600">
                    Each service is designed to reduce uncertainty, improve communication, and keep sourcing decisions moving.
                </p>
            </div>

            <a data-reveal href="{{ route('contact') }}" class="hidden sm:inline-flex btn btn-primary magnetic-card">
                Start an Inquiry
            </a>
        </div>

        <div class="mt-10 grid items-stretch gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($services as $service)
                <div
                    data-reveal
                    class="group magnetic-card relative flex h-full flex-col overflow-hidden rounded-[1.7rem] border border-slate-200 bg-white shadow-lg shadow-slate-900/5 transition-all duration-500 hover:-translate-y-3 hover:scale-[1.02] hover:border-[#015ea4]/35 hover:shadow-2xl hover:shadow-[#015ea4]/15"
                    data-mouse-depth="4"
                >
                    <div class="relative overflow-hidden">
                        @if ($service->image)
                            <img
                                class="h-56 w-full object-cover transition duration-700 group-hover:scale-110"
                                src="{{ asset('storage/'.$service->image) }}"
                                alt="{{ $service->title }}"
                            >
                        @else
                            <img
                                class="h-56 w-full object-cover transition duration-700 group-hover:scale-110"
                                src="{{ asset('assets/images/services/services-hero.jpg') }}"
                                alt="{{ $service->title }}"
                            >
                        @endif

                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/25 to-transparent transition duration-500 group-hover:from-[#015ea4]/50 group-hover:via-[#015ea4]/25"></div>

                        <div class="absolute left-5 top-5 rounded-full border border-white/30 bg-white/90 px-3 py-1 text-xs font-black uppercase tracking-wide text-[#015ea4] backdrop-blur">
                            Service
                        </div>
                    </div>

                    <div class="flex flex-1 flex-col p-7">
                        <h3 class="text-xl font-black leading-snug text-slate-950 transition duration-300 group-hover:text-[#015ea4]">
                            {{ $service->title }}
                        </h3>

                        <p class="mt-3 line-clamp-4 text-sm leading-relaxed text-slate-600">
                            {{ $service->description }}
                        </p>

                        <div class="mt-auto pt-6">
                            <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 text-sm font-black text-[#015ea4]">
                                Contact us
                                <span class="transition group-hover:translate-x-1">→</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-14 grid gap-8 lg:grid-cols-12 lg:items-center">
            <div class="lg:col-span-7">
                <div data-reveal class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-xl shadow-slate-900/5">
                    <div class="section-kicker">TYPICAL ENGAGEMENT STAGES</div>

                    <div class="mt-6 grid gap-4">
                        @foreach ([
                            ['title' => 'Stage 01 — Requirements clarification', 'text' => 'We review technical scope, capacity, standards, expected deliverables, and missing information.'],
                            ['title' => 'Stage 02 — Commercial alignment', 'text' => 'We coordinate quotation details, supplier communication, commercial terms, and documentation needs.'],
                            ['title' => 'Stage 03 — Delivery coordination', 'text' => 'We support packing, loading, shipment follow-up, and export documentation checks.'],
                        ] as $stage)
                            <div class="rounded-2xl bg-slate-50 p-5">
                                <div class="font-black text-slate-950">{{ $stage['title'] }}</div>
                                <p class="mt-2 text-sm leading-relaxed text-slate-600">
                                    {{ $stage['text'] }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div data-reveal class="magnetic-card overflow-hidden rounded-[2rem] border border-slate-200 bg-white p-3 shadow-2xl shadow-slate-900/10" data-mouse-depth="6">
                    <img
                        src="{{ asset('assets/images/services/services-hero1.jpg') }}"
                        alt="Service workflow"
                        class="h-[420px] w-full rounded-[1.5rem] object-cover"
                    >
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-white">
    <div class="container-max py-16">
        <div data-reveal class="relative overflow-hidden rounded-[2rem] border border-white/10 bg-slate-950 p-10 text-white shadow-2xl shadow-slate-900/20 md:p-12">
            <div class="absolute -right-20 -top-20 h-72 w-72 rounded-full bg-[#015ea4]/35 blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 h-80 w-80 rounded-full bg-[#711726]/28 blur-3xl"></div>

            <div class="relative grid gap-8 lg:grid-cols-12 lg:items-center">
                <div class="lg:col-span-8">
                    <div class="text-sm font-black uppercase tracking-[0.22em] text-white/60">
                        LET’S ALIGN SCOPE AND DELIVERABLES
                    </div>

                    <div class="mt-3 text-2xl font-black leading-tight md:text-4xl">
                        Talk to our team about your project requirements.
                    </div>

                    <p class="mt-4 max-w-2xl leading-relaxed text-white/75">
                        We will confirm technical parameters, clarify assumptions, and prepare next steps for sourcing, documentation, and delivery.
                    </p>
                </div>

                <div class="lg:col-span-4 lg:text-right">
                    <a href="{{ route('contact') }}" class="btn bg-white text-[#015ea4] hover:bg-[#015ea4] hover:text-white">
                        Contact
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection