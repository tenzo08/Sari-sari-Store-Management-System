// Function to show transaction details
function showTransactionDetails(transactionId) {
    fetch(`../includes/getTransactionDetails.php?transaction_id=${transactionId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`Transaction Details:\n\n${data.details}`);
            } else {
                alert("Failed to fetch transaction details.");
            }
        })
        .catch(error => console.error("Error fetching transaction details:", error));
}

// Function to cancel a transaction
function cancelTransaction(transactionId) {
    if (confirm("Are you sure you want to cancel this transaction?")) {
        fetch(`../includes/cancelTransaction.php?transaction_id=${transactionId}`, { method: 'POST' })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Transaction cancelled successfully.");
                    location.reload();
                } else {
                    alert("Failed to cancel transaction.");
                }
            })
            .catch(error => console.error("Error cancelling transaction:", error));
    }
}
