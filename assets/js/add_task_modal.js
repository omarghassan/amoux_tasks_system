import { callApi, showUserMessage } from './api_calls.js';

document.getElementById('addTaskForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    // Get form data
    const formData = new FormData(this);
    const taskData = {
        title: formData.get('title'),
        date: formData.get('date'),
        priority: formData.get('priority'),
        description: formData.get('description')
    };

    // Validate that all fields are filled
    if (!taskData.title || !taskData.date || !taskData.priority || !taskData.description) {
        showUserMessage('Please fill in all fields', 'error');
        return;
    }

    // Get submit button reference
    const submitBtn = document.querySelector('.add_task_btn');
    const originalText = submitBtn.textContent;

    try {
        // Disable the submit button to prevent double submission
        submitBtn.disabled = true;
        submitBtn.textContent = 'Adding...';

        // Call the API
        const response = await callApi('add_task', taskData);

        if (response.success) {
            showUserMessage('Task added successfully!', 'success');

            // Reset the form
            this.reset();

            // Close modal or redirect (adjust based on your needs)
            setTimeout(() => {
                window.location.href = './dashboard.php';
            }, 1500);
        }

    } catch (error) {
        console.error('Error adding task:', error);
        showUserMessage('Failed to add task. Please try again.', 'error');
    } finally {
        // Re-enable the submit button
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    }
});