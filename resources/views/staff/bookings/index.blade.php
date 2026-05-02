@extends('layouts.staff')

@section('content')

<style>
.alert-success
{
    background:#dcfce7;
    color:#166534;
    padding:10px;
    border-radius:6px;
    margin-bottom:15px;
}
</style>

<div>

    <h2 class="mb-4">Manage Bookings</h2>

    @if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
    @endif

    <a href="{{ route('staff.bookings.create') }}" class="add-btn">
        + Add Booking
    </a>

    <table class="booking-table">
        <thead>
            <tr>
                <th>Guest</th>
                <th>Room</th>
                <th>Check-In</th>
                <th>Check-Out</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Handled By</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bookings as $booking)
                <tr>
                    <td>{{ $booking->guest_name }}</td>
                    <td>{{ $booking->room->name ?? '-' }}</td>
                    <td>{{ $booking->check_in_date }}</td>
                    <td>{{ $booking->check_out_date }}</td>
                    <td>{{ number_format($booking->total_price, 2) }}</td>
                    <td>
                        <span class="status {{ $booking->status }}">
                            {{ ucfirst(str_replace('_',' ',$booking->status)) }}
                        </span>
                    </td>
                    <td>{{ $booking->staff->name ?? '-' }}</td>
                    <td>
                        <a href="{{ route('staff.bookings.edit', $booking) }}" class="edit-btn">Edit</a>

                        <form action="{{ route('staff.bookings.destroy', $booking) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                            class="btn btn-sm btn-danger"
                            onclick="openDeleteModal({{ $booking->id }})">
                            Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center;">No bookings found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div>
        <div class="pagination-wrapper">
            {{ $bookings->links() }}
        </div>
    </div>

</div>

<!-- Delete Modal -->
<div id="deleteModal" class="modal-overlay" style="display:none;">
    <div class="modal-box">

        <h3>Delete Booking</h3>

        <p>
            Are you sure you want to delete this booking?
            This action cannot be undone.
        </p>

        <div class="modal-actions">

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn-delete">
                    Delete
                </button>

                <button type="button" class="btn-cancel" onclick="closeDeleteModal()">
                    Cancel
                </button>

            </form>

        </div>

    </div>
</div>
<script>

function openDeleteModal(id)
{
    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');

    form.action = "/staff/bookings/" + id;

    modal.style.display = "flex";
}

function closeDeleteModal()
{
    document.getElementById('deleteModal').style.display = "none";
}

</script>

@endsection