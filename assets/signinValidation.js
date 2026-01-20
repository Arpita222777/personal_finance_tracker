function validateForm() {
  const email = document.getElementById('email').value.trim();
  const password = document.getElementById('password').value.trim();

  if (!email) {
    alert("Please enter your email.");
    return false;
  }

  if (!password) {
    alert("Please enter your password.");
    return false;
  }

  // Basic email regex check
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailRegex.test(email)) {
    alert("Please enter a valid email address.");
    return false;
  }

  return true;
}


function togglePassword() {
  const passwordInput = document.getElementById('password');
  const eyeIcon = document.querySelector('.password-toggle i');
  
  if (passwordInput.type === 'password') {
    passwordInput.type = 'text';
    eyeIcon.classList.remove('fa-eye');
    eyeIcon.classList.add('fa-eye-slash');
  } else {
    passwordInput.type = 'password';
    eyeIcon.classList.remove('fa-eye-slash');
    eyeIcon.classList.add('fa-eye');
  }
}
