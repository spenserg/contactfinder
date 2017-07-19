<?php
/**
 * Website Model
 * 
 * app/Model/Website.php
 */

class Website extends AppModel {
  
  function make_new($str) {
    $this->create();
    $this->set(array('name'=>$str));
    $this->save();
  }
  
  function get_all($start = 2, $end = 564) {
    $arr = [];
    $x = $this->find('all', array('conditions' => array('id >=' => 2, 'id <=' => 3873))); //3873
    
    //debug($x);
    
    foreach($x as $val) {
      $tags = explode("|",str_replace(',','|',str_replace(', ','|',$val['Website']['tags'])));
        array_push($arr, array(
          'name' => $val['Website']['name'],
          'email' => $val['Website']['email'],
          'phoneNumber' => $val['Website']['phoneNumber'],
          'desc' => $val['Website']['desc'],
          'tags' => $tags,
          'category' => $val['Website']['category'],
          'flagged' => ($val['Website']['is_selling'] == 0 || $val['Website']['is_selling'] == -1) ? "Y" : "N"
        ));
    }
    
    //debug($arr);
    
    return json_encode($arr);
  }
  
}