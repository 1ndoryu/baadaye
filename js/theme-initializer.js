(function () {
    'use strict';

    /**
     * Add all functions that need to run on page load and after AJAX navigation here.
     * These functions should ideally be defined in their own component files.
     */
    function runInitializers() {
        console.log('Running initializers...'); // For debugging

        // --- Call your specific init functions ---
        // Example structure: Check if function exists before calling
        /*
        if (typeof window.initMasonry === 'function') {
            window.initMasonry();
        }
        */	
        // ... Add calls to all your other necessary initialization functions ...
        // e.g., initSliders, initTabs, initComments, etc.

        // Handle hash links for things like tabs after content is loaded
    }

    // Listen for the custom event dispatched by ajax-navigation.js
    document.addEventListener('themePageReady', runInitializers);

    // Note: themePageReady is also fired on the initial page load within ajax-navigation.js,
    // so you generally don't need a separate themePageReady listener here for these initializers.
})();
