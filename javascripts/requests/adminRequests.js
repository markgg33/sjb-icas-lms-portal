async function loadAdminRequests() {
  const res = await fetch("admin_get_requests.php");
  const list = await res.json();
  let html = "";
  list.forEach((r) => {
    html += `<tr>
        <td>${r.id}</td>
        <td>${r.student_name}</td>
        <td>${r.type}</td>
        <td>${r.description}</td>
        <td>${r.status}</td>
        <td>
          ${
            r.status === "Pending"
              ? `
            <button class="btn btn-success btn-sm me-2" onclick="approveRequest(${r.id})">Approve</button>
            <button class="btn btn-danger btn-sm" onclick="rejectRequest(${r.id})">Reject</button>`
              : ""
          }
        </td></tr>`;
  });
  $("#adminRequestsTable tbody").html(html);
}
loadAdminRequests();

async function updateRequest(id, status) {
  const res = await fetch("admin_update_request.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id, status }),
  });
  const r = await res.json();
  alert(r.message);
  loadAdminRequests();
}
function approveRequest(id) {
  updateRequest(id, "Approved");
}
function rejectRequest(id) {
  updateRequest(id, "Rejected");
}
