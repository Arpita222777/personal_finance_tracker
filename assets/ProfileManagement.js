// Show one section and hide others
function showScreen(id) {
  const sections = document.querySelectorAll(".section");
  sections.forEach(section => {
    section.style.display = "none";
  });

  const active = document.getElementById(id);
  if (active) {
    active.style.display = "block";
  }
}

// Save profile edits
function saveProfile() {
  const name = document.getElementById("e_name").value;
  const email = document.getElementById("e_email").value;
  const gender = document.getElementById("e_gender").value;
  const country = document.getElementById("e_country").value;
  const dob = document.getElementById("e_dob").value;

  if (!name || !email || !gender || !country || !dob) {
    alert("Please fill out all fields.");
    return;
  }

  document.getElementById("v_name").textContent = name;
  document.getElementById("v_email").textContent = email;
  document.getElementById("v_gender").textContent = gender;
  document.getElementById("v_country").textContent = country;
  document.getElementById("v_dob").textContent = dob;

  // Calculate and update age
  const birthDate = new Date(dob);
  const today = new Date();
  let age = today.getFullYear() - birthDate.getFullYear();
  const m = today.getMonth() - birthDate.getMonth();
  if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
    age--;
  }
  document.getElementById("v_age").textContent = age;

  showScreen("viewProfile");
}

// Set new avatar
function updateAvatar() {
  const input = document.getElementById("avatarInput");
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function (e) {
      document.getElementById("avatar").src = e.target.result;
      showScreen("viewProfile");
    };
    reader.readAsDataURL(input.files[0]);
  } else {
    alert("Please select an image.");
  }
}

// Change password (simulated)
// Update password

function updatePassword() {
  const currentPassword = document.getElementById("current_password").value;
  const newPassword = document.getElementById("new_password").value;
  const confirmPassword = document.getElementById("confirm_password").value;

  if (!currentPassword || !newPassword || !confirmPassword) {
      alert("Please fill in all password fields.");
      return;
  }

  if (newPassword !== confirmPassword) {
      alert("New passwords do not match.");
      return;
  }

  if (newPassword.length < 6) {
      alert("Password must be at least 6 characters long.");
      return;
  }

  const formData = new FormData();
  formData.append('action', 'updatePassword');
  formData.append('current_password', currentPassword);
  formData.append('new_password', newPassword);
  formData.append('confirm_password', confirmPassword);

  fetch('../controller/Profile managementcontroller.php', {
      method: 'POST',
      body: formData
  })
  .then(response => response.json())
  .then(data => {
      if (data.success) {
          alert(data.message);
          console.log("Json data:" + JSON.stringify(data, null, 2));
          showScreen("viewProfile");
          document.getElementById("current_password").value = '';
          document.getElementById("new_password").value = '';
          document.getElementById("confirm_password").value = '';
      } else {
          alert(data.message);
      }
  })
  .catch(error => {
      console.error('Error:', error);
      alert("An error occurred while updating the password.");
  });
}


function updatePassword1() {
    const currentPassword = document.getElementById("current_password").value;
    const newPassword = document.getElementById("new_password").value;
    const confirmPassword = document.getElementById("confirm_password").value;

    if (!currentPassword || !newPassword || !confirmPassword) {
        alert("Please fill in all password fields.");
        return;
    }

    if (newPassword !== confirmPassword) {
        alert("New passwords do not match.");
        return;
    }

    if (newPassword.length < 6) {
        alert("Password must be at least 6 characters long.");
        return;
    }

    // Create form data
    const formData = new FormData();
    formData.append('action', 'updatePassword');
    formData.append('current_password', currentPassword);
    formData.append('new_password', newPassword);
    formData.append('confirm_password', confirmPassword);

    // Send password update request to server
    fetch('../controller/Profile managementcontroller.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message + data);
            showScreen("viewProfile");
            // Clear the form
            document.getElementById("current_password").value = '';
            document.getElementById("new_password").value = '';
            document.getElementById("confirm_password").value = '';
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("An error occurred while updating the password.");
    });
}

// Hamburger toggle
document.addEventListener("DOMContentLoaded", function () {
  showScreen("viewProfile");

  const hamburger = document.getElementById("hamburger");
  const navLinks = document.getElementById("navLinks");

  if (hamburger && navLinks) {
    hamburger.addEventListener("click", () => {
      navLinks.classList.toggle("active");
    });
  }
});
