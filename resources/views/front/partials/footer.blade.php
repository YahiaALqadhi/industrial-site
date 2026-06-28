<footer
    x-data="{
        hidden: false,
        lastScrollY: 0,
        footerTop: 0,

        updateFooterTop() {
            this.footerTop = this.$el.offsetTop;
        },

        handleScroll() {
            const y = window.pageYOffset || document.documentElement.scrollTop;
            const diff = y - this.lastScrollY;
            const viewportBottom = y + window.innerHeight;

            const insideFooterArea = viewportBottom >= this.footerTop;

            if (insideFooterArea && diff < -8) {
                this.hidden = true;
            }

            if (!insideFooterArea || diff > 8) {
                this.hidden = false;
            }

            this.lastScrollY = y <= 0 ? 0 : y;
        }
    }"
    x-init="
        updateFooterTop();
        lastScrollY = window.pageYOffset || document.documentElement.scrollTop;
        window.addEventListener('resize', () => updateFooterTop(), { passive: true });
        window.addEventListener('scroll', () => handleScroll(), { passive: true });
    "
    class="site-footer relative overflow-hidden text-white transition-all duration-300"
    :class="hidden ? 'opacity-0 translate-y-10 pointer-events-none' : 'opacity-100 translate-y-0'"
>
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -right-32 top-0 h-96 w-96 rounded-full bg-[#015ea4]/25 blur-3xl"></div>
        <div class="absolute -left-32 bottom-0 h-96 w-96 rounded-full bg-[#711726]/20 blur-3xl"></div>
    </div>

    <div class="container-max relative py-12">
        <div class="rounded-[1.75rem] border border-white/15 bg-white/[0.07] p-6 shadow-2xl shadow-black/10 backdrop-blur-xl md:p-8">
            <div class="grid gap-10 lg:grid-cols-12">
                <div class="lg:col-span-5" data-reveal>
                    <div class="flex items-center gap-4">
                        <div class="rounded-2xl bg-white p-2 shadow-xl shadow-black/10">
                            <img src="{{ asset('assets/images/logo.jpg') }}" alt="Company Logo" class="h-14 w-14 rounded-xl object-contain">
                        </div>

                        <div>
                            <div class="text-lg font-black">
                                {{ $settings['company_name'] ?? 'Industrial Solutions' }}
                            </div>
                            <div class="mt-1 text-sm text-white/60">
                                {{ $settings['company_tagline'] ?? 'Import and Export Co, LTD' }}
                            </div>
                        </div>
                    </div>

                    <p class="mt-5 max-w-md text-sm leading-relaxed text-white/68">
                        Industrial sourcing, technical coordination, documentation, and shipment follow-up through a clear inquiry-to-delivery workflow.
                    </p>

                    <a href="{{ route('contact') }}" class="mt-6 inline-flex btn bg-white text-[#015ea4] hover:bg-[#015ea4] hover:text-white">
                        Start Inquiry
                    </a>
                </div>

                <div class="lg:col-span-2" data-reveal>
                    <div class="footer-title">Quick Links</div>

                    <div class="mt-4 grid gap-3 text-sm">
                        <a class="footer-link" href="{{ route('home') }}">Home</a>
                        <a class="footer-link" href="{{ route('about') }}">About</a>
                        <a class="footer-link" href="{{ route('products.index') }}">Products</a>
                        <a class="footer-link" href="{{ route('services') }}">Services</a>
                        <a class="footer-link" href="{{ route('contact') }}">Contact</a>
                    </div>
                </div>

                <div class="lg:col-span-3" data-reveal>
                    <div class="footer-title">Contact</div>

                    <div class="mt-4 grid gap-4 text-sm">
                        @if(!empty($settings['company_email']))
                            <div>
                                <div class="text-xs text-white/40">Email</div>
                                <a href="mailto:{{ $settings['company_email'] }}" class="footer-link break-all">
                                    {{ $settings['company_email'] }}
                                </a>
                            </div>
                        @endif

                        @if(!empty($settings['company_phone']))
                            <div>
                                <div class="text-xs text-white/40">Phone</div>
                                <a href="tel:{{ preg_replace('/\s+/', '', $settings['company_phone']) }}" class="footer-link">
                                    {{ $settings['company_phone'] }}
                                </a>
                            </div>
                        @endif

                        @if(!empty($settings['company_whatsapp']))
                            <div>
                                <div class="text-xs text-white/40">WhatsApp</div>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['company_whatsapp']) }}" target="_blank" rel="noopener noreferrer" class="footer-link">
                                    {{ $settings['company_whatsapp'] }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="lg:col-span-2" data-reveal>
                    <div class="footer-title">Company</div>

                    <div class="mt-4 rounded-2xl border border-white/10 bg-white/[0.06] p-4 text-sm leading-relaxed text-white/65 backdrop-blur">
                        Engineering equipment, automation products, industrial supply, and export coordination from China.
                    </div>
                </div>
            </div>

            <div class="mt-10 flex flex-col gap-4 border-t border-white/10 pt-6 text-xs text-white/55 md:flex-row md:items-center md:justify-between">
                <div>
                    Copyright &copy; {{ date('Y') }}
                    {{ $settings['company_name'] ?? 'Company' }}. All Rights Reserved.
                </div>

                <div class="flex gap-4">
                    <a href="{{ route('products.index') }}" class="transition hover:text-white">Catalog</a>
                    <a href="{{ route('contact') }}" class="transition hover:text-white">Inquiry</a>
                </div>
            </div>
        </div>
    </div>
</footer>