<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="../Css/main.css">
    <link rel="stylesheet" href="../Css/main-moblie.css">
    <link rel="stylesheet" href="../Css/Shop.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="../Css/search.css">
</head>
<body>
    <div class="header">
        <div class="content">
            <div class="box-menu-mobile">
                <button>
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
            <nav class="box-menu">
                <ul class="all-list-menu">
                    <li>
                        <a href="../index.php" class="hover-a">Home</a>
                    </li>
                    <li class="padding-list-menu">
                        <a href="Shop.php" class="hover-a">Shop</a>
                    </li>
                    <li class="padding-list-menu">
                        <a href="about.php" class="hover-a">About Us</a>
                    </li>
                    <li class="padding-list-menu">
                        <a href="blog.php" class="hover-a">Blog</a>
                    </li>
                    <li class="padding-list-menu">
                        <a href="contact.php" class="hover-a">Contact</a>
                    </li>
                    <li class="padding-list-menu">
                        <a href="profile-page.php" class="hover-a">Profile</a>
                    </li>
                    <li class="padding-list-menu">
                        <a href="chatbot.php" class="hover-a">ChatBot</a>
                    </li>
                </ul>
            </nav>
            <div class="box-logo">
                <div class="logo">
                    <a href="../index.php">
                        <img src="../plugins/images/logo.png" alt="" style="width: 150px;height: 100px;">
                    </a>
                </div>
            </div>
            <div class="box-icon">
            <div class="box-search">
            <form method="GET" action="Shop.php" class="search-form">
  <button type="submit" class="search__button">
    <div class="search__icon">
      <i class="fa-solid fa-magnifying-glass"></i>
    </div>
  </button>
  <input type="text" name="search" id="searchInput" class="search__input" placeholder="Search...">
  
  <button type="button" onclick="startVoiceSearch()" class="mic__button">
    <div class="mic__icon">
      🎤
    </div>
  </button>
</form>
</div>
                <a href="login.php" class="box-user" style="padding-top: 10px;">
                    <i class="fa-regular fa-user user"></i>
                    <?php if (isset($_SESSION['user_email'])): ?>
                        <p>Welcome, <?php echo htmlspecialchars($_SESSION['user_email']); ?>!</p>
                        <a href="logout.php" class="btn btn-danger" style="height: 40px;">Logout</a>
                    <?php else: ?>
                        <p><a href="login.php" class="btn btn-primar y">Login</a></p>
                    <?php endif; ?>
                </a>

                <a href="" class="box-heart" style="padding-top: 10px;">
                    <i class="fa-regular fa-heart heart"></i>
                </a>
                <a href="cart.php" class="box-cart" style="padding-top: 10px;">
                    <i class="fa-solid fa-cart-shopping cart"></i>
                </a>
            </div>
        </div>
    </div>
    <script>
function startVoiceSearch() {
    if (!('webkitSpeechRecognition' in window)) {
        alert("Trình duyệt không hỗ trợ tìm kiếm bằng giọng nói!");
        return;
    }
    const recognition = new webkitSpeechRecognition();
    recognition.lang = "vi-VN";
    recognition.interimResults = false;
    recognition.maxAlternatives = 1;
    recognition.start();
    recognition.onresult = function(event) {
        const voiceResult = event.results[0][0].transcript;
        document.getElementById("searchInput").value = voiceResult;
        document.querySelector("form.search-form").submit();
    };
    recognition.onerror = function(event) {
        console.error("Lỗi khi nhận diện giọng nói: ", event.error);
    };
}
</script>
</body>

</html>