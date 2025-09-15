import { callApi, showUserMessage } from './api_calls.js';

// Modal mode state
let currentMode = 'add'; // 'add' or 'edit'
let currentTaskData = null;

// Wait for DOM to load
document.addEventListener('DOMContentLoaded', function() {
    initializeTaskModal();
});

function initializeTaskModal() {
    const form = document.getElementById('addTaskForm');
    const modal = document.getElementById('addTaskModal');
    
    if (!form || !modal) {
        console.error('Task modal form or modal element not found');
        return;
    }

    // Handle form submission
    form.addEventListener('submit', handleFormSubmit);
    
    // Handle modal reset when it's closed
    modal.addEventListener('hidden.bs.modal', resetModalToAddMode);
    
    // Make functions globally available
    window.openEditModal = openEditModal;
}

async function handleFormSubmit(e) {
    e.preventDefault();

    // Get form data
    const formData = new FormData(e.target);
    const taskData = {
        title: formData.get('title'),
        date: formData.get('date'),
        priority: formData.get('priority'),
        description: formData.get('description')
    };

    // Add task_id for edit mode
    if (currentMode === 'edit' && formData.get('task_id')) {
        taskData.task_id = parseInt(formData.get('task_id'));
    }

    // Validate that all fields are filled
    if (!taskData.title || !taskData.date || !taskData.priority || !taskData.description) {
        showUserMessage('Please fill in all fields', 'error');
        return;
    }

    // Get submit button reference
    const submitBtn = document.getElementById('submitBtn');
    const originalText = submitBtn.textContent;

    try {
        // Disable the submit button to prevent double submission
        submitBtn.disabled = true;
        submitBtn.textContent = currentMode === 'edit' ? 'Updating...' : 'Adding...';

        // Call the appropriate API
        const apiEndpoint = currentMode === 'edit' ? 'edit_task' : 'add_task';
        const response = await callApi(apiEndpoint, taskData);

        if (response.success) {
            const successMessage = currentMode === 'edit' ? 'Task updated successfully!' : 'Task added successfully!';
            showUserMessage(successMessage, 'success');

            // Reset the form
            e.target.reset();
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('addTaskModal'));
            modal.hide();

            // Refresh the dashboard tasks
            if (typeof window.refreshTasks === 'function') {
                setTimeout(() => {
                    window.refreshTasks();
                }, 500);
            } else {
                // Fallback: reload the page
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            }
        }

    } catch (error) {
        console.error('Error with task operation:', error);
        const errorMessage = currentMode === 'edit' ? 'Failed to update task' : 'Failed to add task';
        showUserMessage(errorMessage + '. Please try again.', 'error');
    } finally {
        // Re-enable the submit button
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    }
}

// Function to open modal in edit mode
function openEditModal(taskData) {
    currentMode = 'edit';
    currentTaskData = taskData;
    
    // Update modal title and button text
    document.getElementById('modalTitle').textContent = 'Edit Task';
    document.getElementById('submitBtn').textContent = 'Update Task';
    
    // Populate form with task data
    populateFormWithTaskData(taskData);
    
    // Show the modal
    const modal = new bootstrap.Modal(document.getElementById('addTaskModal'));
    modal.show();
}

// Function to populate form with existing task data
function populateFormWithTaskData(taskData) {
    // Set hidden task ID
    document.getElementById('taskId').value = taskData.id || '';
    
    // Set form fields
    document.getElementById('title').value = taskData.title || '';
    document.getElementById('date').value = taskData.date || '';
    document.getElementById('description').value = taskData.description || '';
    
    // Set priority radio button
    if (taskData.priority) {
        const priorityRadio = document.querySelector(`input[name="priority"][value="${taskData.priority}"]`);
        if (priorityRadio) {
            priorityRadio.checked = true;
        }
    }
}

// Function to reset modal to add mode
function resetModalToAddMode() {
    currentMode = 'add';
    currentTaskData = null;
    
    // Reset modal title and button text
    document.getElementById('modalTitle').textContent = 'Add Task';
    document.getElementById('submitBtn').textContent = 'Done';
    
    // Clear hidden task ID
    document.getElementById('taskId').value = '';
    
    // Clear form (this should already be done by form.reset(), but just in case)
    document.getElementById('addTaskForm').reset();
}

// Export functions for global access
export { openEditModal, resetModalToAddMode };