window.togglePassword = function() {
    const input = document.getElementById("password");
    const icon = document.querySelector(".toggle-password");
    
    if (input.type === "password") {
        input.type = "text";
        icon.classList.replace("bi-eye", "bi-eye-slash");
    } else {
        input.type = "password";
        icon.classList.replace("bi-eye-slash", "bi-eye");
    }
};
