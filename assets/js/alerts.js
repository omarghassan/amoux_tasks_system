import { callApi, showUserMessage } from './assets/js/config.js';

    document.addEventListener("DOMContentLoaded", async () => {
      const tbody = document.getElementById("alerts-body");
      tbody.innerHTML = `<tr><td colspan='5' class='text-center py-4'>Loading...</td></tr>`;

      const res = await callApi("get_alert_logs");

      if (res?.success && Array.isArray(res.data)) {
        tbody.innerHTML = "";
        res.data.forEach(log => {
          const tr = document.createElement("tr");
          tr.innerHTML = `
            <td>#${log.round_id}</td>
            <td>${log.url}</td>
            <td>${log.http_code}</td>
            <td>${log.error}</td>
            <td>${new Date(log.created_at).toLocaleString()}</td>
          `;
          tbody.appendChild(tr);
        });
      } else {
        tbody.innerHTML = `<tr><td colspan='5' class='text-center text-danger'>No alerts found or failed to load data.</td></tr>`;
      }
    });