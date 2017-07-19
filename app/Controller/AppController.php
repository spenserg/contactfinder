<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
  // Auto Loader for Models
  public function &__get($name) {
    if(!isset($this->modelsList))
      $this->modelsList = array_flip(App::objects('model'));
  
    if(isset($this->modelsList[$name])){
      try {
        $this->loadModel($name);
        return $this->$name;
      } catch(Exception $e) { }
    }
  
    // Model not found. Let's see if our parent knows what we're trying to access
    $ret = parent::__get($name);
    return $ret; // must return a variable containing false/null, not false itself
  }
}
