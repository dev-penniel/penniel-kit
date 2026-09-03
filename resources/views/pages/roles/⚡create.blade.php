<?php

use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Livewire\Component;

new class extends Component {

    public $permissions, $name;
    public $selectedPermissions = [];

    public function mount(): Void
    {

        // Authorisation check
        abort_unless(
            auth()->user()->can('create-roles'),
            403
        );

        $this->permissions = Permission::all();
    }

    

    public function getGroupedPermissionsProperty()
    {
        return Permission::query()
            ->orderBy('name')
            ->get()
            ->groupBy(function ($permission) {
                return str($permission->name)
                    ->afterLast('-')
                    ->headline();
            });
    }

    public function createRole()
    {

        abort_unless(
            auth()->user()->can('create-roles'),
            403
        );

        $validated = $this->validate([
            'name' => [
                'string',
                'required',
                Rule::unique('roles', 'name')]
        ]);


        $role = Role::create($validated);

        $role->syncPermissions($this->selectedPermissions);

        $this->dispatch('role-created');

        $this->resetForm();

    }

    public function resetForm()
    {
        $this->reset();
    }

}; ?>

<div>
    <div class="relative mb-6 w-full">
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl" level="1">
                    {{ __('Add Role') }}
                </flux:heading>

                <flux:text class="mt-1">
                    Create a role and assign the permissions it should have.
                </flux:text>

                <flux:breadcrumbs class="mt-3">
                    <flux:breadcrumbs.item href="{{ route('dashboard') }}">
                        Home
                    </flux:breadcrumbs.item>

                    <flux:breadcrumbs.item href="{{ route('dashboard') }}">
                        Roles
                    </flux:breadcrumbs.item>

                    <flux:breadcrumbs.item>
                        Create
                    </flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
        </div>

        <flux:separator variant="subtle" class="mt-6" />
    </div>

    <form wire:submit.prevent="createRole" class="space-y-6">

        {{-- Role Details --}}
        <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="mb-5">
                <flux:heading size="lg">
                    Role Details
                </flux:heading>

                <flux:text class="mt-1">
                    Give this role a name that clearly describes its purpose.
                </flux:text>
            </div>

            <div class="max-w-xl">
                <flux:input
                    wire:model="name"
                    :label="__('Role name')"
                    type="text"
                    required
                    placeholder="e.g. Manager"
                    autocomplete="off"
                />
            </div>
        </div>

        {{-- Permissions --}}
        <div class="rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">

            <div class="border-b border-zinc-200 px-6 py-5 dark:border-zinc-700">
                <flux:heading size="lg">
                    Permissions
                </flux:heading>

                <flux:text class="mt-1">
                    Select the permissions that users with this role should have.
                </flux:text>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">

                    @foreach ($this->groupedPermissions as $category => $permissions)
                        <div class="mb-6">
                            <div class="mb-3">
                                <flux:heading size="sm">
                                    {{ $category }}
                                </flux:heading>

                                <flux:text size="sm">
                                    Manage {{ strtolower($category) }} access and actions.
                                </flux:text>
                            </div>

                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-2">
                                @foreach ($permissions as $permission)
                                    @php
                                        $action = str($permission->name)
                                            ->beforeLast('-')
                                            ->replace('-', ' ')
                                            ->title();
                                    @endphp

                                    <label
                                        for="permission-{{ $permission->id }}"
                                        class="flex cursor-pointer items-center gap-3 rounded-lg border border-zinc-200 p-4
                                            transition hover:bg-zinc-50
                                            dark:border-zinc-700 dark:hover:bg-zinc-800/50"
                                    >
                                        <input
                                            id="permission-{{ $permission->id }}"
                                            type="checkbox"
                                            wire:model="selectedPermissions"
                                            value="{{ $permission->name }}"
                                            class="rounded border-zinc-300 text-primary-600
                                                focus:ring-primary-500
                                                dark:border-zinc-600"
                                        >

                                        <span class="text-sm font-medium text-zinc-900 dark:text-white">
                                            {{ $action }} {{ strtolower($category) }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-between">

            <flux:button
                href="{{ route('dashboard') }}"
                variant="ghost"
                type="button"
            >
                Cancel
            </flux:button>

            <div class="flex items-center gap-4">

                <div
                    x-data="{ show: false }"
                    x-on:role-created.window="
                        show = true;
                        setTimeout(() => show = false, 3000)
                    "
                >
                    <span
                        x-show="show"
                        x-transition
                        class="text-sm font-medium text-green-600 dark:text-green-400"
                    >
                        {{ __('Saved successfully.') }}
                    </span>
                </div>

                <flux:button
                    variant="primary"
                    type="submit"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.remove>
                        {{ __('Create Role') }}
                    </span>

                    <span wire:loading>
                        {{ __('Creating...') }}
                    </span>
                </flux:button>

            </div>
        </div>

    </form>
</div>
