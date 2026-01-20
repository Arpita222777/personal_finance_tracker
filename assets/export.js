document.addEventListener('DOMContentLoaded', () => {
  const tabs = document.querySelectorAll('nav.tabs button');
  const sections = document.querySelectorAll('.tab-content');
  const typeError = document.getElementById('type-error');
  const form = document.getElementById('export-form');

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(t => t.classList.remove('active'));
      tab.classList.add('active');

      sections.forEach(sec => {
        sec.classList.remove('active');
        if (sec.id === tab.dataset.tab) {
          sec.classList.add('active');
        }
      });
    });
  });
/* */
  if (form) {
    form.addEventListener('submit', (e) => {
      const exportType = document.getElementById('export_type');
      if (!exportType.value) {
        e.preventDefault();
        typeError.style.display = 'block';
      } else {
        typeError.style.display = 'none';
      }
    });
  }
});

