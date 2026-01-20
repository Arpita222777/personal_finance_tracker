const urlParams = new URLSearchParams(window.location.search);
  const errorType = urlParams.get("type") || "404";

  const errorData = {
    "404": {
      class: "error-404",
      code: "404",
      title: "Page Not Found",
      message: "Sorry! The page you're looking for doesn't exist.",
      actions: `
        <a href="Profile management.html" class="btn">Back to Home</a>
        <button class="btn" onclick="window.history.back()">Go Back</button>
        <a href="landing-page.html" class="btn">Back to Home</a>
        <button class="btn" onclick="window.history.back()">Go Back</button>
      `
    },
    "500": {
      class: "error-500",
      code: "500",
      title: "Internal Server Error",
      message: "Oops! Something went wrong on our side. Please try again later.",
      actions: `
        <a href="Profile management.html" class="btn">Return to Home</a>
        <button class="btn" onclick="window.location.reload();">Try Again</button>
        <a href="landing-page.html" class="btn">Back to Home</a>
        <button class="btn" onclick="window.history.back()">Go Back</button>
      `
    },
    "403": {
      class: "error-403",
      code: "403",
      title: "Access Forbidden",
      message: "You don't have permission to access this resource.",
      actions: `
        <a href="Profile management.html" class="btn">Return to Home</a>
        <button class="btn" onclick="window.location.reload();">Try Again</button>
        <a href="landing-page.html" class="btn">Back to Home</a>
        <button class="btn" onclick="window.history.back()">Go Back</button>
      `
    },
    "401": {
      class: "error-401",
      code: "401",
      title: "Unauthorized",
      message: "You must log in to continue.",
      actions: `
        <a href="login.html" class="btn">Login</a>
        <a href="Profile management.html" class="btn">Back to Home</a>
      `
    },
    "session": {
      class: "error-500",
      code: "SESSION EXPIRED",
      title: "Session Expired",
      message: "Your session has timed out. Please log in again.",
      actions: `
        <a href="login.html" class="btn">Login Again</a>
      `
    },
    "validation": {
      class: "error-500",
      code: "VALIDATION ERROR",
      title: "Invalid Input",
      message: "Please check your input and try again.",
      actions: `
        <button class="btn" onclick="window.history.back()">Fix Input</button>
      `
    },
    "bank": {
      class: "error-500",
      code: "BANK ERROR",
      title: "Bank Connection Failed",
      message: "We were unable to connect to your bank. Please re-enter credentials.",
      actions: `
        <a href="account-linking.html#resolver" class="btn">Resolve Connection</a>
        <a href="Profile management.html" class="btn">Back to Profile</a>
      `
    }
  };

  const { class: cls, code, title, message, actions } = errorData[errorType] || errorData["404"];
  document.getElementById("error-container").innerHTML = `
    <div class="${cls}">
      <h1><i class="fas fa-triangle-exclamation"></i><br>${code}</h1>
      <h2>${title}</h2>
      <p>${message}</p>
      ${actions}
    </div>
  `;