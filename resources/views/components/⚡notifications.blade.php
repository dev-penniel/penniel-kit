@php
    $unreadCount = auth()->user()->unreadNotifications()->count();
@endphp

<flux:sidebar.item
    icon="bell"
    :href="route('notifications')"
    :current="request()->routeIs('notifications')"
    wire:navigate
>
    <div class="flex w-full items-center justify-between gap-2">
        <span>{{ __('Notifications') }}</span>

        @if ($unreadCount > 0)
            <flux:badge color="red" size="sm">
                {{ $unreadCount }}
            </flux:badge>
        @endif
    </div>
</flux:sidebar.item>