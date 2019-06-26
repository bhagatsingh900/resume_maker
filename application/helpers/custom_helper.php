<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

		function is_logged_in() {
				$CI =& get_instance();	  
				$user = $CI->session->userdata('admin_user_id');
				 if (!isset($user)) { return false; } else { return true; }
			}
		
		    if ( ! function_exists('encryptIt'))
        {
        
               function encryptIt( $q ) {
                    $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
                    $qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
                    return( $qEncoded );
                }
        }
        
                
         if ( ! function_exists('decryptIt'))
        {
                function decryptIt( $q ) {
                        $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
                        $qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
                        return( $qDecoded );
                    }
        }
