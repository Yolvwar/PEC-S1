<?php

namespace App\Entities;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '.../../../vendor/autoload.php';
require_once __DIR__ . '/../Helpers/session_helper.php';


class Mail
{
  public static function sendMail($to, $subject, $body)
  {
    $mail = new PHPMailer(true);

    try {
      // Paramètres du serveur
      $mail->SMTPDebug = 0;
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'pec.project.2025@gmail.com';
      $mail->Password = 'hgumtzxsnoxchffd';
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port = 587;

      // Activer le débogage
      $mail->SMTPDebug = 2; // 0 = off (for production use), 1 = client messages, 2 = client and server messages
      $mail->Debugoutput = 'html'; // Afficher les messages de débogage en HTML

      // Destinataires
      $mail->setFrom('pec.project.2025@gmail.com', '{ProjectName}');
      $mail->addAddress($to, 'User');

      // Contenu
      $mail->isHTML(true);
      $mail->Subject = $subject;
      $mail->Body    = $body;
      $mail->AltBody = strip_tags($body);


      // Bypasser la vérification de certificat SSL
      $mail->SMTPOptions = array(
        'ssl' => array(
          'verify_peer' => false,
          'verify_peer_name' => false,
          'allow_self_signed' => true
        )
      );

      $mail->send();
      flash("register", "Un email de validation a été envoyé à votre adresse email.");
      return true;
    } catch (Exception $e) {
      flash("register", "Erreur lors de l'envoi de l'email de validation. Veuillez réessayer.");
      return false;
    }
  }

  public static function sendServiceRequestAcceptedMail($user, $serviceRequest)
  {
    $to = $user->email;
    $subject = "Demande de service acceptée";
    $body = "Bonjour " . $user->name . ",<br><br>
    Votre demande de réparation avec l'id " . $serviceRequest->id . " a bien été acceptée.<br>
    Un technicien va très prochainement vous contactez.<br><br>";
    return self::sendMail($to, $subject, $body);
  }
}
