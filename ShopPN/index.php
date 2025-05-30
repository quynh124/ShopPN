<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="Css/main.css">
    <link rel="stylesheet" href="Css/main-moblie.css">
    <link rel="stylesheet" href="Css/search.css">
    <link rel="icon" type="image/png" sizes="16x16" href="./plugins/images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <title>Home</title>
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
                        <a href="" class="hover-a">Home</a>
                    </li>
                    <li class="padding-list-menu">
                        <a href="./Page/Shop.php" class="hover-a">Shop</a>
                    <li class="padding-list-menu">
                        <a href="./Page/about.php" class="hover-a">About Us</a>
                    </li>
                    <li class="padding-list-menu">
                        <a href="./Page/blog.php" class="hover-a">Blog</a>
                    </li>
                    <li class="padding-list-menu">
                        <a href="./Page/contact.php" class="hover-a">Contact</a>
                    </li>
                    <li class="padding-list-menu">
                        <a href="./Page/profile-page.php" class="hover-a">Profile</a>
                    </li>
                    <li class="padding-list-menu">
                        <a href="./Page/chatbot.php" class="hover-a">ChatBot</a>
                    </li>
                </ul>
            </nav>
            <div class="box-logo">
                <div class="logo">
                    <a href="index.php">
                        <img src="./plugins/images/logo.png" alt="" style="width: 150px;height: 100px;">
                    </a>
                </div>
            </div>
            <div class="box-icon">
                <div class="box-search">
                    <form method="GET" action="./Page/Shop.php" class="search-form">
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
                <a href="Page/login.php" class="box-user" style="padding-top: 6px;
">
                    <i class="fa-regular fa-user user"></i>
                    <?php if (isset($_SESSION['user_email'])): ?>
                        <p>Welcome, <?php echo htmlspecialchars($_SESSION['user_email']); ?>!</p>
                        <a href="./Page/logout.php" class="btn btn-danger" style="height: 40px;">Logout</a>
                    <?php else: ?>
                        <p><a href="./Page/login.php" class="btn btn-primar y">Login</a></p>
                    <?php endif; ?>
                    <a href="" class="box-heart" style="padding-top: 10px;">
                        <i class="fa-regular fa-heart heart"></i>
                    </a>
                    <a href="" class="box-cart" style="padding-top: 10px;">
                        <i class="fa-solid fa-cart-shopping cart"></i>
                    </a>
            </div>
        </div>
    </div>
    <div class="banner">
        <img id="pic" src="Picture/slider-4.jpg" alt="">
        <div class="in-content">
            <div class="tran-box">
                <div class="title">Design for life</div>
                <div class="text-title">Say hello to our brand new arrivals.</div>
                <div class="all-button">
                    <button>Shop all new in</button>
                </div>
            </div>
            <button id="left"><i class="fa-solid fa-arrow-left"></i></button>
            <button id="right"><i class="fa-solid fa-arrow-right"></i></button>
        </div>
        <div id="list">
            <ul>
                <li><button onclick="indexNumber(0)"></button></li>
                <li><button onclick="indexNumber(1)"></button></li>
                <li><button onclick="indexNumber(2)"></button></li>
            </ul>
        </div>
    </div>
    <div class="box-room">
        <a href="">
            <div class="living-room">
                <img src="Picture/Living-room.jpg" alt="">
                <div class="title-Living-room">Living room</div>
                <div class="Shop-col">Shop Collection</div>
            </div>
        </a>
        <a href="">
            <div class="bed-room">
                <img src="Picture/bedroom.jpg" alt="">
                <div class="title-bed-room">Bed room</div>
                <div class="Shop-col">Shop Collection</div>
            </div>
        </a>
        <a href="">
            <div class="ketchen-room">
                <img src="Picture/ketchen-room.jpg" alt="">
                <div class="title-kitchen-room">kitchen room</div>
                <div class="Shop-col">Shop Collection</div>
            </div>
        </a>
    </div>
    <div class="setion-shop">
        <div class="box-title">
            <div class="title-shop">Shop by categories</div>
        </div>
        <div class="all-box-product">
            <div class="box-product">
                <a href="">
                    <img src="Picture/categories-9.jpg" alt="">
                    <div class="title-product">Armchairs</div>
                </a>
            </div>
            <div class="box-product">
                <a href="#1">
                    <img src="Picture/categories-7.jpg" alt="">
                    <div class="title-product">Dining Chairs</div>
                </a>
            </div>
            <div class="box-product">
                <a href="#2">
                    <img src="Picture/categories-6.jpg" alt="">
                    <div class="title-product">Lighting</div>
                </a>
            </div>
            <div class="box-product">
                <a href="#3">
                    <img src="Picture/categories-11.jpg" alt="">
                    <div class="title-product">Sofas</div>
                </a>
            </div>
            <div class="box-product">
                <a href="#4">
                    <img src="Picture/categories-10.jpg" alt="">
                    <div class="title-product">Storage</div>
                </a>
            </div>
        </div>
    </div>
    <div class="box-product-sell">
        <div class="box-product-sell-2">
            <div class="in-title">
                <div class="word">
                    Deals of the days
                </div>
                <div class="see-deals">
                    <a href="">
                        View all deals
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="all-new-product">
                <div class="new-product">
                    <div class="all-product">
                        <a href="" style="text-decoration: none;">
                            <div class="new-img-product">
                                <img id="Pic-1" src="Picture/products-7-600x600.jpg" alt="">
                                <div class="note-notif">
                                    <div class="box-sell">
                                        -33%
                                    </div>
                                    <div class="title-hot">
                                        Hot
                                    </div>
                                </div>
                                <div class="all-box-icon">
                                    <i class="fa-regular fa-heart"></i>
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </div>
                            </div>
                            <div class="contents-new-product">
                                <div class="star">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </div>
                                <div class="view-product">
                                    (4 review)
                                </div>
                            </div>
                        </a>
                        <div class="box-name-product">
                            <div class="name-product">
                                VB1 Little Petra Lounge Chair & ATD1 Pouf
                            </div>
                            <div id="Prict-prod" class="price-product">
                                <del>$ 150.00</del>
                                <span>$ 100.00</span>
                            </div>
                            <div class="buttom-1">
                                <button type="submit">
                                    <i class="fa-solid fa-cart-plus"></i>
                                    <span>add to cart</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="new-product">
                    <div class="all-product">
                        <a href="" style="text-decoration: none;">
                            <div class="new-img-product">
                                <img id="Pic-2" src="Picture/img-15-9-600x600.jpg" alt="">
                                <div class="note-notif">
                                    <div class="title-hot">
                                        Hot
                                    </div>
                                </div>
                                <div class="all-box-icon">
                                    <i class="fa-regular fa-heart"></i>
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </div>
                            </div>
                            <div class="contents-new-product">
                                <div class="star">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </div>
                                <div class="view-product">
                                    (4 review)
                                </div>
                            </div>
                        </a>
                        <div class="box-name-product">
                            <div class="name-product">
                                Zunkel Schawarz
                            </div>
                            <div id="Prict-prod" class="price-product">
                                <span>$ 100.00</span>
                            </div>
                            <div class="buttom-1">
                                <button type="submit">
                                    <i class="fa-solid fa-cart-plus"></i>
                                    <span>add to cart</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="new-product">
                    <div class="all-product">
                        <a href="" style="text-decoration: none;">
                            <div class="new-img-product">
                                <img id="Pic-3" src="Picture/products-1-600x600.jpg" alt="">
                                <div class="note-notif">
                                    <div class="box-sell">
                                        -33%
                                    </div>
                                    <div class="title-hot">
                                        Hot
                                    </div>
                                </div>
                                <div class="all-box-icon">
                                    <i class="fa-regular fa-heart"></i>
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </div>
                            </div>
                            <div class="contents-new-product">
                                <div class="star">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </div>
                                <div class="view-product">
                                    (4 review)
                                </div>
                            </div>
                        </a>
                        <div class="box-name-product">
                            <div class="name-product">
                                Drop Dining Chair
                            </div>
                            <div id="Prict-prod" class="price-product">
                                <del>$ 200.00</del>
                                <span>$ 180.00</span>
                            </div>
                            <div class="buttom-1">
                                <button type="submit">
                                    <i class="fa-solid fa-cart-plus"></i>
                                    <span>add to cart</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-bg">
        <div class="box-img">
            <img class="pic-animation" src="Picture/text_animation.png" alt="">
            <img class="pic-chair" src="Picture/img-1.png" alt="">
        </div>
        <div class="box-content">
            <div class="title-content">
                Funori furniture
            </div>
            <div class="box-first-content">
                <div class="first-content">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0"
                        viewBox="0 0 511.981 511.981" style="enable-background:new 0 0 512 512" xml:space="preserve">
                        <g>
                            <path xmlns="http://www.w3.org/2000/svg"
                                d="m90.645 158.847c-5.975 6.055-5.974 15.905.001 21.959l12.671 12.838c.189.192.235.483.114.726l-8.1 16.096c-3.834 7.618-.788 17 6.79 20.914l16.013 8.27c.241.124.375.388.335.655l-2.703 17.827c-1.277 8.421 4.521 16.392 12.926 17.769l17.789 2.915c.268.044.477.253.521.521l2.915 17.79c.975 5.947 5.263 10.578 10.663 12.331v186.862c0 13.853 16.757 20.874 26.628 11.133l67.6-66.72c.652-.645 1.715-.645 2.367 0l67.6 66.72c9.855 9.726 26.628 2.765 26.628-11.132v-89.696c0-4.143-3.357-7.5-7.5-7.5s-7.5 3.357-7.5 7.5v89.696c0 .19 0 .427-.394.592-.396.164-.563-.003-.697-.136l-13.842-13.662v-167.02l4.345-8.413c.123-.24.382-.376.654-.334l9.934 1.506v62.768c0 4.143 3.357 7.5 7.5 7.5s7.5-3.357 7.5-7.5v-62.162c5.407-1.75 9.688-6.384 10.663-12.335l2.915-17.792c.044-.266.253-.474.52-.518l17.79-2.915c8.403-1.377 14.202-9.347 12.926-17.768l-2.703-17.829c-.04-.268.094-.53.334-.654l16.015-8.271c7.577-3.915 10.623-13.297 6.789-20.913l-8.1-16.099c-.122-.241-.075-.532.114-.725l12.671-12.837c5.975-6.054 5.976-15.904 0-21.96l-12.67-12.836c-.19-.193-.237-.485-.115-.728l8.1-16.096c3.835-7.618.789-17-6.79-20.914l-16.013-8.27c-.241-.124-.375-.387-.335-.654l2.703-17.828c1.277-8.421-4.521-16.392-12.926-17.769l-17.791-2.912c-.268-.044-.477-.253-.521-.52l-2.915-17.79c-1.377-8.403-9.355-14.208-17.768-12.926l-17.829 2.703c-.271.041-.531-.095-.654-.335l-8.27-16.014c-3.913-7.577-13.297-10.624-20.914-6.79l-16.097 8.1c-.242.124-.533.075-.726-.114l-12.836-12.669c-6.055-5.976-15.906-5.976-21.959 0l-12.838 12.67c-.192.189-.483.236-.726.115l-16.097-8.102c-7.618-3.833-17-.785-20.913 6.791l-8.27 16.014c-.125.24-.384.374-.654.334l-17.829-2.703c-8.428-1.279-16.39 4.523-17.768 12.926l-2.915 17.792c-.044.267-.253.475-.519.519l-17.792 2.914c-8.402 1.379-14.201 9.349-12.925 17.768l2.703 17.829c.04.268-.094.531-.334.655l-16.014 8.27c-7.578 3.914-10.624 13.296-6.79 20.913l8.1 16.098c.121.241.075.533-.114.726zm99.867 324.266-13.842 13.662c-.134.134-.303.301-.697.135-.394-.165-.394-.401-.394-.592v-187.464l9.934-1.506c.271-.041.53.094.654.334l4.345 8.413zm115.957-14.805-38.758-38.253c-6.462-6.378-16.978-6.38-23.441 0l-38.758 38.253v-136.429c3.48.642 7.002.034 9.839-1.394l16.097-8.1c.24-.123.531-.076.726.114l12.838 12.67c5.987 5.91 15.88 6.001 21.959 0l12.838-12.67c.192-.189.483-.235.726-.115l16.098 8.102c2.992 1.506 6.529 2.008 9.838 1.393v136.429zm-189.64-329.768-8.1-16.098c-.154-.307-.031-.685.274-.842l16.015-8.271c5.958-3.077 9.285-9.6 8.28-16.23l-2.703-17.829c-.051-.34.184-.661.521-.717l17.791-2.914c6.63-1.087 11.813-6.271 12.896-12.897l2.915-17.789c.055-.338.379-.575.717-.522l17.829 2.703c6.625 1.003 13.153-2.321 16.23-8.281l8.27-16.014c.157-.305.534-.428.844-.274l16.097 8.102c5.993 3.014 13.229 1.875 18.005-2.839l12.838-12.67c.244-.24.641-.24.885 0l12.838 12.67c4.776 4.714 12.012 5.856 18.005 2.838l16.096-8.1c.312-.157.688-.031.845.273l8.27 16.014c3.076 5.959 9.595 9.283 16.23 8.282l17.83-2.703c.338-.059.66.183.716.521l2.915 17.79c1.086 6.628 6.27 11.811 12.897 12.896l17.789 2.915c.339.056.573.377.521.717l-2.703 17.829c-1.006 6.631 2.323 13.153 8.282 16.23l16.013 8.27c.306.157.429.535.274.843l-8.1 16.095c-3.017 5.993-1.877 13.229 2.837 18.008l12.67 12.836c.241.245.242.643.001.887l-12.672 12.838c-4.713 4.777-5.853 12.014-2.836 18.005l8.1 16.098c.154.307.031.686-.274.843l-16.015 8.271c-5.958 3.077-9.285 9.6-8.28 16.229l2.703 17.828c.051.341-.183.662-.521.718l-17.79 2.915c-6.63 1.087-11.813 6.271-12.896 12.896l-2.915 17.789c-.055.338-.378.575-.717.522l-1.518-.23h-.002l-16.31-2.473c-6.644-1.014-13.154 2.323-16.23 8.281l-8.27 16.014c-.117.228-.36.355-.604.339-.081-.005-.163-.026-.24-.065l-16.097-8.102c-5.994-3.015-13.229-1.874-18.005 2.839l-12.838 12.67c-.244.24-.641.24-.885 0l-12.837-12.669c-4.729-4.667-12.007-5.86-18.006-2.839l-16.096 8.1c-.311.157-.688.031-.845-.273l-8.27-16.014c-3.078-5.959-9.605-9.283-16.23-8.281l-16.31 2.473s-.003.001-.005.001l-1.514.229c-.351.051-.662-.183-.718-.521l-2.915-17.79c-1.086-6.628-6.27-11.812-12.897-12.897l-17.789-2.915c-.339-.056-.573-.377-.521-.717l2.703-17.828c1.005-6.631-2.323-13.154-8.282-16.231l-16.013-8.27c-.306-.157-.429-.535-.274-.843l8.1-16.096c3.018-5.993 1.877-13.229-2.837-18.006l-12.671-12.838c-.241-.244-.24-.642 0-.886l12.672-12.838c4.714-4.776 5.854-12.013 2.837-18.005z"
                                fill="" data-original=""></path>
                            <path xmlns="http://www.w3.org/2000/svg"
                                d="m160.579 169.826c0 52.609 42.801 95.411 95.411 95.411s95.411-42.802 95.411-95.411c0-52.61-42.801-95.412-95.411-95.412s-95.411 42.802-95.411 95.412zm95.411-80.412c44.339 0 80.411 36.072 80.411 80.412 0 44.339-36.072 80.411-80.411 80.411s-80.411-36.072-80.411-80.411 36.073-80.412 80.411-80.412z"
                                fill="" data-original=""></path>
                            <path xmlns="http://www.w3.org/2000/svg"
                                d="m222.827 184.625-3.653 21.296c-1.705 9.953 8.752 17.552 17.691 12.853l19.125-10.055 19.125 10.055c8.927 4.693 19.4-2.88 17.69-12.853l-3.652-21.296 15.473-15.083c7.233-7.05 3.235-19.346-6.758-20.795l-21.382-3.107-9.563-19.377c-4.471-9.055-17.394-9.055-21.866.001l-9.563 19.376-21.381 3.107c-9.996 1.449-13.992 13.747-6.759 20.795zm16.288-24.353c3.973-.579 7.404-3.073 9.177-6.67l7.698-15.599 7.696 15.596c1.774 3.6 5.206 6.094 9.182 6.673l17.213 2.501-12.454 12.14c-2.876 2.803-4.188 6.839-3.507 10.793l2.94 17.145-15.396-8.095c-3.552-1.867-7.795-1.867-11.348 0l-15.396 8.095 2.94-17.142c.681-3.957-.631-7.993-3.506-10.795l-12.454-12.141z"
                                fill="" data-original=""></path>
                            <path xmlns="http://www.w3.org/2000/svg"
                                d="m255.99 293.948c68.44 0 124.121-55.681 124.121-124.121 0-61.666-45.096-113.077-104.389-122.554-4.092-.65-7.936 2.132-8.59 6.223-.653 4.09 2.132 7.936 6.223 8.59 53.167 8.498 91.756 53.81 91.756 107.741 0 60.17-48.951 109.121-109.121 109.121s-109.121-48.951-109.121-109.121c0-54.045 40.29-100.49 93.719-108.034 4.102-.58 6.957-4.374 6.378-8.476-.58-4.103-4.384-6.954-8.476-6.378-60.67 8.569-106.621 60.715-106.621 122.888 0 68.44 55.681 124.121 124.121 124.121z"
                                fill="" data-original=""></path>
                        </g>
                    </svg>
                </div>
                <div class="word-content">
                    <h3>BEST SEVICES</h3>
                    <p>
                        Nullam quis ante. Pellentesque libero tortor, tincidunt et, tinciduntamet est
                        <br>
                        platea dictumst. Praesent nec nisl a purus blandit viverra
                    </p>
                </div>
            </div>
            <div class="box-first-content">
                <div class="first-content">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 512 512"
                        style="enable-background:new 0 0 512 512" xml:space="preserve">
                        <g>
                            <g xmlns="http://www.w3.org/2000/svg">
                                <g>
                                    <path
                                        d="M414.004,303.627c-32.482,0-58.907,26.426-58.907,58.908c0,32.476,26.426,58.902,58.907,58.902    c32.487,0,58.908-26.426,58.908-58.902C472.912,330.053,446.486,303.627,414.004,303.627z M414.004,388.399    c-14.27,0-25.875-11.605-25.875-25.87c0-14.27,11.605-25.875,25.875-25.875s25.875,11.611,25.875,25.875    C439.88,376.793,428.274,388.399,414.004,388.399z"
                                        fill="" data-original=""></path>
                                </g>
                            </g>
                            <g xmlns="http://www.w3.org/2000/svg">
                                <g>
                                    <path
                                        d="M329.221,90.563H16.516C7.394,90.563,0,97.957,0,107.08v254.348c0,9.122,7.394,16.516,16.516,16.516h51.751v-33.032    H33.032V123.596h279.673v237.832h33.032V107.08C345.738,97.957,338.344,90.563,329.221,90.563z"
                                        fill="" data-original=""></path>
                                </g>
                            </g>
                            <g xmlns="http://www.w3.org/2000/svg">
                                <g>
                                    <rect x="149.196" y="344.912" width="222.417" height="33.032" fill=""
                                        data-original=""></rect>
                                </g>
                            </g>
                            <g xmlns="http://www.w3.org/2000/svg">
                                <g>
                                    <path
                                        d="M108.456,303.627c-32.482,0-58.908,26.426-58.908,58.908c0,32.476,26.426,58.902,58.908,58.902    c32.482,0,58.908-26.426,58.908-58.902C167.363,330.053,140.938,303.627,108.456,303.627z M108.456,388.399    c-14.27,0-25.875-11.605-25.875-25.87c0-14.27,11.605-25.875,25.875-25.875c14.27,0,25.875,11.611,25.875,25.875    C134.331,376.793,122.72,388.399,108.456,388.399z"
                                        fill="" data-original=""></path>
                                </g>
                            </g>
                            <g xmlns="http://www.w3.org/2000/svg">
                                <g>
                                    <path
                                        d="M495.484,227.647H329.221v33.032h149.746v84.232h-23.673v33.032h40.189c9.122,0,16.516-7.388,16.516-16.516V244.163    C512,235.041,504.606,227.647,495.484,227.647z"
                                        fill="" data-original=""></path>
                                </g>
                            </g>
                            <g xmlns="http://www.w3.org/2000/svg">
                                <g>
                                    <path
                                        d="M445.545,159.127c-2.901-5.274-8.451-8.555-14.474-8.555H329.221v33.032h92.083l37.684,68.52l28.947-15.922    L445.545,159.127z"
                                        fill="" data-original=""></path>
                                </g>
                            </g>
                            <g xmlns="http://www.w3.org/2000/svg"></g>
                            <g xmlns="http://www.w3.org/2000/svg"></g>
                            <g xmlns="http://www.w3.org/2000/svg"></g>
                            <g xmlns="http://www.w3.org/2000/svg"></g>
                            <g xmlns="http://www.w3.org/2000/svg"></g>
                            <g xmlns="http://www.w3.org/2000/svg"></g>
                            <g xmlns="http://www.w3.org/2000/svg"></g>
                            <g xmlns="http://www.w3.org/2000/svg"></g>
                            <g xmlns="http://www.w3.org/2000/svg"></g>
                            <g xmlns="http://www.w3.org/2000/svg"></g>
                            <g xmlns="http://www.w3.org/2000/svg"></g>
                            <g xmlns="http://www.w3.org/2000/svg"></g>
                            <g xmlns="http://www.w3.org/2000/svg"></g>
                            <g xmlns="http://www.w3.org/2000/svg"></g>
                            <g xmlns="http://www.w3.org/2000/svg"></g>
                        </g>
                    </svg>
                </div>
                <div class="word-content">
                    <h3>Free shipping worldwide</h3>
                    <p>
                        Nullam quis ante. Pellentesque libero tortor, tincidunt et, tinciduntamet est
                        <br>
                        platea dictumst. Praesent nec nisl a purus blandit viverra
                    </p>
                </div>
            </div>
            <div class="box-button">
                <button>Discovery</button>
            </div>
        </div>
    </div>
    <div class="all-box-banner">
        <div class="box-first-banner">
            <div class="box-img-banner">
                <a href="">
                    <img src="Picture/banner-6-1.jpg" alt="">
                </a>
            </div>
            <div class="title-in-banner">
                <h3>Revive your retreat</h3>
                <a href="">
                    Shop Collection
                </a>
            </div>
        </div>
        <div class="box-first-banner">
            <div class="box-img-banner">
                <a href="">
                    <img src="Picture/banner-7-1.jpg" alt="">
                </a>
            </div>
            <div class="title-in-banner">
                <h3>From loveseats to sectionals.</h3>
                <a href="">
                    Shop Collection
                </a>
            </div>
        </div>
    </div>
    <div class="box-brand">

    </div>
    <!-- Phần footer -->
    <div class="box-first-footer">
        <div class="contact">
            <h2>CONTACT US</h2>
            <div class="in">
                <div>Add :Ninh Kieu ,Can Tho</div>
                <div>Tell : </div>
                <div>HR Fax: </div>
                <div>sales@pn.com</div>
            </div>
        </div>
        <div class="contact">
            <h2>CATEGOIRES</h2>
            <div class="in">
                <a href="">

                </a>
                <a href="">
                    <div>Tables</div>
                </a>
                <a href="">
                    <div>Seating</div>
                </a>
                <a href="">
                    <div>Desks & office </div>
                </a>
                <a href="">
                    <div>Storage</div>
                </a>
                <a href="">
                    <div>Bed & Bath</div>
                </a>
            </div>
        </div>
        <div class="contact">
            <h2>SERVICES</h2>
            <div class="in">
                <a href="">
                    <div>Sale</div>
                </a>
                <a href="">
                    <div>Quick Ship</div>
                </a>
                <a href="">
                    <div>New Designs</div>
                </a>
                <a href="">
                    <div>Accidental Fabric Protection</div>
                </a>
                <a href="">

                </a>
                <a href="">
                    <div>Gift Cards</div>
                </a>
            </div>
        </div>
        <div class="contact">
            <h2>JOIN US</h2>
            <div class="in">
                <div style="margin-bottom: 25px;">Enter your email below to be the first to know
                    <br>
                    about new collections and product launches.
                </div>
                <div class="box-email">
                    <input type="text" placeholder="Email adress...">
                    <button type="submit">
                        <i class="fa-solid fa-envelope"></i>
                    </button>
                </div>
                <div class="icon-contact">
                    <ul>
                        <li>
                            <a href="">
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <i class="fa-brands fa-dribbble"></i>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <i class="fa-brands fa-behance"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="box-second-footer">
        <div class="first-box">
            <div class="title">
                Shop Nội Thất PN
            </div>
        </div>
        <div class="second-box">
            <div class="box-bank">
                <img src="Picture/payments-1.png" alt="">
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
            recognition.onresult = function (event) {
                const voiceResult = event.results[0][0].transcript;
                document.getElementById("searchInput").value = voiceResult;
                document.querySelector("form.search-form").submit();
            };
            recognition.onerror = function (event) {
                console.error("Lỗi khi nhận diện giọng nói: ", event.error);
            };
        }
    </script>
</body>

</html>
<script src="https://kit.fontawesome.com/eda05fcf5c.js" crossorigin="anonymous"></script>
<script src="js/main.js"></script>