<?php //session_start();
	  if(empty($user_id))
	  $curr_user_id = $this->session->userdata('logged_in')['account_id'];
	  else
	  $curr_user_id = $user_id; 
	 // $curr_user_data= $this->customermodel->profiledata($curr_user_id);
	  //$_SESSION['username'] = $curr_user_data[0]->username; // Must be already set
	 // echo $curr_user_data[0]->username;
	 $image = $this->profile_set->get_profile_pic($user_id);
	 $current_user_id_for_post_comment_box = $this->session->userdata('logged_in')['account_id'];
    $user_imge_pbox = $this->profile_set->get_profile_pic($current_user_id_for_post_comment_box);
   ?>
    <section class="col-lg-6 col-md-6 col-sm-5 col-xs-12 coloumn2">
      <div class="updateStatus" id="updateStatus">
        <ul>
          <li> <img src="<?php echo base_url();?>uploads/<?php if(!empty($image[0]->user_img_thumb)) echo $image[0]->user_img_thumb; else echo 'default_profile_pic.png'; ?>" alt="<?php echo base_url();?>uploads/<?php if(!empty($image[0]->user_img_thumb)) echo $image[0]->user_img_thumb; else echo 'default_profile_pic.png'; ?>" height="60" width="60"> </li>
          <li><a href="javascript:document.getElementById('posts').focus()" >Create a Post</a></li>
          <li><a href="javascript:document.getElementById('uploadPhotos').click()">Upload Photos/Video</a></li>
          <li><a href="#">Create Photo/Video Album</a></li>
        </ul>
   
        <div id="uploadPhotosdvPreview"></div>
         <form name = "post_form" id = "my_form" enctype = "multipart/form-data" method = "POST" action="<?php echo  base_url(); ?>signg_in/send_post" />
        <input type="file" name="uploadPhotos[]" id="uploadPhotos" multiple="multiple" style="display:none;" />
        <input type="hidden" id="skipfiles" name="skipfiles" /><div id="tempdivholder" style="display:none;" ></div><div id="tempfilename"></div>
<!--        <textarea cols="" rows="" name="posts" id="posts" class="form-control" placeholder="What's Buzzing?"></textarea>
-->       
		<div class="post-content" style="width:100%; min-height:75px;" onclick="document.getElementById('dummypost').focus();"><div contenteditable="true" data-text="What's Buzzing?" style="min-height:20px; min-width:10px; padding:8px; float:left;" id="dummypost" onkeyup="takeInputToPost()"></div><div id="withTokens" style="display:none; padding:8px; float:left">--With </div><div style="clear:both;"></div></div>
        <input type="hidden" id="posts" name="posts" />
        <input type="reset" style="display:none;"/>
		<div id="hiddentokens" style="display:none;"></div>
        <div id="selectedfriends"><div id="search_frnd_wrapper"><input type="text" name="txtsearch" id="searchfriends" onkeyup="keyupevent();" /><input type="hidden" id="addedusers" name="addedusers" /><div id="autosuggest"></div></div></div>
        <div id="taggedfriends"><div id="tag_frnd_wrapper"><input type="text" name="tagsearch" id="tagsearchfriends" onkeyup="tagkeyupevent();" /><input type="hidden" id="tagaddedusers" name="tagaddedusers" /><div id="tagautosuggest"></div></div></div>
        <div class="updateControls" id="updateControls"><img class="tagging" onclick="showtaginput();" src='<?php echo base_url().'images/person-tagging.png';?>' /><img class="ghost" onclick="showghostinput();" src='<?php echo base_url().'images/haunted.png';?>' /> <select name="post_group" id="post_group"><option value="0">Public</option> <?php $groups = $this->profile_set->get_user_groups(); if($groups) { 
		foreach($groups as $group)
		{
			echo "<option value='".$group['group_id']."'>".$group['group_name']."</option>";
		}
		
		
		} ?></select> <a href="javascript:void(0);" onclick="postsubmitajax('my_form');">Post</a> </div>
        <?php echo form_close(); ?>
        <div class="clear"></div>
      </div>
      
      <?php $this->load->view('auto_job_suggestions'); ?>
      
     <div class="posts" id="posts_content_div">
	<?php  $data['products'] = $this->customermodel->All_Posts($user_id);
		   $data['image'] = $image;
	 $this->load->view('all_posts_inner',$data);?>
      </div>
      
    </section>
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Share this post</h4>
      </div>
      <div class="modal-body" id="sharePostPopup">
        ...
      </div>
      <?php /*?><div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div><?php */?>
    </div>
  </div>
</div>
<!--<div class="modal fade" id="save_as_fav_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Save This Post As Favorite</h4>
      </div>
      <div class="modal-body" id="save_as_fav_popup">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Large modal</button>
-->
<!--
<div class="modal fade bs-example-modal-lg" tabindex="-1" id="save_as_fav_modal" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
     <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Save This Post As Favorite</h4>
      </div>
      <div class="modal-body" id="save_as_fav_popup">
        ...
      </div>
    </div>
  </div>
</div>

-->
<div class="modal fade pin-it-column target01 " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="save_as_fav_modal" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                
                <div class="fav_add_success"></div>
                    <div class="imgHolder-pinit">
                        <div class="img-content-block">
                        
  <!-- Wrapper for slides -->
  
                        
                           
                        </div>
                    </div>
                    <div class="pin-categories-pinit">
                        <div class="pinBoard">
                            <h3>Pick a board</h3>
       <label><i class="fa fa-search"></i><input type="text" placeholder="Search" onkeyup="get_save_fav_categories(this.value);" id="save_fav_category_search"/></label>                            
                        </div>
                        <div class="user-option-block">
                            <div class="scroll-pane" id="categories"> 

                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>


<script>
function takeInputToPost(){
$("#posts").val($("#dummypost").text());
}
function showghostpost(post_id,current_id,posted_to,posted_by){

var viewers = posted_to.split(',');

if(in_array(viewers, current_id) || viewers==current_id || posted_by==current_id)
{
	$("#ghostpostBtn"+post_id).hide(200);
	$("#post"+post_id+" .hidethis").show(500);
	$('#post'+post_id).addClass('ghostpostside');
}
else{
	alert('This is a ghost post.you are not authorized to view');
}

}
function in_array(array, id) {
    for(var i=0;i<array.length;i++) {
        if(array[i] == id)
		return true;
    }
    return false;
}
</script>
