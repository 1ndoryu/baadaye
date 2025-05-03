// service-display.js

/**
 * Initializes the interactive service display component.
 * Uses IntersectionObserver for scroll-based activation
 * and handles hover interactions.
 */
function initServiceDisplay() {
    const container = document.querySelector('.postdisplay-home-services.style-three');
    if (!container) return; // Exit if the main container isn't found

    const contentDisplay = container.querySelector('.content-service-three');
    const serviceItems = container.querySelectorAll('.post-display-wrapper .post-item');
    const wrapper = container.querySelector('.post-display-wrapper'); // Needed for mouseleave detection

    // Exit if essential elements are missing
    if (!contentDisplay || serviceItems.length === 0 || !wrapper) return;

    let scrollActiveItem = serviceItems[0]; // Item determined by scroll, defaults to first
    let isHovering = false; // Flag to track if mouse is over an item
    let observer;

    // Updates the display area and sets the active class
    function updateDisplay(item) {
        if (!item) return; // Safety check

        const contentElement = item.querySelector('.post-content');
        contentDisplay.innerHTML = contentElement ? contentElement.innerHTML : '';

        // Manage active class
        serviceItems.forEach(el => el.classList.remove('is-active')); // Use 'is-active' for clarity
        item.classList.add('is-active');
    }

    // Intersection Observer callback
    function handleIntersection(entries) {
        let bestVisibleEntry = null;

        // Find the last entry that is intersecting (often the most relevant for top-down scroll)
        // Or the one most 'centered' if needed, this requires more complex calculation
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                bestVisibleEntry = entry.target; // Keep track of the latest intersecting item
            }
        });

        // Update scrollActiveItem only if a valid intersecting item was found
        if (bestVisibleEntry) {
            scrollActiveItem = bestVisibleEntry;
        }

        // Only update display based on scroll if not currently hovering
        if (!isHovering && scrollActiveItem) {
            updateDisplay(scrollActiveItem);
        }
    }

    // Setup the observer
    observer = new IntersectionObserver(handleIntersection, {
        root: null, // Use viewport as root
        rootMargin: '-45% 0px -45% 0px', // Activate when item is near vertical center
        threshold: 0 // Trigger as soon as the item enters/leaves the rootMargin zone
    });

    // Observe each service item
    serviceItems.forEach(item => observer.observe(item));

    // Add hover listeners to each item
    serviceItems.forEach(item => {
        item.addEventListener('mouseenter', () => {
            isHovering = true;
            updateDisplay(item); // Immediately update display on hover
        });
    });

    // Add mouseleave listener to the wrapper
    wrapper.addEventListener('mouseleave', () => {
        isHovering = false;
        // Restore display based on the last known scroll-active item
        if (scrollActiveItem) {
            updateDisplay(scrollActiveItem);
        }
    });

    // Initial setup: Display the first item's content
    updateDisplay(serviceItems[0]);

    // Optional: Cleanup observer when navigating away (useful for SPAs)
    // window.addEventListener('beforeunload', () => {
    //     if (observer) {
    //         observer.disconnect();
    //     }
    // });
}

// Initialize script when the custom theme event fires or DOM is ready
document.addEventListener('themePageReady', initServiceDisplay);

// Fallback for initial load if themePageReady hasn't fired yet
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initServiceDisplay);
} else {
    // DOMContentLoaded has already fired
    // Check if container exists before potentially running init again
    if (document.querySelector('.postdisplay-home-services.style-three')) {
        initServiceDisplay();
    }
}
