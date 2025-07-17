<?php



class Token {
    private static function getSecret() {
        static $secret = null;
        if (!$secret) {
            $config = require realpath(__DIR__ . '/../config/config_secret.php');
            $secret = $config['secret_key'];
        }
        return $secret;
    }

    public static function create($data, $expireInSeconds = 3600 * 24 * 3) {
        $secret = self::getSecret();
        $payload = array_merge($data, [
            'exp' => time() + $expireInSeconds
        ]);

        $payloadJson = json_encode($payload);
        $payloadEncoded = base64_encode($payloadJson);

        $signature = hash_hmac('sha256', $payloadEncoded, self::getSecret());

        return $payloadEncoded . '.' . $signature;
    }

    public static function decode($token) {
        if (!$token || !str_contains($token, '.')) {
            return null;
        }

        list($payloadEncoded, $signature) = explode('.', $token, 2);

        $expectedSignature = hash_hmac('sha256', $payloadEncoded, self::getSecret());

        if (!hash_equals($expectedSignature, $signature)) {
            return null;
        }

        $payloadJson = base64_decode($payloadEncoded);
        $payload = json_decode($payloadJson, true);

        if (!$payload || time() > ($payload['exp'] ?? 0)) {
            return null;
        }

        return $payload;
    }
}
?>