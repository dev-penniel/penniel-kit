<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Page Expired</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-zinc-50 dark:bg-zinc-950">

    <div class="flex min-h-screen items-center justify-center px-6">

        <div class="w-full max-w-md text-center">

            <div class="mb-6 flex justify-center">
                <div class="flex size-16 items-center justify-center rounded-full bg-yellow-100 dark:bg-yellow-500/10">
                    <flux:icon
                        name="clock"
                        class="size-8 text-yellow-600 dark:text-yellow-400"
                    />
                </div>
            </div>

            <div class="mb-2 text-sm font-medium text-zinc-500 dark:text-zinc-400">
                Error 419
            </div>

            <flux:heading size="xl">
                Page expired
            </flux:heading>

            <flux:text class="mt-2">
                Your session has expired. Please refresh the page and try again.
            </flux:text>

            <div class="mt-6 flex justify-center gap-3">

                <flux:button
                    onclick="window.location.reload()"
                    variant="ghost"
                >
                    Refresh
                </flux:button>

                <flux:button
                    href="{{ route('dashboard') }}"
                    variant="primary"
                >
                    Dashboard
                </flux:button>

            </div>

        </div>

    </div>

</body>
</html>