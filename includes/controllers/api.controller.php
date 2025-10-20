<?php

class ApiController
{
  private static $url = "http://bestiarium/api/";

  public static function requestApi (string $route, array $datas = [], $post = true)
  {

    $ch = curl_init();

    // Configurer l'URL et d'autres options
    curl_setopt($ch, CURLOPT_URL, self::$url . $route);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Pour retourner le résultat
    curl_setopt($ch, CURLOPT_POST, $post);

    // Optionnel : définir un timeout
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    if (!empty($datas)) {
      $json = json_encode($datas);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
      // Ensure the Content-Type header is set so the API can parse JSON input
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($json)));
    }

    // Exécuter la requête
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
      curl_close($ch);

      return "cURL error: " . curl_error($ch);
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($httpCode >= 200 && $httpCode < 300) {
      return json_decode($response, true);

    }

    return "API responded with HTTP code $httpCode — response: " . $response;
  }
}