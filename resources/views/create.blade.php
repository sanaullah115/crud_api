<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create User - Laravel API</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">👤 Create New User</h4>
                    </div>
                    <div class="card-body">
                        <form id="userfrom">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" placeholder="Enter full name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Enter email address" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" placeholder="Enter password" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Create User</button>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <a href="/" class="btn btn-link">← Back to User List</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script>
        $(document).ready(function () {
            $('#userfrom').on('submit', function (e) {
                e.preventDefault();

                var name = $('#name').val();
                var email = $('#email').val();
                var password = $('#password').val();

                $.ajax({
                    url: '/api/users',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        name: name,
                        email: email,
                        password: password,
                    }),
                    success: function (response) {
                        alert("✅ User created successfully!");
                        $('#userfrom')[0].reset();
                        window.location.href = '/';
                    },
                    error: function (xhr) {
                        let error = xhr.responseJSON?.message || 'Something went wrong';
                        alert("❌ Error: " + error);
                    }
                });
            });
        });
    </script>

</body>

</html>
