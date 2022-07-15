<?php 
include ('session.php');
include ('connect.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- <link rel="stylesheet" href="style.css" /> -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor"
      crossorigin="anonymous"
    />
  </head>
  <body>
    <div class="d-flex" id="wrapper">
        <?php 
            include ("sidebar.php");  
        ?>
    <div id="page-content-wrapper">
         <?php 
            include ("header.php");
        ?>
        <div class="container mt-3">
            <div class="row">
                <h1 class="text-center">Summary</h1>
                <div class="col-4 text-center">
                    <div class="border border-success bg-success">
                        <h1 class="text-center text-light mt-3">
                            Invoices
                        </h1>
                        <i class="fa-solid fa-file-invoice-dollar fa-2xl my-4" style="color: white"></i>
                        <h2 class="text-center text-light mt-2">
                             <?php  $qry = mysqli_query($con,"select count_invoice() as cnt");
                            while($row=mysqli_fetch_array($qry,MYSQLI_NUM)){
                            $no = $row[0];
                            echo $no;
        
                         }?>
                        
                        </h2>  
                    </div>
                   
                </div>
                <div class="col-4 text-center">
                    <div class="border border-success bg-success">
                        <h1 class="text-center text-light mt-3">
                            Total Earn:

                        </h1>
                        <i class="fa-solid fa-dollar-sign fa-2xl my-4" style="color: white"></i>
                        <h2 class="text-center text-light mt-2">
                            $
                             <?php  $qry = mysqli_query($con,"select sum_of_sale() as sum");
                            while($row=mysqli_fetch_array($qry,MYSQLI_NUM)){
                            $no = $row[0];
                            echo $no;
        
                         }?>
                        
                        </h2>  
                    </div>
                   
                </div>
                <div class="col-4 text-center">
                    <div class="border border-success bg-success">
                        <h1 class="text-center text-light mt-3">
                            Total Customer:

                        </h1>
                        <i class="fa-solid fa-users fa-2xl my-4" style="color: white"></i>
                        <h2 class="text-center text-light mt-2">
                            
                             <?php  $qry = mysqli_query($con,"select count_customer() as count");
                            while($row=mysqli_fetch_array($qry,MYSQLI_NUM)){
                            $no = $row[0];
                            echo $no;
        
                         }?>
                        
                        </h2>  
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>