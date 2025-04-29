<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Receipt - Sari-Sari Store</title>
  <link rel="stylesheet" href="../assets/receipt-style.css" />
</head>
<body>
  <div id="receipt-container">
    <h2>Receipt</h2>
    <p><strong>Cashier:</strong> <span id="cashier-name"></span></p>

    <table id="receipt-table">
      <thead>
        <tr>
          <th>Item</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody id="receipt-items"></tbody>
    </table>

    <p><strong>Total Amount:</strong> ₱<span id="total-amount"></span></p>
    <p><strong>Amount Tendered:</strong> ₱<span id="amount-tendered"></span></p>
    <p><strong>Change:</strong> ₱<span id="change-amount"></span></p>

    <button id="printReceiptButton">Print Receipt</button>
    <button id="backButton">Back to Cashier</button>
  </div>

  <!-- Link to external JS -->
  <script src="../includes/receipt.js"></script>
</body>
</html>
