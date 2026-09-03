<?php

use Livewire\Component;

new class extends Component
{
    public function getNotificationsProperty()
    {
        return auth()->user()
            ->notifications()
            ->latest()
            ->paginate(15);
    }

    public function getUnreadNotificationsProperty()
    {
        return auth()->user()
            ->unreadNotifications()
            ->count();
    }

    public function markAsRead(string $id)
    {
        $notification = auth()->user()
            ->notifications()
            ->findOrFail($id);

        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }
    }

    public function markAllAsRead()
    {
        auth()->user()
            ->unreadNotifications()
            ->update([
                'read_at' => now(),
            ]);
    }
};
?>

<div>

    <div class="mx-auto w-full max-w-4xl">

        {{-- Header --}}
        <div class="mb-8 flex items-center justify-between gap-4">

            <div>
                <flux:heading size="xl">
                    Notifications
                </flux:heading>

                <flux:text class="mt-1">
                    Stay up to date with what's happening in your account.
                </flux:text>
            </div>

            @if ($this->unreadNotifications > 0)
                <flux:button
                    variant="ghost"
                    size="sm"
                    wire:click="markAllAsRead"
                    wire:loading.attr="disabled"
                >
                    <flux:icon name="check" class="size-4" />
                    Mark all as read
                </flux:button>
            @endif

        </div>


        {{-- Summary --}}
        @if ($this->unreadNotifications > 0)

            <div class="mb-4 flex items-center gap-2">
                <flux:badge color="blue" size="sm">
                    {{ $this->unreadNotifications }} unread
                </flux:badge>

                <flux:text size="sm">
                    notifications waiting for you
                </flux:text>
            </div>

        @endif


        {{-- Notifications --}}
        <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">

            @forelse ($this->notifications as $notification)

                <div
                    wire:key="notification-{{ $notification->id }}"
                    class="group flex gap-4 border-b border-zinc-100 p-5 last:border-0 dark:border-zinc-800
                    {{ is_null($notification->read_at)
                        ? 'bg-zinc-50/70 dark:bg-zinc-800/30'
                        : 'bg-white dark:bg-zinc-900' }}"
                >

                    {{-- Icon --}}
                    <div class="flex size-10 shrink-0 items-center justify-center rounded-full
                        {{ is_null($notification->read_at)
                            ? 'bg-blue-100 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400'
                            : 'bg-zinc-100 text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400' }}">

                        <flux:icon
                            name="{{ $notification->data['icon'] ?? 'bell' }}"
                            class="size-5"
                        />

                    </div>


                    {{-- Content --}}
                    <div class="min-w-0 flex-1">

                        <div class="flex items-start justify-between gap-4">

                            <div class="min-w-0">

                                <div class="flex items-center gap-2">

                                    <flux:text
                                        class="{{ is_null($notification->read_at)
                                            ? 'font-semibold text-zinc-900 dark:text-white'
                                            : 'font-medium' }}"
                                    >
                                        {{ $notification->data['title'] ?? 'Notification' }}
                                    </flux:text>

                                    @if (is_null($notification->read_at))
                                        <span class="size-2 shrink-0 rounded-full bg-blue-500"></span>
                                    @endif

                                </div>

                                <flux:text
                                    size="sm"
                                    class="mt-1"
                                >
                                    {{ $notification->data['message'] ?? '' }}
                                </flux:text>

                            </div>


                            {{-- Time --}}
                            <flux:text
                                size="xs"
                                class="shrink-0 text-zinc-400"
                            >
                                {{ $notification->created_at->diffForHumans() }}
                            </flux:text>

                        </div>


                        {{-- Actions --}}
                        <div class="mt-3 flex items-center gap-3">

                            @if (is_null($notification->read_at))

                                <button
                                    type="button"
                                    wire:click="markAsRead('{{ $notification->id }}')"
                                    wire:loading.attr="disabled"
                                    class="text-xs font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300"
                                >
                                    Mark as read
                                </button>

                            @else

                                <span class="flex items-center gap-1 text-xs text-zinc-400">
                                    <flux:icon
                                        name="check"
                                        class="size-3.5"
                                    />
                                    Read
                                </span>

                            @endif

                        </div>

                    </div>

                </div>

            @empty

                {{-- Empty State --}}
                <div class="flex min-h-80 flex-col items-center justify-center px-6 text-center">

                    <div class="flex size-12 items-center justify-center rounded-full bg-zinc-100 dark:bg-zinc-800">

                        <flux:icon
                            name="bell-slash"
                            class="size-6 text-zinc-400"
                        />

                    </div>

                    <flux:heading size="lg" class="mt-4">
                        You're all caught up
                    </flux:heading>

                    <flux:text class="mt-1 max-w-sm">
                        You don't have any notifications right now.
                    </flux:text>

                </div>

            @endforelse

        </div>


        {{-- Pagination --}}
        @if ($this->notifications->hasPages())

            <div class="mt-6">
                {{ $this->notifications->links() }}
            </div>

        @endif

    </div>

</div>