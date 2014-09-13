<?php
    
    require("../includes/config.php");
    
    require_once("PHPMailer/class.phpmailer.php");
    
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (empty($_POST["email"]))
        {
            apologize("Please enter an e-mail address.");
        }
        
        else if(preg_match("/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/", $_POST["email"]) == false)
        {
            apologize("Please enter a valid e-mail address.");
        }
        
        $rows = query("SELECT * FROM users WHERE email = ?", $_POST["email"]);
        
        if (count($rows) == 1)
        {
            $row = $rows[0];
            
            $confirmation = substr(md5(uniqid(rand(), true)), 8, 8); //8 character long confirmation code
            
            query("UPDATE users SET confirmation = ? WHERE id = ?", $confirmation, $row['id']);
            
            if ($_POST["email"] == $row["email"])
            {
                $mail = new PHPMailer(true); 
                $body             = 'Hello, ' . $row['username'] . "! \n\n Your confirmation code: " . $confirmation .'';
                
                $mail->IsSMTP();                // tell the class to use SMTP
                $mail->SMTPAuth   = true;                  // enable SMTP authentication
                $mail->Port       = 587;                    // set the SMTP server port
                $mail->SMTPSecure = 'tls'; 
                $mail->Host = 'smtp.gmail.com';
                $mail->Username   = "pset7jharvard@gmail.com";     // SMTP server username
                $mail->Password   = "jharvard123";            // SMTP server password
                
                $mail->AddReplyTo("system@dvts.com","ADMIN");
                $mail->From       = "system@dvts.com";
                $mail->FromName   = "CS50 Finance";
                $mail->AddAddress($_POST["email"]);
                $mail->Subject  = "Password Reset";
                $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
                $mail->WordWrap   = 80; // set word wrap
                $mail->MsgHTML($body);
                $mail->IsHTML(true); // send as HTML
                if ($mail->Send() === false)
                    die($mail->ErrorInfo . "\n");
                
                // set a confirmation session
                $_SESSION["confirmation"] = $confirmation;
                
                render("reset_success.php", ["title" => "Success"]);
            }
        }
    }
    
    else
    {
        render("password_reset_form.php", ["title" => "Password Reset"]);
    }
   
?>
