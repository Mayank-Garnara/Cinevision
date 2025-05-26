const showNotificationButton = document.getElementById('show-notification');
const customNotification = document.getElementById('custom-notification');

// Function to display notification
function showNotification(message, duration = 3000) {
    const notificationMessage = document.getElementById('notification-message');
    notificationMessage.textContent = message;

    // Reset SVG animations by re-adding the SVG element
    const icon = customNotification.querySelector('.icon');
    const svg = document.getElementById('checkmark-svg');
    const newSvg = svg.cloneNode(true);
    svg.parentNode.replaceChild(newSvg, svg);

    // Show notification with animation
    customNotification.classList.remove('hidden');
    customNotification.classList.add('visible');

    // Automatically hide notification after the duration
    setTimeout(() => {
        customNotification.classList.remove('visible');
        setTimeout(() => {
            customNotification.classList.add('hidden');
        }, 500); // Wait for the slide-out animation to complete
    }, duration);
}