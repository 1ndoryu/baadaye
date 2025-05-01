// js/scroll-infinity.js

const initInfinityScroll = () => {
    const path = document.getElementById('infinityScrollPath');
    if (!path) return; // Exit if path not found

    const pathLength = path.getTotalLength(); // Get path length
    const scrollFactor = 0.3; // Animation completes over the first 50% of scroll distance

    // Init styles
    path.style.strokeDasharray = pathLength;
    path.style.strokeDashoffset = pathLength;
    path.style.transition = 'stroke-dashoffset 0.1s linear'; // Optional smooth transition

    const updateInfinityPath = () => {
        const scrollHeight = document.documentElement.scrollHeight;
        const clientHeight = document.documentElement.clientHeight;
        const scrollTop = window.scrollY || document.documentElement.scrollTop;
        const maxScrollTop = scrollHeight - clientHeight;

        // Define the scroll distance over which the animation should complete
        const effectiveScroll = maxScrollTop * scrollFactor;

        // Calculate percentage scrolled based on the effective distance
        // Ensure effectiveScroll is not zero to avoid division by zero
        const scrollPercent = effectiveScroll <= 0 ? 1 : Math.min(1, Math.max(0, scrollTop / effectiveScroll));

        // Calculate draw length
        const draw = pathLength * scrollPercent;

        // Update offset
        path.style.strokeDashoffset = pathLength - draw;
    };

    // Listen & init
    window.addEventListener('scroll', updateInfinityPath, {passive: true}); // Use passive listener
    updateInfinityPath(); // Initial check
};

document.addEventListener('themePageReady', initInfinityScroll);

////////////////////////////////////////////////////////////////////////////////////////

const path = document.getElementById('infinity-path');

// Get the total length of the path
const pathLength = path.getTotalLength();

// --- Setup initial styles ---
// Make the path invisible initially by setting dash array and offset
path.style.strokeDasharray = pathLength;
path.style.strokeDashoffset = pathLength;

// --- Scroll animation function ---
// File: assets/js/svg-path-animation.js

function initSvgPathAnim() {
    const path = document.getElementById('infinity-path');
    // Use the SVG element itself (or a wrapper) for position checks
    const svgElement = path ? path.closest('svg') : null;

    if (!path || !svgElement) {
        // console.warn('SVG path or container element not found for animation.');
        return;
    }

    const pathLength = path.getTotalLength();

    // Setup initial styles
    path.style.strokeDasharray = pathLength;
    path.style.strokeDashoffset = pathLength; // Start hidden

    function updatePathDrawing() {
        const rect = svgElement.getBoundingClientRect();
        const elTop = rect.top;
        const elHeight = rect.height;
        const vpHeight = window.innerHeight;

        // --- Define Animation Zone ---
        // Start animation when the top of the SVG enters the viewport (or slightly before)
        // Let's say, start when top is at 90% of viewport height
        const animStartThreshold = vpHeight * 0.9;

        // End animation when the *bottom* of the SVG reaches the vertical center of the viewport
        const animEndThreshold = vpHeight * 0.5;

        // Calculate the element's top position where the animation should be fully complete
        const animEndTopPosition = animEndThreshold - elHeight;

        // Calculate the total scroll distance over which the animation occurs
        // This is the distance the element's top travels from start threshold to end position
        const totalAnimDistance = animStartThreshold - animEndTopPosition;

        // Avoid division by zero or negative distance if element is huge or thresholds overlap
        if (totalAnimDistance <= 0) {
            // If element top is already past the end point, fully draw it
            if (elTop < animEndTopPosition) {
                path.style.strokeDashoffset = 0;
            } else {
                // Otherwise (above start or in weird state), keep hidden (or initial state)
                path.style.strokeDashoffset = pathLength;
            }
            return;
        }

        // Calculate how far the element's top has moved *into* the animation zone
        const distanceScrolledInZone = animStartThreshold - elTop;

        // Calculate progress (0 to 1) within the animation zone
        let progress = distanceScrolledInZone / totalAnimDistance;

        // Clamp progress between 0 and 1
        progress = Math.max(0, Math.min(1, progress));

        // Calculate the dash offset based on clamped progress
        // Offset = length when progress is 0, Offset = 0 when progress is 1
        const offset = pathLength * (1 - progress);

        // Update the style
        path.style.strokeDashoffset = offset;
    }

    let isTicking = false;
    function onScroll() {
        if (!isTicking) {
            window.requestAnimationFrame(() => {
                updatePathDrawing();
                isTicking = false;
            });
            isTicking = true;
        }
    }

    // Add scroll event listener
    window.addEventListener('scroll', onScroll, {passive: true});

    // Initial call to set state based on load position
    updatePathDrawing();
}

// Run the script after the page loads or when the theme indicates readiness
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSvgPathAnim);
} else {
    initSvgPathAnim(); // Already loaded
}

// Listen for custom theme event to potentially re-run or re-init if needed
document.addEventListener('themePageReady', initSvgPathAnim);
