function showHome() {
    document.getElementById("main-content").classList.remove("hidden");
    document.getElementById("student-bill-content").classList.add("hidden");
}

function showBill() {
    document.getElementById("main-content").classList.add("hidden");
    document.getElementById("student-bill-content").classList.remove("hidden");
}

let orderedUser = [];

function loadTable() {
    const list = document.getElementById("user-table");
    list.innerHTML = '';

    orderedUser.forEach((item, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${item.userName}</td>
            <td>📞 ${item.userPhone}</td>
            <td>${item.totalItem}</td>
            <td>${item.totalAmount}</td>
            <td class="button-containers">
                <button style="width:45px" onclick="showUserOrder(${item.userId})">👁️</button>
            </td>
        `;
        list.appendChild(row);
    });
}

function showUserOrder(id) {
    const user = orderedUser.find(user => parseInt(user.userId) === parseInt(id));
    console.log("Selected user ID:", id);
    console.log("Matched user:", user);

    if (!user) {
        // alert("User not found!");
        showToast("User not found!", "error", 3000);
        return;
    }

    const list = document.getElementById("user-bill-table");
    if (list) {
        list.innerHTML = '';
        user.orderedItems.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.name}</td>
                <td>${item.count}</td>
                <td>${item.price}</td>
                <td>${item.totalPrice}</td>
            `;
            list.appendChild(row);
        });
    }

    document.getElementById("total-amount").textContent = user.totalAmount;
    document.getElementById("total-quentity").textContent = user.totalItem;
    document.getElementById("bill-name").textContent = user.userName;
    document.getElementById("bill-phone").textContent = user.userPhone;

    const billButtons = document.getElementById("bill-buttons");

    if (!billButtons) {
        // console.error("Element with id 'bill-buttons' not found.");
        
        showToast("Element with id 'bill-buttons' not found.", "error", 3000);
        return; 
    }

    const button = document.createElement("div");
   
    button.style.width = "100%";
    button.style.display = "flex";
    button.style.justifyContent = "space-between";
    button.style.alignItems = "center";
    button.style.padding = "10px";
    button.innerHTML = `
    
        <button class="confirm-button" id="confirm-button" style="width: 60%;" onclick="handlePayment(${user.userId})">Payment Received</button>
        <button class="back-button" onclick="showHome()" style="width: 30%;" >Back</button>
    `;
    billButtons.innerHTML = ''; 
    billButtons.appendChild(button);
    
    
        

    showBill();
}

function handlePayment(id) {
    const confirmButton = document.getElementById("confirm-button");
    confirmButton.innerText = "Processing...";
    confirmButton.disabled = true;

    const formData = new FormData();
    formData.append('userId', id);

    fetch('../../../backend/logic/confirmPayment.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // alert("Payment confirmed successfully!");
            showToast("Payment confirmed successfully!", "success", 3000);
            fetchPendingOrders();
            showHome();
        } else {
            // alert("Failed to confirm payment. Please try again.");
            showToast("Failed to confirm payment. Please try again.", "error", 3000);
        }
    })
    .catch(error => {
        console.error("Error confirming payment:", error);
        showToast("Error confirming payment. Please try again.", "error", 3000);
    })
    .finally(() => {
        confirmButton.innerText = "Payment Received";
        confirmButton.disabled = false;
    });
}

function fetchPendingOrders() {
    fetch('../../../backend/logic/getPandingOrderInformation.php')
        .then(response => response.json())
        .then(data => {
            orderedUser = data;
            loadTable();
        })
        .catch(error => {
            // console.error("Failed to load pending orders:", error);
            showToast("Failed to load pending orders. Please try again.", "error", 3000);
        });
}

document.addEventListener("DOMContentLoaded", () => {
    fetchPendingOrders();
});
