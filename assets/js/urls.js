import { callApi, showUserMessage, logMessage } from './config.js';

document.addEventListener("DOMContentLoaded", () => {
  loadUrls();

  // === ADD URL ===
  document.getElementById("addUrlForm").addEventListener("submit", async (e) => {
    e.preventDefault();
    const payload = {
      url: document.getElementById("add-url").value,
      label: document.getElementById("add-label").value || "",
    //   region: document.getElementById("add-region").value || "",
    //   status: document.getElementById("add-status").value || "1",
    };

    const res = await callApi("add_url", payload);
    if (!res.success) return;

    showUserMessage("URL added successfully", "success");
    document.getElementById("addUrlForm").reset();
    bootstrap.Modal.getInstance(document.getElementById("addUrlModal")).hide();
    loadUrls();
  });

  // === EDIT URL ===
  document.getElementById("editUrlForm").addEventListener("submit", async (e) => {
    e.preventDefault();
    const payload = {
      id: document.getElementById("edit-id").value,
      url: document.getElementById("edit-url").value,
      label: document.getElementById("edit-label").value || "",
    //   region: document.getElementById("edit-region").value || "",
    //   status: document.getElementById("edit-status").value || "1",
    };

    const res = await callApi("edit_url", payload);
    if (!res.success) return;

    showUserMessage("URL updated successfully", "success");
    document.getElementById("editUrlForm").reset();
    bootstrap.Modal.getInstance(document.getElementById("editUrlModal")).hide();
    loadUrls();
  });
});

// === LOAD ALL URLS ===
async function loadUrls() {
  const tbody = document.getElementById("urls-body");
  tbody.innerHTML = `<tr><td colspan="6" class="text-center py-4">Loading...</td></tr>`;
  const res = await callApi("get_urls");

  if (!res.success) {
    tbody.innerHTML = `<tr><td colspan="6" class="text-center text-danger py-4">Failed to load URLs</td></tr>`;
    return;
  }

//    <td>${item.region}</td>
//       <td class="${item.status === '1' ? 'text-success' : 'text-danger'}">
//         ${item.status === '1' ? 'Active' : 'Inactive'}
//       </td>

  tbody.innerHTML = "";
  res.data.forEach((item, index) => {
    const tr = document.createElement("tr");
    tr.innerHTML = `
      <th scope="row">${index + 1}</th>
      <td>${item.url}</td>
      <td>${item.label}</td>
     
      <td class="text-end">
        <button class="btn btn-sm btn-outline-dark me-2" onclick='openEdit(${JSON.stringify(item)})'>
          <i class="bi bi-pencil-fill"></i>
        </button>
        <button class="btn btn-sm btn-outline-danger" onclick='deleteUrl(${item.id})'>
          <i class="bi bi-trash-fill"></i>
        </button>
      </td>
    `;
    tbody.appendChild(tr);
  });
}

// === OPEN EDIT MODAL ===
window.openEdit = function (item) {
  document.getElementById("edit-id").value = item.id;
  document.getElementById("edit-url").value = item.url;
  document.getElementById("edit-label").value = item.label || "";
//   document.getElementById("edit-region").value = item.region || "";
//   document.getElementById("edit-status").value = item.status;

  const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById("editUrlModal"));
  modal.show();
};

// === DELETE URL ===
window.deleteUrl = async function (id) {
  if (!confirm("Are you sure you want to delete this URL?")) return;
  const res = await callApi("delete_url", { id });
  if (!res.success) return;

  showUserMessage("URL deleted successfully", "success");
  loadUrls();
};
