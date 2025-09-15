<?php
// Include session check at the top
require_once('session_check.php');
require_once('navbar.php');
require_once('sidebar.php');
require_once('modal.php')
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- ========== CSS ========== -->
    <link rel="stylesheet" href="./assets/css/dashboard.css">

    <!-- ========== Icons CDN ========== -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />

    <!-- ========== Bootstrap CDN========== -->
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

            <button type="button" class="btn btn-outline-danger add_task_button" data-bs-toggle="modal"
                data-bs-target="#addTaskModal">Add Task</button>
        </div>

        <div class="tasks_container">
            <!-- To-Do Tasks Section -->
            <div class="to_do_tasks">
                <div class="to_do_tasks_header">
                    <div class="to_do_title_container">
                        <img class="task_icon" src="./assets/images/to_do_task.png" alt="To Do Task Icon">
                        <p class="to_do_title">To-Do</p>
                    </div>

                    <div>
                        <button type="button" class="btn add_task_btn_small" data-bs-toggle="modal"
                            data-bs-target="#addTaskModal">
                            <i class="ri-add-line add_icon"></i> Add task
                        </button>
                    </div>
                </div>

                <!-- To-Do Tasks Container - JS will populate multiple of these -->
                <div id="todoTasksContainer">
                    <!-- Template/Loading state - will be replaced by JS -->
                    <div class="task_details_container">
                        <div class="task_details_header">
                            <p class="task_title">Loading tasks...</p>
                            <!-- Status Dropdown Template -->
                            <div class="dropdown d-inline-block ms-1">
                                <button class="btn btn-link p-0 border-0 lh-1 status-dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false" data-task-id=""
                                    data-current-status="">
                                    <i class="ri-more-fill"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end status-dropdown-menu">
                                    <li>
                                        <p class="dropdown_header">Task</p>
                                    </li>
                                    <li>
                                        <button
                                            class="dropdown-item status-dropdown-item d-flex align-items-center menu_status_not_started"
                                            type="button" data-status="not_started">
                                            Not Started
                                        </button>
                                    </li>
                                    <li>
                                        <button
                                            class="dropdown-item status-dropdown-item d-flex align-items-center menu_status_in_progress"
                                            type="button" data-status="in_progress">
                                            In Progress
                                        </button>
                                    </li>
                                    <li>
                                        <button
                                            class="dropdown-item status-dropdown-item d-flex align-items-center menu_status_completed"
                                            type="button" data-status="completed">
                                            Completed
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <p class="task_description">Please wait while we fetch your tasks.</p>
                        <div class="task_info">
                            <p class="task_priority">Priority: <span class="priority_value">-</span></p>
                            <p class="task_status">
                                Status: <span class="status_value">-</span>
                            </p>
                            <p class="task_date">Created on: -</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tasks_status_container">
                <!-- Task Status Widget -->
                <div class="task-status-widget">
                    <div class="widget-header">
                        <img class="task_status_image" src="./assets/images/task_status.png" alt="Task Status Image">
                        <h3 class="widget-title">Task Status</h3>
                    </div>

                    <div class="status-circles">
                        <div class="status-item completed">
                            <div class="circle-container">
                                <div class="circle-bg"></div>
                                <div class="circle-progress" style="--progress-deg: 0deg;">
                                    <span class="percentage">0%</span>
                                </div>
                            </div>
                            <div class="status-label">
                                <div class="status-dot"></div>
                                <span>Completed</span>
                            </div>
                        </div>

                        <div class="status-item in-progress">
                            <div class="circle-container">
                                <div class="circle-bg"></div>
                                <div class="circle-progress" style="--progress-deg: 0deg;">
                                    <span class="percentage">0%</span>
                                </div>
                            </div>
                            <div class="status-label">
                                <div class="status-dot"></div>
                                <span>In Progress</span>
                            </div>
                        </div>

                        <div class="status-item not-started">
                            <div class="circle-container">
                                <div class="circle-bg"></div>
                                <div class="circle-progress" style="--progress-deg: 0deg;">
                                    <span class="percentage">0%</span>
                                </div>
                            </div>
                            <div class="status-label">
                                <div class="status-dot"></div>
                                <span>Not Started</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Completed Tasks Section -->
                <div class="completed_tasks">
                    <div class="completed_tasks_header">
                        <div class="completed_title_container">
                            <img class="task_icon" src="./assets/images/completed_task.png" alt="Completed Task Icon">
                            <p class="completed_title">Completed Tasks</p>
                        </div>
                    </div>

                    <!-- Completed Tasks Container - JS will populate these -->
                    <div id="completedTasksContainer">
                        <!-- Template/Loading state - will be replaced by JS -->
                        <div class="completed_task_item">
                            <div class="completed_task_content">
                                <div class="task_details_header">
                                    <p class="completed_task_title">Loading completed tasks...</p>
                                    <!-- Status Dropdown Template -->
                                    <div class="dropdown d-inline-block ms-1">
                                        <button class="btn btn-link p-0 border-0 lh-1 status-dropdown-toggle"
                                            type="button" data-bs-toggle="dropdown" aria-expanded="false"
                                            data-task-id="" data-current-status="">
                                            <i class="ri-more-fill"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end status-dropdown-menu">
                                            <li>
                                                <p>Task</p>
                                            </li>
                                            <li>
                                                <button
                                                    class="dropdown-item status-dropdown-item d-flex align-items-center menu_status_not_started"
                                                    type="button" data-status="not_started">
                                                    Not Started
                                                </button>
                                            </li>
                                            <li>
                                                <button
                                                    class="dropdown-item status-dropdown-item d-flex align-items-center menu_status_in_progress"
                                                    type="button" data-status="in_progress">
                                                    In Progress
                                                </button>
                                            </li>
                                            <li>
                                                <button
                                                    class="dropdown-item status-dropdown-item d-flex align-items-center menu_status_completed"
                                                    type="button" data-status="completed">
                                                    Completed
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <p class="completed_task_description">Please wait...</p>
                                <p class="completed_task_date">Status: Loading</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

    <!-- Load tasks JavaScript -->
    <script src="./assets/js/dashboard.js"></script>
</body>

</html>