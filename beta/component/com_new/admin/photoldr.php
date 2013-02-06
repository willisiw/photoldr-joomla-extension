<?php 
// to encrypt pasword
/*$salt = JUserHelper::genRandomPassword(32);
$crypt = JUserHelper::getCryptedPassword($pass, $salt);
$pass = $crypt.':'.$salt;
echo $pass;*/
/*$salt = JUserHelper::genRandomPassword(32);
			$crypt = JUserHelper::getCryptedPassword($array[$pass], $salt);
			echo $array[$pass] = $crypt . ':' . $salt;*/
			/*$hashparts = preg_split (':' , $password1);
echo $hashparts[0]; //this is the hash  4e9e4bcc5752d6f939aedb42408fd3aa
echo $hashparts[1];//salt
 echo $userhash = md5($userpassword.$hashparts[1])."meenu";
*/
//code to get url of site
$user =& JFactory::getUser();
 $userId = $user->get( 'id' );
 $group_id = &JFactory::group_id();
echo 'User group id is '.$group_id ;
echo "</br>";
//echo '<input type="hidden" name="user_id" value="' . $userId . '" />';
$url = JURI::root();
$output = preg_replace("/^(http:\/\/)/", "", $url);
//echo $output; 
$fqdn = rtrim($output,"/");
//echo $fqdn; 
if(file_exists('../configuration.php'))
 {
  require_once('../configuration.php');
}
$obj=new JConfig;
$database=$obj->db;
 $db_host=$obj->host;
$db_host=$obj->host;
$db_login=$obj->user;
$db_pass=$obj->password;
$dbprefix=$obj->dbprefix;
  $db = mysql_connect("$db_host","$db_login","$db_pass");
//mysql_select_db($database,$db);
mysql_select_db($database,$db);
if(isset($_POST['submit'])){
//$fqdn = JURI::root();// $_POST['text1'];
$expiry = $_POST['text2'];
$arr=$_POST['select2'];
print_r($arr);
$real_selection = ""; 
foreach($arr as $key => $value) 
{ 
  if ($real_selection)
  $real_selection .= ", ".trim($value);
  else
  $real_selection = trim($value); 
}  
 $image_style = $_POST['select'];
$icon_style = $_POST['select1'];
 $defaultitem = $_POST['select22'];
$name2 = $_POST['name'];
$password2 = $_POST['password'];

//echo $real = mysql_escape_string($real_selection);
 $insert = "INSERT INTO ".$dbprefix."photo(userid,fqdn,expiry,content_type,image_style,icon_style,defaultitem,name,password)VALUES('$userId','$fqdn','$expiry','".mysql_escape_string($real_selection)."','$image_style','$icon_style','$defaultitem','$name2','$password2')";
mysql_query($insert);
}
?>
<form name = "form1" action = "" method = "POST">
<span style = "font-size:14px;font-weight:bold;">Username</span><br/>
<input type = "text" name = "name" value = ""/><br/>Enter you username<br/>
<span style = "font-size:14px;font-weight:bold;">Password</span><br/>
<input type = "text" name = "password" value = ""/><br/>Enter your password<br/><br/>
<span style = "font-size:14px;font-weight:bold;">FQDN</span><br/><input type = "text" name = "text1" value = "<?php echo $fqdn;?>"><br/>Fully Qualified Domain Name of this web site.  Ex. www.example.com
<br/><br/>
<span style = "font-size:14px;font-weight:bold;">Expiration Date</span><br/><input type = "text" name = "text2" value = "+3 months"><br/>
Enter a relative string like +3 months, +90 days, +1 year, or a static date as YYYY-MM-DD. </br> Expiration Date for data that is cached in the iOS app.  An expired domains data is removed from the app.  Useful if you are migrating to a new site, or shutting down a site, or have data that is time sensative. The app should attemt to refresh the data every day, but if the data is not refreshed for (+3 months, +90 days, +1 year) then the data is cleared from the app.
<br/><br/>
<span style = "font-size:14px;font-weight:bold;">Content type</span><br/>
<select MULTIPLE  name="select2[]" size="3"  tabindex="1">
<option value="" selected="selected">selectone</option>
        <option value="article">article</option>
        <option value="banner">banner</option>
		 <option value="Category">Category</option>
		      </select>
<br/>select the types of content used by PhotoLdr. CTRL-click to select multiple.
<br/><br/>
<span style = "font-size:14px;font-weight:bold;">Image Style</span><br/>
<select name = "select">
<option value = "thumbnail">thumbnail</option>
<option value = "medium">medium</option>
<option value = "large">large</option>
</select>
<br/>Select the style of images displayed by PhotoLdr.</br></br>
<span style = "font-size:14px;font-weight:bold;">Icon Style</span><br/>
<select name = "select1">
<option value = "thumbnail">thumbnail</option>
<option value = "medium">medium</option>
<option value = "large">large</option>
</select>
<br/>Select the image style of icon displayed by PhotoLdr PhotoLdr.</br></br>
<span style = "font-size:14px;font-weight:bold;">Type of item to post as default </span><br/>
<select name = "select22">
<option value = "articles">articles</option>
<option value = "banners">banners</option>
</select><br/></br>
<span style = "font-size:17px;font-weight:bold;">Save Settings after changing any above options to refresh the available options bellow.</span><br/>
<input type = "submit" name = "submit" value = "Save and Refresh"/>
</form>
<?php
 if(file_exists('../configuration.php'))
 {
  require_once('../configuration.php');
}
$obj=new JConfig;
$database=$obj->db;
 $db_host=$obj->host;
$db_host=$obj->host;
$db_login=$obj->user;
$db_pass=$obj->password;
$dbprefix=$obj->dbprefix;
  $db = mysql_connect("$db_host","$db_login","$db_pass");
mysql_select_db($database,$db);
defined('_JEXEC' ) or die('Restricted access');
$sql ="SELECT * from ".$dbprefix."photo where name = '$name2' order by id desc";
$res = mysql_query($sql);
$row = mysql_fetch_array($res);
/*echo $name3 = $row['name'];
echo "</br>";
echo $password3 = $row['password'];
echo "</br>";
$password9 = $password3.$salt;
$password4 = md5($password9).":".$salt;*/
 $fqdn = $row['fqdn'];
$expiry  = $row['expiry'];




$content_type = print_r (explode(",",$content_type));

echo $content_type1  = $row['content_type'];










//echo "123";
$publish = 1;
$standalone = 1;
$cms = "joomla";
$startDate=date("Y-m-d");
/*fetching admin details*/
$sql2 = "SELECT * from ".$dbprefix."users";
$result1 = mysql_query($sql2);
$count5 = mysql_num_rows($result1);
$sql9 = "SELECT * from ".$dbprefix."users where id = $userId";
$result9 = mysql_query($sql9);
$row9 = mysql_fetch_array($result9);
$uid = $row9['id'];
$username = $row9['username'];
$mail = $row9['email'];
$password = $row9['password'];
$parts = explode( ':', $password );
$salt = $parts[1];
/*query used to fetch data for articles*/
$sql141="SELECT COUNT(*) FROM ".$dbprefix."content ";
$res51= mysql_fetch_array(mysql_query($sql141));
$sqlc=$res51[0]-10;
$sqla1 = "select * from ".$dbprefix."content ORDER BY id LIMIT  $sqlc,10" ;
$result = mysql_query($sqla1);
$count = mysql_num_rows($result);
while($row1 = mysql_fetch_array($result)){
$id[] = $row1['id'];
$title[] = $row1['title'];
$state[] = $row1['state'];
$fulltext[] = $row1['introtext'].$row1['fulltext'];
$sectionid[] = $row1['sectionid'];
$catid[] = $row1['catid'];
$created[] = $row1['created'];
$modified[] = $row1['modified'];
}
/*query used to fetch data for banners*/
//$sql13="SELECT COUNT(*) FROM ".$dbprefix."banners ";
//$res41= mysql_fetch_array(mysql_query($sql13));
//$sqlb=$res41[0]-10;
$sql3 = "select * from ".$dbprefix."banners ORDER BY id LIMIT 10";
$resul = mysql_query($sql3);
$count1 = mysql_num_rows($resul);
while($row3 = mysql_fetch_array($resul)){
$id1[] = $row3['bid'];
$name1[] = $row3['name'];
$type[] = $row3['type'];
$date1[] = $row3['date'];
$description[] = $row3['description'];
$cid[] = $row3['cid'];
$imageurl[] = $row3['imageurl'];
$showBanner[] = $row3['showBanner'];
//print_r($count1);
}
/*query used to fetch data for categories*/
 $sql121="SELECT COUNT(*) FROM ".$dbprefix."categories ";
 $res31= mysql_fetch_array(mysql_query($sql121));
 $sqla=$res31[0]-10;
$sql4 = "select * from ".$dbprefix."categories ORDER BY id LIMIT $sqla,10";
$res91 = mysql_query($sql4);
$count4 = mysql_num_rows($res91);
while($row4 = mysql_fetch_array($res91)){
$id11[] = $row4['id'];
$title1[] = $row4['title'];
$description1[] = $row4['description'];
$published1[] = $row4['published']; 	
}
/*calculate to content count*/
$count3 = $count+$count1+$count4;
?>

<?php 
/*echo $asd = "select username,password from ".$dbprefix."users where id = $userId" ;
$qwe = mysql_query($asd);
$zx = mysql_fetch_array($qwe);
echo $name1 = $zx['username'];
echo $password1 = $zx['password'];*/
$asd1 = "select name,password from ".$dbprefix."photo ORDER BY Id DESC LIMIT 1 " ;
$qwe1 = mysql_query($asd1);
$zx1 = mysql_fetch_array($qwe1);
 $name3 = $zx1 ['name'];
$password3 = $zx1 ['password'];
$password9 = $password3.$salt;
 $password4 = md5($password9).":".$salt;
 
 //get the group id for the user 
/*$asd2 = "select * from ".$dbprefix."user_usergroup_map" ;
$qwe2 = mysql_query($asd1);
$zx2 = mysql_fetch_array($qwe1);
echo "</br>";
echo $grpid = $zx2['group_id '];
echo "</br>";*/
 
 
?>
<?php
//echo $content_type;
 //echo $real
echo '</xml>';
$xml = new SimpleXMLElement('<domains/>');
for ($i = 1; $i <= 1; ++$i) {
 //$track = $xml->addChild('Domains','<domains src="PhotoLdr_node_structure_page">');
    $track = $xml->addChild('domain');
   $track->addChild('FQDN',"$fqdn");
    $track->addChild('published',"$publish");
	 $track->addChild('cms', "$cms");
	 $track->addChild('standalone',"$standalone");
	  $track->addChild('date',"$startDate");
	   $track->addChild('exp_date', "$expiry");
	    $track->addChild('exp_url',"$fqdn");
		$track->addChild('post_url', "$fqdn"."/PhotoLdrstructure.xml");
				/*$track = $xml->addChild('FQDN',"$fqdn");
		$track = $xml->addChild('published',"$publish");
		$track = $xml->addChild('cms', "$cms");
		$track = $xml->addChild('standalone',"$standalone");
		$track = $xml->addChild('date',"$startDate");
		$track = $xml->addChild('exp_url',"$fqdn");
		$track = $xml->addChild('post_url', "$fqdn"."PhotoLdrstructure.xml");
		$track->addChild('app_options',"
<option>app:Username:username:textfield:</option>
<option>app:Password:password:password:</option>
<option>app:Publish:status:checkbox:</option>
");*/
$track1 = $track->addChild('app_options');
$track1->addChild('option',"app:Username:username:textfield:");
$track1->addChild('option',"app:Password:password:password:");
$track1->addChild('option',"app:Publish:status:checkbox:");
//$track->addChild('app_options');

//form-item tag
$track2 = $track->addChild('form_items');


$article="article";
$banner="banner";
$Category="Category";



//foreach ($arr as &$value) {


//<-----For article and banner---->


if($content_type1=="article, banner")
{

if( $group_id == 6){
$track2->addChild('option',"$article".":Hidden:posturl:"."$fqdn"."/PhotoLdrstructure.xml");
$track2->addChild('option',"$banner".":Hidden:posturl:"."$fqdn"."/PhotoLdrstructure.xml");

}
elseif($group_id == 7){
$track2->addChild('option',"$article".":Hidden:posturl:"."$fqdn"."/PhotoLdrstructure.xml");
$track2->addChild('option',"$banner".":Hidden:posturl:"."$fqdn"."/PhotoLdrstructure.xml");
}
else
{
$track2->addChild('option',"$content_type".":Hidden:posturl:"."$fqdn"."/PhotoLdrstructure.xml");
$track2->addChild('option',"$banner".":Hidden:posturl:"."$fqdn"."/PhotoLdrstructure.xml");
}

$track2->addChild('option',"$article".":Title:title:textfield:required");
$track2->addChild('option',"$article".":Category:title:textfield:required");
$track2->addChild('option',"$article".":Body:body:textarea:required");
$track2->addChild('option',"$banner".":Title:title:textfield:required");
$track2->addChild('option',"$banner".":Body:body:textarea");

	}


//<-----For article and Category---->
elseif($content_type1=="article, Category")
{
if( $group_id == 6){
$track2->addChild('option',"$article".":Hidden:posturl:"."$fqdn"."/PhotoLdrstructure.xml");
$track2->addChild('option',"$Category".":Hidden:posturl:"."$fqdn"."/PhotoLdrstructure.xml");
}
elseif($group_id == 7){
$track2->addChild('option',"$article".":Hidden:posturl:"."$fqdn"."/PhotoLdrstructure.xml");
$track2->addChild('option',"$Category".":Hidden:posturl:"."$fqdn"."/PhotoLdrstructure.xml");
}
else
{
$track2->addChild('option',"$content_type".":Hidden:posturl:"."$fqdn"."/PhotoLdrstructure.xml");
$track2->addChild('option',"$Category".":Hidden:posturl:"."$fqdn"."/PhotoLdrstructure.xml");
}

$track2->addChild('option',"$article".":Category:title:textfield:required");
$track2->addChild('option',"$article".":Body:body:textarea:required");
$track2->addChild('option',"$Category".":Title:title:textfield:required");
$track2->addChild('option',"$Category".":Body:body:textarea");

	}

 //<-----For banner and Category---->   
elseif($content_type1=="banner, Category")
{
if( $group_id == 6){
$track2->addChild('option',"$banner".":Hidden:posturl:"."$fqdn"."/PhotoLdrstructure.xml");
$track2->addChild('option',"$Category".":Hidden:posturl:"."$fqdn"."/PhotoLdrstructure.xml");
}
elseif($group_id == 7){
$track2->addChild('option',"$banner".":Hidden:posturl:"."$fqdn"."/PhotoLdrstructure.xml");
$track2->addChild('option',"$Category".":Hidden:posturl:"."$fqdn"."/PhotoLdrstructure.xml");
}
else
{
$track2->addChild('option',"$banner".":Hidden:posturl:"."$fqdn"."/PhotoLdrstructure.xml");
$track2->addChild('option',"$Category".":Hidden:posturl:"."$fqdn"."/PhotoLdrstructure.xml");
}
$track2->addChild('option',"$banner".":Title:title:textfield:required");
$track2->addChild('option',"$banner".":Body:body:textarea");
$track2->addChild('option',"$Category".":Title:title:textfield:required");
$track2->addChild('option',"$Category".":Body:body:textarea");

	}


	
	
//<-----For article---->   	
	

elseif($content_type1 == 'article'){
if( $group_id == 6){
$track2->addChild('option',"$article".":Hidden:posturl:"."$fqdn"."/PhotoLdrstructure.xml");}
elseif($group_id == 7){
$track2->addChild('option',"$article".":Hidden:posturl:"."$fqdn"."/PhotoLdrstructure.xml");}
elseif ($group_id == 8){$track2->addChild('option',"$content_type".":Hidden:posturl:"."$fqdn"."/PhotoLdrstructure.xml");}else{}
$track2->addChild('option',"$article".":Title:title:textfield:required");
$track2->addChild('option',"$article".":Category:title:textfield:required");
$track2->addChild('option',"$article".":Body:body:textarea:required");
}
//<-----For banner----> 

elseif ($content_type1 == 'banner'){
if( $group_id == 6){
$track2->addChild('option',"$banner".":Hidden:posturl:"."$fqdn"."/PhotoLdrstructure.xml");
}
elseif($group_id == 7){
$track2->addChild('option',"$banner".":Hidden:posturl:"."$fqdn"."/PhotoLdrstructure.xml");}
elseif ($group_id == 8){$track2->addChild('option',"$banner".":Hidden:posturl:"."$fqdn"."/PhotoLdrstructure.xml");
}
else{}
$track2->addChild('option',"$banner".":Title:title:textfield:required");
$track2->addChild('option',"$banner".":Body:body:textarea");
}
//<-----For Category----> 

elseif ($content_type1== 'Category'){
if( $group_id == 6){
$track2->addChild('option',"$Category".":Hidden:posturl:"."$fqdn"."/PhotoLdrstructure.xml");}
elseif($group_id == 7){
$track2->addChild('option',"$Category".":Hidden:posturl:"."$fqdn"."/PhotoLdrstructure.xml");}elseif ($group_id == 8){$track2->addChild('option',"$Category".":Hidden:posturl:"."$fqdn"."/PhotoLdrstructure.xml");}else{}
$track2->addChild('option',"$Category".":Title:title:textfield:required");
$track2->addChild('option',"$Category".":Body:body:textarea");
}


//<-----For all select or no select---->

else {
//$track2 = $track->addChild('form_items');
$track2->addChild('option',"article:Title:title:textfield:required");
$track2->addChild('option',"article:Body:body:textarea");
$track2->addChild('option',"banner:Title:title:textfield:required");
$track2->addChild('option',"banner:Body:body:textarea");
$track2->addChild('option',"Category:Title:title:textfield:required");
$track2->addChild('option',"Category:Body:body:textarea");
}

//}
				
//node type in form items tag
$track3 = $track->addChild('node_types');

if($content_type1=="article, banner")
{
$track3->addChild('options',"article");
$track3->addChild('options',"banner");
}
elseif ($content_type1 == "article, Category"){
$track3->addChild('options',"article");
$track3->addChild('options',"Category");
}


elseif ($content_type1 == "banner, Category"){
$track3->addChild('options',"banner");
$track3->addChild('options',"Category");
}

elseif ($content_type1 == 'article'){ 
$track3->addChild('options',"article");
}
elseif ($content_type1 == 'banner'){ 
$track3->addChild('options',"banner");
}
elseif ($content_type1 == 'Category'){ 
$track3->addChild('options',"Category");
} else {
$track3->addChild('options',"article");
$track3->addChild('options',"banner");
$track3->addChild('options',"Category");
}



			
/*$track2->addChild('option',"article:Hidden:posturl:"."$fqdn"."/PhotoLdrstructure.xml");
$track2->addChild('option',"article:Title:title:textfield:required");
$track2->addChild('option',"article:Body:body:textarea:");
$track2->addChild('option',"article:Tags:field_tags:textfield:UNSUPPORTED taxonomy");
$track2->addChild('option',"article:Image:field_image:image:#9");
$track2->addChild('option',"article:Replace Photos:image_overwrite:checkbox:");
$track2->addChild('option',"page:Hidden:posturl:"."$fqdn"."/PhotoLdrstructure.xml");
$track2->addChild('option',"page:Title:title:textfield:#required");
$track2->addChild('option',"page:Body:body:textarea:");
//$track->addChild('form_items');
 $track->addChild('form_items',"
      <option>
      article:Hidden:posturl:http://www.example.com/?q=PhotoLdrpost.php
      </option>
      <option>article:Title:title:textfieldrequired</option>
      <option>article:Body:body:textarea:</option>
      <option>
      article:Tags:field_tags:textfield:UNSUPPORTED taxonomy
      </option>
      <option>article:Image:field_image:image:#9</option>
      <option>article:Replace Photos:image_overwrite:checkbox:</option>
      <option>
      page:Hidden:posturl:http://www.example.com/?q=PhotoLdrpost.php
      </option>
      <option>page:Title:title:textfield:#required</option>
      <option>page:Body:body:textarea:</option>
      <option>
  ");
   $track->addChild('form_items');
   $track->addChild('content_types');
      $track->addChild('content_types',"article:table");
	  $track->addChild('content_types');
	  $track->addChild('name',"$username");
	   $track->addChild('email',"$mail");*/
	  	  $track->addChild('name');
	   $track->addChild('email');
	  /*$track = $xml->addChild('name',"$username");
	  $track = $xml->addChild('email',"$mail");*/
	     //$track->addChild('content_count','<contents count="'.$count3.'">');
  // $track = $xml->addChild('content_count','count = "'.$count3.'"');
  //code for usercount and details
     $track6 = $track->addChild('user');
   $track6->addAttribute('user', $count5);
      //for($j = 0;$j<=$count5-1;$j++){
      //$track6->addChild('user');
   //$track5->addChild('id',"$id[$j]");
   if($name3 == $username && $password4 == $password ){
     if($uid == ''){}else{
   $track6->addChild('id',"$uid");
   }
   if($username == ''){}else{
   $track6->addChild('username',"$username");
  }
   if($mail == ''){}else{
     $track6->addChild('mail',"$mail");
	 }}else {
	 	 echo " u r not authenticated user </br>";
	 	 }//}
	//$value = ($new) $xml->user;
//echo $value;
  /*Code for generating XMl for Artciles*/
  //$track4 = $track->addChild('nodes','count = "'.$count3.'"');
 //$track4 = $track->addChild('nodes'.$count3.'');
 //$track4 = $track->addChild('nodes'.$new.''<count = "'.$count3.'"/>);
 $track4 = $track->addChild('nodes');
 $track4->addAttribute('count', $count3);
 
 
if($content_type1=="article, banner")
{
 //<---------For article & banner----------------> 
  for($j = 0;$j<=$count-1;$j++){
 $track5 = $track4->addChild('node');
     //$track2->addChild('content');
	if($id[$j] == ''){ }else{
   $track5->addChild('nid',"$id[$j]");
   }
   if($title[$j] == ''){}else{
   $track5->addChild('title',"$title[$j]");
  }
  $track5->addChild('log');
 if($state[$j] == ''){}else{
     $track5->addChild('status',"$state[$j]");
	 }
	 	$track5->addChild('type',"article");
		 		 if($created[$j] == ''){}else{
	 $track5->addChild('created',"$created[$j]");
	 }
	 if($modified[$j] == ''){}else{
	 $track5->addChild('modified',"$modified[$j]");
	 }
	 if($fulltext[$j] == ''){}else{
  $track5->addChild('body',"$fulltext[$j]");
  }
  if($sectionid[$j] == ''){}else{
    $track5->addChild('sectionid',"$sectionid[$j]");
	}
	if($catid[$j] == ''){}else{
    $track5->addChild('cid',"$catid[$j]");
	}  }
		

  for($j = 0;$j<=$count1-1;$j++){
  $track5 = $track4->addChild('node');
    //$track->addChild('content');
	if($id1[$j] == ''){}else{
   $track5->addChild('nid',"$id1[$j]");
   }
   if($name1[$j] == ''){}else{
   $track5->addChild('title',"$name1[$j]");
  }
  $track5->addChild('log');
  if($showBanner[$j] == ''){}else{
      $track5->addChild('status',"$showBanner[$j]");
	  }
	 if($type[$j] == ''){}else{
	 $track5->addChild('type',"banner");
	 }
	 if($date1[$j] == ''){}else{
	 $track5->addChild('created',"$date1[$j]");
	 }
	 if($description[$j] == ''){}else{
  $track5->addChild('body',"$description[$j]");
  }
  if($imageurl[$j] == ''){}{
  $track5->addChild('image0',"$imageurl[$j]");
  }
   if($cid[$j] == ''){}else{
    $track5->addChild('cid',"$cid[$j]");
	}
   //$track->addChild('content',"</content>");
  } 	
 }
 
 
 
//<---------For article & Category----------------> 
elseif($content_type1=="article, Category")
{
 
 
 for($j = 0;$j<=$count-1;$j++){
 $track5 = $track4->addChild('node');
     //$track2->addChild('content');
	if($id[$j] == ''){ }else{
   $track5->addChild('nid',"$id[$j]");
   }
   if($title[$j] == ''){}else{
   $track5->addChild('title',"$title[$j]");
  }
  $track5->addChild('log');
 if($state[$j] == ''){}else{
     $track5->addChild('status',"$state[$j]");
	 }
	 	$track5->addChild('type',"article");
		 		 if($created[$j] == ''){}else{
	 $track5->addChild('created',"$created[$j]");
	 }
	 if($modified[$j] == ''){}else{
	 $track5->addChild('modified',"$modified[$j]");
	 }
	 if($fulltext[$j] == ''){}else{
  $track5->addChild('body',"$fulltext[$j]");
  }
  if($sectionid[$j] == ''){}else{
    $track5->addChild('sectionid',"$sectionid[$j]");
	}
	if($catid[$j] == ''){}else{
    $track5->addChild('cid',"$catid[$j]");
	}  }
	

 //echo "vxcbcnxmcn ,m";
  for($j = 0;$j<=$count4-1;$j++){
    $track5 = $track4->addChild('node');
	if($id11[$j] == ''){}else{
   $track5->addChild('nid',"$id11[$j]");
   }
   if($title1[$j] == ''){}else{
   $track5->addChild('title',"$title1[$j]");
  }
  $track5->addChild('log');
  if($published1[$j] == ''){}else{
      $track5->addChild('status',"$published1[$j]");
	  }	
	$track5->addChild('type',"Category");
	 	 if($description1[$j] == ''){}else{
  $track5->addChild('body',"$description1[$j]");
  }
    if($id11[$j] == ''){}else{
    $track5->addChild('cid',"$id11[$j]");
	}
  // $track->addChild('content',"</content>");
  }
  	
}


//<---------For banner & Category----------------> 

elseif($content_type1=="banner, Category")
{


for($j = 0;$j<=$count1-1;$j++){
  $track5 = $track4->addChild('node');
    //$track->addChild('content');
	if($id1[$j] == ''){}else{
   $track5->addChild('nid',"$id1[$j]");
   }
   if($name1[$j] == ''){}else{
   $track5->addChild('title',"$name1[$j]");
  }
  $track5->addChild('log');
  if($showBanner[$j] == ''){}else{
      $track5->addChild('status',"$showBanner[$j]");
	  }
	 if($type[$j] == ''){}else{
	 $track5->addChild('type',"banner");
	 }
	 if($date1[$j] == ''){}else{
	 $track5->addChild('created',"$date1[$j]");
	 }
	 if($description[$j] == ''){}else{
  $track5->addChild('body',"$description[$j]");
  }
  if($imageurl[$j] == ''){}{
  $track5->addChild('image0',"$imageurl[$j]");
  }
   if($cid[$j] == ''){}else{
    $track5->addChild('cid',"$cid[$j]");
	}
   //$track->addChild('content',"</content>");
  } 

for($j = 0;$j<=$count4-1;$j++){
    $track5 = $track4->addChild('node');
	if($id11[$j] == ''){}else{
   $track5->addChild('nid',"$id11[$j]");
   }
   if($title1[$j] == ''){}else{
   $track5->addChild('title',"$title1[$j]");
  }
  $track5->addChild('log');
  if($published1[$j] == ''){}else{
      $track5->addChild('status',"$published1[$j]");
	  }	
	$track5->addChild('type',"Category");
	 	 if($description1[$j] == ''){}else{
  $track5->addChild('body',"$description1[$j]");
  }
    if($id11[$j] == ''){}else{
    $track5->addChild('cid',"$id11[$j]");
	}
  // $track->addChild('content',"</content>");
  }

}

 
 
 
elseif($content_type1 == 'article'){ 
  for($j = 0;$j<=$count-1;$j++){
 $track5 = $track4->addChild('node');
     //$track2->addChild('content');
	if($id[$j] == ''){ }else{
   $track5->addChild('nid',"$id[$j]");
   }
   if($title[$j] == ''){}else{
   $track5->addChild('title',"$title[$j]");
  }
  $track5->addChild('log');
 if($state[$j] == ''){}else{
     $track5->addChild('status',"$state[$j]");
	 }
	 	$track5->addChild('type',"article");
		 		 if($created[$j] == ''){}else{
	 $track5->addChild('created',"$created[$j]");
	 }
	 if($modified[$j] == ''){}else{
	 $track5->addChild('modified',"$modified[$j]");
	 }
	 if($fulltext[$j] == ''){}else{
  $track5->addChild('body',"$fulltext[$j]");
  }
  if($sectionid[$j] == ''){}else{
    $track5->addChild('sectionid',"$sectionid[$j]");
	}
	if($catid[$j] == ''){}else{
    $track5->addChild('cid',"$catid[$j]");
	}  }
		/*Code to generate XML for banners*/
   //$track->addChild('content',"</content>");
	}

elseif($content_type1 == 'banner' ) {
  for($j = 0;$j<=$count1-1;$j++){
  $track5 = $track4->addChild('node');
    //$track->addChild('content');
	if($id1[$j] == ''){}else{
   $track5->addChild('nid',"$id1[$j]");
   }
   if($name1[$j] == ''){}else{
   $track5->addChild('title',"$name1[$j]");
  }
  $track5->addChild('log');
  if($showBanner[$j] == ''){}else{
      $track5->addChild('status',"$showBanner[$j]");
	  }
	 if($type[$j] == ''){}else{
	 $track5->addChild('type',"banner");
	 }
	 if($date1[$j] == ''){}else{
	 $track5->addChild('created',"$date1[$j]");
	 }
	 if($description[$j] == ''){}else{
  $track5->addChild('body',"$description[$j]");
  }
  if($imageurl[$j] == ''){}{
  $track5->addChild('image0',"$imageurl[$j]");
  }
   if($cid[$j] == ''){}else{
    $track5->addChild('cid',"$cid[$j]");
	}
   //$track->addChild('content',"</content>");
  } }
  /*code to generate XML for categories*/
   //$track->addChild('content',"</content>");



elseif($content_type1 == 'Category' ) {
 //echo "vxcbcnxmcn ,m";
  for($j = 0;$j<=$count4-1;$j++){
    $track5 = $track4->addChild('node');
	if($id11[$j] == ''){}else{
   $track5->addChild('nid',"$id11[$j]");
   }
   if($title1[$j] == ''){}else{
   $track5->addChild('title',"$title1[$j]");
  }
  $track5->addChild('log');
  if($published1[$j] == ''){}else{
      $track5->addChild('status',"$published1[$j]");
	  }	
	$track5->addChild('type',"Category");
	 	 if($description1[$j] == ''){}else{
  $track5->addChild('body',"$description1[$j]");
  }
    if($id11[$j] == ''){}else{
    $track5->addChild('cid',"$id11[$j]");
	}
  // $track->addChild('content',"</content>");
  }
  }
  //for all the content type
else{
  for($j = 0;$j<=$count-1;$j++){
 $track5 = $track4->addChild('node');
      //$track2->addChild('content');
	if($id[$j] == ''){ }else{
   $track5->addChild('nid',"$id[$j]");
   }
   if($title[$j] == ''){}else{
   $track5->addChild('title',"$title[$j]");
  }
  $track5->addChild('log');
 if($state[$j] == ''){}else{
     $track5->addChild('status',"$state[$j]");
	 }
	 	$track5->addChild('type',"article");
		 
		 if($created[$j] == ''){}else{
	 $track5->addChild('created',"$created[$j]");
	 }
	 if($modified[$j] == ''){}else{
	 $track5->addChild('modified',"$modified[$j]");
	 }
	 if($fulltext[$j] == ''){}else{
  $track5->addChild('body',"$fulltext[$j]");
  }
  if($sectionid[$j] == ''){}else{
    $track5->addChild('sectionid',"$sectionid[$j]");
	}
	if($catid[$j] == ''){}else{
    $track5->addChild('cid',"$catid[$j]");
	}  }
    for($j = 0;$j<=$count1-1;$j++){
  $track5 = $track4->addChild('node');
    //$track->addChild('content');
	if($id1[$j] == ''){}else{
   $track5->addChild('nid',"$id1[$j]");
   }
   if($name1[$j] == ''){}else{
   $track5->addChild('title',"$name1[$j]");
  }
  $track5->addChild('log');
  if($showBanner[$j] == ''){}else{
      $track5->addChild('status',"$showBanner[$j]");
	  }
	 if($type[$j] == ''){}else{
	 $track5->addChild('type',"banner");
	 }
	 if($date1[$j] == ''){}else{
	 $track5->addChild('created',"$date1[$j]");
	 }
	 if($description[$j] == ''){}else{
  $track5->addChild('body',"$description[$j]");
  }
  if($imageurl[$j] == ''){}{
  $track5->addChild('image0',"$imageurl[$j]");
  }
   if($cid[$j] == ''){}else{
    $track5->addChild('cid',"$cid[$j]");
	}
   //$track->addChild('content',"</content>");
  }  for($j = 0;$j<=$count1-1;$j++){
  $track5 = $track4->addChild('node');
    //$track->addChild('content');
	if($id1[$j] == ''){}else{
   $track5->addChild('nid',"$id1[$j]");
   }
   if($name1[$j] == ''){}else{
   $track5->addChild('title',"$name1[$j]");
  }
  $track5->addChild('log');
  if($showBanner[$j] == ''){}else{
      $track5->addChild('status',"$showBanner[$j]");
	  }
	 if($type[$j] == ''){}else{
	 $track5->addChild('type',"banner");
	 }
	 if($date1[$j] == ''){}else{
	 $track5->addChild('created',"$date1[$j]");
	 }
	 if($description[$j] == ''){}else{
  $track5->addChild('body',"$description[$j]");
  }
  if($imageurl[$j] == ''){}{
  $track5->addChild('image0',"$imageurl[$j]");
  }
   if($cid[$j] == ''){}else{
    $track5->addChild('cid',"$cid[$j]");
	}
   //$track->addChild('content',"</content>");
  }
    for($j = 0;$j<=$count4-1;$j++){
    $track5 = $track4->addChild('node');
	if($id11[$j] == ''){}else{
   $track5->addChild('nid',"$id11[$j]");
   }
   if($title1[$j] == ''){}else{
   $track5->addChild('title',"$title1[$j]");
  }
  $track5->addChild('log');
  if($published1[$j] == ''){}else{
      $track5->addChild('status',"$published1[$j]");
	  }
		$track5->addChild('type',"Category");
	 	 if($description1[$j] == ''){}else{
  $track5->addChild('body',"$description1[$j]");
  }
    if($id11[$j] == ''){}else{
    $track5->addChild('cid',"$id11[$j]");
	}
  // $track->addChild('content',"</content>");
  }  }
  }
    //$track->addChild('contents');
//  $track->addChild('form_items');
  //$track->addChild('form_items');
$xml =$xml->asXML();
//echo $xml ; ?><br/>
<form name = "form1" action = "#" method = "POST">
<input type = "submit" name = "submit1" value = "Create XML" /><br/>
<?php $title = addslashes($xml);
 $insert1 = "INSERT INTO ".$dbprefix."xml(xml)VALUES('$title')";
mysql_query($insert1);
$sql1 ="SELECT * from ".$dbprefix."xml";
$res1 = mysql_query($sql1);
while($row1 = mysql_fetch_array($res1)){
echo $xml = $row1['xml'];
if (isset($_POST['submit1']))
{
     $xml = $row1['xml'];
	}
$fp = fopen('../PhotoLdrstructure.xml', 'w');
 fputs($fp, $xml);
}
fclose($fp);

?>
</form>