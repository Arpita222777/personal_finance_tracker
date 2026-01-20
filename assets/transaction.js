document.addEventListener('DOMContentLoaded', () => {
  const dateInput = document.getElementById('transactionDate');
  if (dateInput) {
    dateInput.valueAsDate = new Date();
  }
});

let transactionTable;

$(document).ready(function () {
  transactionTable = $('#transactionTable').DataTable({
    ajax: {
      url: '../controller/getTransactions.php',
      dataSrc: function (json) {
        if (!json.success) {
          showToast(json.message || 'Failed to load transactions', 'error');
          return [];
        }
        return json.data.map(txn => {
          return {
            id: txn.id,
            action: `<div style="text-align:center;">
                      <i class="fa fa-trash" style="color:red; cursor:pointer;" onclick="deleteTransaction(${txn.id})"></i>
                    </div>`,
            transaction_date: txn.transaction_date,
            category_name: txn.category_name,
            amount: txn.amount,
            description: txn.description
          };
        });
      }
    },
    columns: [
      { data: 'action', orderable: false },
      { data: 'transaction_date' },
      { data: 'category_name' },
      { data: 'amount' },
      { data: 'description' }
    ]
  });

  $('#transactionTable tbody').on('click', 'tr', function (e) {
    if ($(e.target).closest('i.fa-trash').length) return;

    const data = transactionTable.row(this).data();
    if (!data) return;

    $('#modal-date').val(data.transaction_date);
    $('#modal-amount').val(parseFloat(data.amount).toFixed(2));
    $('#modal-description-input').val(data.description);
    $('#modal-category').val(data.category_name);
    $('#modal-transaction-id').val(data.id);

    $('#transactionModal').fadeIn();
  });
});

function closeModal() {
  $('#transactionModal').fadeOut();
}

function deleteTransaction(transactionId) {
  if (!confirm("Are you sure you want to delete this transaction?")) return;

  const formData = new FormData();
  formData.append('action', 'deleteTransaction');
  formData.append('transactionId', transactionId);

  fetch('../controller/transactionController.php', {
    method: 'POST',
    body: formData
  })
  .then(async response => {
    const text = await response.text();
    console.log('Raw response:', text);

    try {
      const data = JSON.parse(text);
      if (data.success) {
        showToast(data.message, 'success');
        $('#transactionTable').DataTable().ajax.reload(null, false);
      } else {
        showToast(data.message || 'Failed to delete transaction.', 'error');
      }
    } catch (err) {
      console.error('Response was not valid JSON:', text);
      showToast('Server error. See console for details.', 'error');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    showToast('An error occurred while deleting the transaction.', 'error');
  });
}

function handleTransactionSubmit() {
  const categoryId = document.getElementById('dropdownCategory').value;
  const amount = document.getElementById('transactionAmount').value;
  const description = document.getElementById('transactionDescription').value;
  const date = document.getElementById('transactionDate').value;

  if (!categoryId || !amount || !date) {
    showToast('Please select a category, enter an amount, and select a date.', 'warning');
    return;
  }

  const formData = new FormData();
  formData.append('action', 'addTransaction');
  formData.append('category_id', categoryId);
  formData.append('transaction_amount', amount);
  formData.append('transaction_description', description);
  formData.append('transaction_date', date);

  fetch('../controller/transactionController.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    const messageDiv = document.getElementById('transaction-message');
    if (data.success) {
      showToast(data.message, 'success');
      document.getElementById('transaction-form').reset();
      transactionTable.ajax.reload(null, false);
    } else {
      messageDiv.style.color = 'red';
      messageDiv.textContent = data.message;
    }
  })
  .catch(err => {
    console.error(err);
    showToast('Failed to add transaction.');
  });
}

function updateTransactionDescription() {
  const description = document.getElementById('modal-description-input').value;
  const transactionId = document.getElementById('modal-transaction-id').value;

  if (!description || !transactionId) {
    showToast('Transaction ID or description missing.');
    return;
  }

  const formData = new FormData();
  formData.append('action', 'updateDescription');
  formData.append('transactionId', transactionId);
  formData.append('description', description);

  fetch('../controller/transactionController.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      showToast(data.message);
      $('#transactionModal').fadeOut();
      $('#transactionTable').DataTable().ajax.reload(null, false);
    } else {
      showToast(data.message || 'Update failed');
    }
  })
  .catch(err => {
    console.error(err);
    showToast('Error occurred while updating');
  });
}

function convertDMYtoYMD(dateStr) {
  const parts = dateStr.split('-');
  if(parts.length !== 3) return '';
  return `${parts[2]}-${parts[1].padStart(2,'0')}-${parts[0].padStart(2,'0')}`;
}

async function handleReportDownload() {
  const format = document.getElementById('reportFormat').value;

  if (format === 'csv') {
    window.location.href = '../controller/downloadReport.php?format=csv';
  } else if (format === 'pdf') {
    const response = await fetch('../controller/downloadReport.php?format=json');
    const result = await response.json();

    if (result.success) {
      generatePDFReport(result.transactions, result.categories);
    } else {
      showToast('Failed to load data for report.');
    }
  }
}

async function generatePDFReport(transactions, categories) {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();

  doc.setFontSize(14);
  doc.text('Finance Report', 105, 15, null, null, 'center');

  doc.text('Expense Categories', 14, 25);
  doc.autoTable({
    startY: 30,
    head: [["Name", "Monthly Limit", "Spent"]],
    body: categories.map(cat => [cat.name, cat.monthly_limit, cat.spent]),
    styles: { fontSize: 10 }
  });

  const startY = doc.autoTable.previous.finalY + 10;
  doc.text('Transactions', 14, startY);
  doc.autoTable({
    startY: startY + 5,
    head: [["Date", "Category", "Amount", "Description"]],
    body: transactions.map(txn => [
      txn.transaction_date,
      txn.category_name,
      txn.amount,
      txn.description || ''
    ]),
    styles: { fontSize: 10 }
  });

  doc.save('FinanceReport.pdf');
}
