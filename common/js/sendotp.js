function sendOtp() {

    let emailElement = document.getElementById('email');
    let emailText = document.getElementById('email').value.trim();

    let clickedOtpButton = document.getElementById('otpButton');


    let receiveOtpDiv = document.getElementById('afterotp');
    let user_name_at_otp_time = document.getElementById('user_name_at_otp_time');


    let errorElement = document.getElementById('errorMessage');

    if (emailText.length > 0) {
        clickedOtpButton.innerHTML = `<div class="spinner-container">
                                    <div class="spinner"></div>
                                </div>`;
        $.ajax({
            method: 'post',
            url: 'login_process/sent_otp.php',
            data: {
                email: emailText,
                token: 'send_otp',
            },
            success: function (data) {

                if (data == "user_not_found") {
                    showErrorNotification('User not found!', 3000);
                    // alert('user not found');
                    clickedOtpButton.innerHTML = "Resend !";
                } else if (data.includes('not_sent')) {
                    showErrorNotification('Something went wrong!', 3000);
                    // alert('something went wrong')
                } else {
                    clickedOtpButton.disabled = "disabled";
                    startTimer();
                    if (errorElement.style.display != "none") {
                        errorElement.style.display = "none";
                        emailElement.classList.remove('error-border');
                    }

                    receiveOtpDiv.style.display = "block";
                    user_name_at_otp_time.innerText = data;
                }
            }
        });
    } else {
        shake(emailElement, errorElement);
    }
}

function startTimer() {
    const resendBtn = document.getElementById('otpButton');
    let countdown = 120; // 2 minutes in seconds

    const interval = setInterval(() => {
        // Calculate minutes and seconds
        const minutes = Math.floor(countdown / 60);
        const seconds = countdown % 60;

        // Display the timer
        resendBtn.innerHTML = `Please wait ${minutes}:${seconds < 10 ? '0' : ''}${seconds} to resend OTP`;

        // Decrement the countdown
        countdown--;

        if (countdown < 0) {
            clearInterval(interval);
            resendBtn.innerHTML = 'Re-Send OTP';
            enableResendButton();
        }
    }, 1000); // Update every second
}
function enableResendButton() {
    const resendBtn = document.getElementById('otpButton');
    resendBtn.disabled = false;
}