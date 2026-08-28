<?php

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use Spatie\Permission\Models\Role;

new class extends Component {

    public $user, $id, $name, $email, $password, $password_confirmation, $allRoles, $selectedRole;

    #[On('user-updated')]
    public function mount($id): Void
    {

        // Authorisation check
        abort_unless(
            auth()->user()->can('edit-users'),
            403,
        );

        $this->user = User::findOrFail($id);
        $this->allRoles = Role::latest()->get();

        // Get current user role
        $this->selectedRole = $this->user->roles->pluck('name')->first();

        $this->name = $this->user->name;
        $this->email = $this->user->email;


    }

    public function updateUser($id)
    {

        // Authorisation check
        abort_unless(
            auth()->user()->can('edit-users'),
            403
        );

        $user = User::findOrFail($id);

        $validated = $this->validate([
            'name' => ['string', 'max:255'],
            'password' => ['nullable', 'string', 'confirmed', Rules\Password::defaults()],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($id),
            ],
            'selectedRole' => ['required', 'exists:roles,name'],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->fill($validated);

        $user->save();

        // Assign user role
        $user->syncRoles($this->selectedRole);

        $this->dispatch('user-updated', $user->id);

    }


}; ?>


<div>
    <div>
        <div class="relative mb-6 w-full">
            <div class="flex justify-between items-center">
                <div>
                    <div class="flex gap-2 items-center">
                        <a wire:navigate href="{{ route('users') }}">
                            <flux:icon.arrow-left-circle/>
                        </a>
                        <flux:heading size="xl" level="1">{{ __('Edit User - ') }}{{$name}}</flux:heading>
                    </div>
                    <flux:breadcrumbs class="mb-4 mt-2">
                        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Home</flux:breadcrumbs.item>
                        <flux:breadcrumbs.item href="{{ route('dashboard') }}">users</flux:breadcrumbs.item>
                        <flux:breadcrumbs.item>Create</flux:breadcrumbs.item>
                    </flux:breadcrumbs>
                </div>
            </div>
            <flux:separator variant="subtle"/>
        </div>
        <form wire:submit.prevent="updateUser({{ $user->id }})">
            <div class="flex gap-5 mb-5">
                <flux:input
                    wire:model="name"
                    :label="__('Names')"
                    type="text"
                    required
                    placeholder="Names"
                    autocomplete="names"
                />
                <flux:input
                    disabled
                    wire:model="email"
                    :label="__('User Email')"
                    type="email"
                    required
                    placeholder="User email"
                    autocomplete="user-email"
                />

                <select class="form-select" wire:model="selectedRole">
                    @forelse ($allRoles ?? [] as $role)
                        <option wire:key="{{ $role->id }}" value="{{ $role->name }}">{{ $role->name }}</option>
                    @empty
                        <option disabled>No roles found</option>
                    @endforelse
                </select>
            </div>
            <div class="flex gap-5 mb-5">
                <flux:input
                    wire:model="password"
                    :label="__('Password')"
                    type="password"
                    placeholder="Password"
                    autocomplete="password"
                />
                <flux:input
                    wire:model="password_confirmation"
                    :label="__('Confirm Password')"
                    type="password"
                    placeholder="Password"
                    autocomplete="confirm-password"
                />
            </div>
            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>

                <div
                    x-data="{ show: false }"
                    x-on:user-updated.window="show = true; setTimeout(() => show = false, 3000)"
                >
                    <span x-show="show" x-transition>
                        {{ __('Saved.') }}
                    </span>
                </div>
            </div>
        </form>
    </div>
</div>
