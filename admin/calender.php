<?php

include '../config/db/connect.php';
include '../config/functions.php';


$query = "SELECT rb.room_id, b.checkin_date, b.checkout_date, b.id as booking_id FROM room_booking rb INNER JOIN booking b ON rb.booking_id = b.id";
$result = $mysqli->query($query);

$bookings = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Calendar</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
        }
        .day {
            border: 1px solid #ddd;
            padding: 10px;
            position: relative;
            min-height: 100px;
        }
        .booking-bar {
            position: absolute;
            top: 5px;
            left: 5px;
            right: 5px;
            height: 20px;
            background-color: rgba(0, 123, 255, 0.7);
            color: white;
            text-align: center;
            font-size: 12px;
            border-radius: 5px;
            cursor: pointer;
        }
        .booking-bar:hover {
            background-color: rgba(0, 123, 255, 0.9);
        }
        .calendar-navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .calendar-navigation button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .calendar-navigation button:hover {
            background-color: #0056b3;
        }
        .calendar-navigation .month-year {
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>
<body style="padding-top: 85px;">
    <?php include '../config/page/adminHeader.php'; ?>

    <h1 style="margin-top: 85px;">Booking Calendar</h1>     
    <div class="calendar-navigation">
        <button id="prevMonth">Previous</button>
        <div class="month-year" id="monthYear"></div>
        <button id="nextMonth">Next</button>
    </div>
    <div id="calendar" class="calendar"></div>
 
    <script>
        const bookings = <?php echo json_encode($bookings); ?>;
        const rooms = 6;
        const calendar = document.getElementById('calendar');
        const monthYear = document.getElementById('monthYear');
        const prevMonth = document.getElementById('prevMonth');
        const nextMonth = document.getElementById('nextMonth');

        let currentDate = new Date();

        function parseDate(dateString) {
            
            const parts = dateString.split('-');
            return new Date(parts[0], parts[1] - 1, parts[2]);
        }

        function generateCalendar(date) {
            calendar.innerHTML = '';
            const startDate = new Date(date.getFullYear(), date.getMonth(), 1);
            const endDate = new Date(date.getFullYear(), date.getMonth() + 1, 0);

            monthYear.textContent = `${startDate.toLocaleString('default', { month: 'long' })} ${startDate.getFullYear()}`;

            for (let d = new Date(startDate); d <= endDate; d.setDate(d.getDate() + 1)) {
                const dayDiv = document.createElement('div');
                dayDiv.className = 'day';
                dayDiv.innerHTML = `<strong>${d.getDate()}</strong>`;
                dayDiv.style.position = 'relative'; 

                let barOffset = 30; 
                bookings.forEach(booking => {
                    const checkIn = parseDate(booking.checkin_date);
                    const checkOut = parseDate(booking.checkout_date);

                    if (d >= checkIn && d <= checkOut) {
                        const bar = document.createElement('div');
                        bar.className = 'booking-bar';
                        bar.style.top = `${barOffset}px`; 
                        bar.innerText = `Room ${booking.room_id}`;
                        bar.onclick = () => {
                            window.location.href = `booking.php?id=${booking.booking_id}`;
                        };
                        dayDiv.appendChild(bar);
                        barOffset += 25; 
                    }
                });

                calendar.appendChild(dayDiv);
            }
        }

        prevMonth.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            generateCalendar(currentDate);
        });

        nextMonth.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            generateCalendar(currentDate);
        });

        generateCalendar(currentDate);
    </script>
</body>
</html>