$("#studentRequestForm").on("submit", async function (e) {
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

loadStudentRequests();
