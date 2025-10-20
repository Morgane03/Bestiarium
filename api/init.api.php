<?php
require_once 'C:\wamp64\www\MyDigitalSchool\Bestiarium\api\controllers\api.user.controller.php';
require_once 'C:\wamp64\www\MyDigitalSchool\Bestiarium\api\controllers\api.monster.controller.php';

$method = $_SERVER['REQUEST_METHOD'];
$userController = new APIUserController();
$monsterController = new ApiMonsterController();

if (!empty($_GET['action'])) {
  // Nettoie et découpe l'action en segments
  $url = explode('/', filter_var($_GET['action'], FILTER_SANITIZE_URL));

  switch ($url[0]) {
    case 'user':
      switch ($url[1]) {
        case 'register':
          if($method == 'POST'){
            $input = json_decode(file_get_contents('php://input'), true);

            if(!$input || !isset($input['pseudo'], $input['password'],$input['email'])){
              http_response_code(400);
              echo json_encode(['error' => 'Champs manquants : pseudo, email, password']);
              exit;
            }
              $pseudo = htmlspecialchars($input['pseudo']);
              $email = filter_var($input['email'], FILTER_VALIDATE_EMAIL);

              $response = $userController->addUser($pseudo, $email, $input['password']);
              echo json_encode($response);
          }
          else{
            echo json_encode(['error' => 'Vous devez utiliser la methode POST']);
          }
          break;
          case 'login':
            if ($method === 'POST') {
              // Récupère les données JSON envoyées dans le corps de la requête
              $input = json_decode(file_get_contents('php://input'), true);

              // Vérifie que les champs nécessaires sont bien fournis
              if(!$input || !isset($input['pseudo']) || !isset($input['password'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Champs manquants : pseudo, mot de passe ou mot de passe incorrect']);
                exit;
              }


            }
            break;
            case 'logout':
              if($method === 'POST') {

              }
              break;
      }
      break;
    case 'creature':
      switch ($url[1]) {
        case 'add':
          if($method == 'POST'){
            $input = json_decode(file_get_contents('php://input'), true);

            if(!$input || !isset($input['heads'], $input['type'])){
              http_response_code(400);
              echo json_encode(['error' => 'Champs manquants : Nombre de têtes, type']);
              exit;
            }
            $heads = htmlspecialchars($input['heads']);
            $type = filter_var($input['type'], FILTER_VALIDATE_EMAIL);

            $response = $monsterController->addCreature(['heads' => $input['heads'],'type'=>$input['type']]);
            echo json_encode($response);
          }
          else{
            echo json_encode(['error' => 'Vous devez utiliser la methode POST']);
          }
          break;
      }
      break;

  }
}