let categoryTable;

$(document).ready(function() {
  categoryTable = $('#categoryTable').DataTable({
    ajax: {
      url: '../controller/getCategories.php',
      dataSrc: function(json) {
        if (!json.success) {
          showToast(json.message || 'Failed to load categories', 'error');
          return [];
        }

        return json.data.map(cat => {
          const spent = cat.spent || 0;
          const limit = parseFloat(cat.monthly_limit);
          const progressPercent = Math.min((spent / limit) * 100, 100).toFixed(2);

          let progressColor = '#00aa00'; // Green
          if (spent >= limit) progressColor = '#ff4444'; // Red
          else if (spent >= limit * 0.8) progressColor = '#ffaa00'; // Orange

          const progressBar = `
            <div style="background:#eee; border-radius:4px; width:100%; height:15px;">
              <div style="width:${progressPercent}%; background-color:${progressColor}; height:100%; border-radius:4px;"></div>
            </div>
          `;
          const actionIcon = `<div style="text-align: center;">
            <i class="fa fa-trash" style="color:red; cursor:pointer;" onclick="deleteCategory(${cat.id})"></i>
          </div>`;

          return [
            actionIcon,
            cat.name,
            limit.toFixed(2),
            spent,
            progressBar
          ];
        });
      }
    },
    columns: [
      { title: "Action" },
      { title: "Name" },
      { title: "Monthly Limit (₹)" },
      { title: "Spent (₹)" },
      { title: "Progress", orderable: false }
    ]
  });
});


function saveCategory() {
  const categoryName = document.getElementById("categoryName").value;
  const monthlyLimit = document.getElementById("monthlyLimit").value;

  const formData = new FormData();
  formData.append('action', 'saveCategory');
  formData.append('categoryName', categoryName);
  formData.append('monthlyLimit', monthlyLimit);

  fetch('../controller/expenseCategoriesController.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      showToast(data.message, 'success');
      document.getElementById("categoryName").value = '';
      document.getElementById("monthlyLimit").value = '';
      categoryTable.ajax.reload(null, false);
    } else {
      showToast(data.message, 'error');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    showToast("An error occurred while saving category.", 'error');
  });
}


function deleteCategory(categoryId) {
  if (!confirm("Are you sure you want to delete this category?")) return;

  const formData = new FormData();
  formData.append('action', 'deleteCategory');
  formData.append('categoryId', categoryId);

  fetch('../controller/expenseCategoriesController.php', {
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
        categoryTable.ajax.reload(null, false);
      } else {
        showToast(data.message || 'Failed to delete category.', 'error');
      }
    } catch (err) {
      console.error('Response was not valid JSON:', text);
      showToast('Server error. See console for details.', 'error');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    showToast('An error occurred while deleting the category.', 'error');
  });
}


function loadDropdownCategories() {
  fetch('../controller/getCategories.php')
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        const dropdown = document.getElementById("dropdownCategory");
        dropdown.innerHTML = '<option value="">Select a category</option>';
        data.data.forEach(cat => {
          const option = document.createElement("option");
          option.value = cat.id;
          option.textContent = cat.name;
          dropdown.appendChild(option);
        });
      } else {
        showToast(data.message || "Failed to load categories.", 'error');
      }
    })
    .catch(err => {
      console.error("Dropdown fetch error:", err);
      showToast("An error occurred while loading dropdown categories.", 'error');
    });
}


function handleDropdownSubmit() {
  const categoryId = document.getElementById("dropdownCategory").value;
  const spentAmount = document.getElementById("spentAmount").value;

  if (!categoryId || spentAmount === '') {
    showToast("Please select a category and enter a spent amount.", 'warning');
    return;
  }

  const formData = new FormData();
  formData.append('action', 'updateSpent');
  formData.append('category_id', categoryId);
  formData.append('spent_amount', spentAmount);

  fetch('../controller/expenseCategoriesController.php', {
    method: 'POST',
    body: formData
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        showToast(data.message, 'success');
        document.getElementById("spentAmount").value = '';
        categoryTable.ajax.reload(null, false);
      } else {
        showToast(data.message, 'error');
      }
    })
    .catch(err => {
      console.error('Error updating spent:', err);
      showToast('Failed to update spent amount.', 'error');
    });
}


document.addEventListener("DOMContentLoaded", loadDropdownCategories);
