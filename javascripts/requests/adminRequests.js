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
        r.attachment
          ? `<a href="${r.attachment}" target="_blank" class="btn btn-sm btn-primary">📎 View File</a>`
          : `<span class="text-muted">—</span>`
      }
    </td>
    <td>
      ${
        r.status === "Pending"
          ? `
        <form class="d-flex gap-1" onsubmit="return submitApprovalWithFile(event, ${r.id})" enctype="multipart/form-data">
          <input type="file" name="attachment" accept=".pdf,.doc,.docx" class="form-control form-control-sm" required>
          <button type="submit" class="btn btn-sm btn-success">Approve</button>
        </form>
        <button class="btn btn-sm btn-danger mt-1" onclick="rejectRequest(${r.id})">Reject</button>`
          : ""
      }
    </td>
  </tr>`;
  });

  $("#adminRequestsTable tbody").html(html);
}

loadAdminRequests(); // initial load ✅

// 🔁 Auto-refresh every 5s *only if visible*
setInterval(() => {
  const isVisible = $("#requests-page").is(":visible");
  const hasPendingFile = $("input[type='file'][name='attachment']")
    .toArray()
    .some((input) => input.files.length > 0);

  if (isVisible && !hasPendingFile) {
    loadAdminRequests();
  }
}, 5000);

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

//ADDED CONFIRMATION
function approveRequest(id) {
  if (confirm("Approve this request?")) {
    updateRequest(id, "Approved");
  }
}

function rejectRequest(requestId) {
  if (!confirm("Are you sure you want to reject this request?")) return;

  fetch("admin_reject_request.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "id=" + requestId,
  })
    .then((res) => res.json())
    .then((data) => {
      alert(data.message);
      if (data.status === "success") loadAdminRequests();
    })
    .catch((err) => {
      console.error("Reject error:", err);
      alert("Failed to reject request.");
    });
}
