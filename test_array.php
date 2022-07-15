<html>
<head></head> 
<body>
<?php
include ('connect.php');
include('session.php');
$cartArray = array(123, 12, 490);
$_SESSION['cartle'] = $cartArray;
$num = 0;
foreach($_SESSION["cartle"] as $keys => $values)
{
        $_SESSION["quan"][$num] = 0; 
  
?>
        <form action=<?php 
        if(isset($_POST["increment"]))
        {
            $_SESSION["quan"][$_POST["value"]] = $_SESSION["quan"][$num] + 1;
        }
        if(isset($_POST["decrement"]))
        {
            $_SESSION["quan"][$_POST["value"]] = $_SESSION["quan"][$num] - 1;
        }
        ?>method="post">
        <input type="submit" name="increment" class="btn btn-primary" value="+"/>
        <input type="hidden" name="value" value=<?php echo $num?>>
        <?php echo $_SESSION["quan"][$num]?>
        <input type="submit" name="decrement" class="btn btn-primary" value="-"/>                                  
        </form>        
<?php 
$num++;   
}
?> 
</body>   
</html>
