function showHome() {
    document.getElementById("main-content").classList.remove("hidden");
    document.getElementById("orders").classList.add("hidden");
}
function getOrdersData() {
    const list = document.getElementById('order-user');
    list.innerHTML = '';
    
    orders.forEach((item, index) => {
        const row = document.createElement('div');
        row.className = 'row item-container';
        row.innerHTML = `
            <p>${item.itemName}</p>
            <p>${item.itemQuentity}</p>    
        `;
        list.appendChild(row);
    })
    document.getElementById("main-content").classList.add("hidden");
    document.getElementById("orders").classList.remove("hidden");
}
const orders =[]
function getPandingOrdersItem() {
    fetch('../../backend/logic/getPandingOrdersItem.php')
    .then(response => response.json())
    .then(data => {
        data.forEach(item => {
            console.log(item.itemName, item.itemQuantity);
            orders.push({
                itemName: item.itemName,
                itemQuentity: item.itemQuantity,
            });
        });
        
    document.getElementById("panding-orders-count").innerText= orders.length
    })
    .catch(error => console.error('Error fetching orders:', error));
}
function showTotalOrders() {
    fetch('../../backend/logic/findTotalOrder.php')
    .then(response => response.json())
    .then(data => {
        document.getElementById('day-total').textContent = (data.day ?? 0).toFixed(0);
        document.getElementById('month-total').textContent = (data.month ?? 0).toFixed(0);
        document.getElementById('year-total').textContent = (data.year ?? 0).toFixed(0);
    })
    .catch(error => {
        console.error('Error fetching totals:', error);
        showToast("Failed to fetch totals. Please try again.", "error", 3000);
    });
}
document.addEventListener("DOMContentLoaded",()=>{
    getPandingOrdersItem()
    showTotalOrders()
})

