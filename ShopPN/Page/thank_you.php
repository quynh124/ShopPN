
<?php
require 'connect.php'; 
session_start();
// Kiểm tra nếu người dùng gửi đánh giá
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    $rating = intval($_POST['rating']);
    $comment = trim($_POST['comment']);
    $user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : null;
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    // Thêm đánh giá vào bảng reviews
    $sql = "INSERT INTO reviews (user_id, rating, comment, email) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("iiss", $user_id, $rating, $comment, $user_email);

    if ($stmt->execute()) {
        echo "<p class='thank-you-message'>Thank you for your review!</p>";
    } else {
        echo "<p style='color: red;'>Failed to submit your review. Please try again.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .review-container {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 400px;
            text-align: center;
        }

        .review-container h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 25px;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        .btn-submit {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }

        .thank-you-message {
            margin-bottom: 20px;
            color: #28a745;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="review-container">
        <h2>Thank you for your order</h2>
        <p>Please leave a review for your experience.</p>
        <form method="POST" action="thank_you.php">
            <div class="form-group">
                <label for="rating">Rating (1-5):</label>
                <input type="number" id="rating" name="rating" class="form-control" min="1" max="5" required>
            </div>
            <div class="form-group">
                <label for="comment">Comment:</label>
                <textarea id="comment" name="comment" class="form-control" rows="4" placeholder="Write your review here..." required></textarea>
            </div>
            <button type="submit" name="submit_review" class="btn-submit">Submit Review</button>
        </form>
    </div>
</body>
</html>