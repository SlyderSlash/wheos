<?php

define('FILE_ENCRYPTION_BLOCKS', 10000);

/**
 * @param  $source  Path of the unencrypted file
 * @param  $dest  Path of the encrypted file to created
 * @param  $key  Encryption key
 */
function encryptFile($source, $dest, $key)
{
    $cipher = 'aes-256-cbc';
    $ivLenght = openssl_cipher_iv_length($cipher);
    $iv = openssl_random_pseudo_bytes($ivLenght);

    $fpSource = fopen($source, 'rb');
    $fpDest = fopen($dest, 'w');

    fwrite($fpDest, $iv);

    while (! feof($fpSource)) {
        $plaintext = fread($fpSource, $ivLenght * FILE_ENCRYPTION_BLOCKS);
        $ciphertext = openssl_encrypt($plaintext, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        $iv = substr($ciphertext, 0, $ivLenght);

        fwrite($fpDest, $ciphertext);
    }

    fclose($fpSource);
    fclose($fpDest);
}

/**
 * @param  $source  Path of the encrypted file
 * @param  $dest  Path of the decrypted file
 * @param  $key  Encryption key
 */
function decryptFile($source, $dest, $key)
{
    $cipher = 'aes-256-cbc';
    $ivLenght = openssl_cipher_iv_length($cipher);

    $fpSource = fopen($source, 'rb');
    $fpDest = fopen($dest, 'w');

    $iv = fread($fpSource, $ivLenght);

    while (! feof($fpSource)) {
        $ciphertext = fread($fpSource, $ivLenght * (FILE_ENCRYPTION_BLOCKS + 1));
        $plaintext = openssl_decrypt($ciphertext, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        $iv = substr($plaintext, 0, $ivLenght);

        fwrite($fpDest, $plaintext);
    }

    fclose($fpSource);
    fclose($fpDest);
}