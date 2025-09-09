<?php
// Get current day and date
$current_day = date('l'); // Full day name (e.g., Monday, Tuesday)
$current_date = date('j/n/Y'); // Date format: 8/9/2025
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CDN & CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    
    <link rel="stylesheet" href="./assets/css/navbar.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-body-white">
        <div class="container-fluid">
            <a class="navbar-brand logo" href="#">Taskati</a>
            <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button> -->

            <div class="date_container">
                <p class="day" id="currentDay"><?php echo $current_day; ?></p>
                <p class="date" id="currentDate"><?php echo $current_date; ?></p>
            </div>
        </div>
    </nav>

    <!-- JavaScript to update the date/time dynamically -->
    <script>
        function updateDateTime() {
            const now = new Date();
            
            // Get day names
            const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const currentDay = days[now.getDay()];
            
            // Get current date in format: d/m/yyyy
            const day = now.getDate();
            const month = now.getMonth() + 1; // Months are 0-indexed
            const year = now.getFullYear();
            const currentDate = `${day}/${month}/${year}`;
            
            // Update the DOM elements
            const dayElement = document.getElementById('currentDay');
            const dateElement = document.getElementById('currentDate');
            
            if (dayElement) {
                dayElement.textContent = currentDay;
            }
            
            if (dateElement) {
                dateElement.textContent = currentDate;
            }
        }
        
        // Update immediately when page loads
        document.addEventListener('DOMContentLoaded', updateDateTime);
        
        // Update every minute (60000 milliseconds)
        setInterval(updateDateTime, 60000);
        
        // Update when the page becomes visible again (user switches tabs)
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) {
                updateDateTime();
            }
        });
    </script>

    <!-- Bootstrap CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

</body>

</html>