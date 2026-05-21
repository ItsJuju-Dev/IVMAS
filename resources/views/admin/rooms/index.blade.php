@extends('layouts.admin')

@section('title', 'Room Management')

@section('content')

<style>
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 28px;
}

.page-header h2 {
    margin: 0;
    font-size: 56px;
    font-weight: 700;
    color: #4b362b;
}

.page-header p {
    margin: 0;
    font-size: 18px;
    color: #7b6a58;
}

.card {
    background: #f7f4ee;
    border-radius: 28px;
    padding: 28px;
    border: 1px solid #ece4d8;
    margin-bottom: 24px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 20px 14px;
    border-bottom: 1px solid #e7ded2;
    text-align: left;
}

th {
    background: #efe9df;
    color: #4b362b;
    font-size: 14px;
    font-weight: 700;
}

td {
    color: #5c4638;
    font-size: 15px;
}

.badge {
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
}

.badge.active,
.badge.available {
    background: #d7f0dd;
    color: #2f6b3d;
}

.badge.maintenance {
    background: #f8e7c9;
    color: #9b6500;
}

.badge.inactive,
.badge.unavailable {
    background: #f5d7d7;
    color: #8b2f2f;
}

.btn {
    padding: 10px 18px;
    border-radius: 14px;
    border: none;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
    transition: 0.2s ease;
    text-decoration: none;
}

.btn-add,
.btn-edit {
    background: #6b4b35;
    color: white;
}

.btn-add:hover,
.btn-edit:hover {
    background: #5a3f2d;
}

.btn-delete {
    background: #8b5e3c;
    color: white;
}

.btn-delete:hover {
    background: #734d31;
}

.action-buttons {
    display: flex;
    gap: 10px;
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
    background: #f7f4ee;
    padding: 32px;
    width: 440px;
    border-radius: 24px;
    border: 1px solid #e9dfd2;
}

.modal-content h3 {
    margin-top: 0;
    color: #4b362b;
    font-size: 24px;
}

input,
select {
    width: 100%;
    padding: 12px 14px;
    border-radius: 14px;
    border: 1px solid #d9cbb8;
    background: #fffdf9;
    font-size: 14px;
    margin-top: 6px;
}

.form-group {
    margin-bottom: 18px;
}

.form-group label {
    display: block;
    margin-bottom: 6px;
    font-size: 14px;
    font-weight: 600;
    color: #4b362b;
}

.modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 24px;
}
</style>

<div class="page-header">
    <div>
        <h2>Room Management</h2>
        <p>Manage villa rooms for direct bookings.</p>
    </div>

    <button class="btn btn-add" onclick="openAddModal()">Add Room</button>
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
                    <div class="action-buttons">

                        <button class="btn btn-edit"
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
                            class="btn btn-delete"
                            onclick="openDeleteRoomModal({{ $room->id }}, '{{ $room->name }}')">
                            Delete
                        </button>

                    </div>
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
            <div class="form-group">
                <label>Room Name</label>
                <input name="name" required>
            </div>

            <div class="form-group">
                <label>Room Type</label>
                <input name="type" required>
            </div>

            <div class="form-group">
                <label>Capacity</label>
                <input type="number" name="capacity" required>
            </div>

            <div class="form-group">
                <label>Base Price</label>
                <input type="number" name="base_price" required>
            </div>

            <div class="form-group">
                <label>Status</label>

                <select name="status" required>
                    <option value="active">Active</option>
                    <option value="maintenance">Maintenance</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <button class="btn btn-add">Save</button>
            <button type="button" class="btn btn-delete" onclick="closeAddModal()">Cancel</button>
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

            <div class="form-group">
                <label>Room Name</label>
                <input id="edit-name" name="name" required>
            </div>

            <div class="form-group">
                <label>Room Type</label>
                <input id="edit-type" name="type" required>
            </div>

            <div class="form-group">
                <label>Capacity</label>
                <input id="edit-capacity" type="number" name="capacity" required>
            </div>

            <div class="form-group">
                <label>Base Price</label>
                <input id="edit-price" type="number" name="base_price" required>
            </div>

            <div class="form-group">
                <label>Status</label>

                <select id="edit-status" name="status" required>
                    <option value="active">Active</option>
                    <option value="maintenance">Maintenance</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <div class="modal-actions">
                <button class="btn btn-edit">Update</button>

                <button
                    type="button"
                    class="btn btn-delete"
                    onclick="closeEditModal()">
                    Cancel
                </button>
            </div>
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
                <button type="submit" class="btn btn-delete">
                    Delete
                </button>
                <button type="button" class="btn btn-edit" onclick="closeDeleteRoomModal()">
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