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

//FOR DASHBOARD

document.addEventListener("DOMContentLoaded", () => {
  fetch("get_student_dashboard_info.php")
    .then((res) => res.json())
    .then((data) => {
      document.getElementById("studentName").textContent = data.name;
      document.getElementById("studentCourseYear").textContent = `${
        data.course
      } - ${ordinal(data.year_level)} Year`;
      document.getElementById("studentBalance").textContent =
        "₱" + parseFloat(data.balance).toFixed(2);
      document.getElementById("studentPendingRequests").textContent =
        data.pending_requests;

      /* Load photo if available
      const photo = data.photo
        ? `uploads/students/${data.photo}`
        : "uploads/students/default.png";
      document.getElementById("studentPhoto").src = photo;*/
    });
});

function ordinal(n) {
  const suffix = ["th", "st", "nd", "rd"],
    v = n % 100;
  return n + (suffix[(v - 20) % 10] || suffix[v] || suffix[0]);
}

