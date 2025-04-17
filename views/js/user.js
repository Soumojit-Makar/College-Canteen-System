let items = [];
const state = {
  counts: []
};
function showOrderMenu() {
  document.getElementById("main-content").classList.add("hidden");
  document.getElementById("order-menu-form").classList.remove("hidden");
  document.getElementById("billing-container").classList.add("hidden");
  fetchItemsFromBackend(); 
}

function showHome() {
  document.getElementById("main-content").classList.remove("hidden");
  document.getElementById("order-menu-form").classList.add("hidden");
  document.getElementById("billing-container").classList.add("hidden");
}

function showBilling() {
  document.getElementById("main-content").classList.add("hidden");
  document.getElementById("order-menu-form").classList.add("hidden");
  document.getElementById("billing-container").classList.remove("hidden");
}

function goBack() {
  showHome();
}
function searchItems() {
  const term = document.getElementById('searchInput').value;
  fetchItemsFromBackend(term);
}

async function fetchItemsFromBackend(searchTerm = '') {
  try {
    const response = await fetch('../../backend/logic/getItems.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `search=${encodeURIComponent(searchTerm)}`
    });

    const data = await response.json();

    if (Array.isArray(data)) {
      items = data.map(item => ({
        id: parseInt(item.item_id),
        image: `../images/${item.product_image}`,
        name: item.item_name,
        price: parseFloat(item.item_price),
        avability: parseInt(item.item_quantity)
      }));

      state.counts = Array(items.length).fill(0);
      renderItems();
    } else {
      showToast(data.message || "Something went wrong!", "error");
    }
  } catch (error) {
    console.error("Error fetching items:", error);
    showToast("Failed to fetch items!", "error");
  }
}
function renderItems() {
  const list = document.getElementById('item-list');
  list.innerHTML = '';

  items.forEach((item, index) => {
    const count = state.counts[index];

    const row = document.createElement('div');
    row.className = 'row';

    row.innerHTML = `
      <img src="${item.image}" alt="image" style="width: 40px; height: 40px; margin-right: 10px;">
      <div style="flex: 1;">
        <strong>${item.name}</strong><br>
        Price: ₹${item.price}<br>
        Available: ${item.avability}
      </div>
      <div class="item-controls" style="display: flex; align-items: center;">
        <button onclick="updateCount(${index}, -1)" ${count === 0 ? 'disabled' : ''}>−</button>
        <span style="margin: 0 10px;">${count}</span>
        <button onclick="updateCount(${index}, 1)" ${count >= item.avability ? 'disabled' : ''}>+</button>
      </div>
    `;

    list.appendChild(row);
  });

  updateSummary();
}
function updateCount(index, delta) {
  const item = items[index];
  const newCount = state.counts[index] + delta;

  if (newCount >= 0 && newCount <= item.avability) {
    state.counts[index] = newCount;
    renderItems();
  }
}
function updateSummary() {
  const totalItems = state.counts.reduce((a, b) => a + b, 0);
  const totalAmount = state.counts.reduce((sum, count, i) => sum + count * items[i].price, 0);
  document.getElementById('totalItems').innerText = totalItems;
  document.getElementById('totalAmount').innerText = totalAmount;
}
function getSelectedItems() {
  return items
    .map((item, index) => ({
      id: item.id,
      name: item.name,
      price: item.price,
      count: state.counts[index],
      image: item.image,
      totalPrice: item.price * state.counts[index]
    }))
    .filter(item => item.count > 0);
}
function checkout() {
  const selectedItems = getSelectedItems();

  if (selectedItems.length === 0) {
    showToast("No items selected!", "error");
    return;
  }

  const list = document.getElementById('order-item-list');
  list.innerHTML = '';

  let totalItems = 0;
  let totalAmount = 0;

  selectedItems.forEach(item => {
    const row = document.createElement('div');
    row.className = 'row item-container';

    row.innerHTML = `
      <img src="${item.image}" alt="image" style="width: 40px; height: 40px; margin-right: 10px;">
      <div class='item-container'>
        <strong>${item.name}</strong>
        <p> Price: ₹${item.totalPrice} </p>
        <p> Quantity: ${item.count} </p>
      </div>
    `;

    list.appendChild(row);
    totalAmount += item.totalPrice;
    totalItems += item.count;
  });

  document.getElementById('billing-totalItems').innerText = totalItems;
  document.getElementById('billing-totalAmount').innerText = totalAmount;

  showBilling();
  // console.log("Sending to backend:", selectedItems);
}
