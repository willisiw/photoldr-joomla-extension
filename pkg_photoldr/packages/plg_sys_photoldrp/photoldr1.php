<?php
// no direct access
defined('_JEXEC')  or die( 'Restricted access' );

 
class plgSystemphotoldr1 extends JPlugin
{
     
  function onAfterInitialise() {  
           
          // Getting the site url
	  $pageurl = JRequest::getURI(); 
          
          // Code to put meta tag in header of file
          $obj      = new JConfig;
          
          $dbprefix = $obj->dbprefix;
          
          $result_value['fqdn'] = NULL;
          $query  = "SELECT *  FROM ".$dbprefix."photo"; 
             
          $result = mysql_query($query);
          $document =& JFactory::getDocument();
           
          while($result_value =  mysql_fetch_array($result)){ 
              if($result_value['unpublish_content']=="yes"){
                   $document->addCustomTag( '<meta name="apple-itunes-app" content="app-id=555194288,app-argument=photoldr://'.$result_value['fqdn'].'" /> ' );
              }
          }
          
          
          
          // redirect to the our function to genrate xml
          if(strchr($pageurl, 'photoldrstructure.xml')) {
            
            // Catch the dispatcher 
            $dispatcher =& JDispatcher::getInstance();
           
            $results = $dispatcher->trigger( 'generateXML', '' );            
            
          }
          
          if(strchr($pageurl, 'photoldrpost.php')) { 
              
             // Catch the dispatcher 
            $dispatcher =& JDispatcher::getInstance();
           
            $results = $dispatcher->trigger( 'photoldr_postdata', '' );
            
          }
             
	 }
     
    
     
     function generateXML() {   
         
         $data = ''; 
            
         // Take the data from  get or post 
         if (isset($_POST['username'])) {

            $data = $_POST;

          }

          elseif (isset($_GET['username'])) {

            $data = $_GET;

          }          
         
             
          $url = JURI::root();

            // remove the http from the url

            $output = preg_replace("/^(http:\/\/)/", "", $url); 

            $fqdn = rtrim($output,"/");

             // creation of object of Jconfig
             $obj      = new JConfig;
             $database = $obj->db;
             $db_host  = $obj->host;    
             $db_login = $obj->user;
             $db_pass  = $obj->password;
             $dbprefix = $obj->dbprefix;

             // Connectivity with database 
             $db       = mysql_connect("$db_host","$db_login","$db_pass");       

             // Selection of database
             mysql_select_db($database,$db);

             // if not connect then return error  
             if (!$db)
              {
              die('Could not connect: ' . mysql_error());
              }



             $dispatcher =& JDispatcher::getInstance();

             // Getting the uid with username and password
             $getuid = $dispatcher->trigger( 'photoldr_user_auth', "" );

             $uid    = $getuid[0];      

              // Count all the user of the database   
             $query1  = "SELECT count(id) as countr FROM ".$dbprefix."users";  
             $result1 = mysql_query($query1);

             while($result_value =  mysql_fetch_array($result1)){     
                 $coutuser = $result_value['countr'];
             }



             $publishcoutnodes = $unpublishcoutnodes = null;

             // Count all the publish articles of the database   
             $queryq  = "SELECT COUNT(*) as countr FROM ".$dbprefix."content where state = 1";  
             $resultq = mysql_query($queryq);
             while($result_valueq =  mysql_fetch_array($resultq)){     
                 $publishcoutnodes = $result_valueq['countr'];
             }

             // Count all the unpublish articles of the database   
             $queryw  = "SELECT COUNT(*) as countr FROM ".$dbprefix."content where state = 0";  
             $resultw = mysql_query($queryw);
             while($result_valuew     =  mysql_fetch_array($resultw)){     
                 $unpublishcoutnodes = $result_valuew['countr'];
             }         


             // total no of nodes
             $nodes = array('FQDN','site_name','published','cms','standalone','date','exp_date','exp_url','post_url');

             $queryt  = "SELECT * FROM ".$dbprefix."photo";         
             $resultt = mysql_query($queryt);

             $pub               = array();
              /*$pub['FQDN']       = $fqdn;*/

             $chekpublish = "yes";
         
              // Get all the value of the field ;
              while($result_value =  mysql_fetch_array($resultt)){ 
                 
                   $pub['FQDN']       = $result_value['fqdn']; 
                   $pub['site_name']  = $result_value['site_name'];
                   $exp_date_string   = $result_value['expiry'];                                    
                   $exp_date          = date('Y-m-d',strtotime("$exp_date_string"));                 
                   
                   //$exp_date          = date('Y-m-d',strtotime($result_value['expiry']."+3 year"));
                   $pub['published']  = "1";

                   $pub['cms']        = "joomla";

                   $pub['standalone'] = "1";

                   $pub['date']       = date("Y-m-d H:i");

                   $pub['exp_date']   = date("Y-m-d", strtotime($exp_date));

                   $pub['exp_url']    = $result_value['fqdn'];

                   $pub['post_url']   = "http://" . $pub['FQDN'] . "/index.php/?q=photoldrpost.php";
                   
                   $nodeitem_max      = $result_value['photoldr_item_max_article'];
                   
                   $nodeorderby       = $result_value['photoldr_item_orderby_article'];
                   
                   $nodeitem_order    = $result_value['photoldr_item_order_article'];
                   
                   $chekpublish       = $result_value['unpublish_content'];
                   
                 } 
                 

                  // <app_options> exposes site specific options for user settings   Node Types

                  // in the iOS app.

                  $pub['app_options'][1] = "app:Username:username:textfield:";

                  $pub['app_options'][2] = "app:Password:password:password:";

                  $pub['app_options'][3] = "app:Publish:status:checkbox:";




                  header('Content-type: text/xml');

                  echo '<?xml version="1.0" encoding="UTF-8"?>'."\n";

                  echo "<domains src='photoldr_node_structure_page'>\n";

                  echo "<domain>\n";



                  // start loop

                  for($k=0;$k<count($nodes);$k++) {

                    echo "<$nodes[$k]>";

                    echo $pub[$nodes[$k]];

                    echo "</$nodes[$k]>";

                  }


                  // start app_options loop

                  echo"<app_options>\n";

                  for($l=1;$l<=count($pub['app_options']);$l++) {

                    echo "<option>";

                    echo $pub['app_options'][$l];

                    echo "</option>";

                  }

                  echo"</app_options>";

                  $type = 'article';

                    // start form_items loop

                echo"<form_items>\n";


                   // check if user have permission of edit or delete of articles
                $useredit = $dispatcher->trigger( 'check_role', "$uid,$type");          


                 if($useredit[0]) {

                       echo "<option>";echo $type.':Hidden:posturl:'.$pub['post_url'];echo "</option>\n";

                  }

                  echo "<option>";echo $type.':'.'Title'.':'.'title'.':'.'textfield'.':'.'#required';echo "</option>";

                  echo "<option>";echo $type.':'.'Body'.':'.'body'.':'.'textarea';echo "</option>";

                  echo "<option>";echo $type.':'.'Image'.':'.'field_image'.':'.'image'.':'.'#2';echo "</option>";


                  echo "<option>";echo $type.':'.'Replace Photos'.':'.'image_overwrite'.':'.'checkbox';echo "</option>";          


                  echo"</form_items>";



                  echo"<node_types>\n";

                  echo "<option>";

                  echo $type .":table" ;

                  echo "</option>";

                  echo"</node_types>";





                  // User start user count loop.

                  echo"<users count='$coutuser'>\n";

                  // Select users from database 

                  $query      = "SELECT * FROM ".$dbprefix."users";

                  $resultuser = mysql_query($query);

                  // Treverse through while loop 
                  while($result_value =  mysql_fetch_array($resultuser)){ 

                   echo"<user>\n";

                      echo "<uid>";

                      echo $result_value['id']; 

                      echo "</uid>";

                      echo "<name>";

                      echo $result_value['username'];

                      echo "</name>";

                      echo "<mail>";

                      echo $result_value['email'];

                      echo "</mail>";

                      echo "<created>";

                      echo $result_value['registerDate'];

                      echo "</created>";

                      echo "<status>";

                      echo 0;

                      echo "</status>";

                  echo"</user>\n";

                    }

                  echo"</users>";


                  // For the publish nodes
                 echo"<nodes  count='$publishcoutnodes'>\n";  


                 $query  = "SELECT * FROM ".$dbprefix."content where state = 1 order by $nodeorderby $nodeitem_order  limit $nodeitem_max";  

                 $result = mysql_query($query);
                 while($result_value =  mysql_fetch_array($result)){
                     
                 
                 $is_userid = $result_value['created_by'];
                 
                  echo"<node>\n";

                    $useredit = $dispatcher->trigger( 'check_role', "$uid,$type");

                    if($useredit[0]) {

                    echo "<userdelete>";

                    echo "1";

                    echo "</userdelete>";


                    echo "<useredit>";

                    echo "1";

                    echo "</useredit>";

                    }            


                    echo "<uid>";

                    echo $is_userid;

                    echo "</uid>";
                    
                    
                    echo "<nurl>";
                    
                    echo htmlspecialchars($url."index.php/".$result_value['id']."-".$result_value['alias']);

                    echo "</nurl>";
                    

                    echo "<title>";

                    echo htmlspecialchars($result_value['title']);

                    echo "</title>";


                   echo "<status>";

                   echo '1';

                   echo "</status>";


                   echo "<nid>";

                   echo $result_value['id'];

                   echo "</nid>";         



                   echo "<type>";

                   echo 'article';

                   echo "</type>";



                   echo "<created>";

                   echo $result_value['created'];

                   echo "</created>";



                   echo "<changed>";

                   echo $result_value['modified'];

                   echo "</changed>";



                  echo "<body>";

                  echo htmlspecialchars($result_value['introtext']);

                  echo "</body>";

                 $query_select  = "SELECT username FROM ".$dbprefix."users where id = $is_userid";  

                 $result_selects = mysql_query($query_select);
                 
                 while($result_value_select =  mysql_fetch_array($result_selects)){
                     
                 
                  echo "<name>";

                  echo $result_value_select['username'];

                  echo "</name>";
                  
                 }


                echo "</node>\n";

                   }


                 echo"</nodes>\n";

                 
             // Display unpublish nodes in XML.
                 
             if($chekpublish == "yes")
             {              

              echo"<unpublished_nodes count='$unpublishcoutnodes'>\n";

              $query  = "SELECT * FROM ".$dbprefix."content where state = 0 order by $nodeorderby $nodeitem_order  limit $nodeitem_max";  

                 $result = mysql_query($query);

                 while($result_value =  mysql_fetch_array($result)){

                   echo"<node>\n";

                    $useredit = $dispatcher->trigger( 'check_role', "$uid,$type");           


                    if($useredit[0]) {

                    echo "<userdelete>";

                    echo "1";

                    echo "</userdelete>";


                    echo "<useredit>";

                    echo "1";

                    echo "</useredit>";

                    }

                    echo "<uid>";

                    echo $result_value['created_by'];

                    echo "</uid>";


                    echo "<title>";

                    echo htmlspecialchars($result_value['title']);

                    echo "</title>";


                    echo "<status>";

                    echo '0';

                    echo "</status>";


                    echo "<nid>";

                    echo $result_value['id'];

                    echo "</nid>";           



                    echo "<type>";

                    echo 'article';

                    echo "</type>";



                    echo "<created>";

                    echo $result_value['created'];

                    echo "</created>";



                    echo "<changed>";

                    echo $result_value['modified'];

                    echo "</changed>";



                    echo "<body>";

                    echo htmlspecialchars($result_value['introtext']);

                    echo "</body>";


                    echo "<name>";

                    echo $data['username'];

                    echo "</name>";



                    echo "</node>\n";
                 }

                    echo"</unpublished_nodes>";
             }

                    echo '</domain>';

                    echo '</domains>';

                    exit;  

     
     
     }
     
     
     
     // Function for user aunthication
     function photoldr_user_auth() {
         
          $data = '';
          
          $uid = FALSE;
          
          // Get the data come from get or post method
          if (isset($_POST['username'])) {

            $data = $_POST;

          }

          elseif (isset($_GET['username'])) {

            $data = $_GET;

          }

          else

          {

               $user = & JFactory::getUser();
               $uid   = $user->id;

          }         
         
          
               
              
          // Authenticate the user.

          if (isset($data['username']) && isset($data['password'])) {

            $usern = $data['username'];

            $passw = $data['password'];
            
            jimport( 'joomla.user.authentication');
            
            $auth = &JAuthentication::getInstance();
            
             $credentials = array( 'username' => $usern, 'password' => $passw );
             
             $options     = array();
             
             $response    = $auth->authenticate($credentials, $options);
             
             // Check the response of the username and password
             
             if(!$response->error_message)
             {
                // Creating the object of database 
                $db     = JFactory::getDbo();
		$query	= $db->getQuery(true);

		$query->select('*');
		$query->from('#__users');
		$query->where('username=' . $db->Quote($credentials['username']));
                $db->setQuery($query);
		$result = $db->loadObject();           
                
                // Get the uid of aunthticate user 
                $uid    = $result->id;  
                 
             }
             else
             {
                 $uid = false;
             }

          }
          
          else {

           // No DATA moved from Post or Get.

          }
         
          //Return UID.

          return $uid;

        }
        
        // To check user have permission of create and delete of articles
        function check_role($uid){  
            
            
            $usercreate = FALSE;
            
            // get the uid of user 
            $array = explode(",",$uid);           
            $uid  = $array[0];
            $type = $array[1];            
            
            
            if($uid) {
                
            // Selection user group  from userid   
            $db     = JFactory::getDbo();            
            $query  = $db->getQuery(true);

	     $query->select('*');
	     $query->from('#__user_usergroup_map');
	     $query->where('user_id=' . $uid);
             $db->setQuery($query);
	     $result = $db->loadObject();           
                
             $group_id    = $result->group_id;  
             
             // Selection of role of the user from group id
             
             $query->select('title');
	     $query->from('#__usergroups');
	     $query->where('id=' . $group_id);
             $db->setQuery($query);
	     $result = $db->loadObject();
             
             $roles  = $result->title; 
             
              //access of the page

              $access = 'edit_' . $type.'s';



              // switch according to role with the access

              switch ($roles) {

                case 'Manager':

                  $usercreate = TRUE;

                  break;

                case 'Administrator':
                    
                      $usercreate = TRUE;
                  
                  break;

                case 'Super Users':

                       $usercreate = TRUE;

                   break;

              }
              
            }
            
            
              return $usercreate;
            

          }
          
          
            // After post data is save from this function 

            function photoldr_postdata(){       

                // creation of  database object 

                $obj      = new JConfig;
                $database = $obj->db;
                $db_host  = $obj->host;    
                $db_login = $obj->user;
                $db_pass  = $obj->password;
                $dbprefix = $obj->dbprefix;
                $db       = mysql_connect("$db_host","$db_login","$db_pass"); 

                // Selection of database
                mysql_select_db($database,$db);

               // Decide on Get or Post  Post preffered.
                $data = '';
                      if (isset($_POST['username'])) {

                        $data = $_POST;

                      }

                      elseif (isset($_GET['username'])) {

                        $data = $_GET;

                      }

                      else {

                        return;

                      }

                    // If data is not blank than return
                    if($data!=''){
                      $default_type = 'article';

                      $ntype        = isset($data['type']) ? $data['type'] : $default_type;


                      // get the uid

                      $dispatcher  =& JDispatcher::getInstance();
                      $getuid      = $dispatcher->trigger( 'photoldr_user_auth', '' );

                      $uid    = $getuid[0];



                      if ($uid == FALSE) {

                        return;

                      }

                  else {

                      $usercreate = $dispatcher->trigger( 'check_role', "$uid,$ntype");


                    if (!($usercreate[0])) {

                          echo 'access_denied';

                          print "<!doctype html><html><head><meta charset=\"UTF-8\"><title>Access Denied</title></head><body>Access Denied</body></html>";

                          return;

                    }

                  }


                  // Since we have a valid node type, decide if we are

                  // modifying or creating a node.

                  $nid = (isset($data['nid'])) ? $data['nid'] : 'new';



                  // Load existing node by node id.


                    if ($nid != 'new') {

                       $node = new stdClass();

                        $article =& JTable::getInstance("content");

                        $article->load($nid);


                        $node->id               = $article->get("id");

                        $node->created_by       = $article->get("created_by");

                        $node->state            = $article->get("state");

                        $node->created          = $article->get("created");

                        $node->checked_out_time = $article->get("checked_out_time");

                        $node->publish_up       = $article->get("publish_up");

                        $node->catid            = $article->get("catid");

                        $node->hits             = $article->get("hits");

                        $node->access           = $article->get("access");
                        
                        $node->alias           = $article->get("alias");


                    if (!$node) {

                      // Could not load the nid, create a new node.

                      $nid = 'new';

                    }
                    }


                  // Create blank node object in memory.

                  if ($nid == 'new') {

                    // Setup the node structure.

                    $node = new stdClass();



                    $node->nid = NULL;



                    // Insert new data.


                    $node->created_by       = $uid;

                    $node->state            = '1';

                    $node->created          = date("Y-m-d H:i");

                    $node->checked_out_time = date("Y-m-d H:i");

                    $node->publish_up       = date("Y-m-d H:i");

                    $node->catid            = '2';

                    $node->hits             = '1';

                    $node->access             = '1';

                  }

                  // Loop through $data array and fill in the node values.

                  foreach ($data as $k => $v) {

                    if (is_array($v)) {

                      // If $v is an array, make it a string.

                      $v = implode('; ', $v);

                    }


                    // Switch according to the data which come from post
                    switch($k) {

                      case 'status':

                          if($v==1) {

                            $node->state  = isset($v) ? '1' : $node->state;

                          }

                          else {

                            $node->state  = isset($v) ? '0' : $node->state;

                          }

                        break;



                      case 'image_overwrite':

                        $image_overwrite          = isset($v) ? ($v) : FALSE;

                        break;



                      case 'title':

                        $node->title         = isset($v) ? ($v) : $node->title;
                          
                        $node->alias         = $node->title ;

                        break;



                      case 'body':

                        $node->introtext       = isset($v) ? ($v) : $node->introtext;

                        break;



                        // END switch case.

                    }

                    // END foreach $data.

                  }


                  // for replace the image

                  if($image_overwrite!= FALSE) {      

                    if (preg_match('/img*/i', $node->introtext)) {

                      $content = explode("<",$node->introtext);

                      $node->introtext = $content[0];

                    }

                  }


                  // Image handling

                  $images   = $dispatcher->trigger( 'photoldr_images_process', "$uid,$ntype" );          // get the image html
                  $images   = $images[0];         

                  if(!empty($images)) {

                    $htmlimg = '';

                    foreach ($images as $value) {

                      $htmlimg .= $value;

                    }

                    // Concatinate ine image with body

                    $node->introtext .= $htmlimg;

                  }

                   $subject = explode("\\",$node->introtext);

                   if(!empty($subject)){

                   $node->introtext = str_replace('\\', '', $node->introtext);

                   }


                  //Create new post if new otherwise update

                  if($nid=='new') {             

                    $insert = "INSERT INTO ".$dbprefix."content(title,introtext,alias,state,created,created_by,publish_up,hits,catid,checked_out_time,access)VALUES('$node->title','".mysql_escape_string($node->introtext)."','$node->alias','$node->state','$node->created','$node->created_by','$node->publish_up','$node->hits','$node->catid','$node->checked_out_time','$node->access')";

                    $test   = mysql_query($insert); 

                    $nid   = mysql_insert_id();

                  }

                  else {

                     $nid = $node->id;
                     $querynew  = "UPDATE ".$dbprefix."content SET title = '$node->title',introtext = '".mysql_escape_string($node->introtext)."',state = '$node->state',alias = '$node->alias',created='$node->created',created_by = '$node->created_by',publish_up='$node->publish_up',hits = '$node->hits',catid = '$node->catid',checked_out_time ='$node->checked_out_time',access ='$node->access' where id = '$nid' ";         
                     mysql_query($querynew); 

                  }


                  // For debug the file if user is Super user
                 $query1  = "SELECT name  FROM ".$dbprefix."users where id = $uid";  
                 $result1 = mysql_query($query1);

                 while($result_value =  mysql_fetch_array($result1)){     
                     $name = $result_value['name'];
                 }

                  if ($name == 'Super User') { 

                    $testdata1 = '';

                    $testdata  = $node;            

                    if(isset($_FILES)) {

                        $testdata1 = $_FILES;

                    }

                    $joomla_root_path = getcwd();

                    $handle = fopen($joomla_root_path . "/postdata.txt", "a");            

                    fwrite($handle, 'Data: \n' . print_r($testdata, TRUE) . '  ');

                    fwrite($handle, 'Image section \n' . print_r($testdata1, TRUE) . '  '); 

                    fclose($handle);

                  }

                  $countnode = 1;



                      // Genrate XML to return

                  if ($nid) {

                    header('Content-type: text/xml');

                    echo '<?xml version="1.0" encoding="UTF-8"?>'."\n";

                    echo "<domains>\n";

                    echo "<domain>\n";

                    echo "<nodes  count='$countnode'>\n";

                    echo "<node>\n";



                    echo "<userdelete>";

                    echo "1";

                    echo "</userdelete>";



                    echo "<useredit>";

                    echo "1";

                    echo "</useredit>";



                    echo "<vid>";

                    echo $nid;

                    echo "</vid>";



                    echo "<uid>";

                    echo $uid;

                    echo "</uid>";



                    echo "<title>";

                    echo htmlspecialchars($node->title);

                    echo "</title>";



                    echo "<status>";

                    echo '1';

                    echo "</status>";



                    echo "<nid>";

                    echo $nid;

                    echo "</nid>";



                    echo "<type>";

                    echo 'article';

                    echo "</type>";



                    echo "<language/>";



                    echo "<created>";

                    echo $node->created;

                    echo "</created>";



                    echo "<changed>";

                    echo $node->created;

                    echo "</changed>";



                    echo "<revision_timestamp>";

                    echo date("Y-m-d H:i");

                    echo "</revision_timestamp>";



                    echo "<body>";

                    echo htmlspecialchars($node->introtext);

                    echo "</body>";


                    echo "<name>";

                    echo $data['username'];

                    echo "</name>";



                    echo "</node>";

                    echo "</nodes>";



                    echo "</domain>";

                    echo "</domains>";

                  }

                  exit;

                    }
            }
    
    
    
    
    
            function photoldr_images_process($uid) {

                $array = explode(",",$uid);           
                $uid  = $array[0];
                $type = $array[1];  

                  if (!isset($_FILES)) {

                    // No Files in _POST.

                    return;

                  }

                  $count = 0;

                   foreach ($_FILES as $k => $v) {

                     if (preg_match('/imag*/i', $k)) {

                       // Count Images in _POST.

                       $count++;

                     }

                   }

                   if ($count == 0) {

                     // No Images in POST.

                     return;

                   }



                  // Set and Prepare the file directory.

                  $joomla_root_path = getcwd();



                  $joomla_root_paths = $joomla_root_path."/postimg/";



                  if (!is_dir($joomla_root_paths)) {

                    mkdir($joomla_root_paths);

                  }



                  // Traversing $_FILES one by one and return image tag

                  $imagehtml = array();

                  $i = "0";


                  foreach ($_FILES as $k => $v) {

                    // object of php standard class

                    $src            = new stdClass();

                    $src->uri       = $v['tmp_name'];

                    $fuid[$i]       = str_pad((int) $uid, 6, "0", STR_PAD_LEFT);

                    $fdate[$i]      = time();


                    // get the extension of image

                    $extensions  = explode('.', $v['name']);

                    $extensions1 = $extensions[1];



                    // check the image has valid extension.

                    $exten_img  = array('bmp','gif','jpg','png','psd','jpeg');

                    $validimg   = in_array($extensions1, $exten_img);



                    $filename   = $type . '-' . $fuid[$i] . '-' . $fdate[$i] . '-' .$i.'.'.$extensions1; // unique file name



                    if($validimg) {             

                      $file_copy      = move_uploaded_file($src->uri, $joomla_root_path.'/postimg/'.$filename);

                      $imgurl         = JURI::root()."postimg/".$filename;

                      $imagehtml[$i]  =  "<img src='$imgurl'/>";

                    }




                     $i++;

                  }



                   // return image html

                   return $imagehtml;

            }



}

     

?>