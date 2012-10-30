<?php
//new changes //
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


 $sql ="SELECT * from ".$dbprefix."photo";
$res = mysql_query($sql);
while($row = mysql_fetch_array($res)){
$fqdn = $row['fqdn'];
$expiry  = $row['expiry'];
$content_type  = $row['content_type'];
}
$publish = 1;
$standalone = 1;
$cms = "joomla";
$startDate=date("Y-m-d");
/*fetching admin details*/
$sql2 = "SELECT * from ".$dbprefix."users";
$result1 = mysql_query($sql2);
while($row2 = mysql_fetch_array($result1)){
$username = $row2['username'];
$mail= $row2['email'];
}
/*query used to fetch data for articles*/
$sql1 = "select * from ".$dbprefix."content";
$result = mysql_query($sql1);
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
$sql3 = "select * from ".$dbprefix."banner";
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
$sql4 = "select * from ".$dbprefix."categories";
$res11 = mysql_query($sql4);
$count4 = mysql_num_rows($res11);
while($row4 = mysql_fetch_array($res11)){
$id11[] = $row4['id'];
$title1[] = $row4['title'];

$description1[] = $row4['description'];
$published1[] = $row4['published']; 	



}
/*calculate to content count*/
$count3 = $count+$count1+$count4;
?>
<?php
echo '</xml>';
$xml = new SimpleXMLElement('<domains/>');
for ($i = 1; $i <= 1; ++$i) {
 $track = $xml->addChild('Domains','<domains src="photoldr_node_structure_page">');
    $track = $xml->addChild('Domain',"<domain>");
   $track->addChild('FQDN',"<FQDN>".$fqdn."</FQDN>" );
    $track->addChild('published',"<published>".$publish."</published>");
	 $track->addChild('cms', "<cms>".$cms."</cms>");
	 $track->addChild('standalone', "<standalone>".$standalone."</standalone>");
	  $track->addChild('date',"<date>".$startDate."</date>");
	   $track->addChild('exp_date', "<exp_date>".$expiry."</exp_date>");
	    $track->addChild('exp_url', "<exp_url>".$fqdn."</exp_url>");
		$track->addChild('post_url', "<post_url></post_url>");
		$track->addChild('app_options',"<app_options>");
$track->addChild('app_options',"
<option>app:Username:username:textfield:</option>
<option>app:Password:password:password:</option>
<option>app:Publish:status:checkbox:</option>
");
$track->addChild('app_options',"</app_options>");
$track->addChild('form_items',"<form_items>");
 $track->addChild('form_items',"
      <option>
      article:Hidden:posturl:http://www.example.com/?q=photoldrpost.php
      </option>
      <option>article:Title:title:textfieldrequired</option>
      <option>article:Body:body:textarea:</option>
      <option>
      article:Tags:field_tags:textfield:UNSUPPORTED taxonomy
      </option>
      <option>article:Image:field_image:image:#9</option>
      <option>article:Replace Photos:image_overwrite:checkbox:</option>
      <option>
      page:Hidden:posturl:http://www.example.com/?q=photoldrpost.php
      </option>
      <option>page:Title:title:textfield:#required</option>
      <option>page:Body:body:textarea:</option>
      <option>
  ");
  $track->addChild('form_items',"</form_items>");
   $track->addChild('content_types',"<content_types>");
      $track->addChild('content_types',"<option>article:table</option>");
	  $track->addChild('content_types',"</content_types>");
	  $track->addChild('name',"<name>".$username."</name>");
	   $track->addChild('email',"<email>".$mail."</email>");
	  
   $track->addChild('content_count','<contents count="'.$count3.'">');
  /*Code for generating XMl for Artciles*/
   for($j = 0;$j<=$count-1;$j++){
    $track->addChild('content',"<content>");
	if($id[$j] == ''){}else{
   $track->addChild('id',"<id>".$id[$j]."</id>");
   }
   if($title[$j] == ''){}else{
   $track->addChild('title1',"<title>".$title[$j]."</title>");
  }
  $track->addChild('log',"<log/>");
 if($state[$j] == ''){}else{
     $track->addChild('status',"<status>".$state[$j]."</status>");
	 }
	 	$track->addChild('type',"<type>".'article'."</type>");
		 
		 if($created[$j] == ''){}else{
	 $track->addChild('created',"<created>".$created[$j]."</created>");
	 }
	 if($modified[$j] == ''){}else{
	 $track->addChild('modified',"<modified>".$modified[$j]."</modified>");
	 }
	 if($fulltext[$j] == ''){}else{
  $track->addChild('body',"<body>".$fulltext[$j]."</body>");
  }
  if($sectionid[$j] == ''){}else{
    $track->addChild('sectionid',"<sectionid>".$sectionid[$j]."</sectionid>");
	}
	if($catid[$j] == ''){}else{
    $track->addChild('cid',"<cid>".$catid[$j]."</cid>");
	}
	/*Code to generate XML for banners*/
   $track->addChild('content',"</content>");
  }
  for($j = 0;$j<=$count1-1;$j++){
    $track->addChild('content',"<content>");
	if($id1[$j] == ''){}else{
   $track->addChild('id',"<id>".$id1[$j]."</id>");
   }
   if($name1[$j] == ''){}else{
   $track->addChild('title1',"<title>".$name1[$j]."</title>");
  }
  $track->addChild('log',"<log/>");
  if($showBanner[$j] == ''){}else{
      $track->addChild('status',"<status>".$showBanner[$j]."</status>");
	  }
	 if($type[$j] == ''){}else{
	 $track->addChild('type',"<type>".$type[$j]."</type>");
	 }
	 if($date1[$j] == ''){}else{
	 $track->addChild('created',"<created>".$date1[$j]."</created>");
	 }
	 if($description[$j] == ''){}else{
  $track->addChild('body',"<body>".$description[$j]."</body>");
  }
  if($imageurl[$j] == ''){}{
  $track->addChild('image0',"<image0>".$imageurl[$j]."</image0>");
  }
   if($cid[$j] == ''){}else{
    $track->addChild('cid',"<cid>".$cid[$j]."</cid>");
	}
   $track->addChild('content',"</content>");
  }
  /*code to generate XML for categories*/
   $track->addChild('content',"</content>");
  }
  for($j = 0;$j<=$count4-1;$j++){
    $track->addChild('content',"<content>");
	if($id11[$j] == ''){}else{
   $track->addChild('id',"<id>".$id11[$j]."</id>");
   }
   if($title1[$j] == ''){}else{
   $track->addChild('title1',"<title>".$title1[$j]."</title>");
  }
  $track->addChild('log',"<log/>");
  if($published1[$j] == ''){}else{
      $track->addChild('status',"<status>".$published1[$j]."</status>");
	  }
	
	$track->addChild('type',"<type>".'Category'."</type>");
	 
	 
	 if($description1[$j] == ''){}else{
  $track->addChild('body',"<body>".$description1[$j]."</body>");
  }
 
   if($id11[$j] == ''){}else{
    $track->addChild('cid',"<cid>".$id11[$j]."</cid>");
	}
   $track->addChild('content',"</content>");
  }
  
  
  
  
  
  
  
   $track->addChild('contents',"</contents>");
  
    $track->addChild('form_items',"</domain>");
    $track->addChild('form_items',"</domains>");

print($xml->asXML());

?>
