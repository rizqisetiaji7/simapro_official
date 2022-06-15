<?php
class Str_secure {
	private $encrypt_method;
	private $secret_key;
	private $secret_iv;
	private $key_hash;
    
	function __construct() {
		$this->encrypt_method = "AES-256-CBC";
		$this->secret_key = "Your secret key";
		$this->secret_iv = "Your secret iv";
		$this->key_hash = hash("sha256", $this->secret_key);
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