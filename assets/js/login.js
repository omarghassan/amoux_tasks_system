import { callApi, showUserMessage } from "./config.js";

document.getElementById("loginForm").addEventListener("submit", async function (e) {
  e.preventDefault();

  const email = document.getElementById("email").value.trim();
  const password = document.getElementById("password").value;

  try {
    const response = await callApi("login", { email, password });

    if (response.success) {
      localStorage.setItem("user", JSON.stringify(response.data));
      const session_response = await callApi("set_login_session", { user_id: response.data.id });
      if (session_response.success) {
        window.location.replace("dashboard.php");
      } else {
        showUserMessage(session_response.message || "Login failed", "error");
      }
    } else {
      showUserMessage(response.message || "Login failed", "error");
    }
  } catch (err) {
    showUserMessage("Unexpected error during login.", "error");
  }
});
