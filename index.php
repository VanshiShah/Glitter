<?php
include('db.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
 if (isset($_POST['Add_To_Pouch']))
  {
     if (isset($_SESSION['cart1']))
      {
         $myitems = array_column($_SESSION['cart1'], 'Item_Name');
         if (in_array($_POST['Item_Name'], $myitems))
          {
             header("Location: index1.php");
             exit();
         } 
         else 
         {
             $count = count($_SESSION['cart1']);
             $_SESSION['cart1'][$count] = array('Item_Name' => $_POST['Item_Name'], 'Price' => $_POST['Price'], 'Quantity' => 1);
             header("Location: index1.php");
             exit();
         }
     }
      else
       {
         $_SESSION['cart1'][0] = array('Item_Name' => $_POST['Item_Name'], 'Price' => $_POST['Price'], 'Quantity' => 1);
         header("Location: index1.php");
         exit();
     }
 }
 if (isset($_POST['Remove_Item'])) {
     foreach ($_SESSION['cart1'] as $key => $value) {
         if ($value['Item_Name'] == $_POST['Item_Name']) {
             unset($_SESSION['cart1'][$key]);
             $_SESSION['cart1'] = array_values($_SESSION['cart1']);
             header("Location: addtopouch.php");
             exit();
         }
     }
 }
 if (isset($_POST['mod_quantity'])) {
     foreach ($_SESSION['cart1'] as $key => $value) {
         if ($value['Item_Name'] == $_POST['Item_Name']) {
             $_SESSION['cart1'][$key]['Quantity'] = $_POST['mod_quantity'];
             header("Location: addtopouch.php");
             exit();
         }
     }
 }
}
?>
</head>
<!DOCTYPE html>
<html lang="english">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width-device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style2.css">
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
        <title>Glitter</title>
    <style>
      h2{
        font-family: cursive;
        padding-left: 20px;
        margin-top: 10px;
      }
      h3{
        font-family: cursive;
        font-size: 25px;
        padding-left: 20px;
        margin-top: 10px;
      }
      .icon { 
            margin-left: 10px; 
            float: right; 
            padding-right: 10px;
        } 
        /***MENU BAR****/
        #sidebar {
          height: 100%;
          width: 0;
          position: fixed;
          background-color: #f3819c;
          overflow-x: hidden;
          transition: 0.5s;
          padding-top: 80px;
          
        }

        #sidebar a {
          padding: 10px 15px;
          text-decoration: none;
          font-size: 18px;
          color: rgb(0, 0, 0);
          display: block;
          transition: 0.3s;
          
        }

        #sidebar a:hover {
          background-color: whitesmoke;
        }

        #menu-btn {
          font-size: 30px;
          cursor: pointer;
          position: fixed;
          z-index: 1;
          margin-left: 60px;
          margin-top: -20px;
          color: rgb(0, 0, 0);
        }

        .content {
          margin-left: -50px;
          padding: 20px;
          transition: margin-left 0.5s;
        }
        .checkbtn{
          font-size:30px;
          color:black;
          float:right;
          line-height:80px;
          margin-right:40px;
         
        }
        #check{
          display:none;

        }
        ul{
          list-style:none;
      
        }
        ul li{
          display: inline-block;
          position: relative;
        }
        ul li a{
          position: relative;
          padding: 5px 20px;
          text-decoration: none;
          text-align: center;
          font-size:20px;
          color: black;
        }
          ul li ul.dropdown li{
            display:block;

          }
          ul li ul.dropdown{
            width: 100%;
            position: absolute;
            z-index:999;
            display:none;
          }
        ul li a:hover{
          background: #FFC0CB;
        }
          ul li:hover ul.dropdown{
            display: block;
          }
    </style>
</head>
<body>

    <!--Navigation Bar start-->
    <nav class="navbar">
    <ul>
      <li>
      <?php// include("menu.php"); ?>
      <a href="index1.php"><i class="fas fa-bars" style="font-size:27px;color:black"></i></a>
      <!--a href="#">menu</a-->
    <ul class="dropdown">
      <li><a href="sreg1.php">Seller</a></li>
      <li><a href="dreg.php">DeliveryPerson</a></li>
      <li><a href="myorders.php">MyOrders</a></li>
    
      </ul>
    </li>
        </ul>
        <div class="logo"><h1>Glitter</h1></div>
     
        <div class="search-box">
        <form action ="index2.php" method="POST">
        <!--div class="row"-->
           <button type="submit" name ="submit" require><i class="fa fa-search" aria-hidden="true"></i></button>
            <input list="beauty" id="input-box" placeholder="Search here" name="search" autocomplete="off" require>
            <datalist id="beauty">
              <option value="lipstick"></option>
              <option value="foundation"></option>
              <option value="Eyeshadow"></option>
              <option value="Mascara"></option>
              <option value="Makeup Brushes"></option>
              <option value="Nude Lipstick"></option>
              <option value="Nailart"></option>
              <option value="MAC Foundation"></option>
              <option value="Maybelline New York Eyeliner"></option>
              <option value="maybelline foundation"></option>
              <option value="M.A.C Studio Fix 24-Hour Smooth Wear Concealer"></option>
              <?php
  if(isset($_POST['search']))
{
   // $search =mysqli_real_escape_string($con, $_POST['search']);
    $sql="SELECT * FROM `product`";
    $result=mysqli_query($con,$sql);
    if($result==TRUE)
    {
    $count = mysqli_num_rows($result);
    $sn=1;
    if($count > 0)
    {
       while($row=mysqli_fetch_assoc($result))
        {
            $P_id = $row['P_ID'];
            $P_name = $row['P_name'];
            $Category = $row['Category'];
            $MFG_Date = $row['MFG_Date'];
            $EXP_Date = $row['EXP_Date'];
            $Size= $row['Size'];
            $Price=$row['Price'];
            $Quantity = $row['Quantity'];
            $p_img=$row['p_img'];
            $P_des=$row['P_des']; 
        } 
    }
  }
    else
    {
        echo "<div class='alert alert-danger'>There is no product please try again:</div>";
    }

}
?>
        </datalist>

            
            </form>
        </div>
        <ul class="menu">
        
        <li><a href="customerProfile.php"><i class="fas fa-user-circle" style="font-size:27px;color:black"></i></a></li>
        <li><a href="index1.php"><i class="fa fa-home" style="font-size:27px;color:black"></i></a></li>
            <li><a href="wish.php"><i class="fa fa-heart" style="font-size:27px;color:rgb(241, 47, 122)"></i></a></li>
             <li><a href="addtopouch.php"><i class="fa fa-shopping-bag" type="submit" style="font-size:27px;color:black"></i></a></li>
        </ul>

    </nav>
     
    </body>
</html>
    <section id="slider" class="pt-5">
    </section>
    <div class="container">
      <h8 class="text-center"></h8>
          <div class="slider">
            <div class="owl-carousel">
              <div class="slider-card">
                
                  <img src="lak.jpg" height="300" width="395">
                 
                <img src="may.jpg" height="300" width="395">
                
                <img src="09AUG21-BP-LB-MAC-9_9-APP.jpg" height="300" width="388">   
              
                <img src="swisss.jpg" height="300" width="385">   
                          
        </div>
        </div>
        </div>
        </div>
        </div>
      
    <!--Navigation Bar End-->
    <!--Brand buttons start-->
      
          <!--Brand buttons End-->



      <h3>Products You May Like
            <?php 
        $sql = "SELECT * FROM product";
        $result= mysqli_query($con,$sql);
        ?>
      <section class="sec">
        <div class="products">
    
          <!--Card start-->
          <?php
          while($row=mysqli_fetch_array($result)){
            ?>
          <div class="card">
            <div class="img"><img src="<?= $row['p_img']; ?>" name="img" alt="" height="250" width="250"></div></a>
            <div class="desc"><?= $row['P_des'];?></div>
            <div class="title"><?= $row['P_name'];?></div>
            <div class="box">
            <div class="Price"><?= $row['Price'];?></div>
            <form action = "manage_wishlist.php" method="POST">
            <button type="submit" name="wish" class="wish"><a href=""><i class="fa fa-heart" style="font-size:27px;color:rgb(241, 47, 122)"></i></a></button>
            <input type="hidden" name="Item_Name" value="<?= $row['P_name'];?>">
            <input type="hidden" name="Price" value="<?= $row['Price'];?>"></form>
            </div>
            <form action = "index1.php" method="POST">
            <button class="btn" name="Add_To_Pouch">Add to Pouch</button>
            <input type="hidden" name="Item_Name" value="<?= $row['P_name'];?>">
            <input type="hidden" name="Price" value="<?= $row['Price'];?>">
            <button class="btn1" name="Add_To_Pouch"><a style="text-decoration: none; color: rgb(241, 47, 122);" href="pdisplay.php?P_ID=<?= $row['P_ID'];?>">View</button></form>
            <input type="hidden" name="Item_Name" value="<?= $row['P_name'];?>">
            <input type="hidden" name="Price" value="<?= $row['Price'];?>">
            <!--input type="hidden" name="submit" value="pdisplay.php?P_ID=<?/* $row['P_ID'];*/?>"> 
            <a href="pdisplay.php?P_ID=<?/* $row['P_ID'];*/?>" class="btn"  type="submit"></a--> 
          </div>
        <?php
          }
?>

          <!--Card End-->
          <!--Card start-->

             <!--Card End-->
        </div>
      </section>
      
      <footer>
        <p>Copyrights at <a href="">Glitter</a></p>
      </footer>
      
</body>
</html>