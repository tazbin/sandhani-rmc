<?php
require "PHPMailer/PHPMailerAutoload.php";

function smtpmailer($to, $from, $from_name, $subject, $body)
    {
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;

        $mail->SMTPSecure = 'ssl';
        $mail->Host = '****';
        $mail->Port = 465;
        $mail->Username = '****';
        $mail->Password = '****';

        $mail->IsHTML(true);
        $mail->From="****";
        $mail->FromName=$from_name;
        $mail->Sender=$from;
        $mail->AddReplyTo($from, $from_name);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AddAddress($to);
        if(!$mail->Send())
        {
            // $error ="Please try Later, Error Occured while Processing...";
            $error = true;
            return $error;
        }
        else
        {
            // $error = "Thanks You !! Your email is sent.";
            $error = false;
                    ?>
                      <script>
                        window.location = "../reset-password";
                      </script>
                    <?php
                    exit();
            return $error;
        }
    }

?>
