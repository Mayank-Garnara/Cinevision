function verifyOTP() {
    let txtOTP = document.getElementById('txtOTP').value.trim();
    let link = document.getElementById('go_to_chnage_password');
    if (txtOTP.length == 6) {
        $.ajax({
            url: 'login_process/verify_otp.php',
            method: 'post',
            data: {
                token: 'verifyOTP',
                txtOTP: txtOTP,
            },
            success: function (data) {
                if (data == "valid_otp") {
                    document.getElementById('txtOTP').value = "";
                    link.click();
                } else if (data == "invalid_otp") {
                    alert('Invalid otp!');
                }
            }

        });
    } else {
        alert("Invalid otp");
    }
}