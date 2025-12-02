<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = htmlspecialchars($_POST["supportName"]);
    $email = htmlspecialchars($_POST["supportEmail"]);
    $message = htmlspecialchars($_POST["supportMessage"]);

    // Where the message will be sent (YOUR EMAIL)
    $to = "support@teslamanmr@gnail.com"; // <-- CHANGE TO YOUR EMAIL
    $subject = "New Support Message from Tickify";

    $body = "You have a new support message:\n\n";
    $body .= "Name: $name\n";
    $body .= "Email: $email\n";
    $body .= "Message:\n$message\n";

    $headers = "From: $email";

    if (mail($to, $subject, $body, $headers)) {
        echo "<h2 style='text-align:center;'>Message Sent Successfully!</h2>";
    } else {
        echo "<h2 style='text-align:center; color:red;'>Failed to Send Message.</h2>";
    }
}
?>
