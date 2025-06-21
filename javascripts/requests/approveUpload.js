async function submitApprovalWithFile(event, requestId) {
  event.preventDefault();

  const form = event.target;
  const formData = new FormData(form);
  formData.append("id", requestId);

  if (!confirm("Approve and send this file to the student?")) return;

  const res = await fetch("admin_approve_with_file.php", {
    method: "POST",
    body: formData,
  });

  const r = await res.json();
  alert(r.message);
  loadAdminRequests();
  return false;
}
