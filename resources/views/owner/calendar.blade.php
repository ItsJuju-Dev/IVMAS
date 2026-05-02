@extends('layouts.owner')

@section('content')

<h2 class="page-title">Booking Calendar</h2>

<div class="card">
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
        height: 600,
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