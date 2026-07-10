
<?php
require_once __DIR__.'/../../includes/auth.php';

requireRole(['admin']);
require_once __DIR__ . '/../../config/database.php';

?>

<div class="card shadow border-0">

    <div class="card-header d-flex justify-content-between">

        <h4 class="mb-0">
            Add User
        </h4>

        <button
        class="btn btn-secondary"
        onclick="loadPage('modules/users/index.php')">

            Back

        </button>

    </div>

    <div class="card-body">

        <form
        action="modules/users/store.php"
        method="POST"
        enctype="multipart/form-data">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Full Name
                    </label>

                    <input
                    type="text"
                    name="name"
                    class="form-control"
                    required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Email
                    </label>

                    <input
                    type="email"
                    name="email"
                    class="form-control"
                    required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Phone
                    </label>

                    <input
                    type="text"
                    name="phone"
                    class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Password
                    </label>

                    <input
                    type="password"
                    name="password"
                    class="form-control"
                    required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Role
                    </label>

                    <select
                    name="role"
                    class="form-select">

                        <option value="staff">
                            Staff
                        </option>

                        <option value="manager">
                            Manager
                        </option>

                        <option value="admin">
                            Admin
                        </option>

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Status
                    </label>

                    <select
                    name="status"
                    class="form-select">

                        <option value="active">
                            Active
                        </option>

                        <option value="inactive">
                            Inactive
                        </option>

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Profile Image
                    </label>

                    <input
                    type="file"
                    name="profile_image"
                    class="form-control"
                    accept="image/*">

                </div>

            </div>

            <button
            type="submit"
            class="btn btn-success">

                Save User

            </button>

        </form>

    </div>

</div>
