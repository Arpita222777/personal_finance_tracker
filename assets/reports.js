// Allowed section IDs
const validSections = ['trends', 'incomeVsExpense', 'netWorth'];

function showSection(sectionId) {
  if (!validSections.includes(sectionId)) {
    alert("Invalid section selected.");
    return;
  }
  
  validSections.forEach(id => {
    const el = document.getElementById(id);
    if (el) {
      if (id === sectionId) {
        el.classList.add('active');
      } else {
        el.classList.remove('active');
      }
    }
  });
}

// Chart export function: downloads canvas as PNG
function exportChart(chartId) {
  const canvas = document.getElementById(chartId);
  if (!canvas) {
    alert("Chart not found.");
    return;
  }
  
  // Create a link and trigger download
  const link = document.createElement('a');
  link.href = canvas.toDataURL('image/png');
  link.download = chartId + '_export.png';
  link.click();
}

// Initialization code: create charts with dummy data or real data if available
document.addEventListener('DOMContentLoaded', () => {
  // Example: Initialize dummy charts using Chart.js
  
  const trendsCtx = document.getElementById('trendsChart').getContext('2d');
  const incomeExpenseCtx = document.getElementById('incomeExpenseChart').getContext('2d');
  const netWorthCtx = document.getElementById('netWorthChart').getContext('2d');

  // Spending Trends Chart (line)
  new Chart(trendsCtx, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
      datasets: [{
        label: 'Spending',
        data: [500, 700, 400, 650, 800, 600],
        borderColor: 'rgba(75, 192, 192, 1)',
        fill: false,
        tension: 0.1
      }]
    },
    options: { responsive: true }
  });

  // Income vs Expense Chart (bar)
  new Chart(incomeExpenseCtx, {
    type: 'bar',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
      datasets: [
        {
          label: 'Income',
          data: [1500, 1700, 1600, 1800, 2000, 2100],
          backgroundColor: 'rgba(54, 162, 235, 0.7)'
        },
        {
          label: 'Expense',
          data: [1000, 1200, 900, 1150, 1300, 1400],
          backgroundColor: 'rgba(255, 99, 132, 0.7)'
        }
      ]
    },
    options: { responsive: true }
  });

  // Net Worth Chart (line)
  new Chart(netWorthCtx, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
      datasets: [{
        label: 'Net Worth',
        data: [5000, 5300, 5600, 5900, 6200, 6500],
        borderColor: 'rgba(153, 102, 255, 1)',
        fill: false,
        tension: 0.1
      }]
    },
    options: { responsive: true }
  });
});
