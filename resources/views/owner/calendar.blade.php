@extends('layouts.owner')

@section('content')

<style>

/* ================= HEADER ================= */

.section-header {
    margin-bottom: 36px;
}

.section-header h2 {
    margin: 0;

    font-size: 54px;

    color: #4A3728;
}

.section-header p {
    margin-top: 10px;

    color: #7A6855;

    font-size: 16px;
}

/* ================= CALENDAR CARD ================= */

.card
{
    background:#F9F5EC;

    border-radius:28px;

    padding:24px;

    border:1px solid #E8DDCC;

    box-shadow:
        0 10px 30px rgba(74,55,40,0.05);
}

/* ================= FULLCALENDAR ================= */

.fc
{
    color:#4A3728;
}

.fc-toolbar-title
{
    font-size:32px !important;

    font-weight:700;
}

.fc .fc-button
{
    background:#8b5e3c !important;

    border:none !important;

    border-radius:14px !important;

    padding:10px 16px !important;

    font-weight:600 !important;

    box-shadow:none !important;

    transition:0.2s ease;
}

/* LEFT SIDE BUTTONS */
.fc .fc-toolbar-chunk:first-child
{
    display:flex;
    align-items:center;
    gap:10px;
}

/* RIGHT SIDE BUTTONS */
.fc .fc-toolbar-chunk:last-child
{
    display:flex;
    align-items:center;
    gap:10px;
}

/* Fix grouped buttons sticking together */
.fc .fc-button-group
{
    display:flex;
    gap:6px;
}

.fc .fc-button:hover
{
    background:#6f472c !important;
}

.fc .fc-button-active
{
    background:#4A3728 !important;
}

.fc-theme-standard td,
.fc-theme-standard th
{
    border-color:#DDD2BF;
}

.fc-scrollgrid
{
    border-color:#DDD2BF !important;
}

.fc-daygrid-day
{
    background:#FDF9F2;
}

.fc-col-header-cell
{
    background:#F5EEDD;
}

.fc-day-today
{
    background:#EFE5D6 !important;
}

/* ================= EVENTS ================= */

.fc-event
{
    border:none !important;

    border-radius:8px !important;

    padding:2px 6px !important;

    font-size:12px !important;

    font-weight:600;

    cursor:pointer;
}

/* ================= MODAL ================= */

.calendar-modal-overlay
{
    position: fixed;

    top:0;
    left:0;

    width:100%;
    height:100%;

    background: rgba(0,0,0,0.45);

    display:flex;

    align-items:center;

    justify-content:center;

    z-index:9999;
}

.calendar-modal-box
{
    background:#F9F5EC;

    padding:32px;

    border-radius:24px;

    width:420px;

    box-shadow:
        0 10px 30px rgba(74,55,40,0.18);

    color:#4A3728;
}

.calendar-modal-box h3
{
    margin-top:0;

    margin-bottom:20px;

    font-size:28px;
}

.calendar-modal-actions
{
    margin-top:24px;

    display:flex;

    justify-content:center;
}

.calendar-modal-actions button
{
    background:#8b5e3c;

    color:white;

    border:none;

    padding:10px 18px;

    border-radius:14px;

    font-weight:600;

    cursor:pointer;

    transition:0.2s ease;
}

.calendar-modal-actions button:hover
{
    background:#6f472c;
}

.calendar-hidden
{
    display:none;
}

.calendar-card,
.calendar-card:hover
{
    transform:none !important;
    translate:none !important;

    box-shadow:none !important;

    transition:none !important;

    border-color:#e5dccf !important;
}
</style>

<h2 class="page-title font-bold"
    style="font-family: 'Poppins', sans-serif;">Booking Calendar</h2>

<div class="card calendar-card">
    <div id="calendar"></div>
</div>

<div id="bookingModal" class="calendar-modal-overlay calendar-hidden">
    <div class="calendar-modal-box">

        <h3>Booking Details</h3>

        <!--  NEW: dynamic content -->
        <div id="modalContent"></div>

        <div class="calendar-modal-actions">
            <button onclick="closeModal()">Close</button>
        </div>

    </div>
</div>

@endsection


@section('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    function formatStatus(status) {
        return status
            .replace('_', ' ')
            .replace(/\b\w/g, l => l.toUpperCase());
    }

    //  SINGLE BOOKING VIEW
    function openSingleBooking(event) {
        let data = event.extendedProps;

        document.getElementById('modalContent').innerHTML = `
            <p><strong>Guest:</strong> ${data.guest}</p>
            <p><strong>Room:</strong> ${data.room}</p>
            <p><strong>Dates:</strong> ${event.startStr} → ${event.endStr ?? event.startStr}</p>
            <p><strong>Status:</strong> ${formatStatus(data.status)}</p>
        `;

        document.getElementById('bookingModal')
            .classList.remove('calendar-hidden');
    }

    //  MULTIPLE BOOKINGS VIEW
    function openMultipleBookings(events) {

        let html = '';

        events.forEach(event => {
            let data = event.extendedProps;

            html += `
                <div style="margin-bottom:15px; padding-bottom:10px; border-bottom:1px solid #ddd;">
                    <p><strong>Guest:</strong> ${data.guest}</p>
                    <p><strong>Room:</strong> ${data.room}</p>
                    <p><strong>Dates:</strong> ${event.startStr} → ${event.endStr ?? event.startStr}</p>
                    <p><strong>Status:</strong> ${formatStatus(data.status)}</p>
                </div>
            `;
        });

        document.getElementById('modalContent').innerHTML = html;

        document.getElementById('bookingModal')
            .classList.remove('calendar-hidden');
    }

    //  EMPTY DATE
    function openEmptyDate(date) {
        document.getElementById('modalContent').innerHTML = `
            <p><strong>Date:</strong> ${date}</p>
            <p><strong>Status:</strong> No Booking</p>
        `;

        document.getElementById('bookingModal')
            .classList.remove('calendar-hidden');
    }

    let calendarEl = document.getElementById('calendar');

    let calendar = new FullCalendar.Calendar(calendarEl, {

        initialView: 'dayGridMonth',
        height: 700,
        expandRows: true,

        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },

        //  CLICK DATE (MULTI SUPPORT)
        dateClick: function(info) {

            let clickedDate = info.dateStr;
            let events = calendar.getEvents();

            let matchedEvents = events.filter(event => {
                let start = event.startStr;
                let end = event.endStr ?? event.startStr;

                return clickedDate >= start && clickedDate < end;
            });

            if (matchedEvents.length === 0) {
                openEmptyDate(clickedDate);
            }
            else if (matchedEvents.length === 1) {
                openSingleBooking(matchedEvents[0]);
            }
            else {
                openMultipleBookings(matchedEvents);
            }
        },

        //  CLICK EVENT
        eventClick: function(info) {
            openSingleBooking(info.event);
        },

        events: @json($events)

    });

    calendar.render();

});

function closeModal() {
    document.getElementById('bookingModal')
        .classList.add('calendar-hidden');
}
</script>

@endsection