<?php
/**
 * Main Controller
 *
 * app/Controller/MainController.php
 */

class MainController extends AppController {
  
  function view_json($start_id = 2, $end_id = 2) {
    for ($x = $start_id; $x <= $end_id; $x++) {
      $site = $this->Website->find('first',array('conditions'=>array('id'=>$x)));
      if ($site) {
        $url = $site['Website']['name'];
        $html = get_html('www.'.$url);
      
        $desc = ($site['Website']['desc'] == "") ? trim(get_description($html)) : $site['Website']['desc'];
        $phone = ($site['Website']['phoneNumber'] == "") ? get_phone($html, []) : explode(", ",$site['Website']['phoneNumber']);
        $email = ($site['Website']['email'] == "") ? get_email($html, []) : explode(", ",$site['Website']['email']);
        $tags = ($site['Website']['tags'] == "") ? get_tags($html, []) : explode(", ",$site['Website']['tags']);
        $address = ($site['Website']['address'] == "") ? get_address($html, []) : explode("|",$site['Website']['address']);
        $is_selling = $site['Website']['is_selling'] == null ? (get_first_match($html, '/(\$\d)/') !== false) : $site['Website']['is_selling'];

        $contact_links = get_contact_links($html, $url);
        foreach($contact_links as $xal) {

          $tst_html = get_html($xal);
          $phone = array_unique(array_merge($phone, get_phone($tst_html, $phone)));
          $email = array_unique(array_merge($email, get_email($tst_html, $email)));
          $tags = array_unique(array_merge($tags, get_tags($tst_html, $tags)));
          $address = array_unique(array_merge($address, get_address($tst_html, $address)));
          $is_selling = $site['Website']['is_selling'] == null ? (get_first_match($html, '/(\$\d)/') !== false) : $site['Website']['is_selling'];
        }
        
        $s_email = implode(", ",$email);
        $s_email = ($s_email == "") ? null : $s_email;
        $s_phone = implode(", ",$phone);
        $s_phone = ($s_phone == "") ? null : $s_phone;
        $s_tags = implode(", ",$tags);
        $s_tags = ($s_tags == "") ? null : $s_tags;
        $s_address = implode(" | ",$address);
        $s_address = ($s_address == "") ? null : str_replace(PHP_EOL, '', $s_address);
      
        $this->Website->read(null, $x);
        $this->Website->set(array(
          'email' => $s_email,
          'phoneNumber' => $s_phone,
          'desc' => $desc,
          'tags' => $s_tags,
          'category' => 'shoes',
          'address' => $s_address,
          'is_selling' => $is_selling
        ));
        $this->Website->save();
      }
    }
     
    $this->set('next_start_id', $start_id + 10);
    
    $this->set('str',"TESTING");
  }

  function gsearch($tmp_id = 2) {
    if ($this->request->is('post')) {
      $g_info = get_google_info($_POST);
      $cur = $this->Website->find('first',array('conditions'=>array('id'=>$tmp_id)));
      
      $address = (!$g_info['address'] || $g_info['address'] == "") ? $cur['Website']['address'] : $g_info['address'];
      $phone = $cur['Website']['phoneNumber'] . ", " . $g_info['phone'];
      
      $this->Website->read(null, $tmp_id);
      $this->Website->set(array(
        'address' => str_replace(PHP_EOL, '', $address),
        'phoneNumber' => $phone
      ));
      $this->Website->save();
      
      $tmp_id++;
    }
    
    $str = "";
    foreach($this->Website->find('all') as $oal) {
      $str .= 'http://www.' . $oal['Website']['name'] . '<br/>https://www.'.$oal['Website']['name'] . '<br/>';
    }
    $this->set('str',$str);
        
    $site = $this->Website->find('first', array('conditions'=> array('id >='=>$tmp_id,'OR'=>array('phoneNumber'=>null, 'address'=>""))));
    if (!$site) {
      $site = $this->Website->find('first', array('conditions' => array('id'=>2)));
    }
    $url = $site['Website']['name'];
    $this->set('web_id', $site['Website']['id']);
    $this->set('url',$url);
  }

  function index() {
    $tmp_id = 563;
    $html_override = "";
    if ($this->request->is('post')) {
      $this->Website->read(null, $_POST['id_hidden']);
      $this->Website->set(array(
        'address' => str_replace(PHP_EOL, '', $_POST['address']),
        'phoneNumber' => $_POST['phone'],
        'desc' => $_POST['description'],
        'category' => 'shoes',
        'tags' => $_POST['tags']
      ));
      $this->Website->save();
      
      if ($_POST['id_reload'] != "") {
        $tmp_id = intval($_POST['id_reload']);
        $html_override = $_POST['manual_html'];
      } else {
        $tmp_id = intval($_POST['id_hidden']);
        $tmp_id++;
        
      }
    }

    $site = $this->Website->find('first',array('conditions'=>array('id'=>$tmp_id)));
    if (!$site) {
      $site = $this->Website->find('first',array('conditions'=>array('id'=>2)));
    }
    $url = $site['Website']['name'];
    $this->set('web_id', $site['Website']['id']);
    
    $html = ($html_override == "") ? get_html('www.'.$url) : $html_override;
    $is_selling = (get_first_match($html, '/(\$\d)/') !== false);
      
    $this->set('desc', ($site['Website']['desc'] == "") ? trim(get_description($html)) : $site['Website']['desc']);
    
    $phone = ($site['Website']['phoneNumber'] == "") ? get_phone($html, []) : explode(", ",$site['Website']['phoneNumber']);
    $email = ($site['Website']['email'] == "") ? get_email($html, []) : explode(", ",$site['Website']['email']);
    $tags = ($site['Website']['tags'] == "") ? get_tags($html, []) : explode(", ",$site['Website']['tags']);
    $address = ($site['Website']['address'] == "") ? get_address($html, []) : explode("|",$site['Website']['address']);
    
    $contact_links = get_contact_links($html, $url);

    foreach($contact_links as $xal) {
      $tst_html = get_html($xal);
      
      $phone = array_unique(array_merge($phone, get_phone($tst_html, $phone)));
      $email = array_unique(array_merge($email, get_email($tst_html, $email)));
      $tags = array_unique(array_merge($tags, get_tags($tst_html, $tags)));
      $address = array_unique(array_merge($address, get_address($tst_html, $address)));
      $is_selling = $is_selling || (get_first_match($html, '/(\$\d)/') !== false);

    }
    
    $this->Website->read(null, $site['Website']['id']);
    $this->Website->set(array('is_selling',$is_selling));
    $this->Website->save();
    
    
    $this->set('tags', implode(", ",$tags));
    $this->set('contact_info', ['phone'=>$phone,'address'=>$address,'email'=>$email,'links'=>$contact_links]);
      
    $this->set('html',$html);
    $this->set('url',$url);
  }

  function quiz() {}
  
  function stormer() {}
  
}