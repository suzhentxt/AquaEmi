<?php

include 'config.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $about = mysqli_real_escape_string($conn, $_POST['about']);
   $socialmedia = mysqli_real_escape_string($conn, $_POST['socialmedia']);
   $games = mysqli_real_escape_string($conn, $_POST['games']);
   $places = mysqli_real_escape_string($conn, $_POST['places']); 

   $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if (mysqli_num_rows($select) > 0) {
      $message[] = 'User already exists';
   } else {
      if ($pass != $cpass) {
         $message[] = 'Confirm password not matched!';
      } elseif ($image_size > 2000000) {
         $message[] = 'Image size is too large!';
      } else {
         $insert = mysqli_query($conn, "INSERT INTO `user_form`(name, email, password, image, about, socialmedia, games, places) VALUES('$name', '$email', '$pass', '$image', '$about', '$socialmedia', '$games', '$places')") or die('query failed');

         if ($insert) {
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'Registered successfully!';
            header('location: login.php');
         } else {
            $message[] = 'Registration failed!';
         }
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<div class="form-container">

   <form action="" method="post" enctype="multipart/form-data">
      <h3>register</h3>
      <?php
      if(isset($message)){
         foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
         }
      }
      ?>
      
      <div class="flex">
      
         <div class="inputBox">
            <input type="text" name="name" placeholder="name" class="box" required>
            <input type="email" name="email" placeholder="email" class="box" required>
            <input type="password" name="password" placeholder="password" class="box" required>
            <input type="password" name="cpassword" placeholder="confirm password" class="box" required>
            <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png" required>
         </div>

         <div class="inputBox">
            <textarea name="about" placeholder="about" class="box" required></textarea>
            <textarea name="socialmedia" placeholder="social media" class="box" required></textarea>
            <textarea name="games" placeholder="games" class="box" required></textarea>
            <textarea name="places" placeholder="places" class="box" required></textarea>
         </div>
      
      </div>

      <input type="submit" name="submit" value="register now" class="btn">
      <p>already have an account? <a href="login.php">login now</a></p>
   
   </form>

</div>

</body>
</html>