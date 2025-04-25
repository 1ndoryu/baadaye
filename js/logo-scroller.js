// App/js/components/logo-scroller.js

function initLogoScroller() {
    const scrollers = document.querySelectorAll('.client-logos-wrap'); // Find all potential scrollers

    scrollers.forEach(scroller => {
        // # Prevent re-initialization
        if (scroller.classList.contains('js-scroller-initialized')) {
            return;
        }

        const logos = scroller.querySelectorAll('.client-logo');
        if (logos.length <= 1) { // # No need to scroll if 0 or 1 logo
            return;
        }

        // # Duplicate logos for seamless loop
        logos.forEach(logo => {
            const clone = logo.cloneNode(true);
            clone.setAttribute('aria-hidden', 'true'); // # Hide decorative clones from screen readers
            scroller.appendChild(clone);
        });

        // # Add class to confirm initialization and potentially trigger CSS animation via class
        scroller.classList.add('js-scroller-initialized');

         // # Note: Animation is now applied directly via CSS using @keyframes scrollLogos
         // # No need to set animationName via JS unless dynamically calculating duration

         // # Example: Dynamically calculate duration (optional)
         // const totalWidth = scroller.scrollWidth / 2; // Width of one set of logos
         // const desiredSpeed = 50; // pixels per second
         // const duration = totalWidth / desiredSpeed;
         // if (duration > 0) {
         //     scroller.style.animationDuration = `${duration}s`;
         // }
    });
}

// # Run on custom event
document.addEventListener('themePageReady', initLogoScroller);