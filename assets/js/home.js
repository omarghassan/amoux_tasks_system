import { callApi, showUserMessage, logMessage } from './config.js';


document.addEventListener("DOMContentLoaded", function () {
  fetchHomePage();
});

async function fetchHomePage() {
  try {
    const res = await callApi("getHomePage");
    if (!res.success) return showUserMessage(res.message, false);

    const data = res.data;

    // === Daily Deals ===
    const dealCarousel = document.getElementById("dealCarousel");
    dealCarousel.innerHTML = "";
    data.daily_deals.forEach(product => {
      const card = createProductCard(product);
      dealCarousel.appendChild(card);
    });

    // === Bestsellers ===
    const bestsellersCarousel = document.getElementById("bestsellersCarousel");
    bestsellersCarousel.innerHTML = "";
    data.bestsellers.forEach(product => {
      const card = createProductCard(product);
      bestsellersCarousel.appendChild(card);
    });

    // === Categories ===
    const categoriesCarousel = document.getElementById("categoriesCarousel");
    categoriesCarousel.innerHTML = "";
    data.categories.forEach(cat => {
      const card = document.createElement("div");
      card.className = "deal-product card-no-padding flex-shrink-0 full-cover-card";
      card.style.scrollSnapAlign = "start";
      card.innerHTML = `
      <a href= "shop.php?category_id=${cat.id}">
        <img src="${cat.image}" alt="${cat.name}">
        <div class="overlay-title">${cat.name}</div>
      </a>
      `;
      categoriesCarousel.appendChild(card);
    });

    // === Tiktok Viral ===
    const tiktokCarousel = document.getElementById("tiktokCarousel");
    tiktokCarousel.innerHTML = "";
    data.tiktok_viral.forEach(group => {
      group.products.forEach(product => {
        const card = createProductCard(product);
        tiktokCarousel.appendChild(card);
      });
    });

  } catch (err) {
    showUserMessage("Error loading homepage", false);
    console.error(err);
  }
}

function createProductCard(product) {
  const card = document.createElement("div");
  card.className = "deal-product flex-shrink-0 text-center";
  card.style.width = "230px";
  card.style.scrollSnapAlign = "start";
  card.innerHTML = `
  <a href= "single_product.php?product_id=${product.id}">
    <img src="${product.image}" class="img-fluid mb-2" alt="${product.name}">
    <p class="text-dark mb-0">${product.name}</p>
    </a>
  `;
  return card;
}
