<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Profile</title>

   <!-- Template Stylesheet -->
   <link href="css/style.css" rel="stylesheet">

</head>

<body>   

<div class="container">

   <div class="profile">

      <div class="profile-info">
         <?php
            $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
            if(mysqli_num_rows($select) > 0){
               $fetch = mysqli_fetch_assoc($select);
            }
            if($fetch['image'] == ''){
               echo '<img src="images/default-avatar.png" class="profile-image">';
            }else{
               echo '<img src="uploaded_img/'.$fetch['image'].'" class="profile-image">';
            }
         ?>
         <h3 class="profile-name"><?php echo $fetch['name']; ?></h3>
         
      </div>
      <a href="update_profile.php" class="home-btn">update profile</a>
      <!-- <a href="home.php?logout=<?php echo $user_id; ?>" class="delete-btn">logout</a> -->
      
      <div class="profile-info2">

         <table>
            <tr>
                <th>About</th>
                <td>
                    <p><?php echo $fetch['about']; ?></p>
                </td>
            </tr>
            <tr>
                <th>Social Media</th>
                <td>
                  <p><?php echo $fetch['socialmedia']; ?></p>
                </td>
                
            </tr>
            <tr>
                <th>Games</th>
                <td>
                  <p><?php echo $fetch['games']; ?></p>
                </td>
            </tr>
            <tr>
                <th>Places</th>
                <td>
                  <p><?php echo $fetch['place']; ?></p>
                </td>
            </tr>
        </table>
      
      </div>

   </div>

</div>

</body>
</html>