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

//

const path = document.getElementById('infinity-path');

// Get the total length of the path
const pathLength = path.getTotalLength();

// --- Setup initial styles ---
// Make the path invisible initially by setting dash array and offset
path.style.strokeDasharray = pathLength;
path.style.strokeDashoffset = pathLength;

// --- Scroll animation function ---
function updatePathDrawing() {
    // Calculate scroll progress
    const scrollTop = window.scrollY || document.documentElement.scrollTop;
    const scrollHeight = document.documentElement.scrollHeight;
    const clientHeight = document.documentElement.clientHeight;

    // Total scrollable distance
    const maxScroll = scrollHeight - clientHeight;

    // Avoid division by zero if page isn't scrollable
    if (maxScroll <= 0) {
        path.style.strokeDashoffset = 0; // Fully draw if not scrollable
        return;
    }

    // Calculate scroll progress (0 at top, 1 at bottom)
    // Clamp progress between 0 and 1
    const scrollProgress = Math.max(0, Math.min(1, scrollTop / maxScroll));

    // Calculate the dash offset
    // When scrollProgress is 0 (top), offset is pathLength (invisible)
    // When scrollProgress is 1 (bottom), offset is 0 (fully visible)
    const drawLength = pathLength * scrollProgress;
    const offset = pathLength - drawLength;

    // Update the strokeDashoffset style
    path.style.strokeDashoffset = offset;
}

// --- Add scroll event listener ---
window.addEventListener('scroll', () => {
    // Use requestAnimationFrame for performance optimization
    window.requestAnimationFrame(updatePathDrawing);
});

// --- Initial call ---
// Call the function once on load to set the initial state
// based on the current scroll position (in case the page loads scrolled)
updatePathDrawing();
