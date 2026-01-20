function showToast(message, type = 'success', duration = 4000) {
    let bgColor;
  //alert(message);
    switch (type) {
      case 'success':
        bgColor = '#28a745'; // Green
        break;
      case 'error':
        bgColor = '#dc3545'; // Red
        break;
      case 'info':
        bgColor = '#17a2b8'; // Blue
        break;
      case 'warning':
        bgColor = '#ffc107'; // Yellow
        break;
      default:
        bgColor = '#333'; // Default dark
    }
  
    Toastify({
      text: message,
      duration: duration,
      gravity: 'top',
      position: 'right',
      backgroundColor: bgColor,
      close: true
    }).showToast();
  }
  