<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after core.php
 *
 * This file should load/create any application wide configuration settings, such as
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
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
 * @package       app.Config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

// Setup a 'default' cache configuration for use in the application.
Cache::config('default', array('engine' => 'File'));

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 *
 * App::build(array(
 *     'Model'                     => array('/path/to/models/', '/next/path/to/models/'),
 *     'Model/Behavior'            => array('/path/to/behaviors/', '/next/path/to/behaviors/'),
 *     'Model/Datasource'          => array('/path/to/datasources/', '/next/path/to/datasources/'),
 *     'Model/Datasource/Database' => array('/path/to/databases/', '/next/path/to/database/'),
 *     'Model/Datasource/Session'  => array('/path/to/sessions/', '/next/path/to/sessions/'),
 *     'Controller'                => array('/path/to/controllers/', '/next/path/to/controllers/'),
 *     'Controller/Component'      => array('/path/to/components/', '/next/path/to/components/'),
 *     'Controller/Component/Auth' => array('/path/to/auths/', '/next/path/to/auths/'),
 *     'Controller/Component/Acl'  => array('/path/to/acls/', '/next/path/to/acls/'),
 *     'View'                      => array('/path/to/views/', '/next/path/to/views/'),
 *     'View/Helper'               => array('/path/to/helpers/', '/next/path/to/helpers/'),
 *     'Console'                   => array('/path/to/consoles/', '/next/path/to/consoles/'),
 *     'Console/Command'           => array('/path/to/commands/', '/next/path/to/commands/'),
 *     'Console/Command/Task'      => array('/path/to/tasks/', '/next/path/to/tasks/'),
 *     'Lib'                       => array('/path/to/libs/', '/next/path/to/libs/'),
 *     'Locale'                    => array('/path/to/locales/', '/next/path/to/locales/'),
 *     'Vendor'                    => array('/path/to/vendors/', '/next/path/to/vendors/'),
 *     'Plugin'                    => array('/path/to/plugins/', '/next/path/to/plugins/'),
 * ));
 *
 */

/**
 * Custom Inflector rules can be set to correctly pluralize or singularize table, model, controller names or whatever other
 * string is passed to the inflection functions
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */

/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. Make sure you read the documentation on CakePlugin to use more
 * advanced ways of loading plugins
 *
 * CakePlugin::loadAll(); // Loads all plugins at once
 * CakePlugin::load('DebugKit'); //Loads a single plugin named DebugKit
 *
 */

/**
 * To prefer app translation over plugin translation, you can set
 *
 * Configure::write('I18n.preferApp', true);
 */

/**
 * You can attach event listeners to the request lifecycle as Dispatcher Filter. By default CakePHP bundles two filters:
 *
 * - AssetDispatcher filter will serve your asset files (css, images, js, etc) from your themes and plugins
 * - CacheDispatcher filter will read the Cache.check configure variable and try to serve cached content generated from controllers
 *
 * Feel free to remove or add filters as you see fit for your application. A few examples:
 *
 * Configure::write('Dispatcher.filters', array(
 *		'MyCacheFilter', //  will use MyCacheFilter class from the Routing/Filter package in your app.
 *		'MyCacheFilter' => array('prefix' => 'my_cache_'), //  will use MyCacheFilter class from the Routing/Filter package in your app with settings array.
 *		'MyPlugin.MyFilter', // will use MyFilter class from the Routing/Filter package in MyPlugin plugin.
 *		array('callable' => $aFunction, 'on' => 'before', 'priority' => 9), // A valid PHP callback type to be called on beforeDispatch
 *		array('callable' => $anotherMethod, 'on' => 'after'), // A valid PHP callback type to be called on afterDispatch
 *
 * ));
 */
Configure::write('Dispatcher.filters', array(
	'AssetDispatcher',
	'CacheDispatcher'
));

/**
 * Configures default file logging options
 */
App::uses('CakeLog', 'Log');
CakeLog::config('debug', array(
	'engine' => 'File',
	'types' => array('notice', 'info', 'debug'),
	'file' => 'debug',
));
CakeLog::config('error', array(
	'engine' => 'File',
	'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
	'file' => 'error',
));

/**
 * Global User-Defined Functions
 */
function html($str, $strip_tags = true){
  return htmlentities($strip_tags? strip_tags($str) : $str, ENT_COMPAT | ENT_SUBSTITUTE, 'UTF-8');
}

function no_spaces($str) {
  return str_replace($str, " ","");
}

function get_html($url){
  ini_set('max_execution_time', 300);
  $c = curl_init($url);
  $options = array(
    CURLOPT_AUTOREFERER => true,
    CURLOPT_CONNECTTIMEOUT => 120,
    CURLOPT_COOKIE => "key=val",
    CURLOPT_ENCODING =>  "",
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_FRESH_CONNECT => true,
    CURLOPT_HEADER => true,
    //CURLOPT_HTTPHEADER => array('Content-type: text/plain'), //used to set header fields
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_REFERER => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_TIMEOUT => 120,
    CURLOPT_USERAGENT => $_SERVER['HTTP_USER_AGENT']
  );
  curl_setopt_array($c, $options);
  $html = curl_exec($c);
  if (curl_error($c))
    return "";
  curl_close($c);
  return $html;
}

// Find first regex match in html source code
function get_first_match($html, $regex){
  if(preg_match($regex, $html, $regs)){
    if(isset($regs[2]))
      return $regs; // multiple capture groups
    else
      return $regs[1];
  }
  return false;
}

// Used to find ALL occurrences, not just the first one
function get_all_matches($html, $regex){
  preg_match_all($regex, $html, $result, PREG_PATTERN_ORDER);
  $matches = array();
  
  for ($i = 0; $i < count($result[0]); $i++) {
    $match = array();
    for ($j = 1; $j < count($result); $j++) {
      $match[$j] = $result[$j][$i];
    } 
    $matches[] = $match;
  }
  
  return $matches;
}

function get_phone($html, $arr) {
  $result = [];
  $patterns = [
    '/([2-9]\d{2}-\d{3}-\d{4})/', // 222-222-2222
    '/([2-9]\d{2}\.\d{3}\.\d{4})/', // 222.222.2222
    '/(\(\d{3}\) \d{3}[ -\.]\d{4})/', //(222) 222-2222
    '/^(1?(-?\d{3})-?)?(\d{3})(-?\d{4})$/', // 7, 10, or 11 digits with or without hyphens
    '/(\+[\d]*[ \d()]*[()\d]* [\d]*[- ][0-9][0-9][0-9][0-9])/' // +44(0)371 423 2020
  ];
  
    foreach($patterns as $wal) {
      $res = get_all_matches($html, $wal);
      foreach($res as $val) {
        if (strlen($val[1]) > 6 &&
          (strpos($val[1],".")!==false || strpos($val[1],"-")!==false || strpos($val[1],")")!==false || strpos($val[1],"(")!==false) &&
          substr_count($val[1],".") != 1) {
          if (!in_array($val[1], $result)) {
            array_push($result, $val[1]);
          }
        }
      }
  }
  return array_unique(array_merge($arr, $result));
}

function get_google_info($data) {
  if ($data == "") {
    return $data;
  }
  $address = trim(get_first_match($data['google_info'], "/Address: ([\s\S]*)\n/Ui"));
  $phone = trim(get_first_match($data['google_info'], "/Phone: ([\s\S]*)\n/Ui"));
  return array ('address'=>$address, 'phone'=>$phone);
}

function get_address($html, $arr) {
  
  $html = str_replace('<br/>','',
      str_replace('<br>','',
      str_replace('<br />','',$html)));
  $html = trim(preg_replace('/\s\s+/', ' ', $html));
  
  //debug($html);
  
  $result = [];
  $patterns = [
    '/<address>([\s\S]*)<\/address>/Ui'
  ];
  
  foreach($patterns as $wal) {
    $res = get_all_matches($html, $wal);
    foreach($res as $val) {
      if (strlen($val[1]) > 10 && !in_array($val[1], $result)) {
        
        //debug($html);
        
        //debug($wal);
        //debug($result);
        
        if (strpos($val[1], 'example') === false) {
          array_push($result, str_replace(PHP_EOL, '', str_replace('<br/>', ' ', trim($val[1]))));
        }
      }
    }
  }
  return array_unique(array_merge($arr, $result));
}

function get_email($html, $arr) {
  $result = [];
  $patterns = [
    //'/(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))/',
    //'/\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}/', // Simple pattern
    '/[\'"]mailto:([\s\S]*)[^\s\"\'><]+/U', //href mailto: ...
    '/([A-Za-z\d]+@[A-Za-z\d]+\.[^\s\"\'><]+)/', //My pattern: X @ X . X
    '/([A-Za-z\d]+@[A-Za-z\d]+\.[A-Za-z\d]+\.[^\s\"\'><]+)/' //My secondary pattern: X @ X . X . X
    //'/([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)/', //email address spec naming guidelines
  ];
  
  foreach($patterns as $wal) {
    $res = get_all_matches($html, $wal);
    foreach($res as $val) {
      if (strlen($val[1]) > 3 && strpos($val[1],"@") !== false && !in_array($val[1], $result)) {
        if (strpos($val[1], 'example') === false && strpos($val[1], 'domain') === false &&
            strpos($val[1], '.png') === false && strpos($val[1], '.jpg') === false && strpos($val[1], '.jpeg') === false) {
          array_push($result, trim(strtolower($val[1])));
        }
      }
    }
  }
  return array_unique(array_merge($arr, $result));
}

function get_tags($html, $arr = []) {
  
  /*
   * 
   * SHOES
   * 
    
  //original list
  $tag_list = ["ankle strap","ballerina","ballet","basketball","beach","bike","biker","boat shoe","bowling",
        "cleat","climbing","clog","comfort","cowboy","cycling","diabetes","dress","espadrilles","exercise",
        "flip flop","golf shoes","gym","jelly","lightweight","loafer","luxury","maritime","mary jane",
        "medical","men","moccasin","oxford","rainboot","rain boot","running","sandal","skate","slingback","slipon","slipper","sneaker",
        "sport","stick on","stick-on","swim","tap shoe","toe shoe","trainer","wader","women","yoga"];
        
  //from wikipedia:
  $tag_list = array_unique(array_merge($tag_list,["ballet","bast","blucher","boat","brogan","brogue","brothel creeper",
    "bucks","cantabrian albarcas","chelsea","chopine","climbing","clog","court","cross country","derby","diabetic","dori",
    "dress","driving moccasin","earth","elevator","espadrille","fashion","five fingers","five-fingers","fivefingers","galesh",
    "giveh","high heel","high-heel","huarache","jazz","jelly","jumpsoles","jutti","kampung","kitten heel","kolhapuri chappal",
    "kung fu","loafer","lotus","mary jane","moccasin","mojari","monk","mule","opanak","opinga","organ","orthopaedic","orthopedic",
    "over the knee","over-the-knee","oxford","pampootie","peranakan beaded slipper","peshawari chappal","platform","pointe","pointed",
    "pointinini","rocker bottom","saddle","sandal","slip on","slip-on","slipon","snow","spectator","steel toe",
    "steel-toe","t-bar","tbar","tiger head","tiger-head","toe shoe","tsarouhi","turnshoe","venetian","winklepicker","worishofer",
    "wörishofer"]));
   * 
   */
   
   $tag_list = [];
    
  //add sports
  //google types of shoes

  //foreach($wlist as $k=>$v) {
    //$wlist[$k] = trim(strtolower($v));
  //}
    
  //sort($wlist);

  //$str = strtolower('["' . implode('","',array_unique($tag_list)) . '"]');

  $result = [];
  foreach($tag_list as $val) {
    if (get_first_match($html, "/(".strtolower($val).')/i') !== false) {
      array_push($result, $val);
    }
  }
  return array_unique(array_merge($arr, $result));
}

function get_contact_links($html, $url) {
  $result = [];
  $patterns = [
    '/href="([\S]*)">[^>]*[cC][oO][nN][tT][aA][cC][tT]/U', //Contact
    '/href="([\S]*)">[^>]*[aA][bB][oO][uU][tT]/U', //About
    '/href="([\S]*)">[^>]*[fF][aA][qQ]/U', //FAQ
    '/href="([\S]*)">[^>]*[oO][rR][dD][eE][rR]/U', //Orders
    '/href="([\S]*)">[^>]*[dD][eE][lL][iI][vV][eE][rR]/U', //Deliveries
    '/href="([\S]*)">[^>]*[rR][eE][tT][uU][rR][Nn]/U', //Returns
  ];

  foreach($patterns as $wal) {
    foreach(get_all_matches($html, $wal) as $val) {
      if (strpos($val[1],".css") === false && strpos($val[1],"twitter") === false && strpos($val[1],"instagram") === false && strpos($val[1],"facebook") === false) {
        if (!in_array($val[1], $result) && count($result) < 10) {
          array_push($result, (strpos($val[1], "www") === false && strpos($val[1], "http") === false) ? "www." . $url . $val[1] : $val[1]);
        }
      }
    }
  }
  if ($tmp = get_first_match($html, '/href="([\S]*)">[^>]*[Mm][Ee][Nn]/U')) { //Men + Women (hopefully shopping links)
    //array_push($result, $tmp);
  }
  
  return array_unique($result);
}

function get_description($html) {
  foreach (get_all_matches($html, '/<meta([\s\S]*)>/U') as $val) {
    if (strtolower(get_first_match($val[1], '/name=[\'"]([\s\S]*)[\'"]/U')) == 'description') {
      return get_first_match($val[1], '/content=[\'"]([\s\S]*)[\'"]/U');
    }
  }
  return "";
}

if(defined('FULL_BASE_URL') && substr(FULL_BASE_URL,0,5) == 'https') // load balancer hack
  $_SERVER['HTTPS'] = 'on';

$is_ssl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'])? true : false;



