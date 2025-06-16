async function loadFacultyRequests() {
  const res = await fetch("faculty_get_requests.php");
  const list = await res.json();
  let html = "";
  list.forEach((r, index) => {
    html += `<tr>
      <td>${index + 1}</td>
      <td>${r.student_name}</td>
      <td>${r.type}</td>
      <td>${r.description}</td>
      <td>${r.status}</td>
      <td>${new Date(r.created_at).toLocaleString()}</td>
      <td>
        ${
          r.status === "Pending"
            ? `<button class="btn btn-success btn-sm me-1" onclick="respondToRequest(${r.id}, 'Approved')">Approve</button>
               <button class="btn btn-danger btn-sm" onclick="respondToRequest(${r.id}, 'Rejected')">Reject</button>`
            : "-"
        }
      </td>
    </tr>`;
  });
  document.querySelector("#facultyRequestsTable tbody").innerHTML = html;
}

function respondToRequest(id, status) {
  if (
    !confirm(`Are you sure you want to ${status.toLowerCase()} this request?`)
  )
    return;

  fetch("faculty_update_request.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id, status }),
  })
    .then((res) => res.json())
    .then((r) => {
      alert(r.message);
      if (r.status === "success") loadFacultyRequests();
    });
}

loadFacultyRequests();
setInterval(() => {
  if ($("#facultyRequests-page").is(":visible")) {
    loadFacultyRequests();
  }
}, 10000);
