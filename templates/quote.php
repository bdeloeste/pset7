<?php  
       
    $stock = lookup($_POST["symbol"]);
    
    print("A share of {$stock['name']} ({$stock['symbol']}) costs: <b>$" . number_format($stock["price"], 2)); 
?>

