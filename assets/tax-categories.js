function showScreen(id) {
  const sections = document.querySelectorAll('.section');
  sections.forEach(section => {
    section.classList.remove('active');
  });
  document.getElementById(id).classList.add('active');
}

function validateForm() {
  const desc = document.getElementById('deductionName').value.trim();
  const amount = document.getElementById('deductionAmount').value.trim();
  if (!desc) {
    alert('Please enter an expense description.');
    return false;
  }
  if (!amount || isNaN(amount) || parseFloat(amount) <= 0) {
    alert('Please enter a valid amount greater than zero.');
    return false;
  }
  return true;
}

function exportData() {
  const deductionListItems = document.querySelectorAll('#deductionList li');
  if (deductionListItems.length === 0) {
    alert('No deductions to export.');
    return;
  }

  let exportText = "Tax Deductions Export\n\n";
  deductionListItems.forEach((li, index) => {
    exportText += `${index + 1}. ${li.textContent}\n`;
  });

  const exportBox = document.getElementById('exportBox');
  exportBox.value = exportText;
  alert('Export data generated below. You can copy it for your accountant.');
}
