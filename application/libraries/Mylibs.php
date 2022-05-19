<?php defined('BASEPATH') OR exit('No direct script access allowed');

// NanoID
use Hidehalo\Nanoid\Client;

// PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mylibs {
   protected $alphabet_format = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
   protected $client;
   protected $ci;
   protected $mail;

   public function __construct() {
      $this->ci =& get_instance();

      // NanoID instance
      $this->client = new Client();

      // Create an instance; passing `true` enables exceptions
      $this->mail = new PHPMailer(true);
   }

   function _randomID($size=10) {
      return $this->client->formattedId($this->alphabet_format, $size);
   }

   function user_login() {
      $id = $this->ci->session->userdata('user_id');
      return $this->ci->bm->get_join('tb_users', '*', ['user_id' => $id])->row();
   }

   function _sendEmail($emailRecipient, $nameRecipient = '', $token, $dataBody = [] ,$smtpDebug = FALSE) {
      $response = [];

      // Send Email Verification Link
      try {
         //Server settings
         if ($smtpDebug != FALSE) {
            $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;           // Enable verbose debug output
         }

         $this->mail->isSMTP();                                   // Send using SMTP
         $this->mail->Host       = SMTP_HOST;                     // Set the SMTP server to send through
         $this->mail->SMTPAuth   = true;                          // Enable SMTP authentication
         $this->mail->Username   = EMAIL;                         // SMTP username
         $this->mail->Password   = EMAIL_PASS;                    // SMTP password
         $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;   // Enable implicit TLS encryption
         $this->mail->Port       = SMTP_PORT;                     // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

         //Recipients
         $this->mail->setFrom(EMAIL, COMPANY);
         $this->mail->addAddress($emailRecipient, $nameRecipient);  // Add a recipient
         $this->mail->addReplyTo(EMAIL, COMPANY);

         //Content
         $this->mail->isHTML(true);                         // Set email format to HTML
         $this->mail->Subject = $dataBody['email_subject'];
         $this->mail->Body    = $dataBody['email_body'];
         $this->mail->send();
         $response['status'] = TRUE;
      } catch (Exception $e) {
         $response['status']      = FALSE;
         $response['error_info']  = $this->mail->ErrorInfo;
      }

      return $response;
   }
}