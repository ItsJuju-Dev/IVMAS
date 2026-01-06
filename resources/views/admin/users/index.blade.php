<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f8;
        }

        /* PAGE WRAPPER */
        .page {
            padding: 32px;
        }

        /* HEADER */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .page-header h2 {
            margin: 0;
            font-size: 22px;
        }

        .page-header p {
            margin: 4px 0 0;
            font-size: 14px;
            color: #64748b;
        }

        /* ===== Action Buttons ===== */
        .action-buttons {
            display: flex;
            gap: 8px;
        }

        /* Base button */
        .btn {
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* Edit button */
        .btn-edit {
            background: #2563eb;
            color: #fff;
        }

        .btn-edit:hover {
            background: #1d4ed8;
        }

        /* Delete button */
        .btn-delete {
            background: #4b5563;
            color: #fff;
        }

        .btn-delete:hover {
            background: #374151;
        }

        /* Add button */
        .btn-add {
            background: #008000 ;
            color: #fff;
        }

        .btn-add:hover {
            background: #3cb371 ;
        }


        /* CARD */
        .card {
            background: #ffffff;
            border-radius: 12px;
            padding: 20px;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        thead {
            background: #f1f5f9;
        }

        th, td {
            padding: 12px 10px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        th {
            font-weight: 600;
            color: #334155;
        }

        /* ROLE BADGE */
        .badge {
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .badge.admin {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge.owner {
            background: #dcfce7;
            color: #065f46;
        }

        .badge.staff {
            background: #fef3c7;
            color: #92400e;
        }

        /* ACTIONS */
        .actions {
            display: flex;
            gap: 8px;
        }

        /* MODAL */
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.45);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: #fff;
            padding: 24px;
            width: 420px;
            border-radius: 12px;
        }

        .form-group {
            margin-bottom: 14px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 8px;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

    </style>
</head>
<body>

<div class="page">

    <!-- HEADER -->
    <div class="page-header">
        <div>
            <h2>User Management</h2>
            <p>Manage system users and assign roles.</p>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST" style="margin-bottom:24px;">
            @csrf

            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>

            <select name="role" required>
                <option value="admin">Admin</option>
                <option value="owner">Owner</option>
                <option value="staff">Staff</option>
            </select>

            <button class="btn btn-add">Add User</button>
        </form>
    </div>

    <!-- TABLE CARD -->
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th style="width: 160px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge {{ $user->role }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button 
                                class="btn btn-edit"
                                onclick="openEditModal(
                                    {{ $user->id }},
                                    '{{ $user->name }}',
                                    '{{ $user->email }}',
                                    '{{ $user->role }}'
                                )">
                                Edit
                            </button>
                            <button 
                                class="btn btn-delete"
                                onclick="openDeleteModal({{ $user->id }}, '{{ $user->name }}')">
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
        </table>
        <div id="editUserModal" class="modal">
            <div class="modal-content">
                <h3>Edit User</h3>

                <form method="POST" id="editUserForm">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" id="edit-name" required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" id="edit-email" required>
                    </div>

                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" id="edit-role">
                            <option value="admin">Admin</option>
                            <option value="owner">Owner</option>
                            <option value="staff">Staff</option>
                        </select>
                    </div>

                    <div class="modal-actions">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        <div id="deleteUserModal" class="modal">
            <div class="modal-content">
                <h3>Delete User</h3>

                <p id="deleteUserText" style="margin: 12px 0 20px;">
                    Are you sure you want to delete this user?
                </p>

                <form method="POST" id="deleteUserForm">
                    @csrf
                    @method('DELETE')

                    <div class="modal-actions">
                        <button type="submit" class="btn btn-deletegit">Delete</button>
                        <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<script>
/* ================= EDIT MODAL ================= */
function openEditModal(id, name, email, role) {
    document.getElementById('edit-name').value = name;
    document.getElementById('edit-email').value = email;
    document.getElementById('edit-role').value = role;

    // Correct template literal
    document.getElementById('editUserForm').action = `/admin/users/${id}`;

    document.getElementById('editUserModal').style.display = 'flex';
}

function closeEditModal() {
    document.getElementById('editUserModal').style.display = 'none';
}

/* ================= DELETE MODAL ================= */
function openDeleteModal(id, name) {
    document.getElementById('deleteUserText').innerText =
        `Are you sure you want to delete ${name}? This action cannot be undone.`;

    // Correct template literal
    document.getElementById('deleteUserForm').action = `/admin/users/${id}`;

    document.getElementById('deleteUserModal').style.display = 'flex';
}

function closeDeleteModal() {
    document.getElementById('deleteUserModal').style.display = 'none';
}
</script>


</body>
</html>
