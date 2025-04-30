<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laravel API CRUD - Users</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">👥 Users Management</h2>
            <a href="/create" class="btn btn-primary">➕ Add New User</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="userTable">
                        <tr>
                            <td colspan="4" class="text-center">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Edit User Modal -->
    <div id="editUserModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit-user-form">
                        <input type="hidden" id="edit-user-id"> 
                        <div class="form-group">
                            <label for="edit-name">Name</label>
                            <input type="text" class="form-control" id="edit-name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-email">Email</label>
                            <input type="email" class="form-control" id="edit-email" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script>
        $(document).ready(function () {
            $.ajax({
                url: '/api/users',
                type: 'GET',
                success: function (response) {
                    if (response.data) {
                        let rows = '';
                        $.each(response.data, function (index, user) {
                            rows += `
                                <tr id="user-${user.id}">
                                    <td>${user.id}</td>
                                    <td>${user.name}</td>
                                    <td>${user.email}</td>
                                    <td>
                                        <!-- Modal kly hy  -->
                                        <!--<button class="btn btn-success edit-user" data-id="${user.id}" data-name="${user.name}" data-email="${user.email}">Edit</button>-->
                                        
                                        <button class="btn btn-sm btn-warning me-2 edit-btn" data-id="${user.id}">Edit</button>
                                        <button class="btn btn-sm btn-danger delete-user" data-user-id="${user.id}">Delete</button>
                                    </td>
                                </tr>`;
                        });
                        $('#userTable').html(rows);
                    }
                },
                error: function (xhr) {
                    let error = xhr.responseJSON?.message || 'Something went wrong';
                    alert("Error: " + error);
                }
            });

            $('#userTable').on('click', '.edit-btn', function () {
                let userId = $(this).data('id');
                $.ajax({
                    url: '/api/users/' + userId,
                    method: 'GET',
                    success: function (response) {
                        localStorage.setItem('editUser', JSON.stringify(response));
                        window.location.href = '/edit';
                    },
                    error: function () {
                        alert('Failed to fetch user data');
                    }
                });
            });

//start
//modal kly hy 
$(document).on('click', '.edit-user', function () {
        editUserId = $(this).data('id');
        $('#edit-name').val($(this).data('name'));
        $('#edit-email').val($(this).data('email'));
        $('#edit-role').val($(this).data('role'));
        $('#editUserModal').modal('show');
    });

    $('#edit-user-form').submit(function (e) {
        e.preventDefault();
        const updatedData = {
            name: $('#edit-name').val(),
            email: $('#edit-email').val(),
        };

        $.ajax({
            url: '/api/users/' + editUserId,
            method: 'PUT',
            contentType: 'application/json',
            data: JSON.stringify(updatedData),
            success: function () {
                $('#editUserModal').modal('hide');
                window.location.href='/';
            },
            error: function () {
                toastr.error('Error updating user!');
            }
        });
    });
//close

            $('#userTable').on('click', '.delete-user', function () {
                let userId = $(this).data('user-id');

                if (confirm('Are you sure you want to delete this user?')) {
                    $.ajax({
                        url: '/api/users/' + userId,
                        type: 'DELETE',
                        success: function (response) {
                            alert(response.message);
                            $('#user-' + userId).remove();
                        },
                        error: function () {
                            alert('Failed to delete user');
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>