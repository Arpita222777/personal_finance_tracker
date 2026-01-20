document.addEventListener('DOMContentLoaded', () => {
  const bankForm = document.getElementById('bankForm');
  const bankName = document.getElementById('bankName');
  const accountType = document.getElementById('accountType');
  const login = document.getElementById('login');
  const password = document.getElementById('password');

  bankForm.addEventListener('submit', function(event) {
    if (bankName.value.trim() === '') {
      alert('Please enter your bank name.');
      bankName.focus();
      event.preventDefault();
      return;
    }
    

    if (accountType.value.trim() === '') {
      alert('Please select an account type.');
      accountType.focus();
      event.preventDefault();
      return;
    }

    if (login.value.trim() === '') {
      alert('Please enter your online banking username.');
      login.focus();
      event.preventDefault();
      return;
    }

    if (password.value === '') {
      alert('Please enter your password.');
      password.focus();
      event.preventDefault();
      return;
    }
  });
});

function resolveError() {
  const bankFix = document.getElementById('bankFix');
  const newPassword = document.getElementById('newPassword');

  if (newPassword.value.trim() === '') {
    alert('Please enter a new password to fix the connection.');
    newPassword.focus();
    return;
  }

  alert(`Connection for ${bankFix.value} fixed successfully.`);
}
