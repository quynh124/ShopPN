<?php
session_start();

// Kết nối cơ sở dữ liệu
$mysqli = new mysqli("localhost", "root", "", "shop_noithat");

if ($mysqli->connect_errno) {
    echo "Kết nối MySQLi lỗi: " . $mysqli->connect_error;
    exit();
}

// Kiểm tra nếu `id_chatbot` tồn tại trong URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM chatbot WHERE id = ? LIMIT 1";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $chatbot = $result->fetch_assoc();
    } else {
        echo "Chatbot not found.";
        exit();
    }
} else {
    echo "Chatbot ID is missing or invalid.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Chatbot</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Edit Chatbot</h2>
        <form method="POST" action="data_processing.php">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($chatbot['id']); ?>">

            <div class="form-group">
                <label for="question">Queries</label>
                <input type="text" class="form-control" id="queries" name="queries" value="<?php echo htmlspecialchars($chatbot['queries']); ?>" required>
            </div>

            <div class="form-group">
                <label for="answer">Replies</label>
                <textarea class="form-control" id="replies" name="replies" rows="3" required><?php echo htmlspecialchars($chatbot['replies']); ?></textarea>
            </div>

            <button type="submit" name="update_chatbot" class="btn btn-primary">Update Chatbot</button>
            <a href="./manage_chatbot.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>