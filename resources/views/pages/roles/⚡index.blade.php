<?php

use Livewire\Attributes\On;
use Spatie\Permission\Models\Role;
use Livewire\Component;
use Livewire\Attributes\Computed;

new class extends Component {

    public $search = '';
    
    
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

        abort_unless(
            auth()->user()->can('delete-roles'),
            403
        );

        $role = Role::findOrFail($id);
        $role->delete();

        $this->dispatch('role-deleted');
    }

}; ?>

<div>
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

                                <div>
                                    @foreach ($role->permissions as $permission)
                                        <flux:badge class="mr-2 mt-2" size="sm">{{ $permission->name }}</flux:badge>
                                    @endforeach
                                </div>
                            </div>

                        </flux:table.cell>

                        <flux:table.cell class="py-0">
                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal"></flux:button>
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

