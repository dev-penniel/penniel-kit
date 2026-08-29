<?php

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\Computed;


new class extends Component {
    
    public $search = '';

    public function mount(): Void
    {
        // Authorisation check
        abort_unless(
            auth()->user()->can('access-users'),
            403
        );
    }

    #[computed]
    public function users()
    {
        return User::query()

        // Hide super-admin from everyone except super-admin
        ->when(!auth()->user()->hasRole('General Admin'), function ($query) {
            $query->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'General Admin');
            });
        })

        // Search
        ->when($this->search, function ($query) {
            $query->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('created_at', 'like', '%' . $this->search . '%');
            });
        })

        ->latest()
        ->paginate(10);
    }
    

    public function deleteUser(User $user): Void
    {

        // Authorisation check
        abort_unless(
            auth()->user()->can('delete-users'),
            403
        );

        if($user->is(auth()->user())) {
            abort(403, 'You cannot delete yourself');
        }

        if ($user->hasRole('General Admin')) {
            abort(403, 'The general admin cannot be deleted.');
        }

        $user->delete();

        $this->dispatch('user-deleted');
    }


}; ?>



<div>
    <div class="relative mb-6 w-full">
        <div class="flex justify-between items-center">
            <div>
                <flux:heading size="xl" level="1">{{ __('Users') }}</flux:heading>
                <flux:breadcrumbs class="mb-4 mt-2">
                    <flux:breadcrumbs.item href="{{ route('dashboard') }}">Home</flux:breadcrumbs.item>
                    <flux:breadcrumbs.item >Users</flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>

            @can('create-users')
                <a wire:navigate href="{{ route('users.create') }}"><flux:button size="sm" variant="primary" class="btn-sm">New User</flux:button></a>
                
            @endcan
        </div>

        <flux:separator variant="subtle" />
    </div>
    <div>

        <div class="flex justify-between items-center mb-5">

            <div class="w-50">
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
                <flux:table.column>Names</flux:table.column>
                <flux:table.column>Email</flux:table.column>
                <flux:table.column>Status</flux:table.column>
                <flux:table.column>Role</flux:table.column>
                <flux:table.column>Created</flux:table.column>
                <flux:table.column>Updated</flux:table.column>
                <flux:table.column></flux:table.column>
            </flux:table.columns>

            <flux:table.rows>

                @foreach ($this->users as $user)

                    <flux:table.row>

                        <flux:table.cell>{{ $user->name }}</flux:table.cell>
                        <flux:table.cell>{{ $user->email }}</flux:table.cell>
                        <flux:table.cell class="py-0"><flux:badge color="green" size="sm">Active</flux:badge></flux:table.cell>

                        @foreach ($user->getRoleNames() as $role)
                            <flux:table.cell variant="strong">{{ $role }}</flux:table.cell>
                        @endforeach

                        <flux:table.cell>{{ $user->created_at->diffForHumans() }}</flux:table.cell>
                        <flux:table.cell>{{ $user->updated_at->diffForHumans() }}</flux:table.cell>

                        <flux:table.cell class="py-0">
                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal"></flux:button>
                        </flux:table.cell>

                    </flux:table.row>

                @endforeach

                

            </flux:table.rows>
        </flux:table>
    </div>
</div>
