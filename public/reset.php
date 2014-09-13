<?php

    require("../includes/config.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (empty($_POST["username"]))
        {
            apologize("Please enter your username.");
        }
        
        $rows = query("SELECT * FROM users WHERE username = ?", $_POST["username"]);

        // if we found user, check if username is valid
        if (count($rows) == 1)
        {
            // first (and only) row
            $row = $rows[0];

            // compare username with username in database
            if ($_SESSION["confirmation"] == $row["confirmation"])
            {
                // temporarily log user in to acquire user id for updating
                $_SESSION["id"] = $row["id"];
        
                if (empty($_POST["newpassword"]))
                {
                    apologize("You must provide a password.");
                }
        
                else if ($_POST["newpassword"] != $_POST["confirm"])
                {
                    apologize("Your passwords do not match!");
                }
                
                query("UPDATE users SET hash = ? WHERE id = ?", crypt($_POST["newpassword"]), $_SESSION["id"]);
                
                // reset confirmation code
                query("UPDATE users SET confirmation = '' WHERE id = ?", $_SESSION["id"]);
                
                // end the session
                logout();

                render("password_success.php", ["title" => "Success"]);
            }
            
            else
            {
                apologize("Invalid username!");
            }
        }
        
        else
        {
            apologize("Invalid username!");
        }
    }
    else
    {
        // else render form
        render("reset_form.php", ["title" => "Reset Password"]);
    }

?>
