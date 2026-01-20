document.addEventListener('DOMContentLoaded', () => {
  const dateInput = document.getElementById('incomeDate');
  if (dateInput) {
    dateInput.valueAsDate = new Date();
  }

  loadIncomeTable();
});

function loadIncomeTable() {
  $('#incomeTable').DataTable({
    destroy: true,
    ajax: {
      url: '../controller/incomeController.php',
      type: 'POST',
      data: { action: 'getAll' },
      dataSrc: function (json) {
        if (!json.success) {
          showToast(json.message || 'Failed to load income records', 'error');
          return [];
        }
        console.log(json.data);
        return json.data.map(inc => ({
          id: inc.id,
          date: inc.date,
          source: inc.source,
          amount: inc.amount,
          description: inc.description,
          action: `<div style="text-align:center;">
                    <i class="fa fa-trash" style="color:red; cursor:pointer;" onclick="deleteIncome(${inc.id})"></i>
                  </div>`
        }));
      }
    },
    columns: [
      { data: 'action', orderable: false },
      { data: 'date' },
      { data: 'source' },
      { data: 'amount' },
      { data: 'description' }
    ]
  });
}

function handleIncomeSubmit() {
  const source = document.getElementById('incomeSource').value.trim();
  const amount = document.getElementById('incomeAmount').value.trim();
  const date = document.getElementById('incomeDate').value;
  const description = document.getElementById('incomeDescription').value.trim();

  if (!source || !amount || !date) {
    showToast('Please provide all income details.', 'error');
    return;
  }

  const formData = new FormData();
  formData.append('action', 'add');
  formData.append('source', source);
  formData.append('amount', amount);
  formData.append('date', date);
  formData.append('description', description); // was wrongly set to date

  fetch('../controller/incomeController.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    const msgDiv = document.getElementById('income-message');
    if (data.success) {
      // msgDiv.style.color = 'green';
      // msgDiv.textContent = data.message;
      showToast(data.message, 'success');
      document.getElementById('income-form').reset();
      $('#incomeTable').DataTable().ajax.reload(null, false);
    } else {
      msgDiv.style.color = 'red';
      msgDiv.textContent = data.message;
      showToast(data.message, 'error');
    }
  })
  .catch(err => {
    console.error(err);
    showToast('Failed to add income.', 'error');
  });
}

function deleteIncome(id) {
  if (!confirm('Are you sure you want to delete this income entry?')) return;

  const formData = new FormData();
  formData.append('action', 'delete');
  formData.append('id', id);

  fetch('../controller/incomeController.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      showToast(data.message, 'success');
      $('#incomeTable').DataTable().ajax.reload(null, false);
    } else {
      showToast(data.message || 'Failed to delete income.', 'error');
    }
  })
  .catch(err => {
    console.error(err);
    showToast('Error while deleting income.', 'error');
  });
}
