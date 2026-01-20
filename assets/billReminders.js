document.addEventListener('DOMContentLoaded', () => {
  // Tabs 
  const tabs = document.querySelectorAll('nav.tabs button');
  const tabContents = document.querySelectorAll('.tab-content');

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(b => b.classList.remove('active'));
      tab.classList.add('active');
      tabContents.forEach(tc => tc.classList.remove('active'));
      document.getElementById(tab.dataset.tab).classList.add('active');
    });
  });


  // Client-side form validation for Add Bill form
  const form = document.getElementById('bill-form');
  form.addEventListener('submit', (e) => {
    let errors = [];

    const name = form.bill_name.value.trim();
    const amount = parseFloat(form.bill_amount.value);
    const date = form.bill_date.value;

    if (name === '') errors.push("Bill name cannot be empty.");
    if (isNaN(amount) || amount <= 0) errors.push("Amount must be a positive number.");
    if (!date) errors.push("Please select a valid due date.");

    if (errors.length > 0) {
      e.preventDefault();
      alert(errors.join("\n"));
    }
  });
});
