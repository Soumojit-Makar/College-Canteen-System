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
const orders =[
    {
        itemName: "Product 1",
        itemQuentity:20
    },
    {
        itemName: "Product 2",
        itemQuentity:30
    },
    {
        itemName: "Product 3",
        itemQuentity:5
    },
    {
        itemName: "Product 4",
        itemQuentity:25
    }
]
document.addEventListener("DOMContentLoaded",()=>{
    const len=orders.length
    document.getElementById("panding-orders-count").innerText=len
})

