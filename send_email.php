<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer et assainir les entrées utilisateur
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Vérifier les entrées utilisateur
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo 'Veuillez remplir tous les champs.';
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Adresse email invalide.';
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Paramètres du serveur
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'bergeryloic@gmail.com'; // Remplacez par votre adresse email
        $mail->Password = 'cidb hslh nuhl zzea'; // Remplacez par votre mot de passe d'application
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Destinataires
        $mail->setFrom('bergeryloic@gmail.com', 'Loïc Bergery'); // Remplacez par votre adresse email et nom
        $mail->addAddress('bergeryloic@gmail.com'); // Adresse de réception

        // Contenu de l'email
        $mail->isHTML(true);
        $mail->Subject = "PORTFOLIO: " . $subject;
        $mail->Body    = "
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; }
                    .container { padding: 20px; }
                    .header { background-color: #f7f7f7; padding: 10px; text-align: center; font-size: 18px; font-weight: bold; }
                    .content { margin-top: 20px; }
                    .footer { margin-top: 20px; padding-top: 10px; border-top: 1px solid #eaeaea; text-align: center; font-size: 12px; color: #777; }
                    .content p { margin: 10px 0; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>PORTFOLIO</div>
                    <div class='content'>
                        <p><strong>Nom:</strong> $name</p>
                        <p><strong>Email:</strong> $email</p>
                        <p><strong>Sujet:</strong> $subject</p>
                        <p><strong>Message:</strong><br>$message</p>
                    </div>
                    <div class='footer'>
                        Cet email a été envoyé depuis le formulaire de contact du portfolio.
                    </div>
                </div>
            </body>
            </html>
        ";

        $mail->send();
        echo 'Merci! Votre message a été envoyé.';
    } catch (Exception $e) {
        echo "Le message n'a pas pu être envoyé. Erreur Mailer: {$mail->ErrorInfo}";
    }
} else {
    echo "Méthode de requête non supportée.";
}
?>
