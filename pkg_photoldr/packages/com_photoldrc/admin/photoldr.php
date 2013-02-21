<?php 

    // Get the user id 
      $user =& JFactory::getUser();
      $userId = $user->id;

    // Get the site url

    $url = JURI::root();

    // remove the http from the url

    $output = preg_replace("/^(http:\/\/)/", "", $url); 

    $fqdn = rtrim($output,"/");

    // Check if file exist if not than include the file 
    if(file_exists('../configuration.php'))
    {
        require_once('../configuration.php');
    }

    // Create objectb of database and other database information 
    $obj      = new JConfig;
    $database = $obj->db;
    $db_host  = $obj->host;    
    $db_login = $obj->user;
    $db_pass  = $obj->password;
    $dbprefix = $obj->dbprefix;
    $db       = mysql_connect("$db_host","$db_login","$db_pass");   
    
    
    
    // Select the database 
    mysql_select_db($database,$db);
    
    // If post the form 
    if(isset($_POST['submit'])){
   
        // Getting all the form filds 
        $FQDN              = $_POST['FQDN'];
        $app_banner        = $_POST['App_Banner'];
        $site_name         = $_POST['site_name'];
        $expiry            = $_POST['exp_date'];
        $unpublish_content = $_POST['unpublished'];
        $real_selection    = $_POST['types'];
        $image_style       = $_POST['image_style'];
        $icon_style        = $_POST['icon_style'];
        $defaultitem       = $_POST['post_type'];
        
        
        
         // add all the information in database

    
        $nodeweight  =  "article";


        $nodeweightfor  = $_POST["photoldr_node_weight_".$nodeweight];

        $nodeview       = $_POST["photoldr_node_view_".$nodeweight];
  
        $nodeitem_max   = $_POST["photoldr_item_max_".$nodeweight];
 
        $nodeage_max    = $_POST["photoldr_item_age_max_".$nodeweight];

        $nodeitem_order = $_POST["photoldr_item_order_".$nodeweight];

        $nodeorderby    = $_POST["photoldr_item_orderby_".$nodeweight];

        
   
        // Check if user already inserted data into database 
        
         $query  = "SELECT * FROM ".$dbprefix."photo where userid = '$userId' ";         
         $result = mysql_query($query);
         $rows   = mysql_num_rows($result);
           
         // If user alredy inserted data than update the information  
         if($rows){
             $querynew  = "UPDATE ".$dbprefix."photo SET fqdn = '$FQDN',app_banner = '$app_banner',site_name = '$site_name',expiry='$expiry',unpublish_content = '$unpublish_content',content_type='".mysql_escape_string($real_selection)."',
                           image_style = '$image_style',icon_style ='$icon_style',defaultitem = '$defaultitem',photoldr_node_weight_$nodeweight = '$nodeweightfor',photoldr_node_view_$nodeweight = '$nodeview',photoldr_item_max_$nodeweight = '$nodeitem_max',photoldr_item_age_max_$nodeweight = '$nodeage_max',photoldr_item_order_$nodeweight = '$nodeitem_order',photoldr_item_orderby_$nodeweight = '$nodeorderby'  where userid = '$userId' ";         
             mysql_query($querynew);            
         }
         // If not then insert the data into database table tbl_photo        
        else{ 
         $insert = "INSERT INTO ".$dbprefix."photo(userid,fqdn,app_banner,site_name,expiry,unpublish_content,content_type,image_style,icon_style,defaultitem,photoldr_node_weight_$nodeweight,photoldr_node_view_$nodeweight,photoldr_item_max_$nodeweight,photoldr_item_age_max_$nodeweight,photoldr_item_order_$nodeweight,photoldr_item_orderby_$nodeweight)
                    VALUES('$userId','$fqdn','$app_banner','$site_name','$expiry','$unpublish_content','".mysql_escape_string($real_selection)."','$image_style','$icon_style','$defaultitem','$nodeweightfor','$nodeview','$nodeitem_max','$nodeage_max','$nodeitem_order','$nodeorderby')";
         
         $test = mysql_query($insert);     
         
        }  
        
      }
    
     // else if ---  form not post
                
             $newnodeweightfor = $newnodeview = $newnodeitem_max = $newnodeage_max = $nenodeitem_order = $newnodeorderby = null;
             $query  = "SELECT * FROM ".$dbprefix."photo"; 
             
             $result = mysql_query($query);
             
             // Get all the value of the field ;
             while($result_value =  mysql_fetch_array($result)){           
                   $newfqdn               = $result_value['fqdn']; 
                   $newsite_name          = $result_value['site_name'];
                   $newapp_banner         = $result_value['app_banner']; 
                   $newunpublish_content  = $result_value['unpublish_content'];
                   $newexpiry             = $result_value['expiry'];
                   $newcontent_type       = $result_value['content_type'];
                   $newimage_style        = $result_value['image_style'];
                   $newicon_style         = $result_value['icon_style'];
                   $newdefaultitem        = $result_value['defaultitem'];
                   
                   $newnodeweightfor      = $result_value['photoldr_node_weight_article'];
                   $newnodeview           = $result_value['photoldr_node_view_article'];
                   $newnodeitem_max       = $result_value['photoldr_item_max_article'];
                   $newnodeage_max        = $result_value['photoldr_item_age_max_article'];
                   $nenodeitem_order      = $result_value['photoldr_item_order_article'];
                   $newnodeorderby        = $result_value['photoldr_item_orderby_article'];
                 }
                 
             
                 
?>
    <div>
<?php
    //No direct access to the file
    defined('_JEXEC') or die('Restricted Access not allowed');
    //import joomla controller library
    jimport('joomla.application.component.controller');
    //get an instance of the controller prefixed by HelloWorld
    $controller = JController::getInstance('photoldr');
    //perform the request task
    $controller->execute(JRequest::getCmd('task'));
    //Redirect if set by controller
    $controller->redirect();
?>
    <div>
    <div>
    <div>

    <form method="post" action="" name="form1">
    <div style="float: left; margin-left: 51px;width: 95%;">

      <div class="form-item">
            <h1>PhotoLDR</h1>
            <h2 class="xml"><a target="_blank" href="<?php echo $url;?>photoldrstructure.xml">PhotoLDR XML Data</a></h2>
            <label class="labels">FQDN </label>
            <input type="text" id="fdqn" name="FQDN" value="<?php if(isset($newfqdn)) echo $newfqdn; else echo $fqdn; ?>" size="30" maxlength="128">
            <div>Fully Qualified Domain Name of this web site.  Ex. www.Example.com</div>
      </div>

      <div class="form-item">
            <label class="labels">Display Smart App Banner </label>
            <select id="appbanner" name="App Banner" class="form-select appbaner">
                 <option  <?php if(isset($newapp_banner) && $newapp_banner=='yes'){ ?> value="<?php echo $newapp_banner ?>" selected=selected" <?php } else { ?> value="yes" <?php } ?> >Yes</option>
                 <option  <?php if(isset($newapp_banner) && $newapp_banner=='no'){  ?> value="<?php echo $newapp_banner ?>" selected=selected" <?php } else { ?> value="no" <?php } ?> >No </option>
            </select>
      </div>

      <div class="form-item">
            <label class="labels">Site Name </label>
            <input type="text" id="site-name" name="site_name" value="<?php if(isset($newsite_name)) echo $newsite_name; else echo 'Joomla on PhotoLDR'; ?>" class="sitename_photo"/>
            <div>Site name.  Remember this will be displayed on iPhone and iPad, so best to keep this short. (v2)</div>
      </div>

      <div class="form-item">
            <label class="labels">Expiration Date </label>
            <input type="text" id="exp-date" name="exp_date" value="<?php if(isset($newexpiry)) echo $newexpiry; else echo ''; ?>" size="30" maxlength="128"/>
            <div>Enter a relative string like +3 months, +90 days, +1 year, or a static date as YYYY-MM-DD. <br> Expiration Date for data that is cached in the iOS app.  An expired domains data is removed from the app.  Useful if you are migrating to a new site, or shutting down a site, or have data that is time sensative. The app should attemt to refresh the data every day, but if the data is not refreshed for (+3 months, +90 days, +1 year) then the data is cleared from the app.</div>
      </div>

      <div class="form-item">
            <label class="labels">Unpublished Content </label>
            <select id="unpublished" name="unpublished" class="form-select" style="width: 80px; height: 18px;">
                <option <?php if(isset($newunpublish_content) && $newunpublish_content=='yes'){ ?> value="<?php echo $newunpublish_content ?>" selected=selected" <?php } else { ?> value="yes" <?php } ?> >Yes</option>
                <option <?php if(isset($newunpublish_content) && $newunpublish_content=='no'){  ?> value="<?php echo $newunpublish_content ?>" selected=selected" <?php } else { ?> value="no" <?php } ?> >No</option>
            </select>
            <div>Allow content editors with permission to work with unpublished content. (v2)</div>
      </div>

      <div class="form-item">
            <label class="labels">Node Types </label>
            <select name="types" id="types" style="width: 80px; height: 18px;">
                <option <?php if(isset($newcontent_type) && $newcontent_type=='article'){  ?> value="<?php echo $newcontent_type ?>" selected=selected" <?php } else { ?> value="article" <?php } ?>   >article</option>            
            </select>
            <div>Select the types of nodes used by PhotoLDR. CTRL-click to select multiple.</div>
      </div>

      <div class="form-item">
            <label class="labels">Image style </label>
            <select id="image-style" name="image_style" style="width: 80px; height: 18px;">
               <option <?php if(isset($newimage_style) && $newimage_style=='thumbnail'){  ?> value="<?php echo $newimage_style ?>" selected=selected" <?php } else { ?> value="thumbnail" <?php } ?>  >thumbnail</option>
               <option <?php if(isset($newimage_style) && $newimage_style=='medium'){     ?> value="<?php echo $newimage_style ?>" selected=selected" <?php } else { ?> value="medium" <?php } ?> >medium</option>
               <option <?php if(isset($newimage_style) && $newimage_style=='large'){      ?> value="<?php echo $newimage_style ?>" selected=selected" <?php } else { ?> value="large" <?php } ?>      >large</option>
            </select>
        <div>Select the style of images displayed by PhotoLDR.</div>
      </div>

      <div class="form-item">
            <label class="labels">Icon style </label>
            <select id="icon-style" name="icon_style" style="width: 80px; height: 18px;">
              <option <?php if(isset($newicon_style) && $newicon_style=='thumbnail'){  ?> value="<?php echo $newicon_style ?>" selected=selected" <?php } else { ?> value="thumbnail" <?php } ?> >thumbnail</option>
              <option <?php if(isset($newicon_style) && $newicon_style=='medium'){  ?>    value="<?php echo $newicon_style ?>" selected=selected" <?php } else { ?> value="medium"    <?php } ?> >medium</option>
              <option <?php if(isset($newicon_style) && $newicon_style=='large'){  ?>     value="<?php echo $newicon_style ?>" selected=selected" <?php } else { ?> value="large"     <?php } ?>  >large</option>
            </select>
            <div>Select the image style of icon displayed by PhotoLDR.</div>
      </div>

      <div class="form-item">
            <label class="labels">Type of item to post as default </label>
            <select id="post-type" name="post_type" style="width: 80px; height: 18px;">
              <option <?php if(isset($newdefaultitem) && $newdefaultitem=='article'){  ?> value="<?php echo $newdefaultitem ?>" selected=selected" <?php } else { ?> value="article" <?php } ?>  >article</option> 
            </select>
            <div>Select the types of nodes to use PhotoLDR.  Revisit this page after setting this for more settings.</div>
      </div>

      <div style="clear: both;">
        &nbsp;
      </div>
    </div>


      <div style="float: left; margin-left: 51px;width: 900px;">
      <hr>
      <h3>Save Settings after changing any above options to refresh the available options bellow.</h3>

      <div style="height:58px">
            <div class="submit-button-photoldr" >
            <input type="submit" class="icon-32-apply-submit" value="" name="submit" id="edit-submit" >
            <div style="width:32px">SAVE</div>
            </div>
      </div>
      <hr>


      <?php $post_type = "article"; ?>

      <div class="form-item form-type-select form-item-photoldr-node-weight-article">



        <label for="edit-photoldr-node-weight-article"><?php echo $post_type ?> - Weight</label>

        <select id="edit-photoldr-node-weight-<?php echo $post_type ?>" name="photoldr_node_weight_<?php echo $post_type ?>" class="form-select">

             <?php for($pp=1; $pp<=50;$pp++) { ?>

                 <option value="<?php echo $pp;?>"  <?php if(isset($newnodeweightfor) && $newnodeweightfor==$pp && $newnodeweightfor !=''){ ?> selected=selected" <?php } else { if($newnodeweightfor == '') { if($pp==10) { ?> selected="selected" <?php } }} ?>> <?php echo $pp;?> </option>

             <?php } ?>

        </select>

        <div class="description">This will set the order that node types are presented to the iOS app.</div>

      </div>

      <table>

        <tr>

          <td class="table_photo_lod">

            <div class="form-item form-type-select form-item-photoldr-node-view-article photo_lod_div">

                <label for="edit-photoldr-node-view-article"><?php echo $post_type ?> - View Type </label>

                <select id="edit-photoldr-node-view-<?php echo $post_type ?>" name="photoldr_node_view_<?php echo $post_type ?>" class="form-select">

                    <option value="table" selected="selected">Table</option>

                    <option value="map" <?php if(isset($newnodeview) && $newnodeview == "map"){ ?> selected="selected" <?php } ?> >Map -coming soon</option></select>

                <div class="description">This will set the view type in the iOS app. CURRENTLY Disabled.  Only Tableview is used no matter what is set.</div>

           </div>

          </td>

          <td class="table_photo_lod">

            <div class="form-item form-type-select form-item-photoldr-item-max-article photo_lod_div">

              <label for="edit-photoldr-item-max-article"><?php echo $post_type ?> - Max items </label>


              <select id="edit-photoldr-item-max-<?php echo $post_type ?>" name="photoldr_item_max_<?php echo $post_type ?>" class="form-select">

                 <?php for($pp=1; $pp<=100;$pp++) { ?>

                 <option value="<?php echo $pp;?>" <?php if(isset($newnodeitem_max) && $newnodeitem_max==$pp && $newnodeitem_max !=''){ ?>  selected=selected" <?php } else { if($newnodeitem_max == '') { if($pp==15) { ?> selected="selected" <?php } }} ?> ><?php echo $pp;?> </option>             

                 <?php } ?>

              </select>

              <div class="description">This will set the maximum number of items presented to the user.</div>

            </div>

            <div class="form-item form-type-select form-item-photoldr-item-age-max-article photo_lod_div">

                <label for="edit-photoldr-item-age-max-article"><?php echo $post_type ?> - Max age (weeks) </label>

                <select id="edit-photoldr-item-age-max-<?php echo $post_type ?>" name="photoldr_item_age_max_<?php echo $post_type ?>" class="form-select">

                <?php for($pp=0; $pp<=52;$pp++) { ?>

                    <option value="<?php echo $pp;?>"  <?php if(isset($newnodeage_max) && $newnodeage_max==$pp && $newnodeage_max !=''){ ?> selected=selected" <?php } else { if($newnodeage_max == '') { if($pp==0) { ?> selected="selected" <?php } }} ?> > <?php echo $pp;?> </option>                              

                    <?php } ?>

                </select>

               <div class="description">This will set the maximum allowable age in weeks of the displayed items.  0 is no max.</div>

            </div>

          </td>

          <td class="table_photo_lod">

            <div class="form-item form-type-select form-item-photoldr-item-order-article photo_lod_div">

               <label for="edit-photoldr-item-order-article"><?php echo $post_type ?> - Sort Order </label>

               <select id="edit-photoldr-item-order-<?php echo $post_type ?>" name="photoldr_item_order_<?php echo $post_type ?>" class="form-select">

                   <option value="DESC" <?php if(isset ($nenodeitem_order) && $nenodeitem_order == "DESC") { ?> selected="selected" <?php }?>  >Descending Z-A or Newest First</option>

                   <option value="ASC"  <?php if(isset ($nenodeitem_order) && $nenodeitem_order == "ASC") { ?> selected="selected" <?php }?>  > Ascending A-Z or Oldest First</option>               

               </select>
               <div class="description">This will set the order which items are returned to the App.</div>

            </div>


            <div class="form-item form-type-select form-item-photoldr-item-orderby-article photo_lod_div">

              <label for="edit-photoldr-item-orderby-article"><?php echo $post_type;?> - Sort By </label>

              <select id="edit-photoldr-item-orderby-<?php echo $post_type ?>" name="photoldr_item_orderby_<?php echo $post_type ?>" class="form-select">

                  <option value="created" <?php if(isset ($newnodeorderby) && $newnodeorderby == "created" ) { ?>   selected="selected" <?php }?>  >Created</option>

                  <option value="modified" <?php if(isset ($newnodeorderby) && $newnodeorderby == "modified" ) { ?>  selected="selected" <?php }?>  >Changed</option>

                  <option value="title"   <?php if(isset ($newnodeorderby) && $newnodeorderby == "title"    ) { ?>  selected="selected" <?php }  elseif($newnodeorderby == '') { ?> selected="selected"  <?php } ?> >Title</option>

                  <option value="id"     <?php if(isset ($newnodeorderby) && $newnodeorderby == "id"  ) { ?>  selected="selected" <?php }?>  >Node ID</option>

              </select>

              <div class="description">This will set the field used to sort.</div>

            </div>

          </td>

        </tr>

      </table>

      <div class="submit-button-photoldr" >
            <input type="submit" class="icon-32-apply-submit" value="" name="submit" id="edit-submit" >
            <div style="width:32px">SAVE</div>
      </div>

      </div>
        
    </form> 
        
        
    <div class="clear"></div></div><!-- wpbody-content -->
    <div class="clear"></div></div><!-- wpbody -->
    <div class="clear"></div></div><!-- wpcontent -->

    <div id="wpfooter">
    <p class="alignleft" id="footer-left"><span id="footer-thankyou"></span></p>
    <p class="alignright" id="footer-upgrade"></p>
    <div class="clear"></div>
    </div>
    </div><!-- wpwrap -->
   