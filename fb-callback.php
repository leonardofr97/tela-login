<?php 

require_once 'vendor/autoload.php';

if(!session_id()) {
    session_start();
}

$fb = new Facebook\Facebook([
    'app_id' => '{app-id}',
    'app_secret' => '{app-secret}',
    'default_graph_version' => 'v2.10'
]);

$helper = $fb->getRedirectLoginHelper();

// definindo o valor de state na session
$_SESSION['FBRLH_state'] = $_GET['state'];

// definindo o access token na session
$_SESSION['fb_access_token'] = (string) $accessToken;

try {
    $accessToken = $helper->getAccessToken();

} catch(Facebook\Exceptions\FacebookResponseException $e) {
    echo 'Ocorreu um erro no Graph: ' . $e->getMessage();
    exit;

} catch(Facebook\Exceptions\FacebookSDKException $e) {
    echo 'Ocorreu um erro no SDK: ' . $e->getMessage();
    exit;

}

if(!isset($accessToken)) {
    if($helper->getError()) {
        header('HTTP/1.0 401 Unauthorized');
        echo "Error: " . $helper->getError() . "\n";
        echo "Error Code: " . $helper->getErrorCode() . "\n";
        echo "Error Reason: " . $helper->getErrorReason() . "\n";
        echo "Error Description: " . $helper->getErrorDescription() . "\n";
    } else {
        header('HTTP/1.0 400 Bad Request');
        echo 'Bad Request';
    }
    exit;
}

// Dados do Access Token
echo '<h3>Access Token</h3>';
var_dump($accessToken->getValue());

try {
    $response = $fb->get('/me', $accessToken->getValue());

} catch(Facebook\Exceptions\FacebookResponseException $e) {
    echo 'Ocorreu um erro no Graph: ' . $e->getMessage();
    exit;

} catch(Facebook\Exceptions\FacebookSDKException $e) {
    echo 'Ocorreu um erro no SDK: ' . $e->getMessage();
    exit;

}

$me = $response->getGraphUser();
echo '<br/><br/> Logado como: ' . $me->getName();

?>
