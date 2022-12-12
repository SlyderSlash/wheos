<?php

namespace App\Service;

use DateTimeImmutable;

class JWTService
{
    // on génère le token

    public function generate(array $header, array $payload, string $secret, int $validity = 10800): string
    {
        if ($validity > 0) {
            $now = new DateTimeImmutable();
            $exp = $now->getTimestamp() + $validity;

            $payload['iat'] = $now->getTimestamp();
            $payload['exp'] = $exp;

        }

        
        // on encode en base64
        $base64Header = base64_encode(json_encode($header));
        $base64Payload = base64_encode(json_encode($payload));

        // on nettoie les valeurs encodéés (retrait des +, / et =)
        $base64Header = str_replace(['+', '/', '='], ['-', '_', ''], $base64Header);
        $base64Payload = str_replace(['+', '/', '='], ['-', '_', ''], $base64Payload);

        // générer la signature
        $secret = base64_encode($secret);

        $signature = hash_hmac('sha256', $base64Header . '.' . $base64Payload, $secret, true);

        $base64Signature = base64_encode($signature);

        $base64Signature = str_replace(['+', '/', '='], ['-', '_', ''], $base64Signature);

        // on crée le token
        $jwt = $base64Header . '.' . $base64Payload . '.' . $base64Signature;

        return $jwt;
    }

    //on vérifie que le token est valide (correctement formé)
    public function isValid(string $token): bool
    {
        return preg_match(
            '/^[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+$/',
            $token
        ) === 1;
    }

    // on récupère le Payload
    public function getPayload(string $token): array
    {
        // on démonte le token
        $array = explode('.', $token);

        // on décode le payload
        $payload = json_decode(base64_decode($array[1]), true);

        return $payload;
    }

    // on récupère le Header
    public function getHeader(string $token): array
    {
        // on démonte le token
        $array = explode('.', $token);

        // on décode le header
        $header = json_decode(base64_decode($array[0]), true);

        return $header;
    }

    // on vérifie si le token a expirer
    public function isExpired(string $token): bool
    {
        $payload = $this->getPayload($token);

        $now = new DateTimeImmutable();

        return $payload['exp'] < $now->getTimestamp();
    }

    // on vérifie la signature du token
    public function check(string $token, string $secret)
    {
        // on récupère le header et le payload
        $header = $this->getHeader($token);
        $payload = $this->getPayload($token);

        // on régénère un token
        $verifToken = $this->generate($header, $payload, $secret, 0);

        return $token === $verifToken;

    }
}