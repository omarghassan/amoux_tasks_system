<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Beauty Pharma</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

  <style>
    body.search-open {
      overflow: hidden;
    }

    .navbar form input[type="text"] {
      width: 220px;
      transition: width 0.3s ease;
    }

    .mobile-search-bar {
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      background: #fff;
      z-index: 999;
      padding: 10px 15px;
      border-bottom: 1px solid #ddd;
      display: none;
    }

    .mobile-search-bar.show {
      display: block;
    }

    #megaMenu .col-md-3 h6 {
      font-size: 1rem;
      margin-bottom: 0.5rem;
    }

    @media (max-width: 991px) {
      #megaMenu {
        display: none !important;
      }
    }
  </style>
</head>

<body class="bg-light">

  <!-- ========== Navbar ========== -->
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="home.php">
        <img src="assets/images/logo.png" alt="logo" class="me-2 rounded-circle" width="82px" />
      </a>

      <!-- Mobile icons -->
      <div class="d-flex align-items-center d-lg-none ms-auto gap-3">
        <a href="#" id="openMobileSearch" class="text-white text-decoration-none">
          <i class="bi bi-search fs-4"></i>
        </a>
        <button class="navbar-toggler text-white border-0 bg-transparent p-0" type="button" data-bs-toggle="collapse"
          data-bs-target="#navbarContent">
          <i class="bi bi-list text-white fs-1"></i>
        </button>
      </div>

      <!-- Collapse items -->
      <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0" id="mainCategories">
          <li class="nav-item">
            <a class="nav-link" href="#" data-category="skin">SKIN</a>
            <ul class="list-unstyled ps-3 collapse" id="submenu-skin"></ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" data-category="hair">HAIR</a>
            <ul class="list-unstyled ps-3 collapse" id="submenu-hair"></ul>
          </li>
          <li class="nav-item"><a class="nav-link" href="#">BODY</a></li>
          <li class="nav-item"><a class="nav-link" href="#">BABY</a></li>
          <li class="nav-item"><a class="nav-link" href="#">PERSONAL</a></li>
          <li class="nav-item"><a class="nav-link" href="#">DEVICES</a></li>
          <li class="nav-item"><a class="nav-link" href="#">OFFERS</a></li>
        </ul>

        <!-- Desktop icons -->
        <div class="nav-icons d-none d-lg-flex align-items-center gap-3">
          <form action="shop.php" method="GET" class="me-3 mb-0">
            <input type="text" name="query" class="form-control form-control-sm rounded-pill px-3 py-2"
              placeholder="Search products..." />
          </form>
          <a href="favorites.php" class="text-white text-decoration-none"><i class="bi bi-heart fs-5"></i></a>
          <a href="cart.php" class="text-white text-decoration-none"><i class="bi bi-bag fs-5"></i></a>
          <a href="login.php" class="btn btn-outline-light btn-sm rounded-pill px-3">Login</a>
          <a href="signup.php" class="btn btn-light btn-sm rounded-pill px-3">Sign Up</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- ========== Mobile Search Bar ========== -->
  <div id="mobileSearchBar" class="mobile-search-bar d-lg-none shadow-sm">
    <form action="shop.php" method="GET" class="d-flex align-items-center gap-2">
      <input type="text" name="query" class="form-control form-control-sm" placeholder="Search products..." />
      <button type="button" class="btn btn-outline-secondary btn-sm" id="closeMobileSearch">
        <i class="bi bi-x-lg"></i>
      </button>
    </form>
  </div>

  <!-- ========== Mega Menu (Desktop Only) ========== -->
  <div id="megaMenu" class="bg-white border-top shadow-sm d-none position-absolute w-100"
    style="top:115px; left:0; z-index:9999;">
    <div class="container py-4">
      <div class="row" id="megaMenuContent"></div>
    </div>
  </div>

  <!-- ========== Scripts ========== -->
  <script>
    const categoryData = {
      skin: {
        Cleanser: ["Foaming", "Oil-Based", "Creamy"],
        Toner: ["Hydrating", "Exfoliating", "Balancing"],
        Moisturizer: ["Day Cream", "Night Cream", "Gel"]
      },
      hair: {
        Shampoo: ["Anti-Dandruff", "Volumizing", "Color Protection"],
        Conditioner: ["Leave-In", "Rinse-Out"],
        Treatments: ["Hair Masks", "Serums", "Oils"]
      },
      body: {
        Shower: ["Scrubs", "Gels", "Bars"],
        Moisturizers: ["Lotion", "Creams"],
        Treatment: ["Stretch Marks", "Cellulite"]
      },
      baby: {
        Bath: ["Baby Wash", "Shampoo"],
        Skincare: ["Baby Lotion", "Cream"],
        Essentials: ["Wipes", "Diapers"]
      },
      personal: {
        OralCare: ["Toothpaste", "Mouthwash"],
        Deodorants: ["Roll-On", "Sprays"],
        IntimateCare: ["Wash", "Wipes"]
      },
      devices: {
        Hair: ["Dryers", "Straighteners"],
        Face: ["Cleansing Brushes", "Light Therapy"],
        Body: ["Massage Devices"]
      },
      offers: {
        Discounts: ["10% Off", "20% Off", "Buy 1 Get 1"],
        Limited: ["Holiday Bundles", "Free Gifts"]
      }
    };

    const links = document.querySelectorAll('#mainCategories .nav-link');

    links.forEach(link => {
      link.addEventListener('click', e => {
        e.preventDefault();
        const cat = e.target.dataset.category;
        if (!cat || !categoryData[cat]) return;

        if (window.innerWidth >= 992) {
          // Desktop Mega Menu
          const megaMenu = document.getElementById('megaMenu');
          const content = document.getElementById('megaMenuContent');
          content.innerHTML = '';

          Object.entries(categoryData[cat]).forEach(([sub, subs]) => {
            const col = document.createElement('div');
            col.className = 'col-12 col-md-3 mb-3';
            const subTitle = document.createElement('h6');
            subTitle.textContent = sub;
            subTitle.classList.add('fw-bold');

            const ul = document.createElement('ul');
            ul.className = 'list-unstyled';

            subs.forEach(item => {
              const li = document.createElement('li');
              li.innerHTML = `<a href="shop.php?sub=${encodeURIComponent(item)}" class="text-decoration-none text-dark small d-block py-1">${item}</a>`;
              ul.appendChild(li);
            });

            col.appendChild(subTitle);
            col.appendChild(ul);
            content.appendChild(col);
          });

          megaMenu.classList.remove('d-none');
        } else {
          // Mobile/Tablet Collapsible
          const submenu = document.getElementById(`submenu-${cat}`);
          submenu.innerHTML = '';

          Object.entries(categoryData[cat]).forEach(([sub, subs]) => {
            const toggleId = `toggle-${cat}-${sub.replace(/\s+/g, '-')}`;
            const subLi = document.createElement('li');
            subLi.innerHTML = `
            <a href="#" class="d-block text-dark py-1" data-bs-toggle="collapse" data-bs-target="#${toggleId}">${sub}</a>
            <ul class="list-unstyled ps-3 collapse" id="${toggleId}">
              ${subs.map(s => `<li><a href="shop.php?sub=${encodeURIComponent(s)}" class="text-muted d-block py-1">${s}</a></li>`).join('')}
            </ul>
          `;
            submenu.appendChild(subLi);
          });

          submenu.classList.add('show');
        }
      });
    });

    // Hide desktop mega menu on outside click
    document.addEventListener("click", function (e) {
      const megaMenu = document.getElementById("megaMenu");
      if (window.innerWidth >= 992 && !megaMenu.contains(e.target) && !document.getElementById("mainCategories").contains(e.target)) {
        megaMenu.classList.add("d-none");
      }
    });
  </script>

  <script>
    // Mobile search behavior
    const openMobileSearch = document.getElementById("openMobileSearch");
    const mobileSearchBar = document.getElementById("mobileSearchBar");
    const closeMobileSearch = document.getElementById("closeMobileSearch");

    openMobileSearch.addEventListener("click", function (e) {
      e.preventDefault();
      mobileSearchBar.classList.add("show");
      document.body.classList.add("search-open");
      mobileSearchBar.querySelector("input").focus();
    });

    closeMobileSearch.addEventListener("click", function () {
      mobileSearchBar.classList.remove("show");
      document.body.classList.remove("search-open");
      mobileSearchBar.querySelector("input").value = "";
    });

    document.addEventListener("click", function (e) {
      if (!mobileSearchBar.contains(e.target) && !openMobileSearch.contains(e.target)) {
        mobileSearchBar.classList.remove("show");
        document.body.classList.remove("search-open");
      }
    });
  </script>

  <!-- Bootstrap Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>