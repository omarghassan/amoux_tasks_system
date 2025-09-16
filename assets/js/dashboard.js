// Load tasks when page loads
document.addEventListener('DOMContentLoaded', function() {
    loadTasks();
});

async function loadTasks() {
    try {
        const response = await fetch('./api/get_tasks.php');
        const data = await response.json();
        
        if (data.success) {
            populateTasksInHTML(data.data.tasks);
            // Update the status widget with real stats
            updateTaskStatusCircles(data.data.stats);
            console.log('Task Stats:', data.data.stats);
        } else {
            showError('Failed to load tasks: ' + data.message);
        }
    } catch (error) {
        console.error('Error loading tasks:', error);
        showError('Error loading tasks. Please refresh the page.');
    }
}

function populateTasksInHTML(tasks) {
    // Filter tasks by status
    const todoTasks = tasks.filter(task => 
        task.task_status === 'not_started' || task.task_status === 'in_progress'
    );
    const completedTasks = tasks.filter(task => task.task_status === 'completed');
    
    populateToDoSection(todoTasks);
    populateCompletedSection(completedTasks);
}

function populateToDoSection(todoTasks) {
    const container = document.getElementById('todoTasksContainer');
    
    if (todoTasks.length === 0) {
        // Show empty state - keep existing HTML structure but update content
        const emptyTask = container.querySelector('.task_details_container');
        if (emptyTask) {
            emptyTask.querySelector('.task_title').textContent = 'No tasks yet';
            emptyTask.querySelector('.task_description').textContent = 'Create your first task to get started!';
            emptyTask.querySelector('.priority_value').textContent = '-';
            emptyTask.querySelector('.status_value').textContent = '-';
            emptyTask.querySelector('.task_date').textContent = 'Created on: -';
            // Hide the dropdown for empty state
            emptyTask.querySelector('.dropdown').style.display = 'none';
        }
        return;
    }
    
    // Clone the template for each task
    const template = container.querySelector('.task_details_container');
    container.innerHTML = ''; // Clear loading state
    
    todoTasks.forEach(task => {
        // Clone the template
        const taskElement = template.cloneNode(true);
        
        // Set task ID on container
        taskElement.setAttribute('data-task-id', task.id);
        
        // Populate task data
        taskElement.querySelector('.task_title').textContent = task.title;
        taskElement.querySelector('.task_description').textContent = task.description;
        taskElement.querySelector('.priority_value').textContent = capitalizeFirst(task.priority);
        taskElement.querySelector('.priority_value').style.color = getPriorityColor(task.priority);
        taskElement.querySelector('.status_value').textContent = getStatusText(task.task_status);
        taskElement.querySelector('.status_value').style.color = getStatusColor(task.task_status);
        taskElement.querySelector('.task_date').textContent = 'Created on: ' + formatDate(task.created_at);
        
        // Set dropdown data attributes
        const dropdownToggle = taskElement.querySelector('.status-dropdown-toggle');
        dropdownToggle.setAttribute('data-task-id', task.id);
        dropdownToggle.setAttribute('data-current-status', task.task_status);
        
        // Set edit button data attributes
        const editButton = taskElement.querySelector('.edit-task-item');
        if (editButton) {
            editButton.setAttribute('data-task-id', task.id);
            editButton.setAttribute('data-task-data', JSON.stringify(task));
        }
        
        // Set delete button data attributes
        const deleteButton = taskElement.querySelector('.delete-task-item');
        if (deleteButton) {
            deleteButton.setAttribute('data-task-id', task.id);
            deleteButton.setAttribute('data-task-title', task.title);
        }
        
        // Show the dropdown
        taskElement.querySelector('.dropdown').style.display = 'inline-block';
        
        container.appendChild(taskElement);
    });
    
    // Initialize dropdown functionality for all new elements
    initializeStatusDropdowns();
    initializeEditButtons();
    initializeDeleteButtons();
}

// Initialize edit buttons functionality
function initializeEditButtons() {
    // Remove existing listeners to avoid duplicates
    document.querySelectorAll('.edit-task-item').forEach(button => {
        button.removeEventListener('click', handleEditTask);
        button.addEventListener('click', handleEditTask);
    });
}

// Initialize delete buttons functionality
function initializeDeleteButtons() {
    // Remove existing listeners to avoid duplicates
    document.querySelectorAll('.delete-task-item').forEach(button => {
        button.removeEventListener('click', handleDeleteTask);
        button.addEventListener('click', handleDeleteTask);
    });
}

function handleEditTask(event) {
    event.preventDefault();
    
    try {
        const taskDataString = event.currentTarget.getAttribute('data-task-data');
        const taskData = JSON.parse(taskDataString);
        
        console.log('Opening edit modal for task:', taskData);
        
        // Call the global edit modal function
        if (typeof window.openEditModal === 'function') {
            window.openEditModal(taskData);
        } else {
            console.error('openEditModal function not found');
            showUserMessage('Edit functionality is not available', 'error');
        }
    } catch (error) {
        console.error('Error parsing task data:', error);
        showUserMessage('Error opening edit modal', 'error');
    }
}

async function handleDeleteTask(event) {
    event.preventDefault();
    
    const taskId = event.currentTarget.getAttribute('data-task-id');
    const taskTitle = event.currentTarget.getAttribute('data-task-title');
    
    // Find the task container for visual feedback
    const taskContainer = event.currentTarget.closest('.task_details_container');
    
    try {
        // Show loading state
        if (taskContainer) {
            taskContainer.classList.add('task-deleting');
            taskContainer.style.opacity = '0.6';
            taskContainer.style.pointerEvents = 'none';
        }
        
        console.log('Deleting task with ID:', taskId);
        
        // Call the delete API
        const response = await fetch('./api/delete_task.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                task_id: parseInt(taskId)
            })
        });
        
        console.log('Delete response status:', response.status);
        const data = await response.json();
        console.log('Delete response data:', data);
        
        if (data.success) {
            // Show success message
            showUserMessage('Task deleted successfully!', 'success');
            
            // Remove the task from UI with animation
            if (taskContainer) {
                taskContainer.style.transform = 'translateX(-100%)';
                taskContainer.style.transition = 'all 0.3s ease-out';
                
                setTimeout(() => {
                    taskContainer.remove();
                    // Check if container is empty and show empty state
                    checkAndShowEmptyState();
                }, 300);
            }
            
            // Reload tasks to update the dashboard and stats after a short delay
            setTimeout(() => {
                loadTasks();
            }, 800);
            
        } else {
            throw new Error(data.message || 'Failed to delete task');
        }
        
    } catch (error) {
        console.error('Error deleting task:', error);
        showUserMessage('Error deleting task: ' + error.message, 'error');
        
        // Remove loading state
        if (taskContainer) {
            taskContainer.classList.remove('task-deleting');
            taskContainer.style.opacity = '1';
            taskContainer.style.pointerEvents = 'auto';
        }
    }
}

// Function to check if todo container is empty and show empty state
function checkAndShowEmptyState() {
    const container = document.getElementById('todoTasksContainer');
    if (container && container.children.length === 0) {
        container.innerHTML = `
            <div class="task_details_container empty-state">
                <div class="task_details_header">
                    <p class="task_title">No tasks yet</p>
                    <div class="dropdown" style="display: none;">
                        <!-- Hidden dropdown for empty state -->
                    </div>
                </div>
                <p class="task_description">Create your first task to get started!</p>
                <div class="task_info">
                    <p class="task_priority">Priority: <span class="priority_value">-</span></p>
                    <p class="task_status">Status: <span class="status_value">-</span></p>
                    <p class="task_date">Created on: -</p>
                </div>
            </div>
        `;
    }
}

function populateCompletedSection(completedTasks) {
    const container = document.getElementById('completedTasksContainer');
    
    if (completedTasks.length === 0) {
        // Show empty state
        container.innerHTML = `
            <div class="completed_task_item">
                <div class="completed_task_content">
                    <p class="completed_task_title">No completed tasks yet</p>
                    <p class="completed_task_description">Complete some tasks to see them here!</p>
                    <p class="completed_task_date">Status: Waiting for completed tasks</p>
                </div>
            </div>
        `;
        return;
    }
    
    // Clear container and populate with completed tasks
    container.innerHTML = '';
    
    completedTasks.forEach(task => {
        const taskHTML = `
            <div class="completed_task_item" data-task-id="${task.id}">
                <div class="completed_task_content">
                    <p class="completed_task_title">${escapeHtml(task.title)}</p>
                    <p class="completed_task_description">${escapeHtml(task.description)}</p>
                    <p class="completed_task_date">Completed: ${formatDate(task.created_at)}</p>
                </div>
            </div>
        `;
        container.innerHTML += taskHTML;
    });
}

// Initialize status dropdown functionality
function initializeStatusDropdowns() {
    // Remove existing listeners to avoid duplicates
    document.querySelectorAll('.status-dropdown-item').forEach(item => {
        item.removeEventListener('click', handleStatusChange);
        item.addEventListener('click', handleStatusChange);
    });
}

// Handle status change
async function handleStatusChange(event) {
    event.preventDefault();
    
    const clickedItem = event.currentTarget;
    const newStatus = clickedItem.getAttribute('data-status');
    const dropdown = clickedItem.closest('.dropdown');
    const dropdownToggle = dropdown.querySelector('.status-dropdown-toggle');
    const taskId = dropdownToggle.getAttribute('data-task-id');
    const currentStatus = dropdownToggle.getAttribute('data-current-status');
    
    console.log('Status change attempt:', { taskId, currentStatus, newStatus });
    
    // Don't update if status is the same
    if (newStatus === currentStatus) {
        console.log('Status is the same, not updating');
        return;
    }
    
    // Show loading state
    const taskContainer = dropdown.closest('.task_details_container');
    if (taskContainer) {
        taskContainer.classList.add('status-updating');
    }
    
    try {
        console.log('Sending request to update task status...');
        
        // Call the update API
        const response = await fetch('./api/update_task_status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                task_id: parseInt(taskId),
                status: newStatus
            })
        });
        
        console.log('Response status:', response.status);
        
        const data = await response.json();
        console.log('Response data:', data);
        
        if (data.success) {
            // Update the UI
            updateTaskStatusUI(dropdownToggle, newStatus);
            
            // Show success message
            showUserMessage('Task status updated successfully!', 'success');
            
            // Reload tasks to update the dashboard and stats
            setTimeout(() => {
                loadTasks();
            }, 500);
            
        } else {
            showUserMessage('Failed to update task status: ' + data.message, 'error');
        }
        
    } catch (error) {
        console.error('Error updating task status:', error);
        showUserMessage('Error updating task status. Please try again.', 'error');
    } finally {
        // Remove loading state
        if (taskContainer) {
            taskContainer.classList.remove('status-updating');
        }
    }
}

// Update task status in UI
function updateTaskStatusUI(dropdownToggle, newStatus) {
    // Find the status value span in the same task container
    const taskContainer = dropdownToggle.closest('.task_details_container');
    const statusValueSpan = taskContainer.querySelector('.status_value');
    
    if (statusValueSpan) {
        statusValueSpan.textContent = getStatusText(newStatus);
        statusValueSpan.style.color = getStatusColor(newStatus);
    }
    
    dropdownToggle.setAttribute('data-current-status', newStatus);
}

// Simple user message function
function showUserMessage(message, type) {
    // Remove existing message if any
    const existingMsg = document.querySelector('.user-message');
    if (existingMsg) {
        existingMsg.remove();
    }
    
    // Create message element
    const msgDiv = document.createElement('div');
    msgDiv.className = 'user-message';
    msgDiv.textContent = message;
    
    // Style based on type
    const colors = {
        success: '#28a745',
        error: '#dc3545',
        warning: '#ffc107'
    };
    
    msgDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${colors[type] || '#333'};
        color: white;
        padding: 12px 20px;
        border-radius: 6px;
        z-index: 9999;
        font-size: 14px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        animation: slideIn 0.3s ease;
    `;
    
    // Add CSS for animation
    if (!document.querySelector('#user-message-styles')) {
        const style = document.createElement('style');
        style.id = 'user-message-styles';
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        `;
        document.head.appendChild(style);
    }
    
    document.body.appendChild(msgDiv);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        if (msgDiv.parentNode) {
            msgDiv.remove();
        }
    }, 3000);
}

function showError(message) {
    const todoContainer = document.getElementById('todoTasksContainer');
    const completedContainer = document.getElementById('completedTasksContainer');
    
    // Update the existing template with error state
    const errorTask = todoContainer.querySelector('.task_details_container');
    if (errorTask) {
        errorTask.querySelector('.task_title').textContent = 'Error';
        errorTask.querySelector('.task_description').textContent = message;
        errorTask.querySelector('.priority_value').textContent = '-';
        errorTask.querySelector('.status_value').textContent = 'Error';
        errorTask.querySelector('.task_date').textContent = 'Please refresh the page';
        // Hide dropdown in error state
        errorTask.querySelector('.dropdown').style.display = 'none';
    }
    
    completedContainer.innerHTML = `
        <div class="completed_task_item">
            <div class="completed_task_content">
                <p class="completed_task_title">Error loading completed tasks</p>
                <p class="completed_task_description">${message}</p>
                <p class="completed_task_date">Please refresh the page</p>
            </div>
        </div>
    `;
}

// Task Status Widget Update Function
function updateTaskStatusCircles(stats) {
    const completedPercent = stats.completed_percent || 0;
    const inProgressPercent = stats.in_progress_percent || 0;
    const notStartedPercent = stats.not_started_percent || 0;
    
    // Update completed circle
    const completedCircle = document.querySelector('.completed .circle-progress');
    const completedPercentage = document.querySelector('.completed .percentage');
    if (completedCircle && completedPercentage) {
        completedCircle.style.setProperty('--progress-deg', `${completedPercent * 3.6}deg`);
        completedPercentage.textContent = `${completedPercent}%`;
    }
    
    // Update in-progress circle
    const inProgressCircle = document.querySelector('.in-progress .circle-progress');
    const inProgressPercentage = document.querySelector('.in-progress .percentage');
    if (inProgressCircle && inProgressPercentage) {
        inProgressCircle.style.setProperty('--progress-deg', `${inProgressPercent * 3.6}deg`);
        inProgressPercentage.textContent = `${inProgressPercent}%`;
    }
    
    // Update not-started circle
    const notStartedCircle = document.querySelector('.not-started .circle-progress');
    const notStartedPercentage = document.querySelector('.not-started .percentage');
    if (notStartedCircle && notStartedPercentage) {
        notStartedCircle.style.setProperty('--progress-deg', `${notStartedPercent * 3.6}deg`);
        notStartedPercentage.textContent = `${notStartedPercent}%`;
    }
}

// Helper functions
function getPriorityColor(priority) {
    switch(priority) {
        case 'extreme': return 'var(--task-extreme)';
        case 'moderate': return 'var(--task-moderate)';
        case 'low': return 'var(--task-low)';
        default: return '#42ADE2';
    }
}

function getStatusText(status) {
    switch(status) {
        case 'not_started': return 'Not Started';
        case 'in_progress': return 'In Progress';
        case 'completed': return 'Completed';
        default: return capitalizeFirst(status.replace('_', ' '));
    }
}

function getStatusColor(status) {
    switch(status) {
        case 'not_started': return 'var(--task-not-started)';
        case 'in_progress': return 'var(--task-in-progress)';
        case 'completed': return 'var(--task-completed)';
        default: return '#f21e1e';
    }
}

function capitalizeFirst(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-GB');
}

function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}

// Refresh tasks function (can be called after adding new tasks)
window.refreshTasks = loadTasks;