document.addEventListener("DOMContentLoaded", function () {
    const passwordInput = document.getElementById("password");
    const ConfirmPasswordInput = document.getElementById('confirm_password');
    const passwordTooltip = document.getElementById("passwordTooltip");
    const confirmPasswordTooltip = document.getElementById('confirmPasswordTooltip')
    const passwordErrorMessage = document.getElementById("errorMessage");
    const form = document.getElementById("container"); // Replace "myForm" with your actual form ID

    passwordInput.addEventListener("keyup", function () {

        if (passwordErrorMessage.style.display != "none") {
            passwordErrorMessage.style.display = "none";
            passwordInput.classList.remove('error-border');
        }

        const password = passwordInput.value;

        let tooltipText = "";

        // Check password conditions and set tooltip text accordingly
        if (password.length < 8) {
            tooltipText += "<br> Password must be at least 8 characters long.";
        }
        if (!/[a-z]/.test(password)) {
            tooltipText += "<br> * Must include at least one lowercase letter. ";
        }
        if (!/[A-Z]/.test(password)) {
            tooltipText += "<br> * Must include at least one uppercase letter. ";
        }
        if (!/\d/.test(password)) {
            tooltipText += "<br> * Must include at least one number. ";
        }
        if (/[' ]/.test(password)) {
            tooltipText += "<br> * Single quote (') and space are not allowed. ";
        }

        // Display the tooltip with the appropriate message
        if (tooltipText !== "") {
            passwordTooltip.innerHTML = tooltipText;
            passwordTooltip.style.color = "red"; // Set the color to red
            passwordTooltip.style.display = "block";
        } else {
            passwordTooltip.style.display = "none";
        }
    });

    ConfirmPasswordInput.addEventListener("keyup", function () {

        if (passwordErrorMessage.style.display != "none") {
            passwordErrorMessage.style.display = "none";
            passwordInput.classList.remove('error-border');
        }

        let tooltipText="";

        if(passwordInput.value != ConfirmPasswordInput.value){
            tooltipText+="<br> * Both password must be same.. ";
        }
        // Display the tooltip with the appropriate message
        if (tooltipText !== "") {
            confirmPasswordTooltip.innerHTML = tooltipText;
            confirmPasswordTooltip.style.color = "red"; // Set the color to red
            confirmPasswordTooltip.style.display = "block";
        } else {
            confirmPasswordTooltip.style.display = "none";
        }
    });

    // Add a submit event listener to the form
    form.addEventListener("submit", function (event) {
        const password = passwordInput.value;

        // Check the password conditions
        if (
            password.length < 8 ||
            !/[a-z]/.test(password) ||
            !/[A-Z]/.test(password) ||
            !/\d/.test(password) ||
            /[' ]/.test(password) ||
            password != ConfirmPasswordInput.value
        ) {
            // Prevent the form from submitting if conditions are not met
            event.preventDefault();
            shake(passwordInput, passwordErrorMessage);
        }
    });
});