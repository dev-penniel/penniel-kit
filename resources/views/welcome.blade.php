<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'StarterKit') }}</title>

        @include('partials.head')


    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-zinc-900 antialiased dark:bg-zinc-950 dark:text-white">

    {{-- Navigation --}}
    <header class="border-b border-zinc-200 dark:border-zinc-800">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-6 lg:px-8">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center gap-2">
                
                    <img src="/fav.png" alt="" class="w-8">

                <span class="font-semibold tracking-tight">
                    {{ config('app.name', 'StarterKit') }}
                </span>
            </a>

            {{-- Navigation --}}
            <nav class="flex items-center gap-2">

                @auth

                    <flux:button
                        href="{{ route('dashboard') }}"
                        variant="ghost"
                    >
                        Dashboard
                    </flux:button>

                    <flux:button
                        href="{{ route('notifications') }}"
                        variant="ghost"
                    >
                        Notifications
                    </flux:button>

                @else

                    <flux:button
                        href="{{ route('login') }}"
                        variant="ghost"
                    >
                        Log in
                    </flux:button>

                    <flux:button
                        href="{{ route('register') }}"
                        variant="primary"
                    >
                        Sign up
                    </flux:button>

                @endauth

            </nav>

        </div>
    </header>


    {{-- Hero --}}
    <main>

        <section class="relative overflow-hidden">

            <div class="mx-auto max-w-7xl px-6 pb-20 pt-20 lg:px-8 lg:pb-28 lg:pt-28">

                <div class="mx-auto max-w-3xl text-center">

                    <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-zinc-200 bg-zinc-50 px-3 py-1 text-sm text-zinc-600 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-400">
                        <span class="size-1.5 rounded-full bg-green-500"></span>
                        Laravel StarterKit
                    </div>

                    <flux:heading
                        size="xl"
                        class="text-4xl tracking-tight sm:text-5xl lg:text-6xl"
                    >
                        A clean foundation for your next Laravel application.
                    </flux:heading>

                    <flux:text class="mx-auto mt-6 max-w-2xl text-base leading-7 sm:text-lg">
                        Authentication, users, roles, permissions, notifications,
                        error handling and a polished dashboard — already built
                        and ready to customize.
                    </flux:text>


                    {{-- Hero buttons --}}
                    <div class="mt-8 flex flex-wrap justify-center gap-3">

                        @auth

                            <flux:button
                                href="{{ route('dashboard') }}"
                                variant="primary"
                                icon="arrow-right"
                            >
                                Go to Dashboard
                            </flux:button>

                            <flux:button
                                href="{{ route('notifications') }}"
                                variant="ghost"
                            >
                                View Notifications
                            </flux:button>

                        @else

                            <flux:button
                                href="{{ route('register') }}"
                                variant="primary"
                                icon="arrow-right"
                            >
                                Get Started
                            </flux:button>

                            <flux:button
                                href="{{ route('login') }}"
                                variant="ghost"
                            >
                                Log in
                            </flux:button>

                        @endauth

                    </div>

                </div>


                {{-- Dashboard Preview --}}
                <div class="relative mx-auto mt-16 max-w-6xl">

                    <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-zinc-100 p-2 shadow-2xl shadow-zinc-900/10 dark:border-zinc-800 dark:bg-zinc-900 dark:shadow-black/30">

                        <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-950">

                            {{-- Fake browser bar --}}
                            <div class="flex h-10 items-center gap-1.5 border-b border-zinc-200 px-4 dark:border-zinc-800">

                                <span class="size-2.5 rounded-full bg-zinc-300 dark:bg-zinc-700"></span>
                                <span class="size-2.5 rounded-full bg-zinc-300 dark:bg-zinc-700"></span>
                                <span class="size-2.5 rounded-full bg-zinc-300 dark:bg-zinc-700"></span>

                                <div class="ml-4 h-5 flex-1 rounded-md bg-zinc-100 dark:bg-zinc-900"></div>

                            </div>


                            {{-- Dashboard mockup --}}
                            <div class="grid min-h-[420px] grid-cols-[180px_1fr]">

                                {{-- Sidebar --}}
                                <aside class="hidden border-r border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-900/50 sm:block">

                                    <div class="mb-8 flex items-center gap-2">
                                        <div class="size-7 rounded-lg bg-zinc-900 dark:bg-white"></div>
                                        <div class="h-3 w-20 rounded bg-zinc-300 dark:bg-zinc-700"></div>
                                    </div>

                                    <div class="space-y-2">

                                        <div class="flex items-center gap-2 rounded-lg bg-zinc-200 px-3 py-2 dark:bg-zinc-800">
                                            <div class="size-3 rounded bg-zinc-500"></div>
                                            <div class="h-2 w-16 rounded bg-zinc-400"></div>
                                        </div>

                                        <div class="flex items-center gap-2 px-3 py-2">
                                            <div class="size-3 rounded bg-zinc-300 dark:bg-zinc-700"></div>
                                            <div class="h-2 w-20 rounded bg-zinc-200 dark:bg-zinc-800"></div>
                                        </div>

                                        <div class="flex items-center gap-2 px-3 py-2">
                                            <div class="size-3 rounded bg-zinc-300 dark:bg-zinc-700"></div>
                                            <div class="h-2 w-14 rounded bg-zinc-200 dark:bg-zinc-800"></div>
                                        </div>

                                        <div class="flex items-center gap-2 px-3 py-2">
                                            <div class="size-3 rounded bg-zinc-300 dark:bg-zinc-700"></div>
                                            <div class="h-2 w-18 rounded bg-zinc-200 dark:bg-zinc-800"></div>
                                        </div>

                                    </div>

                                </aside>


                                {{-- Main dashboard --}}
                                <div class="p-5 sm:p-7">

                                    <div class="flex items-center justify-between">

                                        <div>
                                            <div class="h-4 w-28 rounded bg-zinc-900 dark:bg-white"></div>
                                            <div class="mt-2 h-2.5 w-40 rounded bg-zinc-200 dark:bg-zinc-800"></div>
                                        </div>

                                        <div class="size-8 rounded-full bg-zinc-200 dark:bg-zinc-800"></div>

                                    </div>


                                    {{-- Stats --}}
                                    <div class="mt-7 grid grid-cols-2 gap-3 lg:grid-cols-4">

                                        @foreach ([
                                            ['Users', '1,248'],
                                            ['Orders', '384'],
                                            ['Revenue', '$24.8k'],
                                            ['Pending', '18'],
                                        ] as $stat)

                                            <div class="rounded-xl border border-zinc-200 p-4 dark:border-zinc-800">

                                                <div class="text-[10px] text-zinc-500">
                                                    {{ $stat[0] }}
                                                </div>

                                                <div class="mt-2 text-lg font-semibold">
                                                    {{ $stat[1] }}
                                                </div>

                                                <div class="mt-2 h-1.5 w-12 rounded-full bg-zinc-200 dark:bg-zinc-800"></div>

                                            </div>

                                        @endforeach

                                    </div>


                                    {{-- Content --}}
                                    <div class="mt-4 grid gap-4 lg:grid-cols-3">

                                        <div class="rounded-xl border border-zinc-200 p-5 dark:border-zinc-800 lg:col-span-2">

                                            <div class="flex items-center justify-between">
                                                <div class="h-3 w-24 rounded bg-zinc-800 dark:bg-zinc-300"></div>
                                                <div class="h-2 w-12 rounded bg-zinc-200 dark:bg-zinc-800"></div>
                                            </div>

                                            <div class="mt-8 flex h-32 items-end gap-2">

                                                @foreach ([35, 55, 42, 75, 58, 90, 68, 82, 60, 95, 72, 88] as $height)

                                                    <div
                                                        class="flex-1 rounded-t bg-zinc-200 dark:bg-zinc-800"
                                                        style="height: {{ $height }}%"
                                                    ></div>

                                                @endforeach

                                            </div>

                                        </div>


                                        <div class="rounded-xl border border-zinc-200 p-5 dark:border-zinc-800">

                                            <div class="h-3 w-24 rounded bg-zinc-800 dark:bg-zinc-300"></div>

                                            <div class="mt-5 space-y-4">

                                                @foreach ([1, 2, 3, 4] as $item)

                                                    <div class="flex items-center gap-3">

                                                        <div class="size-7 rounded-full bg-zinc-100 dark:bg-zinc-800"></div>

                                                        <div class="flex-1">
                                                            <div class="h-2 w-20 rounded bg-zinc-200 dark:bg-zinc-800"></div>
                                                            <div class="mt-1.5 h-1.5 w-12 rounded bg-zinc-100 dark:bg-zinc-900"></div>
                                                        </div>

                                                    </div>

                                                @endforeach

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>


        {{-- Features --}}
        <section class="border-y border-zinc-200 bg-zinc-50 dark:border-zinc-800 dark:bg-zinc-900/30">

            <div class="mx-auto max-w-7xl px-6 py-20 lg:px-8">

                <div class="max-w-2xl">

                    <flux:heading size="lg">
                        Everything you need to start
                    </flux:heading>

                    <flux:text class="mt-2">
                        Skip the repetitive setup and focus on building the
                        application your users actually need.
                    </flux:text>

                </div>


                <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

                    @foreach ([
                        [
                            'icon' => 'users',
                            'title' => 'User Management',
                            'text' => 'Manage users with clean CRUD screens and permission-aware actions.',
                        ],
                        [
                            'icon' => 'shield-check',
                            'title' => 'Roles & Permissions',
                            'text' => 'Control access using roles and granular permissions.',
                        ],
                        [
                            'icon' => 'bell',
                            'title' => 'Notifications',
                            'text' => 'A reusable database notification system with read states.',
                        ],
                        [
                            'icon' => 'lock-closed',
                            'title' => 'Authentication',
                            'text' => 'Start with a solid authentication and account foundation.',
                        ],
                        [
                            'icon' => 'exclamation-triangle',
                            'title' => 'Error Handling',
                            'text' => 'Beautiful 403, 404, 419, 429, 500 and 503 pages.',
                        ],
                        [
                            'icon' => 'squares-2x2',
                            'title' => 'Reusable UI',
                            'text' => 'Consistent components, layouts, loading states and interactions.',
                        ],
                    ] as $feature)

                        <div class="rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-800 dark:bg-zinc-950">

                            <div class="flex size-10 items-center justify-center rounded-xl bg-zinc-100 dark:bg-zinc-900">

                                <flux:icon
                                    name="{{ $feature['icon'] }}"
                                    class="size-5 text-zinc-700 dark:text-zinc-300"
                                />

                            </div>

                            <flux:heading size="sm" class="mt-5">
                                {{ $feature['title'] }}
                            </flux:heading>

                            <flux:text class="mt-2 text-sm">
                                {{ $feature['text'] }}
                            </flux:text>

                        </div>

                    @endforeach

                </div>

            </div>

        </section>


        {{-- Product Screens --}}
        <section class="overflow-hidden">

            <div class="mx-auto max-w-7xl px-6 py-20 lg:px-8">

                <div class="mx-auto max-w-2xl text-center">

                    <flux:heading size="lg">
                        Built to grow with your application
                    </flux:heading>

                    <flux:text class="mt-2">
                        Start with the essentials and customize the foundation
                        around your business.
                    </flux:text>

                </div>


                {{-- Screenshot 1 --}}
                <div class="mt-14 grid items-center gap-10 lg:grid-cols-2">

                    <div>

                        <div class="mb-4 flex size-10 items-center justify-center rounded-xl bg-zinc-100 dark:bg-zinc-900">
                            <flux:icon name="shield-check" class="size-5" />
                        </div>

                        <flux:heading size="lg">
                            Roles & permissions
                        </flux:heading>

                        <flux:text class="mt-3 max-w-lg">
                            Give administrators control over what every user
                            can access without cluttering the interface.
                        </flux:text>

                    </div>


                    {{-- Permission screenshot --}}
                    <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-2 shadow-xl dark:border-zinc-800 dark:bg-zinc-900">

                        <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-800 dark:bg-zinc-950">

                            <div class="flex items-center justify-between">

                                <div>
                                    <div class="h-3 w-24 rounded bg-zinc-800 dark:bg-zinc-300"></div>
                                    <div class="mt-2 h-2 w-36 rounded bg-zinc-200 dark:bg-zinc-800"></div>
                                </div>

                                <div class="h-7 w-16 rounded-lg bg-zinc-900 dark:bg-white"></div>

                            </div>

                            <div class="mt-6 grid gap-3 sm:grid-cols-2">

                                @foreach ([
                                    'Users',
                                    'Roles',
                                    'Contacts',
                                    'Notifications',
                                ] as $group)

                                    <div class="rounded-xl border border-zinc-200 p-4 dark:border-zinc-800">

                                        <div class="flex items-center justify-between">

                                            <span class="text-xs font-medium">
                                                {{ $group }}
                                            </span>

                                            <div class="size-4 rounded border border-zinc-300 dark:border-zinc-700"></div>

                                        </div>

                                        <div class="mt-4 space-y-2">

                                            @foreach (['Create', 'View', 'Edit', 'Delete'] as $permission)

                                                <div class="flex items-center gap-2">

                                                    <div class="size-3 rounded border border-zinc-300 dark:border-zinc-700"></div>

                                                    <span class="text-[10px] text-zinc-500">
                                                        {{ $permission }} {{ $group }}
                                                    </span>

                                                </div>

                                            @endforeach

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Screenshot 2 --}}
                <div class="mt-20 grid items-center gap-10 lg:grid-cols-2">

                    {{-- Notifications screenshot --}}
                    <div class="order-2 rounded-2xl border border-zinc-200 bg-zinc-50 p-2 shadow-xl dark:border-zinc-800 dark:bg-zinc-900 lg:order-1">

                        <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-800 dark:bg-zinc-950">

                            <div class="flex items-center justify-between">

                                <div>
                                    <div class="h-3 w-28 rounded bg-zinc-800 dark:bg-zinc-300"></div>
                                    <div class="mt-2 h-2 w-40 rounded bg-zinc-200 dark:bg-zinc-800"></div>
                                </div>

                                <div class="h-7 w-24 rounded-lg bg-zinc-100 dark:bg-zinc-900"></div>

                            </div>

                            <div class="mt-6 divide-y divide-zinc-100 dark:divide-zinc-900">

                                @foreach ([
                                    ['Contact added', 'A new contact has been added.'],
                                    ['Role updated', 'Administrator permissions changed.'],
                                    ['New user', 'A new user registered.'],
                                    ['System update', 'Your application was updated.'],
                                ] as $notification)

                                    <div class="flex gap-3 py-4">

                                        <div class="flex size-8 shrink-0 items-center justify-center rounded-full bg-zinc-100 dark:bg-zinc-900">
                                            <flux:icon name="bell" class="size-4 text-zinc-500" />
                                        </div>

                                        <div class="flex-1">

                                            <div class="text-xs font-medium">
                                                {{ $notification[0] }}
                                            </div>

                                            <div class="mt-1 text-[10px] text-zinc-500">
                                                {{ $notification[1] }}
                                            </div>

                                        </div>

                                        <div class="size-2 rounded-full bg-zinc-900 dark:bg-white"></div>

                                    </div>

                                @endforeach

                            </div>

                        </div>

                    </div>


                    <div class="order-1 lg:order-2">

                        <div class="mb-4 flex size-10 items-center justify-center rounded-xl bg-zinc-100 dark:bg-zinc-900">
                            <flux:icon name="bell" class="size-5" />
                        </div>

                        <flux:heading size="lg">
                            Notifications that just work
                        </flux:heading>

                        <flux:text class="mt-3 max-w-lg">
                            A generic notification system that can be reused
                            across users, roles and different parts of your
                            application.
                        </flux:text>

                    </div>

                </div>

            </div>

        </section>


        {{-- CTA --}}
        <section class="border-t border-zinc-200 dark:border-zinc-800">

            <div class="mx-auto max-w-3xl px-6 py-20 text-center lg:px-8">

                <flux:heading size="lg">
                    Ready to build?
                </flux:heading>

                <flux:text class="mx-auto mt-3 max-w-xl">
                    Start with a clean foundation and spend your time building
                    the features that make your application unique.
                </flux:text>

                <div class="mt-7 flex justify-center gap-3">

                    @auth

                        <flux:button
                            href="{{ route('dashboard') }}"
                            variant="primary"
                            icon="arrow-right"
                        >
                            Go to Dashboard
                        </flux:button>

                    @else

                        <flux:button
                            href="{{ route('register') }}"
                            variant="primary"
                            icon="arrow-right"
                        >
                            Create an Account
                        </flux:button>

                    @endauth

                </div>

            </div>

        </section>

    </main>


    {{-- Footer --}}
    <footer class="border-t border-zinc-200 dark:border-zinc-800">

        <div class="mx-auto flex max-w-7xl flex-col gap-3 px-6 py-8 text-sm text-zinc-500 sm:flex-row sm:items-center sm:justify-between lg:px-8">

            <div>
                © {{ date('Y') }} {{ config('app.name', 'StarterKit') }}.
                All rights reserved.
            </div>

            <div class="flex items-center gap-4">

                <a
                    href="{{ route('login') }}"
                    class="transition hover:text-zinc-900 dark:hover:text-white"
                >
                    Login
                </a>

                <a
                    href="{{ route('register') }}"
                    class="transition hover:text-zinc-900 dark:hover:text-white"
                >
                    Register
                </a>

            </div>

        </div>

    </footer>

</body>

</html>