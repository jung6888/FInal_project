<?php
$_SESSION["location_page"] = "sale.php";
include ('connect.php');
include ('session.php');
if(isset($_POST["add_to_cart"]))  
{   if($_POST["quantity"] > 0)
    {
        if(isset($_SESSION["cart_in"]))  
        {  
           $item_array_id = array_column($_SESSION["cart_in"], "item_id");  
           if(!in_array($_GET["id"], $item_array_id))  
           {  
                $count = count($_SESSION["cart_in"]);  
                $item_array = array(  
                     'item_id'               =>     $_GET["id"],
                     'item_quantity'         =>     $_POST["quantity"]  
                );  
                $_SESSION["cart_in"][$count] = $item_array;  
           }  
           else  
           {  
                echo '<script>alert("Item Already Added")</script>';  
                echo '<script>window.location="sale.php"</script>';  
           }  
        }  
        else  
        {  
           $item_array = array(  
                'item_id'               =>     $_GET["id"], 
                'item_quantity'         =>     $_POST["quantity"]
           );  
           $_SESSION["cart_in"][0] = $item_array;  
        }
    }
    
}
if(isset($_POST["remove_from_cart"])) 
{
    if(empty($_SESSION["cart_in"]))
    {
        header('location: sale.php');
    }
    else
    {

    
    foreach($_SESSION["cart_in"] as $keys => $values)  
    {  
        if($values["item_id"] == $_GET["id"])  
        {  
            unset($_SESSION["cart_in"][$keys]);  
            $count = count($_SESSION["cart_in"]);
            for($i =  $keys; $i < $count; $i++)
            {
                if($i == $count-1)
                {
                    unset($_SESSION["cart_in"][$i] );
                }
                else
                {
                    $_SESSION["cart_in"][$i] = $_SESSION["cart_in"][$i+1];
                }
            }
            echo '<script>alert("Item Removed")</script>';  
            echo '<script>window.location="sale.php"</script>';  
        }  
    } 
} 
} 
function get_options($select)
{
    $con = mysqli_connect("localhost","root","","pos");
    $qury = mysqli_query($con, "call cus_select();");

    $arra =  array("Please select your name:");
    $optioned = '';
    while($roww = mysqli_fetch_array($qury,MYSQLI_ASSOC)){
        array_push($arra, $roww["Customer_Name"]);
    }
    foreach($arra as $values)
    {
        if($select == $values)
        {
            $optioned.='<option value="'.$values.'" selected>'.$values.'</option>';
        }
        else
        {
            $optioned.='<option value="'.$values.'">'.$values.'</option>';
        }
    }
  return $optioned;


}
if(isset($_POST["filter_people"]))
{
  $selected = $_POST["filter_people"];
  $_SESSION["level_cus"] = $selected;
}
if(isset($_POST["submit_order"]))
{
    $no = 0;
    $con = mysqli_connect("localhost","root","","pos");
    $result1 = mysqli_query($con, "call invoice_in('".$_SESSION["discount"]."', '".$_SESSION["new_total"]."','".$_SESSION["customer_id"]."');");
    $qry = mysqli_query($con,"select count_invoice() as cnt");
    while($row=mysqli_fetch_array($qry,MYSQLI_NUM)){
        $no = $row[0];
        echo $no;
        $_SESSION["numbers"] = $no;
    }
    $num =  $_SESSION["numbers"];
    $qry = mysqli_query($con, "select * from Invoice where Invoice_Id = $num");
    $var = 0;
    while($row=mysqli_fetch_array($qry,MYSQLI_ASSOC))
    {
        $var = $row["Invoice_Id"];
    }
    foreach($_SESSION["cart_in"] as $keys => $values)
    {
        $myresult = mysqli_query($con, "insert into Order_Detail values(NULL, '".$values["item_quantity"]."', '".$values["item_id"]."', $var);");
    }
    
    //$stmt=mysqli_prepare($con,"call count_invoice(@p)");
    //mysqli_stmt_execute($stmt);
    //$qry = mysqli_query($con,"select @p");
    //while($row=mysqli_fetch_array($qry,MYSQLI_NUM)){
    //$no = $row[0]+1;


    //foreach($_SESSION["cart_in"] as $keys => $values)
    //{
    //    
//
    //}
    //mysqli_query($con, "call invoice_in('".$_SESSION["discount"]."', '".$_SESSION["new_total"]."','".$_SESSION["customer_id"]."');");
    unset($_SESSION["cart_in"]);
    header('location: sale.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="style.css" />
        <!-- CSS only -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    </head>
    <body>
        <!-- Sidebar  -->
        <div class="d-flex" id="wrapper">
            <?php 
                include ("sidebar.php");  
            ?>
            <div id="page-content-wrapper">
                    <?php 
                        include ("header.php");
                    ?>
                <div class="container-fluid">
                    <h2 class="text-center">Sale</h2>
                    <div class="row">
                        <!--start filter-->
                        <!--end filter-->
                        <div class="col-lg-10">
                            <form class="row" method="post">  
                                <div class="col-lg-11">
                                    <input placeholder="Enter Food/Drink Name....." type="text" class="form-control" name="button_search">
                                </div>
                                <div class="col-lg-1 ps-4 pb-2">
                                    <button type="submit" class="btn btn-success btn-xs">Search</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-2 ps-5">
                            <button class="add-btn btn btn-primary btn-xs" type="button" data-bs-toggle="modal" data-bs-target="#addForm">
                                <span class="h6"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Card: <?php if(empty($_SESSION["cart_in"]) ){ echo "0 ";}else{echo count($_SESSION["cart_in"]);}?> Selected</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-4 ">
                            <?php
                                $connect =  mysqli_connect("localhost","root","","pos");
                                if($connect)
                                {
                                    if(isset($_POST["button_search"]))
                                    {
                                        $argu = $_POST["button_search"];
                                        $mysql = "select * from Food where Food_Name like '$argu%'";
                                    }
                                    else
                                    {
                                        $mysql = "call select_food();";
                                    }
                                    
                                    $myqry = mysqli_query($connect, $mysql);
                                }
                                while($row = mysqli_fetch_array($myqry,MYSQLI_ASSOC)){
                            ?>
                                <div class="col-sm-6 mt-1">
                                    <div class="card" style="width: 18rem;">
                                        <img src=<?php echo $row["photo"]?> class="card-img-top"/>
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $row["Food_Name"];?></h5>
                                            <p class="card-text">$<?php echo $row["Unit_Price"];?></p>
                                        </div>
                                        <div class="container py-2 m-0">
                                            <div class="row me-5">
                                                    <form method="post" action="sale.php?action=add&id=<?php echo $row["Food_Id"];?> ">
                                                        <span>Quantity:
                                                        <input type="number" name="quantity"  /> </span>
                                                        <div class="col-6 mt-2">
                                                            <input type="hidden" name="hidden_id" value="<?php echo $row["Food_Id"]; ?>" />    
                                                            <input type="submit" name="add_to_cart" class="btn btn-success" value="Add to cart"/>
                                                        </div>
                                                    </form>      
                                                    <div class="col-6 mt-2">
                                                        <form method="post" action="sale.php?action=delete&id=<?php echo $row["Food_Id"];?> ">
                                                        <input type="hidden" name="hidden_id" value="<?php echo $row["Food_Id"]; ?>" />    
                                                        <input type="submit" name="remove_from_cart" class="btn btn-danger" value="Remove from chart"/>
                                                    </form> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                }
                            ?>
                        </div>
                        <div class="col-sm-8 bg-light mt-2 ">
                            <div class="title p-3 text-center"><h1>Cart</h1></div>
                            <?php 
                            if(!empty($_SESSION["cart_in"]))
                            {
                                $connect = mysqli_connect("localhost","root","","pos");
                                foreach($_SESSION["cart_in"] as $keys => $values)
                                {
                                    $r = mysqli_query($connect, "select * from Food where Food_Id =".$values["item_id"]."");
                                    $roww = mysqli_fetch_array($r,MYSQLI_ASSOC);
                                    ?>
                                    <div class="cart-item d-flex pb-4 pt-4 border-bottom mx-auto">
                                    <img src=<?php echo $roww["photo"]; ?> style="width: 6rem;" class="card card-img-top"/>
                                    <div class="card-body ms-1 d-flex flex-column justify-content-between">
                                    <div>
                                    <p class="card-title h4"><?php echo $roww["Food_Name"];?></p>
                                    <p class="card-title text-muted"><?php if( $roww["Type_Id"] == 1){echo "Food";}else{echo "Drink";}?></p>
                                    </div>
                                    <p class="card-text align-bottom text-primary h4">$<?php echo $roww["Unit_Price"];?></p>
                                    </div>
                                    <div class="d-flex flex-column">
                                    <div class="col text-center rounded h4" style="width: 2rem;">Q:</div>
                                    <div class="col text-center rounded h4" style="width: 2rem;"><?php echo $values["item_quantity"];?></div>
                                    </div>
                                    </div>
                                    <?php 
                                }
                            }
                            ?>
                            <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
                                <?php
                                 $total = 0.00;
                                 if(!empty($_SESSION["cart_in"]))
                                 {

                                 
                                 foreach($_SESSION["cart_in"] as $keys => $values) 
                                 {
                                     $connect =  mysqli_connect("localhost","root","","pos");  
                                     $r = mysqli_query($connect, "select * from Food where Food_Id =".$values["item_id"]."");
                                     $roww = mysqli_fetch_array($r,MYSQLI_ASSOC);
                                     $total = $total + ($values["item_quantity"] * $roww["Unit_Price"]);
                                 }
                                }
                                 ?>
                                <label for="inputOrder">Customer Name:</label>
                                <select id="inputOrder" class="form-select" name="filter_people" onchange="this.form.submit();" required>
                                <?php echo get_options($selected);?>
                                </select> 
                                <div class="d-flex justify-content-between pt-3 pb-3 my-3">
                                    <p>Note: This transaction will not allow update or delete after User commit to the transaction. So Please check your transaction before commit. Thank You</p>
                                </div>
                                <div class="d-flex justify-content-between pt-3 pb-3 my-3">
                                    <p class="h2">Total</p>
                                    <p class="h2">$<?php
                                    $connect =  mysqli_connect("localhost","root","","pos");
                                    $stmt = mysqli_query($connect, "call cus_Level('".$_SESSION["level_cus"]."');");
                                    $leveling = "";
                                    $_SESSION["total"] =  $total;
                                    while($row = mysqli_fetch_array($stmt,MYSQLI_ASSOC))
                                    {
                                        $_SESSION["customer_id"] =  $row["Customer_Id"];
                                        $leveling = $row["Level"];
                                    }
                                    if($leveling == 'BRONZE')
                                    {
                                        $_SESSION["discount"] = 0;
                                        $_SESSION["new_total"] = $total;
                                        echo $_SESSION["new_total"];
                                    }
                                    else if($leveling == 'SILVER')
                                    {
                                        //echo $leveling;
                                        $qry2=mysqli_query($con,"select calSildis($total, $total) as cal");
                                        while($row=mysqli_fetch_array($qry2,MYSQLI_NUM)){
                                        $_SESSION["discount"] = $row[0];
                                        }
                                        $dis = $_SESSION["discount"];
                                        $qry3=mysqli_query($con,"select calTotal($dis, $total) as cal");
                                        while($row=mysqli_fetch_array($qry3,MYSQLI_NUM)){
                                            $_SESSION["new_total"] = $row[0];
                                            }
                                        echo $_SESSION["new_total"];
                                        
                                        //while($row=mysqli_fetch_array($mysql,MYSQLI_NUM))
                                        //{
                                        //    echo $row[0];
                                        //}
                                        //$mysqle = mysqli_query($connect,"select silver('".$total."') as cnt");
                                        //while($row2=mysqli_fetch_array($mysqle,MYSQLI_NUM))
                                        //{
                                        //    $_SESSION["new_total"] = $row2[0];
                                        //}
                                        //echo  $_SESSION["new_total"];
                                    }
                                    else if($leveling == 'GOLD')
                                    {
                                        $qry2=mysqli_query($con,"select calGolddis($total, $total) as cal");
                                        while($row=mysqli_fetch_array($qry2,MYSQLI_NUM)){
                                        $_SESSION["discount"] = $row[0];
                                        }
                                        $dis = $_SESSION["discount"];
                                        $qry3=mysqli_query($con,"select calTotal($dis, $total) as cal");
                                        while($row=mysqli_fetch_array($qry3,MYSQLI_NUM)){
                                            $_SESSION["new_total"] = $row[0];
                                            }
                                        echo $_SESSION["new_total"];
                                    }
                                    else{
                                        echo 0;
                                    }
                                        ?></p>
                                </div>
                                
                                <input type="submit" class="btn btn-success btn-lg" value="Proceed" name="submit_order"/>
                            </form>   
                        </div>
                    </div>   
                </div>
         
                <!--
                <div class="container-fluid d-flex">
                    <div class="d-flex justify-content-center flex-wrap">
                    //    <?php
                    //        $connect =  mysqli_connect("localhost","root","","pos");
                    //        if($connect)
                    //        {
                    //            $mysql = "call select_food();";
                    //            $myqry = mysqli_query($connect, $mysql);
                    //        }
                    //            while($row = mysqli_fetch_array($myqry,MYSQLI_ASSOC)){
                    //    ?>
                        <div class="p-1">
                            <div class="card" style="width: 18rem;">
                              <img src=<?php //echo $row["photo"]?> class="card-img-top"/>
                                <div class="card-body">
                                  <h5 class="card-title"><?php //echo $row["Food_Name"];?></h5>
                                  <p class="card-text">$<?php //echo $row["Unit_Price"];?></p>
                                  <h5 class="card-title"><?php //if(isset($_POST["select"])) 
                                  //{
                                  //  echo '<p class="text-success>Selected</p>';
                                  //}
                                  //else
                                  //{
                                  //  echo '<p class="text-dark>Not Select</p>';
                                  //}
                                  //?></h5>
                                </div>
                                <div class="container py-2">
                                    <div class="row text-center">
                                      <div class="col-6 ">
                                        <form method="post" action="<?php
                                        //if(isset($_POST["select"]))
                                        //{
                                        //    array_push($_SESSION['cart'],$row["Food_Id"]);
                                        //}
                                        //?>">
                                            <button name="select" class="btn btn-success" onclick="this.form.submit()">Select</button>
                                        </form>
                                      </div>
                                      <div class="col-6">
                                        <form method="post" action="<?php 
                                        //if(isset($_POST["deselect"]))
                                        //{
                                        //    $_SESSION['cart']=array_diff($_SESSION['cart'],$row["Food_Id"]);
                                        //}
                                        //?>">
                                            <input type="submit" name="deselect" value="Deselect" class="btn btn-warning"/>
                                        </form>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        //}
                        ?>
                    </div>
                </div> 
                    -->   
            </div>
        </div>
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>