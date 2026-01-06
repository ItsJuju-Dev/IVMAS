<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
</head>
<body>

<h2>Edit User</h2>

<form method="POST" action="{{ route('admin.users.update', $user) }}">
    @csrf
    @method('PUT')

    <div>
        <label>Name</label><br>
        <input type="text" name="name" value="{{ $user->name }}" required>
    </div>

    <br>

    <div>
        <label>Email</label><br>
        <input type="email" name="email" value="{{ $user->email }}" required>
    </div>

    <br>

    <div>
        <label>Role</label><br>
        <select name="role" required>
            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="owner" {{ $user->role === 'owner' ? 'selected' : '' }}>Owner</option>
            <option value="staff" {{ $user->role === 'staff' ? 'selected' : '' }}>Staff</option>
        </select>
    </div>

    <br>

    <button type="submit">Update User</button>
    <a href="{{ route('admin.users.index') }}">Cancel</a>

</form>

</body>
</html>
