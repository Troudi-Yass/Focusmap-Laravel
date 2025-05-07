import './bootstrap';
import Alpine from 'alpinejs';
import { createApp } from 'vue';

// Initialize AlpineJS
window.Alpine = Alpine;
Alpine.start();

// Initialize Vue components if we have any
// const app = createApp({});
// app.mount('#app');

// Global functions for goal management
window.toggleStatusOptions = (goalId) => {
    const dropdown = document.getElementById(`statusOptions_${goalId}`);
    document.querySelectorAll('[id^="statusOptions_"]').forEach(el => {
        if (el.id !== `statusOptions_${goalId}`) {
            el.classList.add('hidden');
        }
    });
    dropdown.classList.toggle('hidden');
};

window.updateGoalStatus = async (goalId, status) => {
    try {
        const response = await fetch(`/api/goals/${goalId}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status })
        });

        if (!response.ok) throw new Error('Failed to update status');
        window.location.reload();
    } catch (error) {
        console.error('Error updating status:', error);
        alert('Failed to update status');
    }
};

window.updateGoalProgress = async (goalId, progress) => {
    try {
        const response = await fetch(`/api/goals/${goalId}/progress`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ progress })
        });

        if (!response.ok) throw new Error('Failed to update progress');
        window.location.reload();
    } catch (error) {
        console.error('Error updating progress:', error);
        alert('Failed to update progress');
    }
};

window.createGoal = async (formData) => {
    try {
        const response = await fetch('/api/goals', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        });

        if (!response.ok) throw new Error('Failed to create goal');
        
        // Redirect to the goals page after successful creation
        window.location.href = '/goals';
    } catch (error) {
        console.error('Error creating goal:', error);
        alert('Failed to create goal');
    }
};

// Initialize stars animation
document.addEventListener('DOMContentLoaded', () => {
    const stars = document.querySelectorAll('.star');
    stars.forEach((star) => {
        const tailLength = Math.random() * 4 + 3;
        const topOffset = Math.random() * 120 - 10;
        const fallDuration = Math.random() * 3 + 4;
        const fallDelay = Math.random() * -5;
        const hueVariation = Math.random() * 20 - 10;
        const saturation = 90 + Math.random() * 10;
        const lightness = 80 + Math.random() * 15;
        
        star.style.setProperty('--star-tail-length', `${tailLength}em`);
        star.style.setProperty('--top-offset', `${topOffset}%`);
        star.style.setProperty('--fall-duration', `${fallDuration}s`);
        star.style.setProperty('--fall-delay', `${fallDelay}s`);
        star.style.setProperty('--star-color', `hsl(${180 + hueVariation}, ${saturation}%, ${lightness}%)`);
    });
});

