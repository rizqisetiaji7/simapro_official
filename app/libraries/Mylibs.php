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

   private $encrypt_method;
   private $secret_key;
   private $secret_iv;
   private $key_hash;

   public function __construct() {
      $this->ci =& get_instance();

      // NanoID instance
      $this->client = new Client();

      // Create an instance; passing `true` enables exceptions
      $this->mail = new PHPMailer(true);

      $this->encrypt_method = "AES-256-CBC";
      $this->secret_key = "1029384756qwertyuioplkjhgfdsazxcvbnmQWERTYUIOPLKJHGFDSAZXCVBNM";
      $this->secret_iv = "1209385467zaqplwsxokmcdeijnrfvbhutgyASDFGLKJHQWERTPOIUYZXCVMNB";
      $this->key_hash = hash("sha256", $this->secret_key);
   }

   function _randomID($size=10) {
      return $this->client->formattedId($this->alphabet_format, $size);
   }

   function user_login() {
      $id = $this->ci->session->userdata('user_id');
      return $this->ci->bm->get_join('tb_users', '*', ['user_id' => $id])->row();
   }

   function _sendEmail($emailRecipient, $nameRecipient = '', $token = '', $dataBody = [] ,$smtpDebug = FALSE) {
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

   public function encryptid($str='') {
      $iv = substr(hash("sha256", $this->secret_iv), 0, 16);
      $output = openssl_encrypt($str, $this->encrypt_method, $this->key_hash, 0, $iv);
      return base64_encode($output);
   }
    
   public function decryptid($str='') {
      $iv = substr(hash("sha256", $this->secret_iv), 0, 16);
      $output = openssl_decrypt(base64_decode($str), $this->encrypt_method, $this->key_hash, 0, $iv);
      return $output;
   }
}