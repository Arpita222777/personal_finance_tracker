document.addEventListener("DOMContentLoaded", () => {
  // TAB SWITCHING
  let tabs = document.querySelectorAll(".tabs button");
  let tabContents = document.querySelectorAll(".tab-content");

  tabs.forEach(tab => {
    tab.addEventListener("click", () => {
      let target = tab.getAttribute("data-tab");


      // Remove active class from all tabs & contents
      tabs.forEach(t => t.classList.remove("active"));
      tabContents.forEach(tc => tc.classList.remove("active"));

      // Add active class to clicked tab & corresponding content
      tab.classList.add("active");
      document.getElementById(target).classList.add("active");
    });
  });

  // OPTIONAL: CLIENT-SIDE FORM VALIDATION (simplified)
  let goalForm = document.getElementById("goal-form");
  if (goalForm) {
    goalForm.addEventListener("submit", (e) => {
      let valid = true;

      let category = goalForm.category.value.trim();
      let target = parseFloat(goalForm.target.value);
      let spent = parseFloat(goalForm.spent.value);

      clearErrors(goalForm);

      if (!category) {
        showError(goalForm.category, "Category is required");
        valid = false;
      }
      if (isNaN(target) || target <= 0) {
        showError(goalForm.target, "Target must be a positive number");
        valid = false;
      }
      if (isNaN(spent) || spent < 0) {
        showError(goalForm.spent, "Spent amount cannot be negative");
        valid = false;
      }

      if (!valid) e.preventDefault();
    });
  }

  let settingsForm = document.getElementById("settings-form");
  if (settingsForm) {
    settingsForm.addEventListener("submit", (e) => {
      let valid = true;

      let threshold = parseInt(settingsForm.threshold.value);

      clearErrors(settingsForm);

      if (isNaN(threshold) || threshold < 1 || threshold > 200) {
        showError(settingsForm.threshold, "Threshold must be between 1 and 200");
        valid = false;
      }

      if (!valid) e.preventDefault();
    });
  }

  function clearErrors(form) {
    let errors = form.querySelectorAll(".error");
    errors.forEach(err => {
      err.style.display = "none";
      err.textContent = "";
    });
  }

  function showError(input, message) {
    let errorDiv = input.nextElementSibling;
    if (errorDiv && errorDiv.classList.contains("error")) {
      errorDiv.textContent = message;
      errorDiv.style.display = "block";
    }
  }
});
