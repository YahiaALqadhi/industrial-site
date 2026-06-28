@php
    $mainItems = [
        [
            'label' => 'Dashboard',
            'route' => 'admin.dashboard',
            'active' => 'admin.dashboard',
            'icon' => 'M4 13h6v7H4v-7zM14 4h6v16h-6V4zM10 4h4v16h-4V4z',
        ],
        [
            'label' => 'Categories',
            'route' => 'admin.categories.index',
            'active' => 'admin.categories.*',
            'icon' => 'M4 6h7v6H4V6zM13 6h7v6h-7V6zM4 14h7v6H4v-6zM13 14h7v6h-7v-6z',
        ],
        [
            'label' => 'Products',
            'route' => 'admin.products.index',
            'active' => 'admin.products.*',
            'icon' => 'M7 7h10M7 12h10M7 17h10 M5 4h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z',
        ],
        [
            'label' => 'Services',
            'route' => 'admin.services.index',
            'active' => 'admin.services.*',
            'icon' => 'M4 7.5h16M4 12h16M4 16.5h16',
        ],
        [
            'label' => 'Inquiries',
            'route' => 'admin.inquiries.index',
            'active' => 'admin.inquiries.*',
            'icon' => 'M4 6h16v12H4V6z M4 7l8 6 8-6',
            'badge' => $newInquiriesCount ?? 0,
        ],
        [
            'label' => 'Settings',
            'route' => 'admin.settings.edit',
            'active' => 'admin.settings.*',
            'icon' => 'M10 6h4M12 6v12 M4 12a8 8 0 1116 0 8 8 0 01-16 0z',
        ],
    ];

    $superItems = [
        [
            'label' => 'Admin Users',
            'route' => 'admin.users.index',
            'active' => 'admin.users.*',
            'icon' => 'M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2 M8 11a4 4 0 100-8 4 4 0 000 8z M22 21v-2a4 4 0 00-3-3.87 M16 3.13a4 4 0 010 7.75',
        ],
    ];
@endphp

<nav class="px-3 py-5">
    <div x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="mb-3 px-3 text-[11px] font-black uppercase tracking-[0.22em] text-white/35">
        Main Menu
    </div>

    <div class="grid gap-1.5 text-sm">
        @foreach ($mainItems as $item)
            <a
                href="{{ route($item['route']) }}"
                class="admin-nav {{ request()->routeIs($item['active']) ? 'admin-nav-active' : '' }}"
                :title="sidebarCollapsed ? '{{ $item['label'] }}' : ''"
            >
                <span class="admin-nav-icon">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                    </svg>
                </span>

                <span x-show="!sidebarCollapsed" x-transition.opacity.duration.150ms class="min-w-0 flex-1 truncate">
                    {{ $item['label'] }}
                </span>

                @if(($item['badge'] ?? 0) > 0)
                    <span
                        x-show="!sidebarCollapsed"
                        x-transition.opacity.duration.150ms
                        class="ml-auto inline-flex h-6 min-w-6 items-center justify-center rounded-full bg-[#711726] px-2 text-xs font-black text-white shadow-lg shadow-[#711726]/25"
                    >
                        {{ $item['badge'] }}
                    </span>
                @endif
            </a>
        @endforeach
    </div>

    @if (auth()->user()->isSuperAdmin())
        <div class="mt-8 border-t border-white/10 pt-6">
            <div x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="mb-3 px-3 text-[11px] font-black uppercase tracking-[0.22em] text-white/35">
                Super Admin
            </div>

            <div class="grid gap-1.5 text-sm">
                @foreach ($superItems as $item)
                    <a
                        href="{{ route($item['route']) }}"
                        class="admin-nav {{ request()->routeIs($item['active']) ? 'admin-nav-active' : '' }}"
                        :title="sidebarCollapsed ? '{{ $item['label'] }}' : ''"
                    >
                        <span class="admin-nav-icon">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                            </svg>
                        </span>

                        <span x-show="!sidebarCollapsed" x-transition.opacity.duration.150ms class="truncate">
                            {{ $item['label'] }}
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</nav>