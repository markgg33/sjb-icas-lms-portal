/*$("#studentRequestForm").on("submit", async function (e) { WORKING VERSION
  e.preventDefault();

  if (!confirm("Are you sure you want to submit this request?")) return;

  const fd = new FormData(this);
  const res = await fetch("student_submit_request.php", {
    method: "POST",
    body: fd,
  });
  const r = await res.json();
  alert(r.message);
  if (r.status === "success") loadStudentRequests();
});

async function loadStudentRequests() {
  const res = await fetch("student_get_requests.php");
  const list = await res.json();
  let html = `<table class="table"><tr><th>Type</th><th>Status</th><th>Submitted At</th></tr>`;
  list.forEach((r) => {
    html += `<tr><td>${r.type}</td><td>${r.status}</td><td>${r.created_at}</td></tr>`;
  });
  html += "</table>";
  $("#studentRequestsList").html(html);
}

loadStudentRequests();*/

// Show/hide faculty dropdown
$("#requestType").on("change", function () {
  if (this.value === "Grades") {
    $("#facultyDropdownContainer").removeClass("d-none");
    loadFacultyList(); // loads dropdown dynamically
  } else {
    $("#facultyDropdownContainer").addClass("d-none");
  }
});

function loadFacultyList() {
  fetch("get_faculty_for_student.php")
    .then((res) => res.json())
    .then((data) => {
      const select = document.getElementById("facultyDropdown");
      select.innerHTML = '<option value="">Select Faculty</option>';
      data.forEach((f) => {
        select.innerHTML += `<option value="${f.id}">${f.name}</option>`;
      });
    });
}

$("#studentRequestForm").on("submit", async function (e) {
  e.preventDefault();
  if (!confirm("Submit this request?")) return;

  const fd = new FormData(this);
  const res = await fetch("student_submit_request.php", {
    method: "POST",
    body: fd,
  });
  const r = await res.json();
  alert(r.message);
  if (r.status === "success") {
    this.reset();
    $("#facultyDropdownContainer").addClass("d-none");
    loadStudentRequests(1);
  }
});

async function loadStudentRequests(page = 1) {
  const res = await fetch(`student_get_requests.php?page=${page}`);
  const data = await res.json();
  const list = data.requests;
  let html = `<table class="table table-bordered"><thead><tr><th>Type</th><th>Status</th><th>Submitted At</th></tr></thead><tbody>`;

  list.forEach((r) => {
    html += `<tr><td>${r.type}</td><td>${r.status}</td><td>${r.created_at}</td></tr>`;
  });
  html += `</tbody></table>`;
  $("#studentRequestsList").html(html);

  // Pagination
  let pages = Math.ceil(data.total / data.limit);
  let pagHtml = `<nav><ul class="pagination justify-content-center">`;
  for (let i = 1; i <= pages; i++) {
    pagHtml += `<li class="page-item ${i === data.page ? "active" : ""}">
        <button class="page-link" onclick="loadStudentRequests(${i})">${i}</button>
      </li>`;
  }
  pagHtml += "</ul></nav>";
  $("#studentRequestsPagination").html(pagHtml);
}

loadStudentRequests();
