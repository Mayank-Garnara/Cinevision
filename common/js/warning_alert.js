// Select elements
const showErrorButton = document.getElementById('show-error-notification');
const errorNotification = document.getElementById('error-notification');

// Function to display error notification
function showErrorNotification(message, duration = 3000) {
    const errorMessage = document.getElementById('error-message');
    errorMessage.textContent = message;

    // Reset SVG animations by re-adding the SVG element
    const icon = errorNotification.querySelector('.icon');
    const svg = document.getElementById('cross-svg');
    const newSvg = svg.cloneNode(true);
    svg.parentNode.replaceChild(newSvg, svg);

    // Show notification with animation
    errorNotification.classList.remove('hidden');
    errorNotification.classList.add('visible');

    // Automatically hide notification after the duration
    setTimeout(() => {
        errorNotification.classList.remove('visible');
        setTimeout(() => {
            errorNotification.classList.add('hidden');
        }, 500); // Wait for the slide-out animation to complete
    }, duration);
}

