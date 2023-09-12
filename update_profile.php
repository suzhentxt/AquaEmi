<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(isset($_POST['update_profile'])){

   $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
   $update_about = mysqli_real_escape_string($conn, $_POST['update_about']);
   $update_socialmedia = mysqli_real_escape_string($conn, $_POST['update_socialmedia']);
   $update_games = mysqli_real_escape_string($conn, $_POST['update_games']);
   $update_places = mysqli_real_escape_string($conn, $_POST['update_places']);

   mysqli_query($conn, "UPDATE `user_form` SET name = '$update_name', about = '$update_about', socialmedia = '$update_socialmedia', games = '$update_games', places = '$update_places' WHERE id = '$user_id'") or die('query failed');

   $old_pass = $_POST['old_pass'];
   // $update_pass = mysqli_real_escape_string($conn, md5($_POST['update_pass']));
   $new_pass = mysqli_real_escape_string($conn, md5($_POST['new_pass']));
   $confirm_pass = mysqli_real_escape_string($conn, md5($_POST['confirm_pass']));

   // if(!(empty($update_pass) and empty($new_pass) and empty($confirm_pass))){
   //    if($update_pass != $old_pass){
   //       $message[] = 'old password not matched!';
   //    }elseif($new_pass != $confirm_pass){
   //       $message[] = 'confirm password not matched!';
   //    }else{
   //       mysqli_query($conn, "UPDATE `user_form` SET password = '$confirm_pass' WHERE id = '$user_id'") or die('query failed');
   //       $message[] = 'password updated successfully!';
   //    }
   // }

   $update_image = $_FILES['update_image']['name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_folder = 'uploaded_img/'.$update_image;

   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'image is too large';
      }else{
         $image_update_query = mysqli_query($conn, "UPDATE `user_form` SET image = '$update_image' WHERE id = '$user_id'") or die('query failed');
         if($image_update_query){
            move_uploaded_file($update_image_tmp_name, $update_image_folder);
         }
         $message[] = 'image updated succssfully!';
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
   <title>update profile</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<div class="update-profile">

   <?php
      $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select) > 0){
         $fetch = mysqli_fetch_assoc($select);
      }
   ?>

   <form action="" method="post" enctype="multipart/form-data">
      <?php
         if($fetch['image'] == ''){
            echo '<img src="images/default-avatar.png">';
         }else{
            echo '<img src="uploaded_img/'.$fetch['image'].'">';
         }
         if(isset($message)){
            foreach($message as $message){
               echo '<div class="message">'.$message.'</div>';
            }
         }
      ?>

      <div class="flex">

         <div class="inputBox">
            <span>name:</span>
            <input type="text" name="update_name" value="<?php echo $fetch['name']; ?>" class="box">
            <!-- <input type="hidden" name="old_pass" value="<?php echo $fetch['password']; ?>">
            <span>old password:</span>
            <input type="password" name="update_pass" placeholder="enter previous password" class="box">
            <span>new password:</span>
            <input type="password" name="new_pass" placeholder="enter new password" class="box">
            <span>confirm password:</span>
            <input type="password" name="confirm_pass" placeholder="confirm new password" class="box"> -->
            <span>image:</span>
            <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
            <span>about:</span>
            <textarea name="update_about" value="<?php echo $fetch['about']; ?>" class="box"></textarea>
         </div>
      
         <div class="inputBox">
            <span>social media:</span>
            <textarea name="update_socialmedia" value="<?php echo $fetch['socialmedia']; ?>" class="box"></textarea>
            <span>games:</span>
            <textarea name="update_games" value="<?php echo $fetch['games']; ?>" class="box"></textarea>
            <span>places:</span>
            <textarea name="update_places" value="<?php echo $fetch['places']; ?>" class="box"></textarea>
         </div>
      
      </div>
      
      <div class="btn-container">
         <input type="submit" value="update profile" name="update_profile" class="home-btn">
         <a href="home.php" class="delete-btn">go back</a>
      </div>
   </form>

</div>

</body>
</html>