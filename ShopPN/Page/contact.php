<?php
require 'connect.php'; 
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="../Css/about.css">
    <link rel="stylesheet" href="../Css/main.css">
    <link rel="stylesheet" href="../Css/main-moblie.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="../Css/blog.css">
    <link rel="stylesheet" href="../Css/main.css">
    <link rel="stylesheet" href="../Css/about.css">
    <link rel="stylesheet" href="../Css/main-moblie.css">
    <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <script src="https://kit.fontawesome.com/eda05fcf5c.js" crossorigin="anonymous"></script>
    <script src="js/main.js"></script>
    <link rel="stylesheet" href="../Css/search.css">
    <title>Contact</title>
    <style>
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            outline: none;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-logout {
            background-color: #ff3a00;
            color: var(--color-text);
        }
    </style>
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
                        <img src="../plugins/images/logo.png" alt="" style=" width: 150px; height: 100px;">
                    </a>
                </div>
            </div>
            <div class="box-icon" style="height: 60px;">
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
                <a href="login.php" class="box-user" >
                    <i class="fa-regular fa-user user"></i>
                    <?php if (isset($_SESSION['user_email'])): ?>
                        <p>Welcome, <?php echo htmlspecialchars($_SESSION['user_email']); ?>!</p>
                        <a href="logout.php" class="btn btn-logout" style="height: 40px; width: 70px;">Logout</a>
                    <?php else: ?>
                        <p><a href="login.php" style="background-color: #fff;"  class="btn btn-primar y">Login</a></p>
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
    <div class="box-banner-about">
        <div class="in-banner-about">
            <div class="title-banner">Contact </div>
            <div class="box-path-about">
                <div>Home</div>
                <div class="icon">
                    <i class="fa-solid fa-angle-right"></i>
                </div>
                <div>Contact</div>
            </div>
        </div>
    </div>


    <div class="box-padding"></div>
    <div class="box-introduce-2">
    </div>
    <div class="box-map">
        <div class="box-iframe">
            <form method="POST" action="contact.php">
                <div class="form-group">
                    <label for="email">Your Email:</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email"
                        required>
                </div>
                <div class="form-group">
                    <label for="message">Your Message:</label>
                    <textarea id="message" name="message" class="form-control" rows="5" placeholder="Enter your message"
                        required></textarea>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Send</button>
            </form>
        </div>
        <div class="box-iframe">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62861.05874166012!2d105.68291917044557!3d10.032023456596368!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a0883fbc944b83%3A0x77fc34233e5e1320!2zTmluaCBLaeG7gXUsIEPhuqduIFRoxqEsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1745482781055!5m2!1svi!2s"width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
            <div class="in-frame-1">
                <svg xmlns="http://www.w3.org/2000/svg" id="Capa_1" height="512" viewBox="0 0 512 512" width="512">
                    <g>
                        <circle cx="256" cy="196" r="10"></circle>
                        <path
                            d="m181 296h150c5.522 0 10-4.477 10-10v-93.972l13.493 11.566c4.21 3.609 10.521 3.09 14.1-1.086 3.594-4.193 3.108-10.506-1.086-14.101l-104.999-89.999c-3.744-3.21-9.271-3.21-13.016 0l-104.999 89.999c-4.194 3.594-4.68 9.907-1.086 14.101 3.593 4.194 9.907 4.679 14.1 1.086l13.493-11.566v93.972c0 5.523 4.478 10 10 10zm10-121.115 65-55.714 65 55.714v101.115h-55v-40c0-5.523-4.478-10-10-10s-10 4.477-10 10v40h-55z">
                        </path>
                        <path
                            d="m248.814 508.954c1.884 1.947 4.477 3.046 7.186 3.046s5.302-1.099 7.186-3.046c63.824-65.879 182.814-214.083 182.814-312.954 0-34.896-9.487-69.49-27.438-100.042-2.799-4.762-8.926-6.354-13.688-3.557-4.762 2.798-6.354 8.926-3.557 13.688 16.148 27.484 24.683 58.575 24.683 89.911 0 101.169-136.787 255.428-170 291.384-33.213-35.956-170-190.215-170-291.384 0-95.402 77.851-176 170-176 30.377 0 60.33 8.741 86.62 25.279 4.673 2.941 10.849 1.535 13.789-3.14s1.534-10.849-3.141-13.789c-29.483-18.547-63.118-28.35-97.268-28.35-106.552 0-190 92.76-190 196 0 98.768 118.792 246.87 182.814 312.954z">
                        </path>
                        <circle cx="383" cy="65" r="10"></circle>
                    </g>
                </svg>
                <h2>
                    Ninh Kiều,
                    <br>
                    Cần Thơ
                </h2>
                <div class="location">
                   <!-- điền địa chỉ -->
                </div>
            </div>
        </div>
    </div>
    <div class="border"></div>


    <!-- Phần footer -->
    <?php include 'footer.php'; ?>
    
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
<script src="https://kit.fontawesome.com/eda05fcf5c.js" crossorigin="anonymous"></script>
<script src="js/main.js"></script>