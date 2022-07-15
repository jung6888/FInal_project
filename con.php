<?php 
include ("session.php");
if(isset($_POST["final"]))
{
    $_SESSION["final"] = $_POST["final"];
    if($_SESSION["location_page"] == "customer.php")
    header("location: customer.php");
    else if($_SESSION["location_page"] == "food.php")
    {
      header("location: food.php");
    }
    else if($_SESSION["location_page"] == "sale.php")
    {
      header("location: sale.php");
    }
    else
    header("location: dashboard.php");
}
if(isset($_POST["back"]))
{
    $_SESSION["final"] = $_POST["back"];
    if($_SESSION["location_page"] == "customer.php")
    header("location: customer.php");
    else if($_SESSION["location_page"] == "food.php")
    {
      header("location: food.php");
    }
    else if($_SESSION["location_page"] == "sale.php")
    {
      header("location: sale.php");
    }
    else
    header("location: dashboard.php");
}
?>