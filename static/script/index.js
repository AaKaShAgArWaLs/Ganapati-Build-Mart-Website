
document.addEventListener('DOMContentLoaded', function () {
    const video1 = document.getElementById('video1');
    const video2 = document.getElementById('video2');

    if (video1 && video2) {
                    // When the first video ends, scroll it left and start the second video
        video1.addEventListener('ended', () => {
                        // Scroll the first video to the left (with transition)
            video1.style.transform = 'translateX(-100%)';

                        // Wait for the scrolling to complete (2s for the transition)
            setTimeout(() => {
                            // Make video2 visible and start playing
                video2.style.visibility = 'visible'; // Make video2 visible immediately
                video2.style.transform = 'translateX(0%)'; // Bring video2 to the screen

                            // Set video2's playback position to 2 seconds (start from 2 seconds)
                video2.currentTime = 2; // Start video 2 from 2 seconds
                video2.play().then(() => {
                    console.log("Video 2 is playing from 2 seconds");
                }).catch((error) => {
                    console.error("Error starting video 2:", error);
                });
            }, 0); // The duration of the scrolling transition
        });

                    // When video2 ends, reset it and bring video1 back
        video2.addEventListener('ended', () => {
                        // Reset video2's position and hide it
            video2.style.transform = 'translateX(100%)'; // Move video2 off-screen to the right


                        // Bring video1 back to the screen
            video1.style.transform = 'translateX(0%)'; // Move video1 back to its position
            video1.play(); // Play video1 again
        });
    }



                // JavaScript to detect scroll and add 'visible' class for image boxes
    window.addEventListener('scroll', function () {
        var navbar = document.querySelector('.header-nav');
        var plywoodSection = document.querySelector('.plywood-section');
        var plywoodContent = document.querySelector('.plywood-content');
        var plywoodDescription = document.querySelector('.plywood-description');
        var box2 = document.querySelector('.box2');
        var imageBoxes = document.querySelectorAll('.box');

                    // Add 'scrolled' class to navbar
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }

                    // Handle plywood section visibility
        var plywoodSectionTop = plywoodSection.getBoundingClientRect().top;
        var windowHeight = window.innerHeight;

        if (plywoodSectionTop < windowHeight * 0.7) {
            plywoodContent.classList.add('visible');
        } else {
            plywoodContent.classList.remove('visible');
        }

        if (plywoodSectionTop < windowHeight * 0.5) {
            plywoodDescription.classList.add('visible');
        } else {
            plywoodDescription.classList.remove('visible');
        }

                    // Handle visibility of box2 first
        var box2Top = box2.getBoundingClientRect().top;
        if (box2Top < windowHeight * 0.7) {
            box2.classList.add('visible');
        } else {
            box2.classList.remove('visible');
        }

                    // Handle visibility of all other boxes after box2
        imageBoxes.forEach(function (box) {
            var boxTop = box.getBoundingClientRect().top;
            if (boxTop < windowHeight * 0.5) {
                box.classList.add('visible');
            } else {
                box.classList.remove('visible');
            }
        });
    });
});