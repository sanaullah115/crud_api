<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laravel API CRUD - Users</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
