<?php
require_once __DIR__ . '/includes/pollinations/Pollinations.class.php';
require_once __DIR__ . '/includes/controllers/view.controller.php';
require_once __DIR__ . '/includes/controllers/user.controller.php';
require_once __DIR__ . '/includes/controllers/monster.controller.php';
require_once __DIR__ . '/includes/controllers/type.controller.php';
require_once __DIR__ . '/includes/controllers/user.controller.php';
require_once __DIR__ . '/includes/controllers/hybrid.controller.php';
require_once __DIR__ . '/includes/controllers/match.controller.php';
require_once __DIR__ . '/includes/controllers/api.controller.php';

$userController = new UserController();
$monsterController = new MonsterController();
$hybridController = new HybridController();
$typeController = new TypeController();
$matchController = new MatchController();

if (isset($_GET['action'])) {
  $url = explode('/', filter_var($_GET['action'], FILTER_SANITIZE_URL));
}

switch ($url[0] ?? 'home') {
  case'api':
    include __DIR__ . '/api/init.api.php';
    break;
  case 'register':
    //$userController->registerUser($_POST['pseudo'], $_POST['email'], $_POST['password']);
    $response = ApiController::requestApi('user/register', $_POST);

    if ($response['success']) {
      renderPage('login');
    } else {
      renderPage('register');
    }
    break;
  case 'showLogin':
    renderPage('login');
    break;
  case 'login':
    $userController->loginUser($_POST['pseudo'], $_POST['password']);
    $response = APIController::requestApi('user/login', $_POST);

//    if ($response['success']) {
//
//    } else {
//      // En cas d'échec de la connexion, afficher la page de login
//      renderPage('login');
//    }
    break;
  case 'showRegister':
    renderPage('register');
    break;
  case 'logout':
    //$userController->logoutUser();
    $response = APIController::requestApi('user/logout', $_POST);
    if($response['success']){
      renderPage('login');
    }
    break;
  case 'showCreatures': // Nouvelle action pour afficher les créatures

    break;
  case 'showAddCreature':
    renderPage('addCreature');
    break;
    case 'addCreature':
      //$monsterController->addCreature($_POST);
      $response = ApiController::requestApi('creature/add', $_POST);
      break;
  case 'showUserPage':
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    if (isset($_SESSION['user_id'])) {
      $creatures = $monsterController->getCreatures($_SESSION['user_id']);
      renderPage('user', ['creatures' => $creatures]);
    } else {
      renderPage('login');
    }
    break;
  case 'showAddHybrid':
    $creatures = $monsterController->getCreatures();
    $creature = $monsterController->getCreature($_GET['creature1']);
    renderPage('addHybrid', ['creatures' => $creatures, 'creature1' => $creature]);
    break;
  case 'addHybrid':
    $hybridController->addHybrid($_POST);
    break;
  case 'showBattle':
    if (isset($_SESSION['user_id'])) {
      $creatures = $monsterController->getCreatures();
      $creature = $monsterController->getCreatures($_SESSION['user_id']);
      renderPage('battle', ['creatures' => $creatures, 'creature1' => $creature]);
    } else {
      renderPage('login');
    }

    break;
  case 'battle':
    $matchController->addMatch($_POST);
    break;
  case 'showResult':
    break;
  case 'showCreatureInfo':
    $creature = $monsterController->getCreature($_GET['creature_id']);
    $type = $typeController->getType($creature['type_id']);
    renderPage('creatureInfo', ['creature' => $creature, 'type' => $type]);
    break;
  default:
    $creatures = $monsterController->getCreatures();
    renderPage('home', ['creatures' => $creatures]);
    break;
}
