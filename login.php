<?php 

require_once 'vendor/autoload.php'; // autoload do composer

$fb = new Facebook\Facebook([
    // aqui vai os dados na config. do app criado no facebook
    'app_id' => '{app-id}',
    'app_secret' => '{app-secret}',
    'default_graph_version' => 'v2.10'
]);

$helper = $fb->getRedirectLoginHelper();

// permissões opcionais
$permissions = ['email'];

// url de retorno onde iremos ter a validação do login. O domínio deverá ser configurado no próprio app
$loginUrl = $helper->getLoginUrl('https://localhost/fb-callback.php', $permissions);

echo '<a href="' . $loginUrl . '">Login com o seu Facebook</a>';

?>
