<?php

namespace App\Service;

define('FILE_ENCRYPTION_BLOCKS', 10000);
class CryptingFileService
{
    /**
     * @description Encrypt the file set in parameter and send it to the dest
     * @param $source   |   Path of the UNENCRYPTED FILE
     * @param $dest     |   Path of the ENCRYPTED FILE to CREATED
     * @param $key      |   Encryption KEY
     * @return NULL    |   No return in this method, service runner
     */
    public function encryptFile($source, $dest, $key) // METHOD to ENCRYPT FILES when UPLOADED
    {
        $cipher = 'aes-256-cbc';
        $ivLenght = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivLenght);
        $fpSource = fopen($source, 'r');
        $plaintext = fread($fpSource,filesize($source));
        fclose($fpSource);
        unlink($source);
        $fpDest = fopen($dest, 'w');
        fwrite($fpDest, $iv);
        $ciphertext = openssl_encrypt($plaintext, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        $iv = substr($ciphertext, 0, $ivLenght);
        fwrite($fpDest, $ciphertext);
        fclose($fpDest);
    }

    /**
     * @param $source   |   Path of the ENCRYPTED FILE
     * @param $dest     |   Path of the UNENCRYPTED FILE to CREATED
     * @param $key      |   Encryption KEY
     */
    public function decryptFile($source, $dest, $key) // METHOD to DECRYPT FILES when UPLOADED
    {
        $cipher = 'aes-256-cbc';
        $ivLenght = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivLenght);
        
        $fpSource = fopen($source, 'r');
        $plaintext = fread($fpSource,filesize($source));
        $fpDest = fopen($dest, 'w');
        
        $plaintext = openssl_decrypt($plaintext, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        $plaintext = substr($plaintext, $ivLenght);

        fwrite($fpDest, $plaintext);
        fclose($fpSource);
        fclose($fpDest);
    }
}