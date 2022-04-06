<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class ListUsers extends Component
{
    public $state = [];
    public $showEditModal = false;
    public $user;
    public $userIdBeingRemoved = null;

    public function render()
    {
        $users = User::latest()->paginate(10);
        return view('livewire.admin.users.list-users', [ 'users' => $users ]);
    }

    public function addNew() {
        $this->state = [];
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-form');
    }

    public function createUser() {
        $validatedData = Validator::make($this->state, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ])->validate();

        $validatedData['password'] = Hash::make($validatedData['password']);
        User::create($validatedData);

        $this->dispatchBrowserEvent('hide-form', ['message' => 'User added successfully!']);
    }

    public function edit(User $user) {
        $this->user = $user;
        $this->state = $user->toArray();
        $this->showEditModal = true;
        $this->dispatchBrowserEvent('show-form');

    }

    public function updateUser() {
        $validatedData = Validator::make($this->state, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'. $this->user->id,
            'password' => 'sometimes|confirmed',
        ])->validate();

        if(!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $this->user->update($validatedData);

        $this->dispatchBrowserEvent('hide-form', ['message' => 'User updated successfully!']);
    }

    public function confirmUserRemoval($userId) {
        $this->userIdBeingRemoved = $userId;
        $this->dispatchBrowserEvent('show-delete-modal');
    }

    public function deleteUser() {
        $user = User::findOrFail($this->userIdBeingRemoved);

        $user->delete();

        $this->dispatchBrowserEvent('hide-delete-modal', ['message' => 'User deleted successfully!']);
    }
}
