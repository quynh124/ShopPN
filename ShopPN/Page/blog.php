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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <link rel="stylesheet" href="../Css/blog.css">
    <link rel="stylesheet" href="../Css/main.css">
    <link rel="stylesheet" href="../Css/about.css">
    <link rel="stylesheet" href="../Css/main-moblie.css">
    <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/logo.png">
    <link rel="stylesheet" href="../Css/search.css">
    <title>Blog</title>
</head>
<body>
<?php 
   include_once 'header.php'; 
   ?>
    <div class="box-banner-about" style="background-position: 50%;">
        <div class="in-banner-about">
            <div class="title-banner">Fashion</div>
            <div class="box-path-about">
                <div>Home</div>
                <div class="icon">
                    <i class="fa-solid fa-angle-right"></i>
                </div>
                <div>Blog</div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="all-box-sidebar">
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
            <div class="box-categories">                    
                <h3>Categories</h3>
                <div class="in-categories">
                    <i class="fa-solid fa-angle-right"></i>
                    <a href="">
                        <div>Backpack (8)</div>
                    </a>
                </div>
                <div class="in-categories" style="padding-top: 5px;">
                    <i class="fa-solid fa-angle-right"></i>
                    <a href="">
                        <div>Fashion (4)</div>
                    </a>
                </div>
                <div class="in-categories" style="padding-top: 5px;">
                    <i class="fa-solid fa-angle-right"></i>
                    <a href="">
                        <div>Life Style (4)</div>
                    </a>
                </div>
                <div class="in-categories" style="padding-top: 5px;">
                    <i class="fa-solid fa-angle-right"></i>
                    <a href="">
                        <div>Shorts (5)</div>
                    </a>
                </div>
                <div class="in-categories" style="padding: 5px 0 0 0;">
                    <i class="fa-solid fa-angle-right"></i>
                    <a href="">
                        <div>Swimwear (4)</div>
                    </a>
                </div>
            </div>
            <div class="box-recent">
                <h3>Recent Posts</h3>
                <div class="in-recent">
                    <div class="in-content-recent">
                        <img src="../Picture/Blog/Blog_01-500x500.jpg" alt="">
                        <div class="box-text-recent">
                            <div>May 30, 2025</div>
                            <a href="">Easy Fixes For Home Decor</a>
                        </div>
                    </div>
                    <div class="in-content-recent">
                        <img src="../Picture/Blog/Blog_02-500x500.jpg" alt="">
                        <div class="box-text-recent">
                            <div>May 30, 2025</div>
                            <a href="">How To Make Your Home A Showplace</a>
                        </div>
                    </div>
                    <div class="in-content-recent" style="border-bottom: none;">
                        <img src="../Picture/Blog/Blog_03-500x500.jpg" alt="">
                        <div class="box-text-recent">
                            <div>May 30, 2025</div>
                            <a href="">Stunning Furniture With Aesthetic Appeal</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-categories">                    
                <h3>Archives</h3>
                <div class="in-categories">
                    <i class="fa-solid fa-angle-right"></i>
                    <a href="">
                        <div>May 2025</div>
                    </a>
                </div>
                <div class="in-categories" style="padding-top: 5px;">
                    <i class="fa-solid fa-angle-right"></i>
                    <a href="">
                        <div>April 2025</div>
                    </a>
                </div>
            </div>
            <div class="box-tags">
                <h3>Tags</h3>
                <div class="in-tag-1">
                    <a href="" class="tag-1">Baber</a>
                    <a href="" class="tag-1">Baby Needs</a>
                    <a href="" class="tag-1">Beauty</a>
                    <a href="" class="tag-1">Cosmetic</a>
                    <a href="" class="tag-1">Ear Care</a>
                    <a href="" class="tag-1">electric</a>
                    <a href="" class="tag-1">Fashion</a>
                    <a href="" class="tag-1">Food</a>
                    <a href="" class="tag-1">Jwerly</a>
                    <a href="" class="tag-1">Medical</a>
                    <a href="" class="tag-1">Mimimal</a>
                    <a href="" class="tag-1">Organic</a>
                    <a href="" class="tag-1">Simple</a>
                    <a href="" class="tag-1">Sport</a>
                </div>
            </div>
        </div>
        <div class="box-content-blog">
            <div class="blog-1">
                <a href="">
                    <img src="../Picture/Blog/Blog_01.jpg" alt="">
                </a>
                <div class="content-blog-1">
                    <div class="list-link">
                        <a href="">Backpack</a>
                        <span>,</span>
                        <a href="">Fashion</a>
                        <span>,</span>
                        <a href="">Life style</a>
                    </div>
                    <div class="title">
                        <a href="">Easy Fixes For Home Decor</a>
                    </div>
                    <div class="box-by">
                        <span>By : Wpbingo</span>
                        <span>|</span>
                        <span>4 Comments</span>
                    </div>
                </div>
            </div>
            <div class="blog-2">
                <div class="box-1 pading-img-1">
                    <img src="../Picture/Blog/Blog_02.jpg" alt="">
                    <div class="content-box-1">
                        <div class="first-content">
                            <a href="">Backpack</a>
                            <span>,</span>
                            <a href="">Fashion</a>
                            <span>,</span>
                            <a href="">Life style</a>
                        </div>
                        <div class="second-content">
                            <a href="">How To Make Your Home A Showplace</a>
                        </div>
                        <div class="three-content">
                            <span>By : Wpbingo</span>
                            <span>|</span>
                            <span>1 Comment</span>
                        </div>
                    </div>
                </div>
                <div class="box-1 pading-img-2">
                    <img src="../Picture/Blog/Blog_03.jpg" alt="">
                    <div class="content-box-1">
                        <div class="first-content">
                            <a href="">Backpack</a>
                            <span>,</span>
                            <a href="">Fashion</a>
                            <span>,</span>
                            <a href="">Life style</a>
                        </div>
                        <div class="second-content">
                            <a href="">Stunning Furniture With Aesthetic Appeal</a>
                        </div>
                        <div class="three-content">
                            <span>By : Wpbingo</span>
                            <span>|</span>
                            <span>1 Comment</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="blog-1">
                <a href="">
                    <img src="../Picture/Blog/Blog_04.jpg" alt="">
                </a>
                <div class="content-blog-1">
                    <div class="list-link">
                        <a href="">Backpack</a>
                        <span>,</span>
                        <a href="">Fashion</a>
                        <span>,</span>
                        <a href="">Life style</a>
                        <span>,</span>
                        <a href="">Swimwear</a>
                    </div>
                    <div class="title">
                        <a href="">How To Choose The Right Sectional Sofa</a>
                    </div>
                    <div class="box-by">
                        <span>By : Wpbingo</span>
                        <span>|</span>
                        <span>0 Comments</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Phần footer -->
    <?php include 'footer.php'; ?>
    <!-- End Phần footer -->
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