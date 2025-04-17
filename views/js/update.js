let items = [];
const state = {
  counts: []
};
async function fetchItemsFromBackend(searchTerm = '') {
  try {
    const response = await fetch('../../../backend/logic/getItems.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `search=${encodeURIComponent(searchTerm)}`
    });

    const data = await response.json();

    if (Array.isArray(data)) {
      items = data.map(item => ({
        id: parseInt(item.item_id),
        image: `../../images/${item.product_image}`,
        name: item.item_name,
        price: parseFloat(item.item_price),
        avability: parseInt(item.item_quantity)
      }));

      state.counts = Array(items.length).fill(0);
      loadTable()
    } else {
      showToast(data.message || "Something went wrong!", "error");
    }
  } catch (error) {
    console.error("Error fetching items:", error);
    showToast("Failed to fetch items!", "error");
  }
}
function showHome() {
  document.getElementById("main-content").classList.remove("hidden");
  document.getElementById("add-item-content").classList.add("hidden");
  document.getElementById("update-item-content").classList.add("hidden");

}
function showAddItemForm() {
  document.getElementById("main-content").classList.add("hidden");
  document.getElementById("add-item-content").classList.remove("hidden");
  document.getElementById("update-item-content").classList.add("hidden");
}
function showUpdateItemForm() {
  document.getElementById("main-content").classList.add("hidden");
  document.getElementById("add-item-content").classList.add("hidden");
  document.getElementById("update-item-content").classList.remove("hidden");
}
function loadTable() {
  const list = document.getElementById("product-table");
  list.innerHTML = '';
  items.forEach((item, index) => {
    const row = document.createElement('tr');
    row.innerHTML = `
            <td> <img src="${item.image}"/></td>
            <td>${item.name}</td>
            <td>&#8377 ${item.price}</td>
            <td>${item.avability}</td>
            <td class="button-containers">
                <button style="width:45px" onclick="updateProduct(${item.id})" >✒️</button>
                <button style="width:45px" class="back-button">🗑️</button>
            </td>
        `;
    list.appendChild(row);
  })
}
function updateProduct(id) {
  let product = items.filter((item) => item.id === id)[0];
  document.getElementById("product-name").value = product.name;
  document.getElementById("product-price").value = product.price;
  document.getElementById("product-quentity").value = product.avability;
  document.getElementById("product-update-image").src = product.image

  showUpdateItemForm()
}
document.addEventListener("DOMContentLoaded", () => {
  fetchItemsFromBackend()
  
})
function searchItems() {
  const term = document.getElementById('searchInput').value;
  fetchItemsFromBackend(term);
}

function addItem() {
  const name = document.getElementById("name").value;
  const price = document.getElementById("price").value;
  const quantity = document.getElementById("quantity").value;
  const imageFile = document.getElementById("imageInput").files[0];
  // console.log("name",name);
  // console.log("price",price);
  // console.log("Quentity",quantity);
  // console.log("file",imageFile);

  if (!name || !price || !quantity || !imageFile) {
    alert("All fields are required! 1");
    return;
  }

  const formData = new FormData();
  formData.append("name", name);
  formData.append("price", price);
  formData.append("quentity", quantity);
  formData.append("image", imageFile);

  fetch("../../../backend/logic/addItem.php", {
    method: "POST",
    body: formData
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert(data.message);
      } else {
        alert(data.message);
      }
      showHome()
    })
    .catch(err => {
      console.error(err);
      alert("Something went wrong while adding the item.");
    });

}

function update(){

}