<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Users</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex justify-content-end mb-2">
                        <button wire:click.prevent="addNew()" class="btn btn-primary">
                            <i class="fas fa-plus-circle mr-1"> Add New User</i>
                        </button>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <button class="btn px-0 mr-2" wire:click="edit({{ $user }})">
                                                <i class="fas fa-edit text-primary"></i>
                                            </button>
                                            <button class="btn px-0" wire:click="confirmUserRemoval({{ $user->id }})">
                                                <i class="fas fa-trash text-danger"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    <!-- Add/Edit Modal -->
    <div class="modal fade" data-backdrop="static" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <form wire:submit.prevent="{{ $showEditModal ? 'updateUser()' : 'createUser()' }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">
                            {{ $showEditModal ? 'Edit User' : 'Add New User' }}
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="col-form-label">Name</label>
                            <input type="text" wire:model.defer="state.name"
                                class="form-control @error('name') is-invalid @enderror" id="name"
                                placeholder="Enter full name">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-form-label">Email</label>
                            <input type="text" wire:model.defer="state.email"
                                class="form-control @error('email') is-invalid @enderror" id="email"
                                placeholder="Enter email">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-form-label">Password</label>
                            <input type="password" wire:model.defer="state.password"
                                class="form-control @error('password') is-invalid @enderror" id="password"
                                placeholder="Enter password">
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation" class="col-form-label">Confirm Password</label>
                            <input type="password" wire:model.defer="state.password_confirmation" class="form-control"
                                id="password_confirmation" placeholder="Confirm password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                class="fas fa-times mr-1"></i> Close</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i>
                            {{ $showEditModal ? 'Save changes' : 'Save' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Delete user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6>Are you sure you want to delete this user?</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times mr-1"></i> Close</button>
                    <button type="button" wire:click="deleteUser" class="btn btn-danger"><i class="fas fa-trash mr-1"></i> Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

<x-slot name="scripts">
    <script>
        window.addEventListener('show-form', event => {
            $('#addUserModal').modal('show');
        })
        window.addEventListener('hide-form', event => {
            $('#addUserModal').modal('hide');
            toastr.success(event.detail.message, 'Success!');
        })
        window.addEventListener('show-delete-modal', event => {
            $('#confirmationModal').modal('show');
        })
        window.addEventListener('hide-delete-modal', event => {
            $('#confirmationModal').modal('hide');
            toastr.success(event.detail.message, 'Success!');
        })
    </script>
</x-slot>