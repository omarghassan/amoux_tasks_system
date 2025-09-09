<?php
// Include session check at the top
require_once('session_check.php');
require_once('navbar.php');
require_once('sidebar.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link rel="stylesheet" href="./assets/css/dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <section class="main_content">

        <div class="welcome_container">
            <h3 class="welcome_text">
                Welcome back, <?php echo htmlspecialchars(getFirstName($current_user['name'])); ?> 
                <img class="handwave_img" src="./assets/images/handwave.png" alt="handwave image">
            </h3>

            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#addTaskModal">Add task</button>
        </div>

        <!-- Hidden data for JavaScript access -->
        <script>
            // Make user data available to JavaScript
            window.currentUser = <?php echo json_encode($current_user); ?>;
        </script>

    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>