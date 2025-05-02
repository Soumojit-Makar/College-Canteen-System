let orderReport = [];

function getReportFromServer() {
    fetch('/backend/logic/getUserOrders.php')
        .then(response => response.json())
        .then(data => {
            if (data) {
                orderReport = data;
                generateReport();
            } else {
                console.error(data.message);
            }
        })
        .catch(error =>{
             console.error('Error fetching report:', error);
             showToast("Failed to fetch report. Please try again.", "error", 3000);
        
});
}
function getCancelOrderFromServer(orderId, callback) {
    const formData = new FormData();
    formData.append('billId', orderId);

    fetch(`/backend/logic/cancelOrder.php`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data) {
            alert(`Order ID ${orderId} has been cancelled.`);
            if (callback) callback();
        } else {
            console.error(data.message);
        }
    })
    .catch(error => {

    // console.error('Error cancelling order:', error)
    showToast("Failed to cancel order. Please try again.", "error", 3000);
    
}
);
}

function generateReport() {
    const reportContainer = document.getElementById("reportContainer");
    reportContainer.innerHTML = "";
    reportContainer.style.display = "flex";
    reportContainer.style.flexDirection = "column";
    reportContainer.style.gap = "10px";
    reportContainer.style.padding = "20px";

    orderReport.forEach(order => {
        const orderDiv = document.createElement("div");
        orderDiv.style.border = "1px solid #ccc";
        orderDiv.style.padding = "5px";
        orderDiv.style.borderRadius = "5px";
        orderDiv.className = "order";

        const orderHeader = document.createElement("p");
        orderHeader.textContent = `Bill ID: ${order.billId} | Date: ${order.billDate}`;
        orderDiv.appendChild(orderHeader);

        const billAmount = document.createElement("p");
        billAmount.textContent = `Amount: ₹${order.billAmount.toFixed(2)} | Status: ${order.billStatus}`;
        orderDiv.appendChild(billAmount);

        const billButton = document.createElement("button");
        billButton.textContent = "View Bill Details";
        billButton.style = "width: 80%; margin-top: 10px; padding: 5px 10px; border: none; border-radius: 5px; background-color: #007BFF; color: #fff; cursor: pointer;";

        const detailsDiv = document.createElement("div");

        billButton.addEventListener("click", () => {
            detailsDiv.innerHTML = "";
            detailsDiv.style.marginTop = "10px";
            order.billDetails.forEach(detail => {
                const detailItem = document.createElement("p");
                detailItem.textContent = `Item: ${detail.item} | Quantity: ${detail.quantity} | Price: ₹${detail.price.toFixed(2)}`;
                detailsDiv.appendChild(detailItem);
            });
            orderDiv.appendChild(detailsDiv);
        });

        orderDiv.appendChild(billButton);

        if (order.billStatus === "PENDING") {
            const cancelButton = document.createElement("button");
            cancelButton.textContent = "Cancel Order";
            cancelButton.style = "width: 80%; margin-top: 10px; padding: 5px 10px; border: none; border-radius: 5px; background-color: #dc3545; color: #fff; cursor: pointer;";

            cancelButton.addEventListener("click", () => {
                getCancelOrderFromServer(order.billId, () => {
                    getReportFromServer(); 
                });
            });

            orderDiv.appendChild(cancelButton);
        }

        reportContainer.appendChild(orderDiv);
    });
}

document.addEventListener("DOMContentLoaded", getReportFromServer);
