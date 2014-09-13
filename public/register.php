<?php

    // configuration
    require("../includes/config.php");

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // TODO
        if (empty($_POST["username"]))
        {
            apologize("You must provide a username.");
        }
        
        else if (empty($_POST["password"]))
        {
            apologize("You must provide a password.");
        }
        
        else if ($_POST["password"] != $_POST["confirmation"])
        {
            apologize("Your passwords do not match!");
        }
        
        else if ($_POST["email"] != $_POST["econfirm"])
        {
            apologize("Your e-mails do not match!");
        }
        
        //Use regex to validate correct e-mail syntax
        else if(preg_match("/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/", $_POST["email"]) == false)
        {
            apologize("Please enter a valid e-mail address.");
        }
        
        else
        {
            $check = query("INSERT INTO users (username, hash, cash, email) VALUES(?, ?, 10000.00, ?)", $_POST["username"], crypt($_POST["password"]), $_POST["email"]);
            
            if ($check === false)
            {
                apologize("Sorry that username is already taken.");
            }
            
            else
            {
                $rows = query("SELECT LAST_INSERT_ID() AS id");
                $id = $rows[0]["id"];
                
                $_SESSION["id"] = $id;
                
                redirect("/");
            }
        }
    }
    else
    {
        // else render form
        render("register_form.php", ["title" => "Register"]);
    }

?>
