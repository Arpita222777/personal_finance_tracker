function validateForm() {
    const password = document.forms["signup-form"]["password"].value;
    const confirmPassword = document.forms["signup-form"]["confirm_password"].value;

    if (password.length < 6) {
        alert("Password must be at least 6 characters long.");
        return false;
    }

    if (password !== confirmPassword) {
        alert("Passwords do not match.");
        return false;
    }

    return true;
}
