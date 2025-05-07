
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/chatbot.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="../Css/about.css">
    <link rel="stylesheet" href="../Css/main.css">
    <link rel="stylesheet" href="../Css/main-moblie.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="../Css/blog.css">
    <link rel="stylesheet" href="../Css/main.css">
    <link rel="stylesheet" href="../Css/about.css">
    <link rel="stylesheet" href="../Css/main-moblie.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <script src="https://kit.fontawesome.com/eda05fcf5c.js" crossorigin="anonymous"></script>
    <script src="js/main.js"></script>
</head>
<body>
<?php 
   include_once 'header.php'; 
   ?>
   
    <div class="wrapper">
        <div class="title"> Chatbot</div>
        <div class="form">
            <div class="bot-inbox inbox">
                <div class="icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="msg-header">
                    <p>Hello there, how can I help you?</p>
                </div>
            </div>
        </div>
        <div class="typing-field">
            <div class="input-data">
                <input id="data" type="text" placeholder="Type something here.." required>
                <button id="send-btn">Send</button>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $("#send-btn").on("click", function(){
                $value = $("#data").val();
                $msg = '<div class="user-inbox inbox"><div class="msg-header"><p>'+ $value +'</p></div></div>';
                $(".form").append($msg);
                $("#data").val('');
                // start ajax code
                $.ajax({
                    url: '_dbcon.php',
                    type: 'POST',
                    data: 'text='+$value,
                    success: function(result){
                        $replay = '<div class="bot-inbox inbox"><div class="icon"><i class="fas fa-user"></i></div><div class="msg-header"><p>'+ result +'</p></div></div>';
                        $(".form").append($replay);
                        // when chat goes down the scroll bar automatically comes to the bottom
                        $(".form").scrollTop($(".form")[0].scrollHeight);
                    }
                });
            });
        });
    </script>
  <div class="box-first-footer" style="width: 2080px;">
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
                <img src="../Picture/payments-1.png" alt="">
            </div>
        </div>
    </div>
</body>
</html>