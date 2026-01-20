document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
  e.preventDefault();
  let newPassword = document.getElementById('newPassword').value;
  let confirmPassword = document.getElementById('confirmPassword').value;

  if (newPassword.length < 6) {
    alert("Password must be at least 6 characters long.");
    return;
  }

  if (newPassword !== confirmPassword) {
    alert("Passwords do not match.");
    return;
  }

  this.submit(); // submit if all checks pass
});
