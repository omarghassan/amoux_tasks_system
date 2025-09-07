<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | HighBridge</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="./assets/css/styles.css" />
</head>

<body>

  <section id="login_page">

    <div class="text_container">

      <div class="logo_container">
        <img class="logo_image" src="./assets/images/logo.png" alt="logo">
        <h1 class="website_name">HighBridge</h1>
      </div>

      <div class="carousel_container">

        <h3 class="carousel_title">Building the Future...</h3>

        <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">

          <div class="carousel-inner">
            <div class="carousel-item active">
              <p class="carousel_text">
                1 - Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo adipisci id asperiores
                rerum dolorum, laborum eveniet similique aperiam necessitatibus quae laudantium veniam
                fugit deserunt officiis?
              </p>
            </div>
            <div class="carousel-item">
              <p class="carousel_text">
                2 - Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus ea molestias animi
                tempora sit facilis, autem eius quo, excepturi repudiandae nobis odit, inventore
                consectetur delectus?
              </p>
            </div>
            <div class="carousel-item">
              <p class="carousel_text">
                3 - Lorem ipsum dolor sit amet consectetur, adipisicing elit. Distinctio, ipsam
                asperiores incidunt voluptates blanditiis provident laboriosam hic obcaecati. Incidunt
                laudantium iste doloribus velit ad delectus.
              </p>
            </div>
          </div>

          <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="0" class="active"
              aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="1"
              aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="2"
              aria-label="Slide 3"></button>
          </div>
        </div>
      </div>
    </div>

    <div class="form-container">
      <p class="form_title_cta">Welcome Back</p>
      <h2 class="form-title">Log In to your Account</h2>
      <form id="loginForm">
        <div class="form-group">
          <input type="email" id="email" class="form-input" placeholder=" " required>
          <label for="email" class="form-label">Email</label>
        </div>

        <div class="form-group">
          <div class="password-container">
            <input type="password" id="password" class="form-input" placeholder=" " required>
            <label for="password" class="form-label">Password</label>
            <span class="toggle-password" onclick="togglePassword()">👁️</span>
          </div>
        </div>

        <button type="submit" class="submit-btn">Get Started</button>
      </form>

      <div class="divider">
        <span>Or</span>
      </div>

      <div class="sign_up_options">
        <button class="sign_up_buttons">
          <img class="sign_up_buttons_logos" src="./assets/images/google_logo.png" alt="Google Logo">
          <p class="sign_up_options_text">Sign Up with Google</p>
        </button>
        <button class="sign_up_buttons">
          <img class="sign_up_buttons_logos" src="./assets/images/facebook_logo.png" alt="Google Logo">
          <p class="sign_up_options_text">Sign Up with Facebook</p>
        </button>
        <button class="sign_up_buttons">
          <img class="sign_up_buttons_logos apple_logo" src="./assets/images/apple_logo.png" alt="Google Logo">
          <p class="sign_up_options_text">Sign Up with Apple</p>
        </button>
      </div>

      <div class="form-footer">
        <p>New User? <a href="./sign_up.php">SIGN UP HERE</a></p>
      </div>
    </div>

  </section>

  <script type="module" src="./assets/js/login.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>