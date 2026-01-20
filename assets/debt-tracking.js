document.addEventListener("DOMContentLoaded", () => {
  fetchLoans();
});

function showScreen(id) {
  document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
  document.getElementById(id).classList.add('active');
}

function validateLoanForm() {
  const type = document.getElementById('loanName').value;
  const amount = document.getElementById('loanAmount').value;
  const apr = document.getElementById('loanRate').value;
  if (!type || !amount || !apr) {
    alert('Please fill in all fields.');
    return false;
  }
  return true;
}

function fetchLoans() {
  fetch('../controller/debt-trackingcontroller.php?action=fetch')
    .then(res => res.json())
    .then(data => {
      const list = document.getElementById("loanList");
      list.innerHTML = "";
      data.forEach(loan => {
        const div = document.createElement("div");
        div.className = "loan-item";
        div.innerHTML = `<strong>${loan.loan_type}</strong><br>
                         Amount: $${loan.amount}<br>
                         APR: ${loan.apr}%`;
        list.appendChild(div);
      });
    });
}

function calculatePayoff() {
  const amount = parseFloat(document.getElementById('amount').value);
  const rate = parseFloat(document.getElementById('rate').value) / 100 / 12;
  const payment = parseFloat(document.getElementById('payment').value);

  if (!amount || !rate || !payment) {
    alert("Fill in all fields.");
    return;
  }

  const months = Math.ceil(Math.log(payment / (payment - amount * rate)) / Math.log(1 + rate));
  const result = document.getElementById('payoffResult');
  result.innerHTML = `Estimated payoff time: ${months} months.`;
}

function analyzeInterest() {
  const amount = parseFloat(document.getElementById('iaAmount').value);
  const rate = parseFloat(document.getElementById('iaRate').value) / 100;
  const term = parseFloat(document.getElementById('iaTerm').value);

  if (!amount || !rate || !term) {
    alert("Fill in all fields.");
    return;
  }

  const totalInterest = amount * rate * term;
  const result = document.getElementById('interestResult');
  result.innerHTML = `Estimated total interest: $${totalInterest.toFixed(2)}`;
}
