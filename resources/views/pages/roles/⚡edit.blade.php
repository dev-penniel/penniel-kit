<?php

use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Livewire\Component;

new class extends Component {

    public $permissions, $name, $id;
    public $selectedPermissions = [];

    public function mount($id): void
    {
        abort_unless(
            auth()->user()->can('edit-roles'),
            403
        );

        $role = Role::findOrFail($id);

        $this->id = $id;
        $this->name = $role->name;
        $this->permissions = Permission::get();

        // Select the permissions the role already has
        $this->selectedPermissions = $role->permissions
            ->pluck('name')
            ->toArray();
    }

    public function getGroupedPermissionsProperty()
    {
        return $this->permissions->groupBy(function ($permission) {
            return str($permission->name)
                ->afterLast('-')
                ->headline();
        });
    }

    public function updateRole($id): void
    {
        abort_unless(
            auth()->user()->can('edit-roles'),
            403
        );

        $role = Role::findOrFail($id);

        $validated = $this->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('roles', 'name')->ignore($role->id),
            ],
        ]);

        $role->update($validated);

        $role->syncPermissions($this->selectedPermissions);

        $this->dispatch('role-updated');
    }
};
?>

<div>

    {{-- Header --}}
    <div class="relative mb-6 w-full">

        <div class="flex items-center justify-between">

            <div>

                <div class="flex items-center gap-2">

                    <a
                        wire:navigate
                        href="{{ route('roles') }}"
                        class="text-zinc-500 transition hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white"
                    >
                        <flux:icon.arrow-left-circle />
                    </a>

                    <flux:heading size="xl" level="1">
                        {{ __('Edit Role - ') }}{{ $name }}
                    </flux:heading>

                </div>

                <flux:text class="mt-1">
                    Update the role details and permissions.
                </flux:text>

                <flux:breadcrumbs class="mt-3">

                    <flux:breadcrumbs.item href="{{ route('dashboard') }}">
                        Home
                    </flux:breadcrumbs.item>

                    <flux:breadcrumbs.item href="{{ route('roles') }}">
                        Roles
                    </flux:breadcrumbs.item>

                    <flux:breadcrumbs.item>
                        Edit
                    </flux:breadcrumbs.item>

                    <flux:breadcrumbs.item>
                        {{ $name }}
                    </flux:breadcrumbs.item>

                </flux:breadcrumbs>

            </div>

        </div>

        <flux:separator variant="subtle" class="mt-6" />

    </div>


    {{-- Form --}}
    <form wire:submit.prevent="updateRole({{ $id }})" class="space-y-6">

        {{-- Role Details --}}
        <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">

            <div class="mb-5">

                <flux:heading size="lg">
                    Role Details
                </flux:heading>

                <flux:text class="mt-1">
                    Update the name of this role.
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

                <div class="grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-3"> 


                @foreach ($this->groupedPermissions as $category => $permissions)

                    <div class="mb-8 last:mb-0">

                        <div class="mb-3">

                            <flux:heading size="sm">
                                {{ $category }}
                            </flux:heading>

                            <flux:text size="sm">
                                Manage {{ strtolower($category) }} permissions.
                            </flux:text>

                        </div>


                        <div class="grid sm:grid-cols-2 gap-3 md:grid-cols-2 lg:grid-cols-2">

                            @foreach ($permissions as $permission)

                                @php
                                    $action = str($permission->name)
                                        ->beforeLast('-')
                                        ->headline();
                                @endphp

                                <label
                                    for="permission-{{ $permission->id }}"
                                    class="flex cursor-pointer items-center gap-3 rounded-lg border border-zinc-200 p-4 transition
                                           hover:bg-zinc-50
                                           dark:border-zinc-700 dark:hover:bg-zinc-800/50"
                                >

                                    <input
                                        id="permission-{{ $permission->id }}"
                                        type="checkbox"
                                        wire:model="selectedPermissions"
                                        value="{{ $permission->name }}"
                                        class="mt-0.5 rounded border-zinc-300 text-primary-600
                                               focus:ring-primary-500
                                               dark:border-zinc-600"
                                    >

                                    <div class="min-w-0">

                                        <div class="text-sm font-medium text-zinc-900 dark:text-white">
                                            {{ $action }} {{ strtolower($category) }}s
                                        </div>

                                    </div>

                                </label>

                            @endforeach

                        </div>

                    </div>

                @endforeach

            </div>

            </div>

        </div>


        {{-- Actions --}}
        <div class="flex sticky bottom-0 bg-white dark:bg-zinc-900 py-5 items-center justify-between">

            <flux:button
                href="{{ route('roles') }}"
                variant="ghost"
                type="button"
            >
                Cancel
            </flux:button>


            <div class="flex items-center gap-4">

                {{-- Success Message --}}
                <div
                    x-data="{ show: false }"
                    x-on:role-updated.window="
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


                {{-- Save --}}
                <flux:button
                    variant="primary"
                    type="submit"
                    wire:loading.attr="disabled"
                >

                    <span wire:loading.remove>
                        {{ __('Save Changes') }}
                    </span>

                    <span wire:loading>
                        {{ __('Saving...') }}
                    </span>

                </flux:button>

            </div>

        </div>

    </form>

</div>