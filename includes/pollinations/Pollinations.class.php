<?php

class Pollinations
{
    private static string $urlText = "https://text.pollinations.ai/";
    private static string $urlImage = "https://image.pollinations.ai/prompt/";

    private static string $json = "?json=true";

    public static function requestIA(string $prompt, bool $text = true)
    {
        $url = self::$urlImage;

        if ($text) {
            $encoded = rawurlencode($prompt . self::$json);
            $url = self::$urlText;
        }else{
            $encoded = rawurlencode($prompt);
        }

        $ch = curl_init();

        // Configurer l'URL et d'autres options
        curl_setopt($ch, CURLOPT_URL, $url . $encoded);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Pour retourner le résultat

        // Optionnel : définir un timeout
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        // Exécuter la requête
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            //error_log("Pollinations cURL error: " . curl_error($ch));
            curl_close($ch);
            return "Pollinations cURL error: " . curl_error($ch);
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // curl_close($ch);

        if ($httpCode >= 200 && $httpCode < 300) {
            if (!$text) {
                return $response;
            }
            return json_decode($response);

        } else {
            //error_log("Pollinations API responded with HTTP code $httpCode — response: " . $response);
            return "Pollinations API responded with HTTP code $httpCode — response: " . $response;
        }
    }
}