function showScreen(id) {
  document.querySelectorAll('.section').forEach(sec => sec.classList.remove('active'));
  document.getElementById(id).classList.add('active');
}

function validateGoalForm() {
  const name = document.getElementById("newGoalName").value.trim();
  const target = parseFloat(document.getElementById("newGoalTarget").value);
  const saved = parseFloat(document.getElementById("newGoalSaved").value);
  const date = new Date(document.getElementById("newGoalDate").value);
  const today = new Date();

  if (name.length < 3) {
    alert("Goal name must be at least 3 characters.");
    return false;
  }

  if (isNaN(target) || target <= 0) {
    alert("Target amount must be a positive number.");
    return false;
  }

  if (isNaN(saved) || saved < 0 || saved > target) {
    alert("Saved amount must be non-negative and less than or equal to the target.");
    return false;
  }

  if (isNaN(date.getTime()) || date <= today) {
    alert("Due date must be a valid future date.");
    return false;
  }

  return true;
}

// Extra functions like estimateGoalDate and addMilestone can be defined below
