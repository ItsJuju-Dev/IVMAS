<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Calendar UI</title>

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        #calendar {
            max-width: 1100px;
            margin: auto;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">Calendar Interface (UI Only)</h2>

<div id="calendar"></div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView: 'dayGridMonth',

        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },

        selectable: true,
        editable: true,

        select(info) {
            const title = prompt('Event title:');
            if (!title) return;

            calendar.addEvent({
                title: title,
                start: info.start,
                end: info.end,
                allDay: info.allDay
            });
        },

        eventClick(info) {
            if (confirm(`Delete event "${info.event.title}"?`)) {
                info.event.remove();
            }
        }
    });

    calendar.render();
});
</script>

</body>
</html>