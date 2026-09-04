<?php

use Livewire\Attributes\On;
use Spatie\Permission\Models\Role;
use Livewire\Component;
use Livewire\Attributes\Computed;

new class extends Component {

    public $search = '';
    public $deleteRole, $roleId, $roleName;
    
    
    public function mount(): Void
    {

        abort_unless(
            auth()->user()->can('access-roles'),
            403
        );
    }

    #[computed]
    public function roles()
    {
        return Role::query()

            // Hide General Admin from everyone except General Admin
            ->when(!auth()->user()->hasRole('General Admin'), function ($query) {
                $query->where('name', '!=', 'General Admin');
            })

            // Search
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(10);
    }

    public function deleteRole($id)
    {

        dd('hello');

        abort_unless(
            auth()->user()->can('delete-roles'),
            403
        );

        $role = Role::findOrFail($id);
        $role->delete();

        $this->modal('delete-contacts')->close();

        $this->dispatch('role-deleted');
    }

    public function confirmDelete($id)
    {
        $this->roleId = $id;
        $role = Role::findOrFail($id);
        $this->roleName = $role->name;
        $this->modal('delete-contacts')->show();
    }

}; ?>

<div>

    {{-- confirm delete modal --}}
    <flux:modal name="delete-contacts" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete {{ $this->roleName }} </flux:heading>
                <flux:text class="mt-2">
                    You're about to delete this record.<br>
                    This action cannot be reversed.
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button type="link" variant="danger" wire:click="deleteRole({{ $roleId }})">Delete Contact</flux:button>
            </div>
        </div>
    </flux:modal>

    <div class="relative mb-6 w-full">
        <div class="flex justify-between items-center">
            <div>
                <flux:heading size="xl" level="1">{{ __('Roles') }}</flux:heading>
                <flux:breadcrumbs class="mb-4 mt-2">
                    <flux:breadcrumbs.item href="{{ route('dashboard') }}">Home</flux:breadcrumbs.item>
                    <flux:breadcrumbs.item >Roles</flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>

            @can('create-roles')
                <a wire:navigate href="{{ route('roles.create') }}"><flux:button size="sm" icon="plus" variant="primary" class="btn-sm">New Role</flux:button></a>
            @endcan
        </div>
        <flux:separator variant="subtle" />
    </div>
    <div>

        <div class="flex justify-between items-center mb-5">
            
            
            

            <disv class="w-50">
                <flux:input
                    wire:model.live="search"
                    type="text"
                    required
                    placeholder="Search"
                    autocomplete="current-password"
                />
            </div>
        </div>

        <flux:table>
            <flux:table.columns>
                <flux:table.column>Role Name</flux:table.column>
                <flux:table.column></flux:table.column>
            </flux:table.columns>

            <flux:table.rows>

                @foreach ($this->roles as $role)

                    <flux:table.row>

                        <flux:table.cell>
                            
                            <div class="flex flex-col">
                                {{ $role->name }}

                                <div class="flex flex-wrap">
                                    @foreach ($role->permissions as $permission)
                                        <flux:badge
                                            size="sm"
                                            color="zinc"
                                            class="mr-2 mt-2 rounded-lg border border-zinc-300 bg-zinc-100 px-2.5 py-1 font-medium text-zinc-700
                                                dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-200"
                                        >
                                            {{ str($permission->name)->replace('-', ' ')->headline() }}
                                        </flux:badge>
                                    @endforeach
                                </div>
                            </div>

                        </flux:table.cell>

                        <flux:table.cell class="py-0">
                            <flux:dropdown align="end">

                                <flux:button
                                    variant="ghost"
                                    size="sm"
                                    icon="ellipsis-horizontal"
                                />

                                <flux:menu>

                                    <flux:modal.trigger name="edit-contact">

                                        <a href="{{ route('roles.edit', $role->id) }}">
                                            <flux:menu.item
                                                icon="pencil"
                                            >
                                                Edit
                                            </flux:menu.item>
                                        </a>
                                    </flux:modal.trigger>


                                    <flux:menu.separator />

                                    <flux:menu.item
                                        variant="danger"
                                        icon="trash"
                                        wire:click="confirmDelete({{ $role->id }})"
                                    >
                                        Delete
                                    </flux:menu.item>

                                </flux:menu>

                            </flux:dropdown>
                        </flux:table.cell>


                    </flux:table.row>

                @endforeach

                

            </flux:table.rows>
        </flux:table>

        <div class="mt-5">

            {{-- {{ $this->contacts->links() }} --}}

        </div>

    </div>
</div>

