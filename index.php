<?php

include_once 'db.php';

//Setting offset to limit query result size

$currentPageNumber = 1;
$perPage = 10;
if ($currentPageNumber == 1) {
    $offset = 0;
} else if ($currentPageNumber < 1) {
    $offset = ($pageNumber - 1) * $perPage;
}

// Getting data from DB

$sql = "SELECT title, posted_at, posted_by FROM posts ORDER BY posted_at DESC LIMIT :perPage OFFSET :offset";

try {

    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':perPage', $perPage, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

    // Execute the query
    $stmt->execute();

    // Fetch posts into an associative array
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if there are posts otherwise aleart error msg
    if (count($posts) === 0) {
        echo "<script> alert('query result is empty')</script>";
        $posts=[];
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
} finally {
    
    // Close the database connection
    $conn = null;
}

// EXAMPLE DATA
//$posts = [
//    ['title' => 'Sample Post Title 1', 'content' => 'This is the content for post 1.', 'posted_at' => '2023-12-07 12:34:56', 'posted_by' => 'John Doe', 'image' => 'image1.jpg'],
//    ['title' => 'Sample Post Title 2', 'content' => 'This is the content for post 2.', 'posted_at' => '2023-12-08 10:45:30', 'posted_by' => 'Jane Doe', 'image' => 'image2.jpg'],
//    
//];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <title>Community Forum</title>
</head>

<body class="bg-gray-100">

  <!-- Navigation -->
  <div class="bg-blue-500 p-4 text-white">
    <div class="container mx-auto flex justify-between items-center">
      <div class="text-2xl font-bold">Community Forum</div>
      <!-- need to user authentication logic here for displaying user-specific elements -->
      <div>
        <!-- not done yet -->
        <?php if ($loggedInUser): ?>
        <span class="mr-2">Hello, <?php echo $loggedInUser; ?>!</span>
        <a href="logout.php" class="underline">Logout</a>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="container mx-auto mt-8">

    <!-- Search Bar -->
    <div class="mb-4 flex items-center">
      <input type="text" placeholder="Search..." class="border border-gray-300 p-2 rounded-md flex-grow">
      <button class="bg-blue-500 text-white p-2 rounded-md ml-2">Search</button>
    </div>

    <!-- Display Posts -->
    <?php foreach ($posts as $post): ?>
    <!-- Post Information Row -->
    <div class="flex items-center mb-2">
      <div class="font-bold mr-2"><?php echo $post['title']; ?></div>
      <div class="text-gray-500 mr-2"><?php echo $post['posted_at']; ?></div>
      <div class="text-gray-500"><?php echo $post['posted_by']; ?></div>
    </div>

    <!-- Actions Row -->
    <div class="flex">
      <!-- Add your authentication logic here for showing/hiding edit/delete buttons -->
      <!-- Replace 'john_doe' with the actual username of the logged-in user -->
      <?php if ($loggedInUser == $post['posted_by']): ?>
      <button class="bg-green-500 text-white p-2 rounded-md mr-2">Edit</button>
      <button class="bg-red-500 text-white p-2 rounded-md">Delete</button>
      <?php endif; ?>
    </div>

    <!-- Divider Line -->
    <hr class="my-4 border-gray-300">
    <?php endforeach; ?>

    <!-- Button to Write a Post -->
    <div class="mt-8">
      <button class="bg-blue-500 text-white p-2 rounded-md" onclick="location.href='new_post.html'">>Write a
        Post</button>
    </div>

  </div>

</body>

</html>