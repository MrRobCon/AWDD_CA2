<?php require_once '../config.php'; ?>
<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    $rules = [
        "email" => "present|email|minlength:7|maxlength:64",
        "message" => "present|minlength:8|maxlength:300",
        "name" => "present|minlength:4|maxlength:64"
    ];
    $request->validate($rules);

    if (!$request->is_valid()) {
        throw new Exception("Please complete the form correctly");
    }
    $email = $request->input("email");
    $message = $request->input("message");
    $name = $request->input("name");
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.mailtrap.io';                     // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = '11ae924bfff26e';                       // SMTP username
    $mail->Password   = 'a986c0361afc04';                       // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 2525;                                   // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom($email, $name);
    $mail->addAddress('info@bookworms.com', 'Information');           // Add a recipient


    // Content
    $mail->isHTML(true);                                        // Set email format to HTML
    $mail->Subject = 'Contact Form';
    $mail->Body    = $message;
    $mail->AltBody = $message;

    $mail->send();
    $request->session()->set("flash_message", "Your message has been successfully sent! A member of our team will reach out shortly!");
    $request->session()->set("flash_message_class", "alert-info");
    $request->session()->forget("flash_data");
    $request->session()->forget("flash_errors");

    $request->redirect("/views/contact.php");  
}
catch (Exception $ex) {
  $request->session()->set("flash_message", $ex->getMessage());
  $request->session()->set("flash_message_class", "alert-warning");
  $request->session()->set("flash_data", $request->all());
  $request->session()->set("flash_errors", $request->errors());

  $request->redirect("/views/auth/login-form.php");  
}
?>