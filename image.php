<?php
if (isset($_GET['name']) && isset($_GET['table'])) {
    $flower_name = $_GET['name'];
    $table = preg_replace("/[^a-zA-Z0-9_]/", "", $_GET['table']); // sanitize table name

    $conn = new mysqli("localhost", "root", "", "flowers");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT flower_image FROM `$table` WHERE flower_name = ?");
    $stmt->bind_param("s", $flower_name);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($imageData);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        header("Content-Type: image/jpeg"); // or image/png depending on your stored data
        echo $imageData;
    } else {
        echo "Image not found.";
    }

    $stmt->close();
    $conn->close();
}
?>
