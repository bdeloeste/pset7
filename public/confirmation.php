<?php 

    require("../includes/config.php");
    
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (empty($_POST["reset"]))
        {
            apologize("Please enter the confirmation code provided in your e-mail.");
        }
        
        $rows = query("SELECT * FROM users WHERE confirmation = ?", $_POST["reset"]);
        
        if (count($rows) == 1)
        {
            $row = $rows[0];
            
            if ($_POST["reset"] == $row["confirmation"])
            {
            
                unset($_POST);
                
                render("reset_form.php", ["title" => "Reset Form"]);
            }
        }
        
        else
        {
            render("reset_fail.php", ["title" => "Reset Fail"]);
        }
    }
    
    else
    {
        render("reset_success.php", ["title" => "Reset Success"]);
    }
    
?>
