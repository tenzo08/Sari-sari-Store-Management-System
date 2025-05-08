let currentSearchTerm = "";
let inventoryItems = [];
let cartItems = [];

function fetchInventory() {
    console.log("Fetching inventory...");

    fetch('../includes/getinventory.php')
        .then(response => {
            if (!response.ok) {
                throw new Error("HTTP error! Status: " + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log("Inventory received:", data);
            inventoryItems = data;

            if (!Array.isArray(data)) {
                alert("Unexpected data format!");
                return;
            }

            if (data.length === 0) {
                alert("No inventory items found!");
                return;
            }

            displayInventory(filterInventory(currentSearchTerm));
        })
        .catch(error => {
            console.error("Fetch error:", error);
        });
}

function increment(item) {
    const inventoryItem = inventoryItems.find(invItem => invItem.name === item.name);
    if (inventoryItem && inventoryItem.stock > 0) {
        const existingItem = cartItems.find(cartItem => cartItem.name === item.name);
        if (existingItem) {
            existingItem.quantity++;
        } else {
            cartItems.push({ id: item.id, name: item.name, price: item.price, quantity: 1 });
        }

        inventoryItem.stock--;
        updateStockInDatabase(inventoryItem);
        populateCart(); 
        updateTotalAmount();
        displayInventory(filterInventory(currentSearchTerm));
    } else {
        alert("Sorry, out of stock!");
    }
}

function decrement(item) {
    const inventoryItem = inventoryItems.find(invItem => invItem.name === item.name);
    const existingItem = cartItems.find(cartItem => cartItem.name === item.name);

    if (existingItem) {
        if (existingItem.quantity > 1) {
            existingItem.quantity--;
            inventoryItem.stock++;
            updateStockInDatabase(inventoryItem);
        } 
        else {
            cartItems = cartItems.filter(cartItem => cartItem.name !== item.name);
            inventoryItem.stock++;
            updateStockInDatabase(inventoryItem);
        }

        populateCart();
        updateTotalAmount();
        displayInventory(filterInventory(currentSearchTerm));
    }
}



function populateCart() {
    const cartTableBody = document.getElementById('cart-items');
    cartTableBody.innerHTML = '';

    cartItems.forEach((item, index) => {
        const row = document.createElement('tr');
        
        const nameCell = document.createElement('td');
        nameCell.textContent = item.name;
        row.appendChild(nameCell);

        const priceCell = document.createElement('td');
        priceCell.textContent = '₱' + (item.price * item.quantity).toFixed(2);
        row.appendChild(priceCell);

        const quantityCell = document.createElement('td');
        const div = document.createElement('div');
        div.classList.add('item-quantity');

        const decrementButton = document.createElement('button');
        decrementButton.classList.add('decrement');
        decrementButton.innerHTML = '-';
        decrementButton.addEventListener('click', () => {
            decrement(item);
        });

        const quantityInput = document.createElement('input');
        quantityInput.type = 'number';
        quantityInput.id = `quantity-${index}`;
        quantityInput.value = item.quantity;
        quantityInput.min = 1;
        quantityInput.classList.add('quantity-input');
        quantityInput.disabled = true;

        const incrementButton = document.createElement('button');
        incrementButton.classList.add('increment');
        incrementButton.innerHTML = '+';
        incrementButton.addEventListener('click', () => {
            increment(item);
        });

        div.appendChild(decrementButton);
        div.appendChild(quantityInput);
        div.appendChild(incrementButton);

        quantityCell.appendChild(div);
        row.appendChild(quantityCell);  
        cartTableBody.appendChild(row);
    });
}

function updateTotalAmount(){
    let total = 0;
    const rows = document.querySelectorAll('#cart-items tr');
    rows.forEach((row, index) => {
        const quantityInput = row.querySelector('.quantity-input');
        const quantity = parseInt(quantityInput.value);
        const item = cartItems[index];
        const totalPrice = item.price * quantity;

        row.children[1].textContent = '₱' + totalPrice.toFixed(2);
        total += totalPrice;
    });
    document.getElementById('total-amount').textContent = total.toFixed(2);
}

function displayInventory(items) {
    const inventoryList = document.getElementById("inventory-list");
    inventoryList.innerHTML = '';

    items.forEach(item => {
        if (!item.name || item.price == null || item.stock == null) {
            console.error("Missing properties for item:", item);
            return;
        }

        const itemDiv = document.createElement('div');
        itemDiv.classList.add('inventory-item');

        const formattedPrice = isNaN(parseFloat(item.price)) ? "0.00" : parseFloat(item.price).toFixed(2);

        const namePrice = document.createElement('span');
        namePrice.textContent = `${item.name} - ₱${formattedPrice} (Stocks: ${item.stock})`;

        const addButton = document.createElement('button');
        addButton.textContent = "Add to Cart";
        addButton.classList.add('add-to-cart');
        addButton.onclick = () => addToCart(item);

        itemDiv.appendChild(namePrice);
        itemDiv.appendChild(addButton);
        inventoryList.appendChild(itemDiv);
    });
}

function updateStockInDatabase(item) {
    fetch('../includes/updateStock.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ name: item.name, stock: item.stock })
    })
    .then(response => response.json())
    .then(result => {
        if (!result.success) {
            console.error("Failed to update stock:", result.error);
        }
    })
    .catch(error => {
        console.error("Error updating stock:", error);
    });
}

function addToCart(item) {
    if (item.stock > 0) {
        const existingItem = cartItems.find(cartItem => cartItem.name === item.name);
        if (existingItem) {
            existingItem.quantity++;
        } else {
            cartItems.push({ id: item.id, name: item.name, price: item.price, quantity: 1 });
        }

        item.stock--;
        updateStockInDatabase(item);
        populateCart(); 
        updateTotalAmount();
        displayInventory(filterInventory(currentSearchTerm));
    } else {
        alert("Sorry, out of stock!");
    }
}

document.getElementById("inventory-search-input").addEventListener("input", function () {
    currentSearchTerm = this.value.toLowerCase();
    const filteredItems = filterInventory(currentSearchTerm);
    displayInventory(filteredItems);
});

function filterInventory(searchTerm) {
    if (searchTerm === "") {
        return inventoryItems;
    } else {
        return inventoryItems.filter(item => item.name.toLowerCase().includes(searchTerm));
    }
}

window.onload = () => {
    fetchInventory();
    populateCart();
    updateTotalAmount();
};

document.getElementById("checkout-button").addEventListener("click", function () {
    const cartData = cartItems;

    const totalAmountText = document.getElementById("total-amount").textContent.replace('Total Amount: ₱', '').trim();
    const totalAmount = parseFloat(totalAmountText);

    const amountReceived = parseFloat(document.getElementById("amount-received").value);

    console.log("Total Amount Text: " + totalAmountText);
    console.log("Total Amount: " + totalAmount);
    console.log("Amount Received: " + amountReceived);

    if (!isNaN(totalAmount) && !isNaN(amountReceived)) {
        if (cartData.length > 0 && amountReceived >= totalAmount) {
            const change = amountReceived - totalAmount;
            const cashierName = "<?php echo isset($_SESSION['user']) ? $_SESSION['user'] : 'Unknown'; ?>";
            
            localStorage.setItem("cartData", JSON.stringify(cartData));
            localStorage.setItem("totalAmount", totalAmount.toFixed(2));
            localStorage.setItem("cashierName", cashierName);
            localStorage.setItem("change", change.toFixed(2));
            
            window.location.href = "receipt.php";
        } else {
            alert("Amount received is not sufficient. Total amount is ₱" + totalAmount.toFixed(2) + ". Please provide the correct amount.");
        }
    } else {
        alert("There was an issue with the amount values. Please check and try again.");
    }
});
