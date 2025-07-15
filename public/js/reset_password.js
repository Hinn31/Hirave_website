//OTP
const form = document.querySelector('.verification__form');
    form.addEventListener('submit', function() {
        const otp = digit1.value + digit2.value + digit3.value + digit4.value;
        document.getElementById('otp').value = otp;
    });

    let seconds = 60;
    const countdown = document.getElementById('verification__countdown');
    setInterval(() => {
        seconds--;
        let m = Math.floor(seconds / 60);
        let s = seconds % 60;
        countdown.textContent = `${m.toString().padStart(2,'0')}:${s.toString().padStart(2,'0')}`;
        if (seconds <= 0) countdown.textContent = 'Expired!';
    }, 1000);

// New password
function togglePassword(inputId, iconElement) {
    const input = document.getElementById(inputId);
    const icon = iconElement.querySelector('i');

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}
