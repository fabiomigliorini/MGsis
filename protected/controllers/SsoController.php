<?php
session_start();
class SsoController extends Controller
{
       
     public function actionSso()
     {
      //$this->render('/site/sso');
      $query = http_build_query([
         "client_id" => SSO_CLIENT_ID,
         "redirect_uri" => SSO_CLIENT_CALLBACK,
         "response_type" => "code",
         "scope" => SSO_SCOPES,
         "state" => 'Hjcnaj1231ccjKA1AKC901CAZP1',
         "prompt" => true
     ]);
     $this->redirect(SSO_HOST .  "/oauth/authorize?" . $query);
     }
     
     
    
    public function actionCallback()
    {
     
     $url = SSO_HOST .  "/oauth/token" ;
     $post =array(
     "grant_type"=>"authorization_code", 
     "client_id"=>SSO_CLIENT_ID , 
     "client_secret" => SSO_CLIENT_SECRET ,
     "redirect_uri" => SSO_CLIENT_CALLBACK ,
     "code" => $_GET['code']
     );
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, $url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch, CURLOPT_VERBOSE, 1);
     curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
     $response = curl_exec($ch);
     curl_close($ch);
     $json = json_decode($response, true);   
     $_SESSION['access_token'] = $json['access_token'];
   
   
     $this->actionConnect();
     }
     

     public function actionConnect()
     {
      $urlc = SSO_HOST . "/api/v1/auth/user";
      $access_token = $_SESSION['access_token'];
      $crl = curl_init();
      curl_setopt($crl, CURLOPT_URL, $urlc);
      $headr = array();
      $headr[] = 'Accept: application/json';
      $headr[] = 'Authorization: Bearer '.$access_token;
      curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($crl, CURLOPT_HTTPHEADER,$headr);
      $rest = curl_exec($crl);
      //$info = curl_getinfo($crl);
      //$error = curl_error($crl);
      curl_close($crl);
      $json = json_decode($rest, true);
      $model=new LoginForm;
      $model->attributes=['username' => $json['usuario'], 'password' => $json['senha']];
      $model->login();  
      $this->redirect(Yii::app()->user->returnUrl);
     }
     
}
     
?>
     