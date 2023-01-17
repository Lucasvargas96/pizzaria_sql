<?php 
include_once("process/conn.php");
$msg ="";
if(isset($_SESSION["msg"])){
    $msg = $_SESSION["msg"];
    $status =$_SESSION["status"];

    $_SESSION["msg"]="";
    $_SESSION["status"]="";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faça seu pedido</title>
    
    
     <!--BootstrapCSS-->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" 
      rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" 
      crossorigin="anonymous">
      <!--BootstrapJS-->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" 
       integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" 
        crossorigin="anonymous" defer></script>
    <!--Font awesome, isso é uma fonte de icones-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" 
     integrity="sha512- 
      MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" 
       crossorigin="anonymous" referrerpolicy="no-referrer" />
       <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header> 
       <nav class="navbar navbar-expand-lg">
          <a href="index.php" class="navbar-brand">
             <img src="img/pizza.svg" alt="Pizzaria do João" id="brand-logo">
          </a>
         <div class="collapse navbar-collapse" id="navbarNav">
             <ul class="navbar-nav">
                 <li class="nav-item active">
                     <a href="dashboard.php" class="nav-link">Peça sua pizza</a>
                 </li>
             </ul>
         </div>
       </nav>
    </header>
    <?php if($msg != ""):?>
    <div class="alert alert-<?=$status ?>">
        <p><?=$msg?></p>
    </div>
    <?php endif;?>