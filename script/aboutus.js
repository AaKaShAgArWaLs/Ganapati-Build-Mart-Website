
    // Function to animate the numbers
    function animateStatNumber(element, targetValue, suffix = '') {
        let currentValue = 0;
        const increment = targetValue / 100; // Increment value for smooth animation
        const duration = 2000; // Duration of animation in milliseconds
        const stepTime = duration / 100; // Time per step
        
        function updateNumber() {
            if (currentValue < targetValue) {
                currentValue += increment;
                element.innerText = Math.ceil(currentValue); // Update the text with the current number
                setTimeout(updateNumber, stepTime); // Keep updating until we reach the target value
            } else {
                element.innerText = targetValue + suffix; // Add the suffix (e.g., "+" or "k+")
            }
        }
        
        updateNumber(); // Start the animation
    }

    // Trigger animations when page is loaded
    window.addEventListener('load', function() {
        const statNumbers = document.querySelectorAll('.stat-number');
        
        // Trigger animations with respective numbers and suffixes
        animateStatNumber(statNumbers[0], 9, '+');             // 9 years experience
        animateStatNumber(statNumbers[1], 15, '+');        // 15+ brands with us
        animateStatNumber(statNumbers[2], 1000, '+');        // 1k+ products sold
        animateStatNumber(statNumbers[3], 60, '+');        // 60+ variant products
    });
