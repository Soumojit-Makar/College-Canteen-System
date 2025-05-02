let items = [];
const state = {
  counts: [],
  currentPage: 1,
  itemsPerPage: 5
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
  state.currentPage = 1; // Reset page on new search
  fetchItemsFromBackend(term);
}

async function fetchItemsFromBackend(searchTerm = '') {
  try {
    const response = await fetch('/backend/logic/getItems.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `search=${encodeURIComponent(searchTerm)}`
    });

    const data = await response.json();

    if (Array.isArray(data)) {
      items = data.map(item => ({
        id: parseInt(item.item_id),
        image: `/views/images/${item.product_image}`,
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
    showToast("Failed to fetch items!", "error");
  }
}

function renderItems() {
  const list = document.getElementById('item-list');
  list.innerHTML = '';

  const startIndex = (state.currentPage - 1) * state.itemsPerPage;
  const endIndex = startIndex + state.itemsPerPage;
  const visibleItems = items.slice(startIndex, endIndex);

  visibleItems.forEach((item, localIndex) => {
    const globalIndex = startIndex + localIndex;
    const count = state.counts[globalIndex];

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
        <button onclick="updateCount(${globalIndex}, -1)" ${count === 0 ? 'disabled' : ''}>−</button>
        <span style="margin: 0 10px;">${count}</span>
        <button onclick="updateCount(${globalIndex}, 1)" ${count >= item.avability ? 'disabled' : ''}>+</button>
      </div>
    `;

    list.appendChild(row);
  });

  updateSummary();
  renderPaginationControls();
}

function renderPaginationControls() {
  const controls = document.getElementById('pagination-controls');
  controls.innerHTML = '';
controls.style.display = 'flex';
  controls.style.justifyContent = 'between';
  controls.style.alignItems = 'center';
  controls.style.marginTop = '20px';
  controls.style.padding = '10px';
  
  const totalPages = Math.ceil(items.length / state.itemsPerPage);

  if (totalPages <= 1) return;

  const prevBtn = document.createElement('button');
  prevBtn.style.marginRight = '10px';
  prevBtn.style.backgroundColor = '#007bff';
  prevBtn.style.color = '#fff';
  prevBtn.style.border = 'none';
  prevBtn.style.padding = '5px 10px';
  prevBtn.style.borderRadius = '5px';
  prevBtn.style.cursor = 'pointer';
  prevBtn.style.fontSize = '14px';
  prevBtn.style.fontWeight = 'bold';

  prevBtn.innerText = 'Previous';
  prevBtn.disabled = state.currentPage === 1;
  prevBtn.onclick = () => {
    state.currentPage--;
    renderItems();
  };
  controls.appendChild(prevBtn);


  const nextBtn = document.createElement('button');
  nextBtn.innerText = 'Next';
  nextBtn.disabled = state.currentPage === totalPages;
  nextBtn.style.marginLeft = '10px';
  nextBtn.style.backgroundColor = '#007bff';
  nextBtn.style.color = '#fff';
  nextBtn.style.border = 'none';
  nextBtn.style.padding = '5px 10px';
  nextBtn.style.borderRadius = '5px';
  nextBtn.style.cursor = 'pointer';
  nextBtn.style.fontSize = '14px';
  nextBtn.style.fontWeight = 'bold';
  nextBtn.style.marginLeft = '10px';
  nextBtn.style.backgroundColor = '#007bff';
  nextBtn.style.color = '#fff';
  nextBtn.style.border = 'none';
  nextBtn.style.padding = '5px 10px';
  nextBtn.style.borderRadius = '5px';
  
  nextBtn.onclick = () => {
    state.currentPage++;
    renderItems();
  };
  controls.appendChild(nextBtn);
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
  const checkoutButton = document.getElementById('checkout-btn');
  checkoutButton.disabled = true;
  checkoutButton.innerText = "Processing...";

  const selectedItems = getSelectedItems();

  if (selectedItems.length === 0) {
    showToast("No items selected!", "error");
    checkoutButton.disabled = false;
    checkoutButton.innerText = "Buy";
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
  document.getElementById('billing-totalItems').value = totalItems;
  document.getElementById('billing-totalAmount').value = totalAmount;

  showBilling();
}

function billing() {
  const checkoutButton = document.getElementById('billing-btn');
  checkoutButton.disabled = true;
  checkoutButton.innerText = "Processing...";

  const selectedItems = getSelectedItems();
  const totalItems = document.getElementById('billing-totalItems').value;
  const totalAmount = document.getElementById('billing-totalAmount').value;
  const paymentMethod = document.getElementById('payment-method').value;

  if (!paymentMethod || paymentMethod.trim() === '') {
    showToast("Select the Payment Method", "error");
    checkoutButton.disabled = false;
    checkoutButton.innerText = "Buy";
    return;
  }

  if (selectedItems.length === 0) {
    showToast("No items selected!", "error");
    checkoutButton.disabled = false;
    checkoutButton.innerText = "Buy";
    return;
  }

  const payload = {
    items: selectedItems,
    totalItems,
    totalAmount,
    paymentMethod
  };

  fetch('/backend/logic/billAdd.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(payload)
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        showToast("Billing successful!", "success");
        state.counts = Array(items.length).fill(0);
        renderItems();
        showHome();
      } else {
        showToast(data.message || "Billing failed!", "error");
      }
    })
    .catch(error => {
      console.error("Billing error:", error);
      showToast("Billing process encountered an error!", "error");
    })
    .finally(() => {
      checkoutButton.disabled = false;
      checkoutButton.innerText = "Buy";
    });
}
