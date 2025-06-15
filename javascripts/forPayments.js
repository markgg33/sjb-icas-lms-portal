document
  .getElementById("applyPaymentBtn")
  .addEventListener("click", function () {
    const id = selectedStudentId; // must be declared globally on selection
    const amount = parseFloat(document.getElementById("paymentInput").value);
    if (isNaN(amount) || amount <= 0) return alert("Enter valid amount");

    if (!confirm("Apply payment of ₱" + amount.toFixed(2) + "?")) return;

    fetch("update_balance.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "id=" + id + "&amount=" + amount,
    })
      .then((res) => res.json())
      .then((data) => {
        alert(data.message);
        if (data.status === "success") {
          document.getElementById("balanceInput").value = data.new_balance;
          document.getElementById("paymentInput").value = "";
        }
      });
  });
