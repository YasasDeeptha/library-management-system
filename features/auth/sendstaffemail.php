<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';

function sendStaffEmail($email, $username, $password){

    $mail = new PHPMailer(true);

    try {

       

        $mail->isSMTP();

        $mail->Host = 'smtp.gmail.com';

        $mail->SMTPAuth = true;

        $mail->Username = 'thanujasm61@gmail.com';

        $mail->Password = 'tiqxtdhqrexpcfah';

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        $mail->Port = 587;


        $mail->setFrom(
            'yourgmail@gmail.com',
            'Library Management System'
        );

        $mail->addAddress($email);

        $mail->isHTML(true);

        $mail->Subject = 'Your LMS Staff Account';

        $loginLink =
        'http://localhost/library-management-system/index.php';

        $mail->Body = "

            <h2>Library Management System</h2>

            <p>
                Your staff account has been created successfully.
            </p>

            <p>

                <strong>Username:</strong>
                {$username}

            </p>

            <p>

                <strong>Password:</strong>
                {$password}

            </p>

            <p>

                <a href='{$loginLink}'>
                    Click here to login
                </a>

            </p>

        ";

        $mail->send();

        return true;

    } catch (Exception $e) {

        return false;

    }

}
?>