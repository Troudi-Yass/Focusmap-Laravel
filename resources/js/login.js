// public/js/login.js
document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing stars animation');
    
    const stars = document.querySelectorAll('.star');
    console.log(`Found ${stars.length} star elements`);
    
    if (stars.length === 0) {
        console.error('No star elements found! Check your HTML');
        return;
    }
    
    stars.forEach((star, index) => {
        // Random values with more variation
        const tailLength = (Math.random() * 5 + 2).toFixed(2); // 2-7em
        const topOffset = (Math.random() * 120 - 10).toFixed(2); // -10% to 110%
        const fallDuration = (Math.random() * 4 + 3).toFixed(2); // 3-7s
        const fallDelay = (Math.random() * -8).toFixed(2); // Immediate to -8s delay
        const hue = Math.floor(170 + Math.random() * 40); // 170-210 (blue-cyan)
        const saturation = Math.floor(80 + Math.random() * 20); // 80-100%
        const lightness = Math.floor(70 + Math.random() * 30); // 70-100%
        
        // Apply values with debugging
        console.log(`Star ${index}: 
            Length: ${tailLength}em, 
            Top: ${topOffset}%, 
            Duration: ${fallDuration}s, 
            Delay: ${fallDelay}s,
            Color: hsl(${hue}, ${saturation}%, ${lightness}%)`);
        
        star.style.setProperty('--star-tail-length', `${tailLength}em`);
        star.style.setProperty('--top-offset', `${topOffset}%`);
        star.style.setProperty('--fall-duration', `${fallDuration}s`);
        star.style.setProperty('--fall-delay', `${fallDelay}s`);
        star.style.setProperty('--star-color', `hsl(${hue}, ${saturation}%, ${lightness}%)`);
    });
    
    console.log('Stars animation initialized');
});