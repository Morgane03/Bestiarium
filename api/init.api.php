<?php
require_once 'C:\wamp64\www\MyDigitalSchool\Bestiarium\api\controllers\api.user.controller.php';
require_once 'C:\wamp64\www\MyDigitalSchool\Bestiarium\api\controllers\api.monster.controller.php';
require_once 'C:\wamp64\www\MyDigitalSchool\Bestiarium\api\controllers\api.match.controller.php';
require_once 'C:\wamp64\www\MyDigitalSchool\Bestiarium\api\controllers\api.hybrid.controller.php';

$method = $_SERVER['REQUEST_METHOD'];
$userController = new APIUserController();
$monsterController = new ApiMonsterController();
$matchController = new ApiMatchController();
$hybridController = new ApiHybridController();

if (!empty($_GET['action'])) {
  // Nettoie et découpe l'action en segments
  $url = explode('/', filter_var($_GET['action'], FILTER_SANITIZE_URL));
  switch ($url[0]) {
    case 'user':
      switch ($url[1]) {
        case 'register':
          if ($method == 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);

            if (!$input || !isset($input['pseudo'], $input['password'], $input['email'])) {
              http_response_code(400);
              echo json_encode(['error' => 'Champs manquants : pseudo, email, password']);
              exit;
            }
            $pseudo = htmlspecialchars($input['pseudo']);
            $email = filter_var($input['email'], FILTER_VALIDATE_EMAIL);

            $response = $userController->addUser($pseudo, $email, $input['password']);
            echo json_encode($response);
          } else {
            echo json_encode(['error' => 'Vous devez utiliser la methode POST']);
          }
          break;
        case 'login':
          if ($method === 'POST') {
            // Récupère les données JSON envoyées dans le corps de la requête
            $input = json_decode(file_get_contents('php://input'), true);

            // Vérifie que les champs nécessaires sont bien fournis
            if (!$input || !isset($input['pseudo']) || !isset($input['password'])) {
              http_response_code(400);
              echo json_encode(['error' => 'Champs manquants : pseudo, mot de passe ou mot de passe incorrect']);
              exit;
            }

            $response = $userController->loginUser($input['pseudo'], $input['password']);
            echo json_encode($response);
          }
          break;
        case 'logout':
          if ($method === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);

            $response = $userController->logoutUser();
            echo json_encode($response);
          } else {
            echo json_encode(['error' => 'Vous devez utiliser la méthode POST']);
          }
      }
      break;
    case 'creature':
      switch ($url[1]) {
        case 'add':
          if ($method === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);

            $response = $monsterController->addCreature(['heads' => $input['heads'], 'type' => $input['type'],
                                                         'user_id' => $input['user_id']]);
            echo json_encode($response);
          } else {
            echo json_encode(['error' => 'Vous devez utiliser la methode POST']);
          }
          break;
        case 'createHybrid':
          if ($method === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);

            $response = $hybridController->addHybrid(['creature1' => $input['creature1_id'],
                                                      'creature2' => $input['creature2_id'],
                                                      'user_id' => $input['user_id']]);
            echo json_encode($response);
          }else{
            echo json_encode(['error' => 'Vous devez utiliser la methode POST']);
          }
          break;
        case 'showinfo':
          if($method === 'GET'){
            $input = json_decode(file_get_contents('php://input'), true);

            $response = $monsterController->getCreature($input['creature_id']);
            echo json_encode($response);
          }else{
            echo json_encode(['error' => 'Vous devez utiliser la methode GET']);
          }
          break;
        case'showAllMyMonsters':
          if($method === 'GET'){
            $input = json_decode(file_get_contents('php://input'), true);

            $response = $monsterController->getCreatures($input['user_id']);
            echo json_encode($response);
          }else{
            echo json_encode(['error' => 'Vous devez utiliser la methode GET']);
          }
          break;
      }
      break;
    case 'battle':
      switch ($url[1]) {
        case 'add':
          if ($method === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);

            if (!$input || !isset($input['creature1'], $input['creature2'])) {
              http_response_code(400);
              echo json_encode(['error' => 'Champs manquants : creature1, creature2']);
              exit;
            }

            $response = $matchController->addMatch([
                'creature1' => ['id'=> $input['creature1']['id']],
                'creature2' => ['id'=> $input['creature2']['id']]]
            );

            echo json_encode($response);
          } else {
            echo json_encode(['error' => 'Méthode HTTP incorrecte. Utilisez POST.']);
          }
          break;
        case 'results':
          if($method === 'GET'){
            $input = json_decode(file_get_contents('php://input'), true);

            $response = $matchController->showAllMatches();
            echo json_encode($response);
          }else {
            echo json_encode(['error' => 'Méthode HTTP incorrecte. Utilisez GET.']);
          }
          break;
      }
      break;
  }
}