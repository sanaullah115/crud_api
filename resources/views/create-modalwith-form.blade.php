<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Modal CRUD</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    
</head>
<body>


<div class="container mt-5">

    <!-- Add User Button -->
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addUserModal">Add User</button>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add User</h5>
                        <button class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <h4>All Users</h4>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal{{ $user->id }}">Edit</button>
                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $user->id }}">Delete</button>
                </td>
            </tr>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit User</h5>
                                <button class="close" data-dismiss="modal"><span>&times;</span></button>
                            </div>
                            <div class="modal-body">

                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>New Password (leave blank to keep current)</label>
                                    <input type="password" name="password" class="form-control">
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button class="btn btn-primary" type="submit">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Modal -->
            <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title">Confirm Delete</h5>
                                <button class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete <strong>{{ $user->name }}</strong>?
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        @empty
            <tr>
                <td colspan="4" class="text-center">No users found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

</div>
@if(session('success'))
<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">Well done!</h4>
    <p>        {{ session('success') }}
    </p>
  </div>
@endif
<!-- Bootstrap Scripts -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

</body>
</html>
