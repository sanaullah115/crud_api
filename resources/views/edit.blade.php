<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit User - Laravel API</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0">✏️ Edit User</h4>
                    </div>
                    <div class="card-body">
                        <form id="editForm">
                            <input type="hidden" id="user_id">

                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" placeholder="Enter full name" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Enter email address" required>
                            </div>

                            <button type="submit" class="btn btn-success w-100">💾 Update User</button>
                        </form>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="/" class="btn btn-link">← Back to User List</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            let userData = JSON.parse(localStorage.getItem('editUser'));
            if (!userData) {
                alert('No user data found. Redirecting to list...');
                window.location.href = '/';
                return;
            }

            // Fill form data
            $('#user_id').val(userData.id);
            $('#name').val(userData.name);
            $('#email').val(userData.email);

            // Submit updated data
            $('#editForm').on('submit', function (e) {
                e.preventDefault();
                const userId = $('#user_id').val();
                const name = $('#name').val();
                const email = $('#email').val();

                $.ajax({
                    url: '/api/users/' + userId,
                    type: 'PUT',
                    data: {name: name,email: email},
                    success: function (response) {
                        alert('✅ User updated successfully!');
                        localStorage.removeItem('editUser');
                        window.location.href = '/';
                    },
                    error: function () {
                        alert('❌ Update failed. Please try again.');
                    }
                });
            });
        });
    </script>

</body>

</html>
