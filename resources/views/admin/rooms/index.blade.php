@extends('layouts.admin')

@section('title', 'Room Management')

@section('content')

<style>
body {
    background: #f4f6f8;
    font-family: Arial, sans-serif;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.page-header h2 {
    margin: 0;
}

.card {
    background: #fff;
    border-radius: 10px;
    padding: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 12px;
    border-bottom: 1px solid #e5e7eb;
    text-align: left;
}

th {
    background: #f1f5f9;
}

.badge {
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: bold;
}

.badge.available {
    background: #dcfce7;
    color: #166534;
}

.badge.unavailable {
    background: #fee2e2;
    color: #991b1b;
}

.btn {
    padding: 6px 12px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-size: 13px;
}

.btn-primary {
    background: #2563eb;
    color: #fff;
}

.btn-danger {
    background: #374151;
    color: #fff;
}

.btn-success {
    background: #16a34a;
    color: #fff;
}

.modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.45);
    justify-content: center;
    align-items: center;
}

.modal-content {
    background: #fff;
    padding: 24px;
    width: 420px;
    border-radius: 10px;
}
</style>
</head>

<body>

<div class="page-header">
    <div>
        <h2>Room Management</h2>
        <p style="color:#64748b">Manage villa rooms for direct bookings.</p>
    </div>

    <button class="btn btn-success" onclick="openAddModal()">Add Room</button>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Capacity</th>
                <th>Base Price</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($rooms as $room)
            <tr>
                <td>{{ $room->name }}</td>
                <td>{{ $room->type }}</td>
                <td>{{ $room->capacity }}</td>
                <td>IDR {{ number_format($room->base_price) }}</td>
                <td>
                    <span class="badge {{ $room->status }}">
                        {{ ucfirst($room->status) }}
                    </span>
                </td>
                <td>
                    <button class="btn btn-primary"
                        onclick="openEditModal(
                            {{ $room->id }},
                            '{{ $room->name }}',
                            '{{ $room->type }}',
                            {{ $room->capacity }},
                            {{ $room->base_price }},
                            '{{ $room->status }}'
                        )">
                        Edit
                    </button>
                        <button
                            class="btn btn-danger"
                            onclick="openDeleteRoomModal({{ $room->id }}, '{{ $room->name }}')">
                            Delete
                        </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<!-- ADD ROOM MODAL -->
<div id="addModal" class="modal">
    <div class="modal-content">
        <h3>Add Room</h3>
        <form method="POST" action="{{ route('admin.rooms.store') }}">
            @csrf
            <input name="name" placeholder="Room Name" required><br><br>
            <input name="type" placeholder="Room Type" required><br><br>
            <input type="number" name="capacity" placeholder="Capacity" required><br><br>
            <input type="number" name="base_price" placeholder="Base Price" required><br><br>

            <select name="status" required>
            <option value="active">Active</option>
            <option value="maintenance">Maintenance</option>
            <option value="inactive">Inactive</option>
            </select><br><br>

            <button class="btn btn-success">Save</button>
            <button type="button" class="btn" onclick="closeAddModal()">Cancel</button>
        </form>
    </div>
</div>

<!-- EDIT ROOM MODAL -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <h3>Edit Room</h3>
        <form id="editRoomForm" method="POST">
            @csrf
            @method('PUT')

            <input id="edit-name" name="name" required><br><br>
            <input id="edit-type" name="type" required><br><br>
            <input id="edit-capacity" type="number" name="capacity" required><br><br>
            <input id="edit-price" type="number" name="base_price" required><br><br>

            <select id="edit-status" name="status" required>
            <option value="active">Active</option>
            <option value="maintenance">Maintenance</option>
            <option value="inactive">Inactive</option>
            </select><br><br>

            <button class="btn btn-primary">Update</button>
            <button type="button" class="btn" onclick="closeEditModal()">Cancel</button>
        </form>
    </div>
</div>

<!-- DELETE ROOM MODAL -->
<div id="deleteRoomModal" class="modal">
    <div class="modal-content">
        <h3>Delete Room</h3>
        <p id="deleteRoomText"></p>

        <form id="deleteRoomForm" method="POST">
            @csrf
            @method('DELETE')

            <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px;">
                <button type="submit" class="btn btn-danger">
                    Delete
                </button>
                <button type="button" class="btn" onclick="closeDeleteRoomModal()">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openAddModal() {
    document.getElementById('addModal').style.display = 'flex';
}
function closeAddModal() {
    document.getElementById('addModal').style.display = 'none';
}

function openEditModal(id, name, type, capacity, price, status) {
    document.getElementById('edit-name').value = name;
    document.getElementById('edit-type').value = type;
    document.getElementById('edit-capacity').value = capacity;
    document.getElementById('edit-price').value = price;
    document.getElementById('edit-status').value = status;

    document.getElementById('editRoomForm').action = `/admin/rooms/${id}`;
    document.getElementById('editModal').style.display = 'flex';
}
function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}

function openDeleteRoomModal(id, name) {
    document.getElementById('deleteRoomText').innerText =
        `Are you sure you want to delete room "${name}"? This action cannot be undone.`;

    document.getElementById('deleteRoomForm').action =
        `/admin/rooms/${id}`;

    document.getElementById('deleteRoomModal').style.display = 'flex';
}

function closeDeleteRoomModal() {
    document.getElementById('deleteRoomModal').style.display = 'none';
}
</script>

@endsection