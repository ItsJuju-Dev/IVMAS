@extends('layouts.staff')

@section('content')

<style>

/* ================= SUCCESS ALERT ================= */

.alert-success
{
    background:#DCFCE7;
    color:#166534;

    padding:14px 18px;

    border-radius:14px;

    margin-bottom:24px;

    border:1px solid #BBF7D0;

    font-weight:600;
}

/* ================= PAGE HEADER ================= */

.page
{
    width:100%;
}

.page-header
{
    display:flex;

    justify-content:space-between;

    align-items:flex-start;

    margin-bottom:32px;

    gap:20px;
}

.page-header h1
{
    margin:0;

    font-size:54px;

    color:#4A3728;
}

/* ================= CARD ================= */

.card
{
    background:#F9F5EC;

    border-radius:28px;

    padding:24px;

    border:1px solid #E8DDCC;

    box-shadow:
        0 10px 30px rgba(74,55,40,0.05);
}

/* ================= BUTTONS ================= */

.btn
{
    border:none;

    cursor:pointer;

    text-decoration:none;

    display:inline-flex;

    align-items:center;

    justify-content:center;

    font-weight:600;

    transition:0.2s ease;
}

.btn-add
{
    background:#8B5E3C;

    color:white;

    padding:12px 22px;

    border-radius:14px;

    font-size:15px;
}

.btn-add:hover
{
    background:#6F4A2F;
}

.action-buttons
{
    display:flex;

    gap:10px;

    align-items:center;
}

.edit-btn
{
    background:#8B5E3C;

    color:white;

    padding:10px 18px;

    border-radius:12px;

    text-decoration:none;

    font-size:14px;

    font-weight:600;

    border:none;
}

.edit-btn:hover
{
    background:#6F4A2F;
}

.delete-btn
{
    background:#A47148;

    color:white;

    padding:10px 18px;

    border:none;

    border-radius:12px;

    font-size:14px;

    font-weight:600;

    cursor:pointer;
}

.delete-btn:hover
{
    background:#8C5C36;
}

/* ================= TABLE ================= */

.booking-table
{
    width:100%;

    border-collapse:collapse;
}

.booking-table thead
{
    background:#EFE7DB;
}

.booking-table th
{
    padding:18px 16px;

    text-align:left;

    font-size:15px;

    color:#4A3728;
}

.booking-table td
{
    padding:18px 16px;

    border-bottom:1px solid #E8DDCC;

    color:#5B4332;
}

/* ================= STATUS BADGES ================= */

.status
{
    padding:6px 12px;

    border-radius:999px;

    font-size:13px;

    font-weight:700;
}

.status.pending
{
    background:#FEF3C7;
    color:#92400E;
}

.status.confirmed
{
    background:#DBEAFE;
    color:#1D4ED8;
}

.status.checked_in
{
    background:#DCFCE7;
    color:#166534;
}

.status.cancelled
{
    background:#FEE2E2;
    color:#B91C1C;
}

/* ================= PAGINATION ================= */

.pagination-wrapper
{
    margin-top:32px;

    display:flex;

    justify-content:center;
}

.pagination-wrapper nav
{
    display:flex;

    align-items:center;

    gap:8px;

    flex-wrap:wrap;
}

/* Hide mobile pagination buttons */

.pagination-wrapper nav > div:first-child
{
    display:none;
}

.pagination-wrapper svg
{
    width:18px !important;
    height:18px !important;
}

.pagination-wrapper a,
.pagination-wrapper span
{
    display:flex;

    align-items:center;
    justify-content:center;

    min-width:38px;
    height:38px;

    padding:0 14px;

    border-radius:12px;

    text-decoration:none;

    font-size:14px;

    font-weight:600;
}

.pagination-wrapper a
{
    background:#F9F5EC;

    border:1px solid #DDD2BF;

    color:#5B4332;
}

.pagination-wrapper a:hover
{
    background:#EFE7DB;
}

.pagination-wrapper .active span
{
    background:#8B5E3C;

    color:white;

    border:none;
}

.pagination-wrapper p
{
    display:none;
}

/* ================= MODAL ================= */

.modal-overlay
{
    position:fixed;

    top:0;
    left:0;

    width:100%;
    height:100%;

    background:rgba(0,0,0,0.45);

    display:flex;

    align-items:center;

    justify-content:center;

    z-index:999;
}

.modal-box
{
    background:#F9F5EC;

    padding:32px;

    border-radius:24px;

    width:420px;

    box-shadow:
        0 20px 50px rgba(0,0,0,0.18);
}

.modal-box h3
{
    margin-top:0;

    color:#4A3728;
}

.modal-box p
{
    color:#7A6855;

    line-height:1.6;
}

.modal-actions
{
    margin-top:24px;

    display:flex;

    gap:12px;
}

.btn-cancel
{
    background:#D6CCBE;

    color:#4A3728;

    border:none;

    padding:10px 18px;

    border-radius:12px;

    cursor:pointer;

    font-weight:600;
}

.btn-cancel:hover
{
    background:#C7B9A6;
}

</style>

<div class="page">

    <!-- PAGE HEADER -->
    <div class="page-header">

        <div>
            <h1>Manage Bookings</h1>
        </div>

        <a href="{{ route('staff.bookings.create') }}"
           class="btn btn-add">
            Add Booking
        </a>

    </div>

    @if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- TABLE CARD -->
    <div class="card">

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

                        <div class="action-buttons">

                            <a href="{{ route('staff.bookings.edit', $booking) }}"
                               class="edit-btn">
                                Edit
                            </a>

                            <form action="{{ route('staff.bookings.destroy', $booking) }}"
                                  method="POST"
                                  style="display:inline;">

                                @csrf
                                @method('DELETE')

                                <button type="button"
                                        class="delete-btn"
                                        onclick="openDeleteModal({{ $booking->id }})">
                                    Delete
                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="8" style="text-align:center;">
                        No bookings found.
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

        <div class="pagination-wrapper">
            {{ $bookings->links('pagination::tailwind') }}
        </div>

    </div>

</div>

<!-- DELETE MODAL -->
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

                <button type="submit" class="delete-btn">
                    Delete
                </button>

                <button type="button"
                        class="btn-cancel"
                        onclick="closeDeleteModal()">
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