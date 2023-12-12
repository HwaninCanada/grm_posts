<?php 
  include_once "db.php";

  $post_id = $_GET["post_id"];

  // Getting Data from DB
  $sql = "SELECT * FROM posts WHERE id = :post_id";
  
  try {
    
      $stmt = $conn->prepare($sql);
  
      // Bind parameter
      $stmt->bindParam(':post_id', $post_id, PDO::PARAM_STR);

      // Execute the statement
      $stmt->execute();
  
      // Fetch a single post into an associative array
      $post = $stmt->fetch(PDO::FETCH_ASSOC);
  
      if ($post) {
          // Post found
          // You can access post data using $post["column_name"]
      } else {
          echo "<script> alert('No post found with that ID') location.href='index.php' </script>  ";
      }
  } catch (PDOException $e) {
      die("Database error: " . $e->getMessage());
  } finally {
      // Close the statement and the database connection
      $stmt = null;
      $conn = null;
  }
  
    
    ?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <title>Post</title>
</head>

<body>
  <div class="container">
    <!-- Post Information Row -->
    <p class="flex items-center mb-2 border-solid border-2 border-sky-500">
      <strong class="font-bold mr-2"><?php echo $post['title']; ?></strong>
      <span class="text-gray-500 mr-2"><?php echo $post['posted_at']; ?></span>
      <strong class="text-gray-500"><?php echo $post['posted_by']; ?></strong>
    </p>

    <!-- Content Row -->
    <textarea class="mb-4 border-solid border-2 border-sky-500"><?php echo $post['content']; ?></textarea>

    <!-- Image Row -->
    <?php 
    $imageData = base64_encode($post['image']);
    
    if(!empty($imageData)){
      
      $imageSrc = "data:image/bmp;base64," . $imageData;
      
      echo "<div class='flex items-center mb-2'>
      <img src=".$imageSrc." alt='Post Image' class='w-16 h-16 object-cover rounded-full mr-2;>
      </div>";
    }

    ?>

  </div>

</body>

</html>