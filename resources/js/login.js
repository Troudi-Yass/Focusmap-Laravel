// DOM Ready
document.addEventListener('DOMContentLoaded', function() {
    // Initialize stars animation
    initStars();
    
    // Set up current date display
    updateCurrentDate();
    
    // Initialize all tooltips
    initTooltips();
    
    // Set up form submissions
    setupForms();
    
    // Initialize modals
    setupModals();
});

// Stars Background Animation
function initStars() {
    const starsContainer = document.querySelector('.stars');
    if (!starsContainer) return;
    
    // Clear existing stars
    starsContainer.innerHTML = '';
    
    // Create 10 stars with random properties
    for (let i = 0; i < 10; i++) {
        const star = document.createElement('div');
        star.className = 'star';
        
        // Random properties
        const tailLength = Math.random() * 4 + 3;
        const topOffset = Math.random() * 120 - 10;
        const fallDuration = Math.random() * 3 + 4;
        const fallDelay = Math.random() * -5;
        const hueVariation = Math.random() * 20 - 10;
        const saturation = 90 + Math.random() * 10;
        const lightness = 80 + Math.random() * 15;
        
        // Apply CSS variables
        star.style.setProperty('--star-tail-length', `${tailLength}em`);
        star.style.setProperty('--top-offset', `${topOffset}%`);
        star.style.setProperty('--fall-duration', `${fallDuration}s`);
        star.style.setProperty('--fall-delay', `${fallDelay}s`);
        star.style.setProperty('--star-color', 
            `hsl(${180 + hueVariation}, ${saturation}%, ${lightness}%)`);
        
        starsContainer.appendChild(star);
    }
}

// Update Current Date Display
function updateCurrentDate() {
    const dateElement = document.getElementById('currentDate');
    if (!dateElement) return;
    
    const options = { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    };
    dateElement.textContent = new Date().toLocaleDateString('en-US', options);
}

// Tooltip Initialization
function initTooltips() {
    const tooltips = document.querySelectorAll('[data-tooltip]');
    
    tooltips.forEach(tooltip => {
        const tooltipText = tooltip.getAttribute('data-tooltip');
        const tooltipElement = document.createElement('div');
        
        tooltipElement.className = 'tooltip hidden absolute z-50 p-2 text-xs bg-gray-800 text-white rounded shadow-lg';
        tooltipElement.textContent = tooltipText;
        tooltip.appendChild(tooltipElement);
        
        tooltip.addEventListener('mouseenter', () => {
            tooltipElement.classList.remove('hidden');
        });
        
        tooltip.addEventListener('mouseleave', () => {
            tooltipElement.classList.add('hidden');
        });
    });
}

// Form Handling
function setupForms() {
    // Handle all form submissions with fetch API
    document.querySelectorAll('form[data-ajax]').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const form = e.target;
            const submitButton = form.querySelector('[type="submit"]');
            const originalButtonText = submitButton.innerHTML;
            
            // Show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = `
                <span class="inline-flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Processing...
                </span>
            `;
            
            try {
                const response = await fetch(form.action, {
                    method: form.method,
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: new FormData(form)
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    showNotification('Success!', data.message || 'Operation completed successfully', 'success');
                    if (form.dataset.redirect) {
                        window.location.href = form.dataset.redirect;
                    }
                } else {
                    showNotification('Error', data.message || 'Something went wrong', 'error');
                    if (data.errors) {
                        displayFormErrors(form, data.errors);
                    }
                }
            } catch (error) {
                showNotification('Error', 'Network error occurred', 'error');
            } finally {
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonText;
            }
        });
    });
}

// Modal Handling
function setupModals() {
    // Open modal triggers
    document.querySelectorAll('[data-modal-toggle]').forEach(trigger => {
        trigger.addEventListener('click', () => {
            const modalId = trigger.getAttribute('data-modal-toggle');
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        });
    });
    
    // Close modal triggers
    document.querySelectorAll('[data-modal-hide]').forEach(trigger => {
        trigger.addEventListener('click', () => {
            const modalId = trigger.getAttribute('data-modal-hide');
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });
    });
    
    // Close modal when clicking outside
    document.querySelectorAll('.modal-overlay').forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });
    });
}

// Notification System
function showNotification(title, message, type = 'info') {
    const notification = document.createElement('div');
    const colors = {
        success: 'bg-green-800 text-green-100',
        error: 'bg-red-800 text-red-100',
        info: 'bg-blue-800 text-blue-100'
    };
    
    notification.className = `fixed bottom-4 right-4 ${colors[type]} px-6 py-3 rounded shadow-lg transform transition-all duration-300 translate-y-4 opacity-0`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="ri-${type === 'success' ? 'check' : type === 'error' ? 'close' : 'information'}-line mr-2"></i>
            <div>
                <strong class="font-medium">${title}</strong>
                <p class="text-sm">${message}</p>
            </div>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Trigger animation
    setTimeout(() => {
        notification.classList.remove('translate-y-4', 'opacity-0');
        notification.classList.add('translate-y-0', 'opacity-100');
    }, 10);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        notification.classList.add('translate-y-4', 'opacity-0');
        setTimeout(() => notification.remove(), 300);
    }, 5000);
}

// Display form errors
function displayFormErrors(form, errors) {
    // Clear previous errors
    form.querySelectorAll('.form-error').forEach(el => el.remove());
    
    Object.entries(errors).forEach(([field, messages]) => {
        const input = form.querySelector(`[name="${field}"]`);
        if (input) {
            const errorContainer = document.createElement('div');
            errorContainer.className = 'form-error text-red-400 text-sm mt-1';
            errorContainer.textContent = messages.join(', ');
            input.parentNode.appendChild(errorContainer);
            
            // Add error class to input
            input.classList.add('border-red-500');
            input.addEventListener('input', () => {
                input.classList.remove('border-red-500');
            }, { once: true });
        }
    });
}

// Toggle task completion
window.toggleTaskCompletion = async function(taskId) {
    try {
        const response = await fetch(`/tasks/${taskId}/toggle`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
        
        if (response.ok) {
            const data = await response.json();
            const checkbox = document.querySelector(`[data-task-id="${taskId}"]`);
            if (checkbox) {
                checkbox.checked = data.completed;
                checkbox.closest('label').classList.toggle('line-through', data.completed);
            }
            showNotification('Success', 'Task updated', 'success');
        } else {
            throw new Error('Failed to update task');
        }
    } catch (error) {
        showNotification('Error', error.message, 'error');
    }
}