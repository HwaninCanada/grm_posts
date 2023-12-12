    <!-- Content Row -->
    <div class="mb-4"><?php echo $post['content']; ?></div>
    
    <!-- Image Row -->
    <?php 
    if(!empty($post['image'])){
      $imageData = base64_encode($post['image']);
      $imageSrc = "data:image/bmp;base64," . $imageData;
      
      echo "<div class='flex items-center mb-2'>
      <img src=".$imageSrc." alt='Post Image' class='w-16 h-16 object-cover rounded-full mr-2;>
      </div>";
    }

    ?>