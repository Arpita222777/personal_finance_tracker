document.getElementById('forgotPasswordForm').addEventListener('submit', function(e) {
  const emailInput = document.getElementById('email');
  const email = emailInput.value.trim();

  const emailPattern = /^[^@]+@[^@]+\.[a-z]{2,}$/i;

  if (!emailPattern.test(email)) {
    e.preventDefault();
    alert("Please enter a valid email.");
    emailInput.focus();
  }
});
