<?php

/**
 * SBaseController class file.
 *
 * @author Spyros Soldatos <spyros@valor.gr>
 * @link http://code.google.com/p/srbac/
 */
/**
 * SBaseController must be extended by all of the applications controllers
 * if the auto srbac should be used.
 * You can import it in your main config file as<br />
 * 'import'=>array(<br />
 * 'application.modules.srbac.controllers.SBaseController',<br />
 * ),
 *
 *
 * @author Spyros Soldatos <spyros@valor.gr>
 * @package srbac.controllers
 * @since 1.0.2
 */
Yii::import("srbac.components.Helper");

class SBaseController extends CController {

  /**
   * Checks if srbac access is granted for the current user
   * @param String $action . The current action
   * @return boolean true if access is granted else false
   */
  protected function beforeAction($action) {

    if (!isset($_COOKIE['access_token'])) {
        $this->redirect(AUTH_API_URL . "/login?redirect_uri=" . SSO_CLIENT_CALLBACK);
    }

    $url = AUTH_API_URL .  "/api/check-token";

    $header = array(
      'Authorization: Bearer ' . $_COOKIE['access_token']
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $response = curl_exec($ch);

    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    $json = json_decode($response, true);

    if($statusCode == 200){
      $model = new LoginForm;
      $model->attributes = [
          'username' => $json['usuario'],
          'oauth' => true
      ];
      if(Yii::app()->user->isGuest){
        $model->login();
      }

      if(Yii::app()->user->id != $json['user_id']){
        Yii::app()->user->logout();
        $model->login();
      }
      // $this->redirect(Yii::app()->user->returnUrl);
    }else{
      Yii::app()->user->logout();
      // return false;
    }

    $del = Helper::findModule('srbac')->delimeter;

    //srbac access
    $mod = $this->module !== null ? $this->module->id . $del : "";

    $contrArr = explode("/", $this->id);
    $contrArr[sizeof($contrArr) - 1] = ucfirst($contrArr[sizeof($contrArr) - 1]);
    $controller = implode(".", $contrArr);

    $controller = str_replace("/", ".", $this->id);
    // Static pages
    if(sizeof($contrArr)==1){
      $controller = ucfirst($controller);
    }
    $access = $mod . $controller . ucfirst($this->action->id);

 //   if (Yii::getVersion() >= "1.1.7") {
//      if (count($this->actionParams) > 0) {
//        $keys = array_keys($this->actionParams);
//        foreach ($keys as $key) {
//          $query = $query . ',' . '$' . $key;
//        }
//
//        $query = substr_replace($query, '', 0, 1);
//        $access = $access . $query;
//      }
//    }
    //Always allow access if $access is in the allowedAccess array
    if (in_array($access, $this->allowedAccess())) {
      return true;
    }


    //Allow access if srbac is not installed yet
    if (!Yii::app()->getModule('srbac')->isInstalled()) {
      return true;
    }

    //Allow access when srbac is in debug mode
    if (Yii::app()->getModule('srbac')->debug) {
      return true;
    }

     // Check for srbac access
    if (!Yii::app()->user->checkAccess($access) || Yii::app()->user->isGuest) {
      $this->onUnauthorizedAccess();
    } else {
      return true;
    }
  }

  /**
   * The auth items that access is always  allowed. Configured in srbac module's
   * configuration
   * @return The always allowed auth items
   */
  protected function allowedAccess() {
    Yii::import("srbac.components.Helper");
    return Helper::findModule('srbac')->getAlwaysAllowed();
  }

  protected function onUnauthorizedAccess() {
    /**
     *  Check if the unautorizedacces is a result of the user no longer being logged in.
     *  If so, redirect the user to the login page and after login return the user to the page they tried to open.
     *  If not, show the unautorizedacces message.
     */
    if (Yii::app()->user->isGuest) {
      Yii::app()->user->loginRequired();
    } else {
      $mod = $this->module !== null ? $this->module->id : "";
      $access = $mod . ucfirst($this->id) . ucfirst($this->action->id);
      $error["code"] = "403";
      $error["title"] = Helper::translate('srbac', 'You are not authorized for this action');
      $error["message"] = Helper::translate('srbac', 'Error while trying to access') . ' ' . $mod . "/" . $this->id . "/" . $this->action->id . ".";
      //You may change the view for unauthorized access
      if (Yii::app()->request->isAjaxRequest) {
        $this->renderPartial(Yii::app()->getModule('srbac')->notAuthorizedView, array("error" => $error));
      } else {
        $this->render(Yii::app()->getModule('srbac')->notAuthorizedView, array("error" => $error));
      }
      return false;
    }
  }

}

