function showHome() {
    document.getElementById("main-content").classList.remove("hidden");
    document.getElementById("student-bill-content").classList.add("hidden");
}
function showBill() {
    document.getElementById("main-content").classList.add("hidden");
    document.getElementById("student-bill-content").classList.remove("hidden");
}
const orderedUser=[
    {
        userId:101,
        userName:"Soumojit Makar",
        userPhone:8250431994,
        totalAmount:400,
        totalItem:6,
        orderStatus:"panding",
        orderedItems:[
            {
                id: 101,
                name: "Product 1",
                price: 50,
                count: 4,
                image: '/views/images/food.jpg',
                totalPrice: 200
            },
            {
                id: 102,
                name: "Product 2",
                price: 100,
                count: 2,
                image: '/views/images/food.jpg',
                totalPrice: 200
            },

        ]
    },
    {
        userId:102,
        userName:"Ram",
        userPhone:8250431994,
        totalAmount:400,
        totalItem:6,
        orderedItems:[
            {
                id: 101,
                name: "Product 1",
                price: 50,
                count: 4,
                image: '/views/images/food.jpg',
                totalPrice: 200
            },
            {
                id: 102,
                name: "Product 2",
                price: 100,
                count: 2,
                image: '/views/images/food.jpg',
                totalPrice: 200
            },

        ]
    }
]
function loadTable(){
    const list=document.getElementById("user-table");
    list.innerHTML='';
    orderedUser.forEach((item,index)=>{
        const row=document.createElement('tr');
        row.innerHTML=`
            
            <td>${item.userName}</td>
            <td>&phone; ${item.userPhone}</td>
            <td>${item.totalItem}</td>
            <td>${item.totalAmount}</td>
            <td class="button-containers">
                <button style="width:45px" onclick="showUserOrder(${item.userId})" >👁️</button>
            </td>
        `;
        list.appendChild(row);
    })
}
function showUserOrder(id){
    let user= orderedUser.filter((user)=>user.userId===id)[0];
    const list=document.getElementById("user-bill-table");
    list.innerHTML='';
    user.orderedItems.forEach((item,index)=>{
        const row=document.createElement('tr');
        
        row.innerHTML=`
            
            <td>${item.name}</td>
            <td>${item.count}</td>
            <td>${item.price}</td>
            <td>${item.totalPrice}</td>
        `;
        list.appendChild(row);
    })
    
    
    document.getElementById("total-amount").innerText=user.totalAmount;
    document.getElementById("total-quentity").innerText=user.totalItem;
    document.getElementById("bill-name").innerText=user.userName;
    document.getElementById("bill-phone").innerText=user.userPhone;
    showBill()
}
document.addEventListener("DOMContentLoaded",()=>{
    loadTable()
})