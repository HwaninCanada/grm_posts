<?php
  include_once "db.php";

// Process Data from new_post
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST["title"];
    $content = $_POST["content"];
    //Not sure about session remove it for now.
    //Do hard coding.
    #$user = $_SESSION["userName"];
    $user = "Admin";
    $image = base64_encode($_POST["image"]);
    

    // Check the data is set
    if (!empty($subject)) {
      echo '<script> alert("Subject is required."); </script>';
      exit();
    }
    else if (!empty($subject)) {
      echo '<script> alert("Password is required."); </script>';
      exit();
    }
    // SQL query to insert post data into the database
    $sql = "INSERT INTO posts (title, content, posted_by, image) VALUES (:title, :content, :user, :image)";

    try {

      $stmt = $conn->prepare($sql);

      // Bind parameters
      $stmt->bindParam(':title', $title, PDO::PARAM_STR);
      $stmt->bindParam(':content', $content, PDO::PARAM_STR);
      $stmt->bindParam(':user', $user, PDO::PARAM_STR);
      $stmt->bindParam(':image', $image, PDO::PARAM_STR);

      // Execute the statement
      if ($stmt->execute()) {
          echo '<script> alert("It has been posted successfully!"); location.href="index.php" </script>';
      } else {
          echo "Error: " . $stmt->errorInfo()[2];
      }
    } catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
    } finally {
      // Close the statement and the database connection
      $stmt = null;
      $conn = null;
    }


  }   
?>