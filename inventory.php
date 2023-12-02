<!DOCTYPE html>
<html>

<head>
    <title>Option Page</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Styles for the calendar */
        #calendar {
            font-family: Arial, sans-serif;
            position: absolute;
            width: 90%;
            /* Adjust based on your preference */
            max-width: 800px;
            /* Set a maximum width if needed */
            height: auto%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 10px;
        }

        .month {
            text-align: center;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            font-weight: bold;
            color: white;
            position: relative;
        }

        .month button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            padding: 5px 10px;
            cursor: pointer;
            background-color: #48bc94;
            color: white;
            border: none;
        }

        .nextMonth {
            right: 10px;
            height: 50px;
            width: 70px;
            background-color: transparent !important;
            background-image: url(images/next.png);
            background-repeat: no-repeat;
        }
        .prevMonth{
            height: 50px;
            width: 70px;
            left: 10px;
            background-color: transparent !important;
            background-image: url(images/prev.png);
            background-repeat: no-repeat;
        }
        .weekdays {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .weekdays div {
            width: 20.28%;
            height: 70px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #48bc94;
            border: 1px solid white;
            font-size: 40px;
            font-weight: bold;
            color: white;
        }

        .days {
            display: flex;
            flex-wrap: wrap;
        }

        .days div {
            width: 14.28%;
            height: 80px;
            text-align: center;
            padding: 5px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #aecfb8;
            border: 1px solid white;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }
        .days div:hover {
color: white;
        }

        @media screen and (max-width: 600px) {
            #calendar {
                width: 95%;
                /* Adjust width for smaller screens */
                max-width: none;
                /* Remove max-width */
            }

            /* Adjust other styles for smaller screens as needed */
        }
    </style>

</head>

<body>
    <div id="calendar"></div>

    <script>
        function fetchDataForDate(selectedDate) {
    fetch('checkout_date.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ selectedDate }),
    })
    .then(response => response.text()) // Receive response as text
    .then(data => {
        // Update the content of the current page with the fetched data
        document.open(); // Clear the current document
        document.write(data); // Write the fetched data to the document
        document.close(); // Close the document write operation
    })
    .catch(error => {
        console.error('Error:', error);
    });
}


        // Function to create a simple calendar
        function createCalendar(year, month) {
            const calendar = document.getElementById('calendar');
            const date = new Date(year, month);

            const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const firstDayIndex = date.getDay();

            let output = `
        <div class="month">
            <button class="prevMonth" id="prevMonth"></button>
            ${monthNames[month]} ${year}
            <button class="nextMonth" id="nextMonth"></button>
        </div>
        <div class="weekdays">
            <div>S</div>
            <div>M</div>
            <div>T</div>
            <div>W</div>
            <div>T</div>
            <div>F</div>
            <div>S</div>
        </div>
        <div class="days">
    `;

            for (let i = 0; i < firstDayIndex; i++) {
                output += `<div></div>`;
            }

            for (let i = 1; i <= daysInMonth; i++) {
                output += `<div class="calendar-day" data-date="${year}-${month + 1}-${i}">${i}</div>`;
            }

            output += `</div>`;
            calendar.innerHTML = output;

            // Previous month button functionality
            document.getElementById('prevMonth').addEventListener('click', () => {
                date.setMonth(date.getMonth() - 1);
                createCalendar(date.getFullYear(), date.getMonth());
            });

            // Next month button functionality
            document.getElementById('nextMonth').addEventListener('click', () => {
                date.setMonth(date.getMonth() + 1);
                createCalendar(date.getFullYear(), date.getMonth());
            });

            // Add event listener for each day to log the clicked date
            const days = document.querySelectorAll('.calendar-day');
            days.forEach(day => {
                day.addEventListener('click', () => {
                    const clickedDate = day.getAttribute('data-date');
                    fetchDataForDate(clickedDate);
                    console.log('Clicked date:', clickedDate);
                });
            });
        }

        // Display the current month's calendar
        const currentDate = new Date();
        createCalendar(currentDate.getFullYear(), currentDate.getMonth());
    </script>
</body>

</html>
