@extends('front.layout')

@section('title', 'About')

@section('meta_description', 'Learn about NINGBO PASAFEITE IMPORT AND EXPORT CO, LTD, an industrial sourcing partner specializing in engineering equipment, automation solutions, materials, supplier coordination, and delivery support.')

@section('meta_image', asset('assets/images/about/og-image.jpg'))

@section('canonical', route('about'))

@section('content')
<section class="bg-white">
    <div class="container-max py-24 lg:py-28">
        <div class="max-w-4xl">
            <h1 data-reveal class="text-4xl font-black leading-tight tracking-[-0.04em] text-slate-950 md:text-6xl">
                Industrial sourcing partner built for clarity, control, and delivery.
            </h1>

            <p data-reveal class="mt-5 max-w-2xl text-lg leading-relaxed text-slate-600">
                NINGBO PASAFEITE IMPORT AND EXPORT CO, LTD supports industrial teams with sourcing, technical coordination, documentation, and shipment follow-up.
            </p>
        </div>
    </div>
</section>

<section class="section relative overflow-hidden bg-white">
    <div class="absolute -right-32 top-32 h-96 w-96 rounded-full bg-[#015ea4]/5 blur-3xl" data-parallax="80"></div>

    <div class="container-max relative">
        <div class="grid gap-12 lg:grid-cols-12 lg:items-start">
            <div class="lg:col-span-7">
                <div data-reveal class="section-kicker">WHO WE ARE</div>

                <h2 data-reveal class="mt-3 section-title">
                    A practical partner for industrial procurement and project coordination.
                </h2>

                <p data-reveal class="mt-5 leading-relaxed text-slate-600">
                    Industrial sourcing is not just buying products. It requires clear specifications, reliable supplier coordination, documentation control, and delivery planning. We help customers manage these steps with a structured inquiry-to-delivery workflow.
                </p>

                <div class="mt-8 grid gap-5 sm:grid-cols-2">
                    <div data-reveal class="card lift p-7">
                        <div class="section-kicker">MISSION</div>
                        <h3 class="mt-3 text-xl font-black text-slate-950">Deliver clarity and control</h3>
                        <p class="mt-3 text-sm leading-relaxed text-slate-600">
                            We reduce uncertainty by clarifying requirements, supplier communication, documentation, and delivery expectations early.
                        </p>
                    </div>

                    <div data-reveal class="card lift p-7">
                        <div class="section-kicker">VISION</div>
                        <h3 class="mt-3 text-xl font-black text-slate-950">Long-term industrial relationships</h3>
                        <p class="mt-3 text-sm leading-relaxed text-slate-600">
                            We aim to build repeatable, dependable, and scalable sourcing relationships based on trust and execution.
                        </p>
                    </div>
                </div>

                <div data-reveal class="mt-10 rounded-[2rem] border border-slate-200 bg-slate-50/70 p-8 shadow-sm">
                    <div class="section-kicker">CORE STRENGTHS</div>

                    <div class="mt-5 grid gap-4">
                        <div class="card lift p-5">
                            <div class="font-black text-slate-950">Engineering communication</div>
                            <p class="mt-2 text-sm leading-relaxed text-slate-600">
                                Clear requirements, assumptions, technical scope, and acceptance expectations.
                            </p>
                        </div>

                        <div class="card lift p-5">
                            <div class="font-black text-slate-950">Sourcing discipline</div>
                            <p class="mt-2 text-sm leading-relaxed text-slate-600">
                                Supplier coordination with quotation comparison, documentation alignment, and technical follow-up.
                            </p>
                        </div>

                        <div class="card lift p-5">
                            <div class="font-black text-slate-950">Delivery support</div>
                            <p class="mt-2 text-sm leading-relaxed text-slate-600">
                                Packing list checks, loading coordination, shipment updates, and export documentation support.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div data-reveal class="perspective-wrap relative">
                    <div class="absolute -right-6 -top-6 h-36 w-36 rounded-full bg-[#015ea4]/10 blur-2xl"></div>
                    <div class="absolute -bottom-6 -left-6 h-40 w-40 rounded-full bg-[#711726]/10 blur-2xl"></div>

                    <div class="magnetic-card overflow-hidden rounded-[2rem] border border-slate-200 bg-white p-3 shadow-2xl shadow-slate-900/10" data-mouse-depth="7">
                        <img src="{{ asset('assets/images/about/factory.jpg') }}" class="h-[520px] w-full rounded-[1.5rem] object-cover" alt="Factory and machinery" data-parallax="45">
                    </div>
                </div>

                <div data-reveal class="mt-6 rounded-[2rem] border border-slate-200 bg-white p-7 shadow-lg shadow-slate-900/5">
                    <div class="section-kicker">TYPICAL ENGAGEMENTS</div>

                    <ul class="mt-5 grid gap-3 text-sm text-slate-600">
                        <li class="rounded-2xl bg-slate-50 p-4 font-semibold">Production line packages and integration support</li>
                        <li class="rounded-2xl bg-slate-50 p-4 font-semibold">Industrial automation components and panel coordination</li>
                        <li class="rounded-2xl bg-slate-50 p-4 font-semibold">Materials and components sourcing with documentation</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="mt-16 grid gap-10 lg:grid-cols-12 lg:items-start">
            <div class="lg:col-span-5">
                <div data-reveal class="section-kicker">FAQ</div>
                <h3 data-reveal class="mt-3 section-title">Common questions from engineering and procurement teams.</h3>
                <p data-reveal class="mt-4 leading-relaxed text-slate-600">
                    We keep inquiries structured to reduce ambiguity and support faster commercial and technical decisions.
                </p>
            </div>

            <div class="lg:col-span-7">
                <div class="space-y-4" x-data="{ open: 1 }">
                    @foreach ([
                        ['q' => 'Is this an ecommerce website?', 'a' => 'No. This platform is a professional product and services catalog designed for inquiries, technical communication, and sourcing coordination.'],
                        ['q' => 'How do you prepare a quotation?', 'a' => 'We review scope, confirm key assumptions, request missing technical parameters, and coordinate supplier information before preparing next steps.'],
                        ['q' => 'Do you support delivery and shipment coordination?', 'a' => 'Yes. We can support packing, loading coordination, shipment scheduling, and documentation checks depending on project requirements.'],
                        ['q' => 'What information should I include in an inquiry?', 'a' => 'Include quantity, target capacity, applicable standards, destination, timeline, and any preferred brands, materials, drawings, or photos.'],
                    ] as $index => $faq)
                        <div data-reveal class="card p-6">
                            <button class="flex w-full items-center justify-between gap-4 text-left" @click="open = open === {{ $index + 1 }} ? 0 : {{ $index + 1 }}">
                                <span class="font-black text-slate-950">{{ $faq['q'] }}</span>
                                <span class="text-xl font-black text-[#015ea4]" x-text="open === {{ $index + 1 }} ? '−' : '+'"></span>
                            </button>
                            <div class="mt-4 text-sm leading-relaxed text-slate-600" x-show="open === {{ $index + 1 }}" x-transition>
                                {{ $faq['a'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mt-16">
            <div data-reveal class="relative overflow-hidden rounded-[2rem] border border-white/10 bg-slate-950 p-10 text-white shadow-2xl shadow-slate-900/20 md:p-12">
                <div class="absolute -right-20 -top-20 h-72 w-72 rounded-full bg-[#015ea4]/35 blur-3xl" data-parallax="60"></div>
                <div class="absolute -bottom-24 -left-24 h-80 w-80 rounded-full bg-[#711726]/28 blur-3xl" data-parallax="80"></div>

                <div class="relative grid gap-8 lg:grid-cols-12 lg:items-center">
                    <div class="lg:col-span-8">
                        <div class="text-sm font-black uppercase tracking-[0.22em] text-white/60">READY TO START?</div>
                        <div class="mt-3 text-2xl font-black leading-tight md:text-4xl">
                            Share your requirement and we will help organize the next step.
                        </div>
                        <p class="mt-4 max-w-2xl leading-relaxed text-white/75">
                            Send product details, standards, quantity, destination, and timeline. We will review the scope and respond with a clear path forward.
                        </p>
                    </div>

                    <div class="lg:col-span-4 lg:text-right">
                        <a href="{{ route('contact') }}" class="btn bg-white text-[#015ea4] hover:bg-[#015ea4] hover:text-white">
                            Contact Our Team
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "{{ $settings['company_name'] ?? 'NINGBO PASAFEITE' }}",
    "url": "{{ route('about') }}",
    "logo": "{{ asset('assets/images/logo.jpg') }}",
    "description": "Industrial sourcing, engineering coordination, supplier management, and delivery support services.",
    "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "{{ $settings['company_phone'] ?? '' }}",
        "contactType": "customer support",
        "email": "{{ $settings['company_email'] ?? '' }}"
    }
}
</script>
@endpush
@endsection