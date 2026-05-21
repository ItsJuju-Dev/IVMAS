@extends('layouts.admin')

@section('title', 'User Management')

@section('content')

    <style>
        /* PAGE WRAPPER */
        .page {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        /* HEADER */
        .page-header {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .page-header h1 {
            margin: 0;
            font-size: 58px;
            font-weight: 700;
            color: #4e3727;
            line-height: 1;
        }

        .page-header p {
            margin: 0;
            font-size: 18px;
            color: #7b6a58;
        }

        /* ===== Action Buttons ===== */
        .action-buttons {
            display: flex;
            gap: 10px;
        }

        /* ===== Base Button ===== */
        .btn {
            padding: 10px 18px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        /* ===== Main Theme Buttons ===== */
        .btn-add,
        .btn-edit {
            background: #6b4b35;
            color: #ffffff;
        }

        .btn-add:hover,
        .btn-edit:hover {
            background: #523826;
            transform: translateY(-1px);
        }

        /* ===== Delete Button ===== */
        .btn-delete {
            background: #8b5e3c;
            color: #ffffff;
        }

        .btn-delete:hover {
            background: #70492e;
            transform: translateY(-1px);
        }

        /* ===== Cancel Button ===== */
        .btn-cancel {
            background: #d8cfc2;
            color: #4e3727;
        }

        .btn-cancel:hover {
            background: #c8bba9;
        }

        .add-user-card {
            display: flex;
            align-items: center;
        }

        /* ADD USER FORM */
        .add-user-form {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            width: 100%;
        }

        .add-user-form input,
        .add-user-form select {
            height: 48px;
            border-radius: 14px;
            border: 1px solid #d8cfc2;
            padding: 0 14px;
            background: #fffdf9;
            font-size: 14px;
        }

        .add-user-form button {
            height: 34px;
            white-space: nowrap;
        }

        /* CARD */
        .card {
            background: #fdfaf5;
            border-radius: 24px;
            padding: 28px;
            border: 1px solid #ece3d6;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        }

        /* ===== TABLE ===== */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        thead {
            background: #f5efe6;
        }

        th,
        td {
            padding: 18px 14px;
            text-align: left;
            border-bottom: 1px solid #ece3d6;
        }

        th {
            font-weight: 700;
            color: #4e3727;
            font-size: 14px;
        }

        td {
            color: #5f4b3a;
        }

        /* Hover Effect */
        tbody tr {
            transition: background 0.2s ease;
        }

        tbody tr:hover {
            background: #f8f4ed;
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
            background: #fdfaf5;
            border-radius: 24px;
            padding: 32px;
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



<div class="page">

    <!-- HEADER -->
    <div class="page-header">
        <h1>User Management</h1>
        <p>Manage system users and assign roles.</p>
    </div>

    <div class="card add-user-card">

        <form action="{{ route('admin.users.store') }}" method="POST" class="add-user-form">
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
                        <button type="submit" class="btn btn-edit">Update</button>
                        <button type="button" class="btn btn-cancel"
                        onclick="closeEditModal()">Cancel</button>
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
                        <button type="submit" class="btn btn-delete">Delete</button>
                        <button type="button" class="btn btn-cancel"
                        onclick="closeDeleteModal()">Cancel</button>
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


@endsection
