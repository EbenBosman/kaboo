<?php
    require 'vendor/autoload.php';

    $errors = [];
    $data = [];

    if (empty($_POST['message'])) {
        $errors['message'] = 'Message is required.';
    }

    if (empty($_POST['email'])) {
        $errors['email'] = 'Email is required.';
    }
    else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $nameErr = "Must be a valid Email Address.";
    }

    if (empty($_POST['name'])) {
        $errors['name'] = 'Name is required.';
    }

    if (!empty($_POST['cellNumber']) && !is_numeric($_POST['cellNumber'])) {
        $errors['cellNumber'] = 'Cellphone number must be a valid number.';
    }

    if (!empty($errors)) {
        $data['success'] = false;
        $data['reason'] = 'Validation';
        $data['errors'] = $errors;
    } else {
        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom("no-reply@kaboo.com", 'Kaboo Foundation');

        $subject = 'Message from ' . getenv('WEB_ADDRESS');

        $email->setSubject($subject);
        $email->addTo(getenv('KABOO_CONTACT_EMAIL'), getenv('WEB_ADDRESS'));

        $messagePlainRaw = isset($_POST['message']) ? $_POST['message'] : null;
        $email->addContent("text/plain", $messagePlainRaw);

        $senderName = isset($_POST['name']) ? $_POST['name'] : null;
        $senderEmail = isset($_POST['email']) ? $_POST['email'] : null;
        $senderCell = isset($_POST['cellNumber']) ? $_POST['cellNumber'] : null;
        $messagePlainHTML = 'You have a new message from <strong>' . $senderName . '</strong><br><br>Email Address: <strong>' . $senderEmail . '</strong><br><br>Cellphone Number: <strong>' . $senderCell . '</strong><br><br>Original Message: <br><br>' . nl2br($messagePlainRaw);
        $email->addContent("text/html", $messagePlainHTML);

        $sendgrid = new \SendGrid(getenv('SENDGRID_KEY'));

        try {        
            $response = $sendgrid->send($email);        
            $data['success'] = true;
        } catch (Exception $e) {
            $data['success'] = false;
            $data['reason'] = 'Sendgrid Failure';
            $errors['name'] = $e->getMessage();
        }
    }

    echo json_encode($data);
?>