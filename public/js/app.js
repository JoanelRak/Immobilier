// JavaScript for showing the loading screen
document.addEventListener("DOMContentLoaded", function () {
    // Wait for all assets to load
    window.onload = function () {
        // Add a 'loaded' class to the body when everything is ready
        document.body.classList.add('loaded');
    };
});

function toggleContent() {
    const contentContainer = document.querySelector('.get-all-fixed-right .content-container');
    if (contentContainer) {
        contentContainer.classList.toggle('show');
    }
}

