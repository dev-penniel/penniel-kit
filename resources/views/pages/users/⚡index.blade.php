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
        </div>
        <flux:separator variant="subtle" />
    </div>
    <div>

        <div class="flex justify-between items-center mb-5">
            
            <a wire:navigate href="{{ route('users.create') }}"><flux:button size="sm" variant="primary" class="btn-sm"> <flux:icon.plus class="size-5" /> Add New</flux:button></a>

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

        <table class="table-auto w-full">
            <thead>
                <th>
                    <tr class="bg-gray-100">
                        <td class="px-5 py-3 font-bold text-sm">Names</td>
                        <td class="px-5 py-3 font-bold text-sm">Email</td>
                        <td class="px-5 py-3 font-bold text-sm">Role</td>
                        <td class="px-5 py-3 font-bold text-sm">Created</td>
                        <td class="px-5 py-3 font-bold text-sm">Actions</td>
                    </tr>
                </th>
            </thead>
            <tbody>

                @foreach ($this->users as $user)
                
                    <tr class="border-b border-gray-300 hover:bg-gray-100">
                        <td class="px-5 py-2 text-sm">{{ $user->name }}</td>
                        <td class="px-5 py-2 text-sm">{{ $user->email }}</td>
                        
                        @foreach ($user->getRoleNames() as $role)
                            <td class="px-5 py-2 text-sm">{{ $role }} </td>
                        @endforeach

                        <td class="px-5 py-2 text-sm">{{ $user->created_at->format('M d, Y H:i') }}</td>
                        <td class="px-5 py-2 text-sm flex gap-2 place-content-center">
                            
                            @can('edit-users')
                                <a wire:navigate href="{{ route('user.edit', $user) }}"><flux:icon.pencil-square class="size-5" color="green" /></a>
                            @endcan
                            
                            @can('delete-users')
                                <flux:icon.trash class="size-5 cursor-pointer" color="red" wire:click="deleteUser({{ $user }})" wire:confirm="Are you sure you want to delete?" />
                            @endcan


                            </td>
                    </tr>

                @endforeach

            </tbody>
            {{-- {{ $contacts->links() }} --}}
        </table>

        <div class="mt-5">

            {{ $this->users->links() }}

        </div>

    </div>
</div>
