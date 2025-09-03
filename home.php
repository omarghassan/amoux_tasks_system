<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Beauty Pharma</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <!-- Google Font: Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />

  <link href="assets/css/styles.css" rel="stylesheet" />


</head>

<body>

  <?php include("nav.php"); ?>

  <!-- Category Grid -->
  <div class="container py-4">
    <div class="row g-3 category-grid">
      <!-- FACE image -->
      <div class="col-lg-6 col-12 h-100">
        <div class="position-relative h-100">
          <a href="shop.php?category_id=1">
            <img src="assets/images/banner_face.png" alt="Face" class="w-100 h-100 rounded-3 object-fit-cover">
            <div class="category-title">face</div>
          </a>
        </div>
      </div>

      <!-- Right side (BODY on top, ACNE below) -->
      <div class="col-lg-6 col-12 h-100">
        <div class="row g-3 h-100">
          <div class="col-12 cat-body-box">
            <div class="position-relative h-100">
              <a href="shop.php?category_id=1">
                <img src="assets/images/banner_body.png" alt="Body" class="w-100 h-100 rounded-3 object-fit-cover">
                <div class="category-title">body</div>
              </a>
            </div>
          </div>
          <div class="col-12 cat-acne-box">
            <div class="position-relative h-100">
              <a href="shop.php?category_id=1">
                <img src="assets/images/banner_acne.png" alt="Acne" class="w-100 h-100 rounded-3 object-fit-cover">
                <div class="category-title">acne</div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Daily Deals Section -->
  <div class="daily-deals">
    <div class="container position-relative">
      <!-- Title and Timer aligned with carousel -->
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="deal-title mb-0">Daily Deals <span class="deal-timer">23:56:01</span></h5>

      </div>

      <!-- Horizontal Scroll Carousel -->
      <div class="position-relative">
        <!-- Scrollable row -->
        <div class="d-flex overflow-x-auto hide-scrollbar gap-3" id="dealCarousel"
          style="scroll-snap-type: x mandatory;">
          <!-- 12 product cards -->
          <div class="deal-product flex-shrink-0 text-center" style="width: 230px; scroll-snap-align: start;">
            <img src="assets/images/product_cream.png" class="img-fluid mb-2" alt="Product 1">
            <p class="text-dark mb-0">X Cream</p>
          </div>
          <div class="deal-product flex-shrink-0 text-center" style="width: 230px; scroll-snap-align: start;">
            <img src="assets/images/product_oil.png" class="img-fluid mb-2" alt="Product 2">
            <p class="text-dark mb-0">M Oil</p>
          </div>
          <div class="deal-product flex-shrink-0 text-center" style="width: 230px; scroll-snap-align: start;">
            <img src="assets/images/product_cream.png" class="img-fluid mb-2" alt="Product 3">
            <p class="text-dark mb-0">Y Cream</p>
          </div>
          <div class="deal-product flex-shrink-0 text-center" style="width: 230px; scroll-snap-align: start;">
            <img src="assets/images/product_oil.png" class="img-fluid mb-2" alt="Product 4">
            <p class="text-dark mb-0">Z Product Name</p>
          </div>
          <div class="deal-product flex-shrink-0 text-center" style="width: 230px; scroll-snap-align: start;">
            <img src="assets/images/product_cream.png" class="img-fluid mb-2" alt="Product 5">
            <p class="text-dark mb-0">Alpha Cream</p>
          </div>
          <div class="deal-product flex-shrink-0 text-center" style="width: 230px; scroll-snap-align: start;">
            <img src="assets/images/product_oil.png" class="img-fluid mb-2" alt="Product 6">
            <p class="text-dark mb-0">Beta Oil</p>
          </div>
          <div class="deal-product flex-shrink-0 text-center" style="width: 230px; scroll-snap-align: start;">
            <img src="assets/images/product_cream.png" class="img-fluid mb-2" alt="Product 7">
            <p class="text-dark mb-0">Gamma Wash</p>
          </div>
          <div class="deal-product flex-shrink-0 text-center" style="width: 230px; scroll-snap-align: start;">
            <img src="assets/images/product_oil.png" class="img-fluid mb-2" alt="Product 8">
            <p class="text-dark mb-0">Soft Balm</p>
          </div>
          <div class="deal-product flex-shrink-0 text-center" style="width: 230px; scroll-snap-align: start;">
            <img src="assets/images/product_cream.png" class="img-fluid mb-2" alt="Product 9">
            <p class="text-dark mb-0">Cool Cream</p>
          </div>
          <div class="deal-product flex-shrink-0 text-center" style="width: 230px; scroll-snap-align: start;">
            <img src="assets/images/product_oil.png" class="img-fluid mb-2" alt="Product 10">
            <p class="text-dark mb-0">Night Serum</p>
          </div>
          <div class="deal-product flex-shrink-0 text-center" style="width: 230px; scroll-snap-align: start;">
            <img src="assets/images/product_cream.png" class="img-fluid mb-2" alt="Product 11">
            <p class="text-dark mb-0">Hydra Gel</p>
          </div>
          <div class="deal-product flex-shrink-0 text-center" style="width: 230px; scroll-snap-align: start;">
            <img src="assets/images/product_oil.png" class="img-fluid mb-2" alt="Product 12">
            <p class="text-dark mb-0">Day Oil</p>
          </div>
        </div>

        <!-- Arrow Controls -->
        <button class="carousel-arrow left" onclick="scrollDeals(-1)">
          <i class="bi bi-chevron-left"></i>
        </button>
        <button class="carousel-arrow right" onclick="scrollDeals(1)">
          <i class="bi bi-chevron-right"></i>
        </button>
      </div>
    </div>
  </div>

  <!-- Bestsellers Section (White) -->
  <div class="py-5 bg-white">
    <div class="container position-relative">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="deal-title text-dark mb-0">Bestsellers</h5>
      </div>

      <div class="position-relative">
        <div class="d-flex overflow-x-auto hide-scrollbar gap-3" id="bestsellersCarousel"
          style="scroll-snap-type: x mandatory;">
          <!-- Repeat product cards -->
          <div class="deal-product flex-shrink-0 text-center" style="width: 230px; scroll-snap-align: start;">
            <img src="assets/images/product_cream.png" class="img-fluid mb-2" alt="Bestseller 1">
            <p class="text-dark mb-0">Top Cream</p>
          </div>
          <!-- Add more cards as needed -->
        </div>
        <button class="carousel-arrow left" onclick="scrollDealsById('bestsellersCarousel', -1)">
          <i class="bi bi-chevron-left"></i>
        </button>
        <button class="carousel-arrow right" onclick="scrollDealsById('bestsellersCarousel', 1)">
          <i class="bi bi-chevron-right"></i>
        </button>
      </div>
    </div>
  </div>

  <!-- Categories Section (Red Background) -->
  <div class="daily-deals">
    <div class="container position-relative">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="deal-title mb-0">Categories</h5>
      </div>

      <div class="position-relative">
        <div class="d-flex overflow-x-auto hide-scrollbar gap-3" id="categoriesCarousel"
          style="scroll-snap-type: x mandatory;">

          <!-- Category Card with Overlay Title -->
          <div class="deal-product card-no-padding flex-shrink-0 full-cover-card" style="scroll-snap-align: start;">
            <img src="assets/images/banner_face.png" alt="Face">
            <div class="overlay-title">Face</div>
          </div>

          <div class="deal-product card-no-padding flex-shrink-0 full-cover-card" style="scroll-snap-align: start;">
            <img src="assets/images/banner_body.png" alt="Body">
            <div class="overlay-title">Body</div>
          </div>

          <div class="deal-product card-no-padding flex-shrink-0 full-cover-card" style="scroll-snap-align: start;">
            <img src="assets/images/banner_acne.png" alt="Acne">
            <div class="overlay-title">Acne</div>
          </div>

          <!-- Add more categories as needed -->

        </div>

        <!-- Carousel Arrows -->
        <button class="carousel-arrow left" onclick="scrollDealsById('categoriesCarousel', -1)">
          <i class="bi bi-chevron-left"></i>
        </button>
        <button class="carousel-arrow right" onclick="scrollDealsById('categoriesCarousel', 1)">
          <i class="bi bi-chevron-right"></i>
        </button>
      </div>
    </div>
  </div>


  <!-- Tiktok Viral Section (White) -->
  <div class="py-5 bg-white">
    <div class="container position-relative">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="deal-title text-dark mb-0">Tiktok Viral</h5>
      </div>

      <div class="position-relative">
        <div class="d-flex overflow-x-auto hide-scrollbar gap-3" id="tiktokCarousel"
          style="scroll-snap-type: x mandatory;">
          <div class="deal-product flex-shrink-0 text-center" style="width: 230px; scroll-snap-align: start;">
            <img src="assets/images/product_oil.png" class="img-fluid mb-2" alt="Tiktok 1">
            <p class="text-dark mb-0">Glow Oil</p>
          </div>
          <!-- Add more cards -->
        </div>
        <button class="carousel-arrow left" onclick="scrollDealsById('tiktokCarousel', -1)">
          <i class="bi bi-chevron-left"></i>
        </button>
        <button class="carousel-arrow right" onclick="scrollDealsById('tiktokCarousel', 1)">
          <i class="bi bi-chevron-right"></i>
        </button>
      </div>
    </div>
  </div>


  <!-- Contact Us Section -->
  <section class="contact-cta text-center py-5">
    <div class="container">
      <h2 class="mb-3 text-white fw-bold">Let’s Talk Beauty</h2>
      <p class="mb-4 text-white fs-5">
        Got questions, feedback, or need skincare advice? We're here for you.
      </p>
      <a href="https://wa.me/+962790000000" class="btn btn-light btn-lg px-4 py-2 fw-semibold">
        Contact Us
      </a>
    </div>
  </section>

  <?php include("footer.php"); ?>



  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    function scrollDeals(direction) {
      const container = document.getElementById('dealCarousel');
      const scrollAmount = container.querySelector('.deal-product').offsetWidth + 16;
      container.scrollBy({
        left: direction * scrollAmount,
        behavior: 'smooth'
      });
    }

    function scrollDealsById(id, direction) {
      const container = document.getElementById(id);
      const scrollAmount = container.querySelector('.deal-product').offsetWidth + 16;
      container.scrollBy({
        left: direction * scrollAmount,
        behavior: 'smooth'
      });
    }
  </script>
  <script type="module" src="assets/js/home.js"></script>




</body>

</html>