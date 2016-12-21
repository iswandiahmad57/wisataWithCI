<?php
class Gumcrypt {
	
	protected $CI;
	protected $cryptKey;

    public function __construct()
	{
		$this->CI =& get_instance();
        $this->cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
    }

    public function gumencrypt( $q ) {
        $qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $this->cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $this->cryptKey ) ) ) );
        return( str_replace("/", "GUMY", $qEncoded) );
    }

    public function gumdecrypt( $q ) {
        $qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $this->cryptKey ), base64_decode( str_replace("GUMY", "/", $q) ), MCRYPT_MODE_CBC, md5( md5( $this->cryptKey ) ) ), "\0");
        return( $qDecoded );
    }
}