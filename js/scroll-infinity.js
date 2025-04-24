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
    window.addEventListener('scroll', updateInfinityPath, { passive: true }); // Use passive listener
    updateInfinityPath(); // Initial check
};

// Run after DOM is loaded
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initInfinityScroll);
} else {
    initInfinityScroll(); // Already loaded
}