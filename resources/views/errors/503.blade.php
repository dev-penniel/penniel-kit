<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Service Unavailable</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-zinc-50 dark:bg-zinc-950">

    <div class="flex min-h-screen items-center justify-center px-6">

        <div class="w-full max-w-md text-center">

            <div class="mb-6 flex justify-center">
                <div class="flex size-16 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-500/10">
                    <flux:icon
                        name="wrench-screwdriver"
                        class="size-8 text-blue-600 dark:text-blue-400"
                    />
                </div>
            </div>

            <div class="mb-2 text-sm font-medium text-zinc-500 dark:text-zinc-400">
                Error 503
            </div>

            <flux:heading size="xl">
                We'll be right back
            </flux:heading>

            <flux:text class="mt-2">
                The application is temporarily unavailable while we perform
                maintenance. Please check back shortly.
            </flux:text>

            <div class="mt-6 flex justify-center">

                <flux:button
                    onclick="window.location.reload()"
                    variant="primary"
                >
                    Refresh Page
                </flux:button>

            </div>

        </div>

    </div>

</body>
</html>