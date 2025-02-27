<?php
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate form inputs
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $office_details = htmlspecialchars($_POST['office_details']);
    $address = htmlspecialchars($_POST['address']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);
    $newsletter = isset($_POST['newsletter']) ? 'Yes' : 'No';

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email address. Please try again.";
    } elseif (empty($name) || empty($email) || empty($message)) {
        $error_message = "Please fill out all required fields.";
    } else {
        // Define recipient email (change this to your email)
        $to = "your-email@example.com";

        // Set email subject
        $email_subject = "New Contact Form Submission: $subject";

        // Create email body
        $email_body = "
        Name: $name\n
        Email: $email\n
        Office Details: $office_details\n
        Address: $address\n
        Subject: $subject\n
        Message:\n$message\n
        Newsletter Subscription: $newsletter
        ";

        // Set email headers
        $headers = "From: no-reply@yourdomain.com\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // Send the email
        if (mail($to, $email_subject, $email_body, $headers)) {
            $success_message = "Thank you, $name! Your message has been sent successfully.";
        } else {
            $error_message = "Sorry, something went wrong. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <style>
        .form-container {
            width: 60%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .form-container h1 {
            text-align: center;
            color: #F4C430;
        }

        .form-container .row {
            display: flex;
            justify-content: space-between;
        }

        .form-group {
            margin-bottom: 10px;
            width: 48%;
        }

        input[type="text"], input[type="email"], textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            background-color: #F4C430;
            border: none;
            padding: 10px 20px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }

        button:hover {
            background-color: #ffcc00;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
        }

        .checkbox-group label {
            margin-left: 5px;
            font-size: 14px;
            color: #808080;
        }

        .message {
            text-align: center;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h1>Contact Us</h1>
        <p>Enable communication and engagement.</p>

        <?php
        // Display success or error message
        if (isset($success_message)) {
            echo "<div class='message success'>$success_message</div>";
        } elseif (isset($error_message)) {
            echo "<div class='message error'>$error_message</div>";
        }
        ?>

        <form action="contact.php" method="POST">
            <div class="row">
                <div class="form-group">
                    <input type="text" name="name" placeholder="Name" value="<?= isset($name) ? $name : '' ?>" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email" value="<?= isset($email) ? $email : '' ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <input type="text" name="office_details" placeholder="Office Details" value="<?= isset($office_details) ? $office_details : '' ?>">
                </div>
                <div class="form-group">
                    <input type="text" name="address" placeholder="Address of HQ and hubs" value="<?= isset($address) ? $address : '' ?>">
                </div>
            </div>
            <div class="form-group">
                <input type="text" name="subject" placeholder="Subject" value="<?= isset($subject) ? $subject : '' ?>">
            </div>
            <div class="form-group">
                <textarea name="message" placeholder="Message" required><?= isset($message) ? $message : '' ?></textarea>
            </div>
            <div class="checkbox-group">
                <input type="checkbox" name="newsletter" id="newsletter" <?= isset($_POST['newsletter']) ? 'checked' : '' ?>>
                <label for="newsletter">Newsletter Subscription</label>
            </div>
            <button type="submit">Send ➤</button>
        </form>
    </div>

</body>
</html>
