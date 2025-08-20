const products = [
  { id: 1, name: "Phone", price: 14999, image: "phone.jpg" },
  { id: 2, name: "Headphones", price: 2999, image: "headphone.jpg" },
  { id: 3, name: "Laptop", price: 54999, image: "laptop.jpg" },
  { id: 4, name: "Smart Watch", price: 6999, image: "watch.jpg" },
  { id: 5, name: "Bluetooth Speaker", price: 3999, image: "speaker.jpg" },
  { id: 6, name: "Gaming Mouse", price: 1999, image: "mouse.jpg" }
];

let cart = [];

const productList = document.getElementById("product-list");
products.forEach(product => {
  const div = document.createElement("div");
  div.className = "product";
  div.innerHTML = `
    <img src="${product.image}" alt="${product.name}">
    <h3>${product.name}</h3>
    <p>₹${product.price}</p>
    <button onclick="addToCart(${product.id})">Add to Cart</button>
  `;
  productList.appendChild(div);
});

function addToCart(productId) {
  const product = products.find(p => p.id === productId);
  const cartItem = cart.find(item => item.id === productId);

  if (cartItem) {
    cartItem.quantity++;
  } else {
    cart.push({ ...product, quantity: 1 });
  }

  updateCartUI();
}

function removeFromCart(productId) {
  const index = cart.findIndex(item => item.id === productId);
  if (index !== -1) {
    cart[index].quantity--;
    if (cart[index].quantity <= 0) {
      cart.splice(index, 1);
    }
  }

  updateCartUI();
}

function updateCartUI() {
  const cartDiv = document.getElementById("cart");
  const cartCount = document.getElementById("cart-count");
  cartDiv.innerHTML = "";

  cart.forEach(item => {
    const div = document.createElement("div");
    div.className = "cart-item";
    div.innerHTML = `
      ${item.name} - ₹${item.price} x ${item.quantity}
      <button onclick="removeFromCart(${item.id})">Remove</button>
    `;
    cartDiv.appendChild(div);
  });

  cartCount.innerText = cart.reduce((sum, item) => sum + item.quantity, 0);

  const total = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
  document.getElementById("total").innerText = `Total: ₹${total}`;
}
