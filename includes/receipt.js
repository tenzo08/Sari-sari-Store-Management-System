window.onload = function () {
    const cartData = JSON.parse(localStorage.getItem("cartData") || "[]");
    const totalAmount = parseFloat(localStorage.getItem("totalAmount")) || 0;
    const change = parseFloat(localStorage.getItem("change")) || 0;
    const tendered = parseFloat(localStorage.getItem("amountTendered")) || totalAmount;
    const cashierName = localStorage.getItem("cashierName") || "Unknown";
  
    const receiptItems = document.getElementById("receipt-items");
  
    if (cartData.length === 0) {
      receiptItems.innerHTML = "<tr><td colspan='4'>No items in cart.</td></tr>";
    } else {
      cartData.forEach(item => {
        const row = document.createElement("tr");
        row.innerHTML = `
          <td>${item.name}</td>
          <td>₱${parseFloat(item.price).toFixed(2)}</td>
          <td>${item.quantity}</td>
          <td>₱${(item.price * item.quantity).toFixed(2)}</td>
        `;
        receiptItems.appendChild(row);
      });
    }
  
    document.getElementById("cashier-name").textContent = cashierName;
    document.getElementById("total-amount").textContent = totalAmount.toFixed(2);
    document.getElementById("amount-tendered").textContent = tendered.toFixed(2);
    document.getElementById("change-amount").textContent = change.toFixed(2);
  
    recordTransaction();
  
    setTimeout(() => {
      localStorage.removeItem("cartData");
      localStorage.removeItem("totalAmount");
      localStorage.removeItem("amountTendered");
      localStorage.removeItem("change");
      localStorage.removeItem("cashierName");
    }, 1000);
  };
  
  document.getElementById("printReceiptButton").addEventListener("click", () => {
    window.print();
  });
  
  document.getElementById("backButton").addEventListener("click", () => {
    window.location.href = "cashier-page.php";
  });
  
  function recordTransaction() {
    const cartData = JSON.parse(localStorage.getItem("cartData") || "[]");
    const totalAmount = parseFloat(localStorage.getItem("totalAmount")) || 0;
    const change = parseFloat(localStorage.getItem("change")) || 0;
    const cashierName = localStorage.getItem("cashierName") || "Unknown";
  
    fetch("../includes/recordTransaction.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        cashierName: cashierName,
        totalAmount: totalAmount,
        change: change,
        items: cartData
      })
    })
    .then(response => response.json())
    .then(result => {
      if (result.success) {
        console.log("Transaction recorded.");
      } else {
        console.error("Failed to record:", result.error);
      }
    })
    .catch(err => {
      console.error("Error posting transaction:", err);
    });
  }
  