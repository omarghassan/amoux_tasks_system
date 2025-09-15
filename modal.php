<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/modal.css">
</head>

<body>
    <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal_header">
                        <p class="modal_title simple-line" id="modalTitle">Add Task</p>
                        <a class="back_btn" href="./dashboard.php">Go Back</a>
                    </div>

                    <div class="modal_content">
                        <form id="addTaskForm">
                            <!-- Hidden field to store task ID for edit mode -->
                            <input type="hidden" id="taskId" name="task_id" value="">
                            
                            <div class="form_group">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" id="title" name="title" class="form-input" required>
                            </div>

                            <div class="form_group">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" id="date" name="date" class="form-input" required>
                            </div>

                            <div class="form_group">
                                <label for="priority" class="form-label">Priority</label>

                                <div class="priority_options">
                                    <div class="priority_group">
                                        <label for="extreme">Extreme</label>
                                        <input type="radio" id="extreme" name="priority" value="extreme" required>
                                    </div>

                                    <div class="priority_group">
                                        <label for="moderate">Moderate</label>
                                        <input type="radio" id="moderate" name="priority" value="moderate" required>
                                    </div>

                                    <div class="priority_group">
                                        <label for="low">Low</label>
                                        <input type="radio" id="low" name="priority" value="low" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form_group">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-input description_input"
                                    placeholder="Start writing here..." required></textarea>
                            </div>
                        </form>
                    </div>

                    <div class="modal_footer">
                        <button type="submit" form="addTaskForm" class="add_task_btn" id="submitBtn">Done</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="module" src="./assets/js/task_modal.js"></script>
</body>

</html>