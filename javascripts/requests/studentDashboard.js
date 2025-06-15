async function loadStudentRequests(page = 1) {
  const res = await fetch(`student_get_requests.php?page=${page}`);
  const data = await res.json();
  const { requests, total, limit } = data;

  let html = `
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Type</th>
            <th>Description</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
  `;

  if (requests.length > 0) {
    requests.forEach((r) => {
      html += `
        <tr>
          <td>${r.id}</td>
          <td>${r.type}</td>
          <td>${r.description}</td>
          <td>${r.status}</td>
        </tr>
      `;
    });
  } else {
    html += `<tr><td colspan="4" class="text-center">No requests found</td></tr>`;
  }

  html += `</tbody></table></div>`;

  // Pagination logic
  const totalPages = Math.ceil(total / limit);
  if (totalPages > 1) {
    html += `<nav><ul class="pagination justify-content-center">`;
    for (let i = 1; i <= totalPages; i++) {
      html += `
        <li class="page-item ${i === data.page ? "active" : ""}">
          <button class="page-link" onclick="loadStudentRequests(${i})">${i}</button>
        </li>
      `;
    }
    html += `</ul></nav>`;
  }

  document.getElementById("studentRequestsList").innerHTML = html;
}

// Auto-refresh student request table every 5 seconds if visible
setInterval(() => {
  if ($("#requests-page").is(":visible")) {
    loadStudentRequests();
  }
}, 5000);

// Load once on page load
loadStudentRequests();
