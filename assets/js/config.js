import { callApi, logMessage, showUserMessage } from './api_calls.js';
import { createModal } from './modal.js';
import { handleImageUpload, initializeImageHandler } from './image_handler.js';
export { callApi, logMessage, showUserMessage, handleImageUpload, initializeImageHandler, createModal, closeModal };

// Function to close any modal
function closeModal() {
    document.querySelectorAll('.custom-modal').forEach(modal => {
        modal.style.display = 'none';
    });
    document.getElementById('modalOverlay').style.display = 'none';
}


