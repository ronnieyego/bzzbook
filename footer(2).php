<?php
$upload_path = "uploads/";							
$thumb_width = "150";						
$thumb_height = "150";		
?>

<footer class="post">
  <ul>
    <li><a hrte>ABOUT US</a></li>
    <li><a href="#">PRIVACY POLICY</a></li>
    <li><a href="#">TERMS OF USE</a></li>
  </ul>
  <p>Bzzbook &copy; 2015 English (US)</p>
</footer>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="<?php echo base_url(); ?>js/jquery-1.11.1.min.js"></script> 
<script src="<?php echo base_url(); ?>javascripts/jquery.attach.js"></script> 
<script src="<?php echo base_url(); ?>javascripts/example.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script> 
<?php
if(strpos($_SERVER['REQUEST_URI'],'company/my_companies') !== false) {
?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script>
$(function () {
    $("#fileupload").change(function () {
		$("#dvPreview").html("");
        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
        if (regex.test($(this).val().toLowerCase())) {
            if ($.browser.msie && parseFloat(jQuery.browser.version) <= 9.0) {
                $("#dvPreview").show();
                $("#dvPreview")[0].filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = $(this).val();
            }
            else {
                if (typeof (FileReader) != "undefined") {
                    $("#dvPreview").show();
                    $("#dvPreview").append("<img />");
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("#dvPreview img").attr("src", e.target.result);
      $("#dvPreview img").attr("style", 'width:149px;height:156px' );
                    }
                    reader.readAsDataURL($(this)[0].files[0]);
                } else {
                    alert("This browser does not support FileReader.");
                }
            }
        } else {
            alert("Please upload a valid image file.");
        }
    });
	
});
	</script>
<?php }
?>
<script src="<?php echo base_url(); ?>js/animate-plus.min.js"></script> 
<script src="<?php echo base_url(); ?>js/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>js/additional-methods.js"></script>
<script src="<?php echo base_url(); ?>js/countries.js"></script>
<script src="<?php echo base_url(); ?>js/usa_states.js"></script>
<script language="javascript">print_country("country");</script>  
<script src="<?php echo base_url(); ?>js/jquery.jqtransform.js"></script>
<script language="javascript">print_usa_states("usa_states");</script>
<script src="<?php echo base_url(); ?>js/lightbox.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.uploadfile.min.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap-datepicker.js"></script> 
<script src="<?php echo base_url(); ?>js/jquery.blImageCenter.js"></script> 
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script> 
<script src="<?php echo base_url(); ?>js/fbphotobox.js"></script>
<script src="<?php echo base_url(); ?>js/custom.js"></script> 

<script>
		$( document ).ready(function() {
		$('.select').jqTransform({ imgPath: '' });
		$('#calYears').datepicker();
		
   $('#email_invite').validate();
   $('#upload_file').validate();
   $('#search_job').validate(); 
   $('#event_discussion').validate();
   $('#change_pwd').hide();
   $('#pf_pwd_change').validate();
   $(".message").fadeOut(6000);
 
  $('#posts').focusin(function() 
   {
   $('#updateControls').show();
  
});



$('#share_business_card_frnds').keypress(function(e) {
	
    if(e.which == 32) {
	var cur_content = $('#selected_emails').html();
	
	var user_mail = $.trim($(this).val());
	
	
	var new_content  =  "<span class='bc_mail_ids' id='"+user_mail+"'>"+user_mail+"<a onclick='removemail(&#39"+user_mail+"&#39)'><img class='as_close_btn' src='<?php echo base_url().'images/close_post.png'; ?>'/></a></span>";
	$('#selected_emails').html(new_content+cur_content);
	$('#selected_emails').show();
	$(this).val('').focus();
	
	 var added_emails = $('#addedmails').val()
if(added_emails!='')
$('#addedmails').val(added_emails+','+user_mail)
else
$('#addedmails').val(user_mail)

    }

});



});




function removemail(user_mail){

	var added_emails = $('#addedmails').val();
	var len = added_emails.length;
	var newval = '';
	if(len==1)
	{ 
		newval = '';
	}
	else if(added_emails.indexOf(user_mail)==(len-1)){
	newval = added_emails.replace(','+user_mail,'');
	}
	else if(added_emails.indexOf(user_mail)==0)
	newval = added_emails.replace(user_mail+',','');
	else
	newval = added_emails.replace(user_mail+',','');
	$('#addedmails').val(newval);
	$('#'+user_mail).remove();
}




</script>
<script>
$(document).ready(function()
{
var settings = {
    url : "<?php echo base_url(); ?>upload.php ?>",
    dragDrop:true,
    fileName: "myfile",
    allowedTypes:"jpg,png,gif,doc,pdf,zip",	
    returnType:"json",
	 onSuccess:function(files,data,xhr)
    {
       // alert((data));
    },
    showDelete:true,
    deleteCallback: function(data,pd)
	{
    for(var i=0;i<data.length;i++)
    {
        $.post("delete.php",{op:"delete",name:data[i]},
        function(resp, textStatus, jqXHR)
        {
            //Show Message  
            $("#status").append("<div>File Deleted</div>");   
			$("#status1").append("<div>File Deleted</div>");      
        });
     }      
    pd.statusbar.hide(); //You choice to hide/not.

}
}
//var uploadObj = $("#mulitplefileuploader").uploadFile(settings);
//var uploadObj = $("#mulitplefileuploader1").uploadFile(settings);


});



</script>   

<script>
$(function(){
	education_edit();
	profile_edit();
	organization_edit();
	group_edit();
			$("form[name=formabout_me]").submit(function(event){
			   url="<?php echo base_url();?>customer/updateabout/";
				 $.ajax({
        			type: "POST",
			        url: url,
			        data: { form_data: $(this).serialize()} ,
        			success: function(html)
			        {   
            			if(html == true)
							alert("Information Updated");
						else
							alert("Something went wrong Please try after sometime");
			        }
			       });			
				event.preventDefault();
			});
			
			$("form[name=newone]").submit(function(event){
			   url="<?php echo base_url();?>customer/sidebarSettings/";
				 $.ajax({
        			type: "POST",
			        url: url,
			        data: { form_data: $(this).serialize()} ,
        			success: function(html)
			        {   
            			if(html == true)
							alert("Information Updated");
					
						else
							alert("Something went wrong Please try after sometime");
			        }
			       });			
				event.preventDefault();
			});
			
				$("form[name=postboard]").submit(function(event){
			   url="<?php echo base_url();?>customer/postboard_update/";
				 $.ajax({
        			type: "POST",
			        url: url,
			        data: { form_data: $(this).serialize()} ,
        			success: function(html)
			        {   
            			alert("Information Updated");
						
			        }
			       });			
				event.preventDefault();
			});
			
			$("form[name=pf_pwd_change]").submit(function(event){
		
				var errors = '';
					if($('#pwd').val()== '' || $("#npwd").val()=='' || $("#cnpwd").val()=='')
					{
						//$("#change_pwd_error").html("please enter password AND Confirmation Password");
				
					}else{
	   url="<?php echo base_url();?>customer/password_update/";
		 $.ajax({
			type: "POST",
			url: url,
			data: { form_data: $(this).serialize()} ,
			success: function(html)
			{   
				$('#change_pwd').toggle();
				alert("Password Updated");
				$('#pwd_change_btn').toggle();
				
			}
		   });			
					}
		event.preventDefault();
	});
			
			$("#privacy_form").submit(function( event ){
					 url="<?php echo base_url();?>customer/updateprivacy/";
					$.post( url, { formdata: $(this).serialize() })
					.done(function( data ) {
					   	if(data == true)
							alert("Information Updated");
						else
							alert("Something Went wrong please try again after sometime");
					  });
					event.preventDefault();
			});
			$("#emailnotification").submit(function( event ){
				url="<?php echo base_url();?>customer/updateemailnotification/";
				$.post( url, { formdata: $(this).serialize() })
					.done(function( data ) {
					   	if(data == true)
							alert("Information Updated");
						else
							alert("Something Went wrong please try again after sometime");
					  });
					event.preventDefault();
			});
			$("#education_form").submit(function( event){
					
					if($("#year_attended_from").val()==0 || $("#month_attended_from").val()==0 || $("#year_attended_to").val()==0 || $("#month_attended_to").val()==0 || $("#field_of_study").val()=='' || $("#college_institution").val()=='' || $("#degree_certificate").val()=='')
					{
						$("#eduformerrors").html("Fields with '*' are mandatory, Please fill them...");
					}
					else if($("#year_attended_from").val() > $("#year_attended_to").val())
					{
						$("#eduformerrors").html("Years Attended Details Not Valid, Please check...");
					}
					else
					{				
					url="<?php echo base_url();?>customer/manageducation/";
					$.post( url, { formdata: $(this).serialize() })
					.done(function( data ) {
						   	if(data == false)
							alert("Please Enter Valid Details");
						else
						{
							$(".groupMainBlock").html(data);
							$('#education_form').trigger("reset");
							$('#eduModal').modal('toggle');
							education_edit();
						}
						
					  });
					}
					event.preventDefault();
				});
				$("#profession_form").submit(function( event){
					
					if($("#pro_year_attended_from").val()==0 || $("#pro_month_attended_from").val()==0 || $("#pro_year_attended_to").val()==0 || $("#pro_month_attended_to").val()==0 || $("#job_title").val()=='' || $("#job_description").val()=='' )
					{
						$("#proformerrors").html("Fields with '*' are mandatory, Please fill them...");
					}
					else if($("#pro_year_attended_from").val() > $("#pro_year_attended_to").val())
					{
						$("#proformerrors").html("Start should not be greater than end date");
					}
					else
					{	
							
					url="<?php echo base_url();?>customer/manageprofession/";
					$.post( url, { formdata: $(this).serialize() })
					.done(function( data ) {
					   	if(data == false)
							alert("Please Enter Valid Details");
						else
							$(".groupMainBlock1").html(data);
							$('#profession_form').trigger("reset");
							$('#profModal').modal('toggle');
							profile_edit();
					  });
					}
				event.preventDefault();});	
				$("#organization_form").submit(function( event){
					if($("#org_year_attended_from").val()==0 || $("#org_month_attended_from").val()==0 || $("#org_year_attended_to").val()==0 || $("#org_month_attended_to").val()==0 || $("#org_name").val()=='' || $("#position").val()==''   )
					{
						$("#orgformerrors").html("Fields with '*' are mandatory, Please fill them...");
					}
					else if($("#org_year_attended_from").val() > $("#org_year_attended_to").val())
					{
						$("#orgformerrors").html("Start date should not be greater than end date");
					}
					else
					{	
					url="<?php echo base_url();?>customer/manageorganization/";
					$.post( url, { formdata: $(this).serialize() })
					.done(function( data ) {
					   	if(data == false)
							alert("Please Enter Valid Details");
						else
							$(".groupMainBlock2").html(data);
							$('#organization_form').trigger("reset");
							$('#orgModal').modal('toggle');
							organization_edit();
					  });
					}
				event.preventDefault();
				});	
				$('#group_form').submit( function( event){
					if($("#group_name").val()=='' || $("#city").val()=="" || $("#usa_states").val()==0 || $("#postal_code").val()=='' )
					{
						$("#grpformerrors").html("Fields with '*' are mandatory, Please fill them...");
					}
					else
					{	
					url="<?php echo base_url(); ?>customer/managegroup/";
					$.post( url, { formdata: $(this).serialize()})
					.done(function( data ) {
						if(data == false)
						alert("Please Enter Valid Details");
						else
						$(".groupMainBlock3").html(data);
						$('#group_form').trigger("reset");
						$('#grpModal').modal('toggle');
						group_edit();
					});
					}
					event.preventDefault();
				});
				function education_edit()
				{
				$(".edu_edit").click(function(){
						education_id = $(this).attr("id").substr(14);
						$("input[name=edu_form_id]").val(education_id)
						url="<?php echo base_url(); ?>profile/eduEdit/";
						$.post( url, { education_id: education_id})
						.done(function( data ) {
							info = JSON.parse(data);
							$("input[name=field_of_study]").val(info.field_of_study);
							$("input[name=college_institution]").val(info.college_institution);
							$("input[name=degree_certificate]").val(info.degree_certificate);
							$("textarea[name=special_studies]").val(info.specialised_studies);
							from_date = info.attended_from.split('-')
							$("select[name=year_attended_from]").val(from_date[0]);
							$("select[name=month_attended_from]").val(from_date[1]);
							to_date = info.attended_upto.split('-')
							$("select[name=year_attended_to]").val(to_date[0]);
							$("select[name=month_attended_to]").val(to_date[1]);
							$("input[name=edu_action]").val("update");
							$('#eduModal').modal('toggle');
						});
						return false;
				});
				}
				function profile_edit()
				{
					$(".prof_edit").click(function(){
						profession_id = $(this).attr("id").substr(15);
						$("input[name=prof_form_id]").val(profession_id)
						url="<?php echo base_url(); ?>profile/profEdit/";
						$.post( url, { profession_id: profession_id})
						.done(function( data ) {
							info = JSON.parse(data);
							$("input[name=job_title]").val(info.job_title);
							start_date = info.start_date.split('-')
							$("select[name=year_attended_from]").val(start_date[0]);
							$("select[name=month_attended_from]").val(start_date[1]);
							end_date = info.end_date.split('-')
							$("select[name=year_attended_to]").val(end_date[0]);
							$("select[name=month_attended_to]").val(end_date[1]);
							$("textarea[name=job_description]").val(info.job_description);
							$("input[name=current]").attr("checked","checked");
							$("input[name=prof_action]").val("update")
							$('#profModal').modal('toggle');
						});
						return false;
				});
				}
				function organization_edit()
				{
					$(".org_edit").click(function(){
						organization_id = $(this).attr("id").substr(14);
						$("input[name=org_form_id]").val(organization_id)
						url="<?php echo base_url(); ?>profile/orgEdit/";
						$.post( url, { organization_id: organization_id})
						.done(function( data ) {
							info = JSON.parse(data);
							$("input[name=org_name]").val(info.org_name);
							$("input[name=position]").val(info.position);
							$("textarea[name=org_description]").val(info.org_desc);
							start_date = info.start_date.split('-')
							$("select[name=year_attended_from]").val(start_date[0]);
							$("select[name=month_attended_from]").val(start_date[1]);
							end_date = info.end_date.split('-')
							$("select[name=year_attended_to]").val(end_date[0]);
							$("select[name=month_attended_to]").val(end_date[1]);
						    $("select[name=emp_status]").val(info.emp_status);	
							$("input[name=org_action]").val("update")
							$('#orgModal').modal('toggle');
						});
						return false;
				});
				}
				function group_edit()
				{
					$(".grp_edit").click(function(){
						group_id = $(this).attr("id").substr(14);
						$("input[name=grp_form_id]").val(group_id)
						url="<?php echo base_url(); ?>profile/grpEdit/";
						$.post( url, { group_id: group_id})
						.done(function( data ) {
							info = JSON.parse(data);
							$("input[name=group_name]").val(info.group_name);
							$("input[name=group_type]").val(info.group_type);
							$("input[name=website_url]").val(info.group_web_url);
							$("input[name=city]").val(info.group_city);
							$("select[name=usa_states]").val(info.group_state);
							$("input[name=postal_code]").val(info.group_postalcode);
							$("textarea[name=additional_info]").val(info.group_about);
							$("input[name=grp_action]").val("update")
							$('#grpModal').modal('toggle');
						});
						return false;
				});
				}
				function job_edit()
				{
				$(".job_edit").click(function(){
						job_id = $(this).attr("id").substr(14);
						$("input[name=edu_form_id]").val(job_id)
						url="<?php echo base_url(); ?>jobs/jobEdit/";
						$.post( url, { job_id: job_id})
						.done(function( data ) {
							info = JSON.parse(data);
							$("input[name=job_title]").val(info.job_title);
							$("input[name=job_type]").val(info.job_type);
							$("input[name=job_keyword]").val(info.job_keyword);							
							$("input[name=job_contact_phone]").val(info.job_contact_phone);
							$("input[name=job_contact_email]").val(info.job_contact_email);
							$("input[name=job_contact_name]").val(info.job_contact_name);
							$("textarea[name=job_description]").val(info.job_description);
							$("textarea[name=job_how_to_apply]").val(info.job_how_to_apply);
							$("textarea[name=job_requirements]").val(info.job_requirements);
							$("select[name=job_category]").val(info.job_category);
							$("select[name=company_posted_by]").val(info.company_posted_by);
							$("select[name=job_salary]").val(info.job_salary);
							$("input[name=edu_action]").val("update");
							$('.bs-example-modal-lg').modal('toggle');
						});
						return false;
				});
				}
				
});
function pwdchange(){
	
var errors = '';
	if($('#pwd').val()== '')
	{
		
	//	$("#change_pwd_error").html("please enter password");

	}else{
var pass=$('#pwd').val();
   url="<?php echo base_url();?>signg_in/checkpass/"+pass;
   $.ajax({
        type: "POST",
        url: url,
        data: { pass: pass} ,
        success: function(data)
        {   
		if(data == false){
    	alert("Please enter valid password");
		$('#pwd').focus();
		}else{
		$('#npwd').focus();
		}
		}
       });
	}
}
 $('#profile_interchange').change(function(){
     id = $(this).val();
	 if(id == 'user')
	 {
	  url="<?php echo base_url(); ?>profile";
	 }else{
	 url="<?php echo base_url(); ?>company/company_disp/"+id;
	 }
	 window.location.replace(url);
	});

</script>
<!-- <script type="text/javascript">
		$( document ).ready(function() {
			$("#country").val("<?php// echo $r->country; ?>");
			print_state('state',$("#country option:selected").index());
			$("#state").val("<?php//echo $r->state?>");
			/*$('#dpYears').datepicker();*/
		});
	</script> -->
    <script type="text/javascript">
function myfunc(cid){
	$('#msg'+cid).toggle();
	$('#des'+cid).toggle();
	

}
function popmyfunc(cid){
	$('#popmsg'+cid).toggle();
	$('#popdes'+cid).toggle();
	

}

function likefun(pid,uid,count){
	var posted_by=pid;
	var user_id=uid;
	url="<?php echo base_url();?>signg_in/insertlinks/"+pid+"/"+uid;
	  $.ajax({
        type: "POST",
        url: url,
        data: { liked_by: pid, like_on : uid} ,
        success: function(html)
        {   
			info = JSON.parse(html);
         if(info.like_status == 'N'){
		 	//$("#like_ajax"+pid).html("Unlike");
			$("#link_like"+pid).html("Like");
		    $("#like_count"+pid).html('<img src="<?php echo base_url(); ?>images/like_myphotos.png" alt="">&nbsp;'+(info.like_count-1)+'&nbsp;&nbsp;');

		 }			
		  else{
			//$("#like_ajax"+pid).html("Like");
			$("#link_like"+pid).html("Unlike");
	        $("#like_count"+pid).html('<img src="<?php echo base_url(); ?>images/like_myphotos.png" alt="">&nbsp;'+(info.like_count+1)+'&nbsp;&nbsp;');

		  }
        }
       });	
}

function commentlikefun(pid,uid,count){
	var posted_by=pid;
	var user_id=uid;
	url="<?php echo base_url();?>signg_in/commentinsertlinks/"+pid+"/"+uid;
	  $.ajax({
        type: "POST",
        url: url,
        data: { liked_by: pid, like_on : uid} ,
        success: function(html)
        {   
			info = JSON.parse(html);
         if(info.like_status == 'N'){
		 	//$("#like_ajax"+pid).html("Unlike");
			$("#cmt_link_like"+pid).html("Like");
		    $("#cmt_like_count"+pid).html('<img src="<?php echo base_url(); ?>images/like_myphotos.png" alt="">&nbsp;'+(info.like_count-1)+'&nbsp;&nbsp;');

		 }			
		  else{
			//$("#like_ajax"+pid).html("Like");
			$("#cmt_link_like"+pid).html("Unlike");
	        $("#cmt_like_count"+pid).html('<img src="<?php echo base_url(); ?>images/like_myphotos.png" alt="">&nbsp;'+(info.like_count+1)+'&nbsp;&nbsp;');

		  }
        }
       });	
}


function cmplikefun(pid,uid,count){
	var posted_by=pid;
	var user_id=uid;
	url="<?php echo base_url();?>signg_in/insertcmplikes/"+pid+"/"+uid;
	  $.ajax({
        type: "POST",
        url: url,
        data: { liked_by: pid, like_on : uid} ,
        success: function(html)
        {   
			info = JSON.parse(html);
         if(info.like_status == 'N'){
		 	//$("#like_ajax"+pid).html("Unlike");
			$("#link_like"+pid).html("Like");
		    $("#like_count"+pid).html(info.like_count-1);

		 }			
		  else{
			//$("#like_ajax"+pid).html("Like");
			$("#link_like"+pid).html("Unlike");
	        $("#like_count"+pid).html(info.like_count+1);

		  }
        }
       });	
}
function saveAsFav(pid){
	
	url="<?php echo base_url();?>signg_in/saveasfav/"+pid;
	  $.ajax({
        type: "POST",
        url: url,
        data: { liked_by: pid } ,
        success: function(html)
        {   
			alert('saved favorite successfully');
        }
       });	
}

function view_comments(id){
	$('#res_comments'+id).hide();
	$('#res_comments_viewmore'+id).show();
}



 
    $('#grp_add').click(function(){
        $('#select-from option:selected').each( function() {
                $('#select-to').append("<option value='"+$(this).val()+"'>"+$(this).text()+"</option>");
            $(this).remove();
        });
    });
    $('#grp_remove').click(function(){
        $('#select-to option:selected').each( function() {
            $('#select-from').append("<option value='"+$(this).val()+"'>"+$(this).text()+"</option>");
            $(this).remove();
        });
    });
 

 // ajax call for get friends list on add group button click
/*
	 $('#grp_list').change(function(){
     id = $(this).val();
	 url="<?php echo base_url() ?>profile/get_grp_friends/"+id;
	 $.post( url )
			.done(function( data ) 
			{	
			
			$("#select_frm").html(data);
	    });
			return false;
	});
	
	
	 $(document).ready(function(){
     id = $(this).val();
	 url="<?php echo base_url() ?>profile/get_friends/";
	 $.post( url )
			.done(function( data ) 
			{	
			
			$("#select_frm").html(data);
			$("#select-from").removeAttr("multiple");
	    });
			return false;
	});
*/


//ajax for profile pic upload
/*
$(function() {
	$('#upload_file').submit(function(e) {
		url ="<?php echo base_url(); ?>profile/do_upload/";
		e.preventDefault();
		$.ajaxFileUpload({
			url 			:url, 
			secureuri		:false,
			fileElementId	:'userfile',
			dataType		: 'json',
			data			: {	},
			success	: function (data, status)
			{
				if(data.status != 'error')
				{
					$('#status').html('<p>Reloading files...</p>');
					refresh_files();
				}
				alert(data.msg);
			}
		});
		return false;
	});
});
*/
function acceptFrnd(id)
{
	$("#pend_frnd_accept"+id).html('<img src="<?php echo base_url(); ?>images/addfrnd_loader.gif" />');
		url="<?php echo base_url(); ?>friends/confirmrequest/"+id;
		$.ajax({
        type: "POST",
        url: url,
        success: function(data)
        {   
			$("#pendingReqUl").html(data);
			location.reload();
		},
		cache: false
		});
		
}

function denyFrnd(id)
{
	$("#pend_frnd_deny"+id).html('<img src="<?php echo base_url(); ?>images/follow_loader.gif" />');
		url="<?php echo base_url(); ?>friends/denyrequest/"+id;
		$.ajax({
        type: "POST",
        url: url,
        success: function(data)
        {   
			$("#pendingReqUl").html(data);
			location.reload();
		},
		cache: false
		});
		
}

function blockFrnd(id)
{
	$("#pend_frnd_block"+id).html('<img src="<?php echo base_url(); ?>images/block_loader.gif" />');
		url="<?php echo base_url(); ?>friends/blockrequest/"+id;
		$.ajax({
        type: "POST",
        url: url,
        success: function(data)
        {   
			$("#pendingReqUl").html(data);
			location.reload();
		},
		cache: false
		});
		
}

function addFrnd(id)
{
	$("#sidebar_addfrnd"+id).html('<img src="<?php echo base_url(); ?>images/addfrnd_loader.gif" />');
		url="<?php echo base_url(); ?>friends/addFriend/"+id;
		$.ajax({
        type: "POST",
        url: url,
        success: function(data)
        {   
			$("#add_friends").html(data);
		},
		cache: false
		});
		
}

function addSearchFrnd(id)
{
		url="<?php echo base_url(); ?>friends/addFriendFromSearch/"+id;
		$.ajax({
        type: "POST",
        url: url,
        success: function(data)
        {   
			$('#addFrnd'+id ).text('Request Sent');
		},
		cache: false
		});
		
}

function addFollowerFrnd(id)
{
		url="<?php echo base_url(); ?>friends/addFriendFromFollowers/"+id;
		$.ajax({
        type: "POST",
        url: url,
        success: function(data)
        {   
			$('#addFrnd'+id).text('Request Sent');
		},
		cache: false
		});
		
}

function cmpFollowPage(id)
{
	var value = $('#follow-btn').prop('value');
	var option = $('#follow_option').val();
	urlfollow="<?php echo base_url(); ?>company/cmp_view_follow/"+id+"/"+option;
	urlunfollow="<?php echo base_url(); ?>company/cmp_view_unfollow/"+id+"/"+option;
	if(value == 'Follow')
	{
		$.ajax({
        type: "POST",
        url: urlfollow
		}).done(function(){
		$(this).hide();	
      $('#unfollow-btn').show();
	  $('#followModal').modal('toggle');
	   location.reload();
		});
		
	}else{
		$.ajax({
        type: "POST",
        url: urlunfollow
		}).done(function(){
			
       $('#follow-btn').show();
		location.reload();
		});
		
	}
}



function acceptFollow(user_id,cmp_id)
{
	url="<?php echo base_url(); ?>company/cmp_follow_req_accept/"+user_id+"/"+cmp_id;
		$.ajax({
        type: "POST",
        url: url,
        success: function(data)
        {   
			$("#pendingReqUl").html(data);
		},
		cache: false
		});
}

function denyFollow(user_id,cmp_id)
{
	url="<?php echo base_url(); ?>company/cmp_follow_req_deny/"+user_id+"/"+cmp_id;
		$.ajax({
        type: "POST",
        url: url,
        success: function(data)
        {   
			$("#pendingReqUl").html(data);
		},
		cache: false
		});
}

function cmpFollow(comp_id)
{
		
	 
$("#sidebar_follow"+comp_id).html('<img src="<?php echo base_url(); ?>images/follow_loader.gif" />');
    $('#followModal1').modal('toggle');
	
	$('#follow_modal_btn').click(function()
	{
	
	var option = $('#follow_as').val();
	url="<?php echo base_url(); ?>company/cmp_follow/"+option+"/"+comp_id;
		$.ajax({
        type: "POST",
        url: url,
        success: function(data)
        {  
		$('#followModal1').modal('toggle'); 
	    $("#cmpfollowers").html(data);
		//$("#sidebar_follow").hide();
		},
		cache: false
		});
	});
	
	
	
	$('.btn').click(function()
	{
		if($("#followModal1").is(':visible'))
		 { 
 		 $("#sidebar_follow"+comp_id).text('Follow');
		}else{
		$("#sidebar_follow"+comp_id).html('<img src="<?php echo base_url(); ?>images/follow_loader.gif" />');
		}
	});
	
	
	
	$('.close').click(function()
	{
		if($("#followModal1").is(':visible'))
		 { 
 		 $("#sidebar_follow"+comp_id).text('Follow');
		}else{
		$("#sidebar_follow"+comp_id).html('<img src="<?php echo base_url(); ?>images/follow_loader.gif" />');
		}
	});
	
}




function saveGroup()
{
	var list_of_members ='';
	var name = $('#grpname').val();
	 $('#select-to option').each( function() {
		 	 list_of_members += $(this).val()+",";
        });
		list_of_members = list_of_members.substring(0, list_of_members.length - 1);
		url="<?php echo base_url(); ?>profile/creategroup/";
		$.ajax({
        type: "POST",
        url: url,
		data: { grp_name: name,members: list_of_members} ,
        success: function(data)
        {   
			var redirect_url = "<?php echo base_url(); ?>"+'profile/addgroup';
			window.location.replace(redirect_url);
		},
		cache: false
		});
		
}

function updateGroup(group_id)
{
	var list_of_members ='';
	var name = $('#grpname').val();
	 $('#select-to option').each( function() {
		 	 list_of_members += $(this).val()+",";
        });
		list_of_members = list_of_members.substring(0, list_of_members.length - 1);
		
		url="<?php echo base_url(); ?>profile/updategroup/";
		$.ajax({
        type: "POST",
        url: url,
		data: { grp_name: name,members: list_of_members,group_id:group_id} ,
        success: function(data)
        {   
			var redirect_url = "<?php echo base_url(); ?>"+'profile/groups';
			window.location.replace(redirect_url);
		},
		cache: false
		});
		
}

/*function searchgroups()
{
	alert('hi');
	url="<?php echo base_url(); ?>profile/groups/";
		$.ajax({
        type: "POST",
        url: url,
        success: function(data)
        {   
			alert('hi');
			//var redirect_url = "<?php echo base_url(); ?>"+'profile/groups';
			//window.location.replace(redirect_url);
		},
		cache: false
		});
}*/
function searchformsubmit()
{
	document.getElementById("groupssearchform").submit();
}
function addeducation()
{
	$("input[name=field_of_study]").val('');
	$("input[name=college_institution]").val('');
	$("input[name=degree_certificate]").val('');
	$("textarea[name=special_studies]").val('');						
	$("select[name=year_attended_from]").val(0);
	$("select[name=month_attended_from]").val(0);
	$("select[name=year_attended_to]").val(0);
	$("select[name=month_attended_to]").val(0);
	$("#edu_action").val('add');
	$("#eduformerrors").html('');
}
function addexp()
{
	$("input[name=job_title]").val('');
	$("select[name=year_attended_from]").val(0);
	$("select[name=month_attended_from]").val(0);
	$("select[name=year_attended_to]").val(0);
	$("select[name=month_attended_to]").val(0);
	$("textarea[name=job_description]").val('');
	$("#prof_action").val('add');
	$("#proformerrors").html('');
	
}
function addorg()
{
	$("input[name=org_name]").val('');
	$("input[name=position]").val('');
	$("textarea[name=org_description]").val('');
	$("select[name=year_attended_from]").val(0);
	$("select[name=month_attended_from]").val(0);
	$("select[name=year_attended_to]").val(0);
	$("select[name=month_attended_to]").val(0);
	$("select[name=emp_status]").val('wor');
	$("#org_action").val('add');
	$("#orgformerrors").html('');
}
function addgroup()
{
		$("input[name=group_name]").val('');
		$("input[name=group_type]").val('');
		$("input[name=website_url]").val('');
		$("input[name=city]").val('');
		$("select[name=state]").val(0);
		$("input[name=postal_code]").val('');
		$("textarea[name=additional_info]").val('');
		$("#grp_action").val('add');
		$("#grpformerrors").html('');
}
function validateCompanyForm()
{
	var error_msg ='';
	if(validatefileupload('fileupload'))
	{
	     error_msg +='';
	}
	else 
	{
	 	error_msg +="Please check file format\n";
	}
	if(document.getElementById('cmp_name') != '')
	{
	     error_msg +='';
	}
	else 
	{
	 	error_msg +="Company Name Not Valid\n";
	}
	if(isSelected('cmp_industry'))
	{
	     error_msg +='';
	}
	else 
	{
	 	error_msg +="Please select industry type\n";
	}
	if(isSelected('cmp_estb'))
	{
	     error_msg +='';
	}
	else 
	{
	 	error_msg +="Please select an year when the company is established\n";
	}
	if(isNumber('cmp_colleagues'))
	{
	     error_msg +='';
	}
	else 
	{
	 	error_msg +="Please specify the no of employees in the company\n";
	}
	if(error_msg!='')
	{
	alert(error_msg);
	return false
	}
	else
	return true;
	
}
function validatefileupload(file_id)
{
	var fup = document.getElementById(file_id);
	var fileName = fup.value;
	var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
	if(ext == "gif" || ext == "GIF" || ext == "JPEG" || ext == "jpeg" || ext == "jpg" || ext == "JPG" || ext == "doc")
	{
		return true;
	} 
	else
	{
		return false;
	}
}
function isAlphaNum(field_id)
{
	var value = document.getElementById(field_id).value;
	var Exp = /^[0-9a-z]+$/;
	if(!value.match(Exp))
	return false;
	else
	return true;
}
function isSelected(field_id)
{
	var value = document.getElementById(field_id).value;	
	if(value==0)
	return false;
	else
	return true;
}
function isNumber(field_id)
{
	var value = document.getElementById(field_id).value;	
	if(isNaN(value))
	return false;
	else
	return true;
}

	
	
/*	$("#company_form").submit(function( event ){
     url = "<?php // echo base_url(); ?>company/addcompany/";
  				   $.post(url, { formdata: $(this).serialize() })
					.done(function( data ) {
						   	if(data == false)
							alert("Please Enter Valid Details");
						else
						{
							alert("details are stored");		
						}
					});
					event.preventDefault();
});
});*/
function getconversations(msg_id,sent_by)
{
 url="<?php echo base_url(); ?>message/getconversations/"+msg_id+'/'+sent_by;
  $.ajax({
        type: "POST",
        url: url,
        success: function(data)
        {   
   $("#message_conversation_content").html(data);
  },
  cache: false
  });
}
function getPostComments(post_id)
{
 url="<?php echo base_url(); ?>customer/getpostcomments/"+post_id;
  $.ajax({
        type: "POST",
        url: url,
        success: function(data)
        {   
   $(".fbphotobox-image-content").html(data);
  },
  cache: false
  });
}

/* fuction to mark as read and mark un-read */

function  onchangeMore(){
	var val = [];
        $(':checkbox:checked').each(function(i){
          val[i] = $(this).val();
        });
		var text='';
		for	(index = 0; index < val.length; index++) {
		text += val[index]+'-';
		} 
		var selectedval = $('#more').val();
		if(text!='' && selectedval!=0){
		
		if(selectedval==1)
		url="<?php echo base_url(); ?>message/markasreadselectedmsgs/"+text;
		else if(selectedval == 2)
		url="<?php echo base_url(); ?>message/markasunreadselectedmsgs/"+text;

		  $.ajax({
				type: "POST",
				url: url,
				success: function(data)
				{   
		   	var redirect_url = "<?php echo base_url(); ?>"+'profile/message';
			window.location.replace(redirect_url);
		  },
		  cache: false
		  });
		}
		else{
			alert('Please select the checkbox to apply action')
		}
}
   /*	 
	 $.post( url, { formdata: $(this).serialize() })
     
 .done(function( data ) {
         if(data == false)
       alert("hi");
      else
       $(".comperrormsg").html(data);
       $('#company_form').trigger("reset");
       //$('#orgModal').modal('toggle');
//       organization_edit();*/
      // });  
//}
//function validateEduForm()
//{	
//	if($("#year_attended_from").val()==0 || $("#month_attended_from").val()==0 || $("#year_attended_to").val()==0 || $("#month_attended_to").val()==0 || $("#field_of_study").val()=='' || $("#college_institution").val()=='' || $("#degree_certificate").val()=='')
//	{
//	$("#eduformerrors").html("Fields with '*' are mandatory, Please fill them...");
//	}
//}

 $(function(){
      $('#delmsgbtn').click(function(){
        var val = [];
        $(':checkbox:checked').each(function(i){
          val[i] = $(this).val();
        });
		var text='';
		for	(index = 0; index < val.length; index++) {
		text += val[index]+'-';
		} 
		if(text!=''){
		 url="<?php echo base_url(); ?>message/deleteselectedmsgs/"+text;
		  $.ajax({
				type: "POST",
				url: url,
				success: function(data)
				{   
		   	var redirect_url = "<?php echo base_url(); ?>"+'profile/message';
			window.location.replace(redirect_url);
		  },
		  cache: false
		  });
		}
		else{
		alert('Please select the checkbox you wish to delete')
		}
      });
    });
	 $(function(){
      $('#delsentselect').click(function(){
        var val = [];
        $(':checkbox:checked').each(function(i){
          val[i] = $(this).val();
        });
		var text='';
		for	(index = 0; index < val.length; index++) {
		text += val[index]+'-';
		} 
		 url="<?php echo base_url(); ?>message/deletesentselectedmsgs/"+text;
		  $.ajax({
				type: "POST",
				url: url,
				success: function(data)
				{   
		   	var redirect_url = "<?php echo base_url(); ?>"+'profile/sent';
			window.location.replace(redirect_url);
		  },
		  cache: false
		  });
      });
    });
	 $(function(){
      $('#deletetrash').click(function(){
        var val = [];
        $(':checkbox:checked').each(function(i){
          val[i] = $(this).val();
        });
		var text='';
		for	(index = 0; index < val.length; index++) {
		text += val[index]+'-';
		} 
		 url="<?php echo base_url(); ?>message/deletetrashmsgs/"+text;
		  $.ajax({
				type: "POST",
				url: url,
				success: function(data)
				{   
		   	var redirect_url = "<?php echo base_url(); ?>"+'profile/trash';
			window.location.replace(redirect_url);
		  },
		  cache: false
		  });
      });
    });
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>cropimage/js/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>cropimage/js/jquery.imgareaselect.js"></script>

<script type="text/javascript" >
	// image croping function for profile settings page--> Start
	
	 $(document).ready(function() {
        $('#userpropicbtn').click(function() {
            $("#viewimage").html('');
            $("#loadingimage").html('<img src="<?php echo base_url(); ?>cropimage/images/loading.gif" />');
            $(".ppuploadform").ajaxForm({
            	url: '<?php echo base_url(); ?>profile/upload_thumb',
                success:    showResUser 
            });
        });
    });
  
    function showResUser(responseText, statusText, xhr, $form){
		
	    if(responseText.indexOf('.')>0){
			$("#loadingimage").html('');
			$('.crop_set_preview').show();
			$('.crop_box').height(350);
			$('#thumbviewimage').html('<img src="<?php echo base_url().$upload_path;?>'+responseText.trim()+'"   style="position: relative;" alt="Thumbnail Preview" />');
	    	$('#viewimage').html('<img class="preview" alt="" src="<?php echo base_url().$upload_path; ?>'+responseText.trim()+'"   id="thumbnail" />');
	    	$('#filename').val(responseText.trim()); 
			$('#thumbnail').imgAreaSelect({  aspectRatio: '1:1', handles: true  , onSelectChange: preview });
		}else{
			alert('please select file first');
			$('#thumbviewimage').html(responseText.trim());
	    	$('#viewimage').html(responseText.trim());
		}
    }
	// image croping function for profile settings page--> End
	
    $(document).ready(function() {
        $('#submitbtn').click(function() {
            $("#viewimage").html('');
            $("#loadingimage").html('<img src="<?php echo base_url(); ?>cropimage/images/loading.gif" />');
            $(".uploadform").ajaxForm({
            	url: '<?php echo base_url(); ?>profile/upload_thumb',
                success:    showResponse 
            });
        });
    });
  
    function showResponse(responseText, statusText, xhr, $form){
		
	    if(responseText.indexOf('.')>0){
			$("#loadingimage").html('');
			$('.crop_set_preview').show();
			$('.crop_box').height(350);
			$('#thumbviewimage').html('<img src="<?php echo base_url().$upload_path;?>'+responseText.trim()+'"   style="position: relative;" alt="Thumbnail Preview" />');
	    	$('#viewimage').html('<img class="preview" alt="" src="<?php echo base_url().$upload_path; ?>'+responseText.trim()+'"   id="thumbnail" />');
	    	$('#filename').val(responseText.trim()); 
			$('#thumbnail').imgAreaSelect({  aspectRatio: '1:1', handles: true  , onSelectChange: preview });
		}else{
			alert('please select file first');
			$('#thumbviewimage').html(responseText.trim());
	    	$('#viewimage').html(responseText.trim());
		}
    }
      $(document).ready(function() {
        $('#userfile').change(function() {
			$(".uploadvideoform").ajaxForm({
            	url: '<?php echo base_url(); ?>profile/add_video',
			    success:    showVideoResponse 
            }).submit();
			
        });
    });
	function showVideoResponse(responsetxt)
	{
		if(responsetxt)
		{
		    alert(responsetxt);
		    var redirect_url = "<?php echo base_url(); ?>"+'profile/my_photos';
			window.location.replace(redirect_url);
		}
	}
</script>

<script type="text/javascript">
function preview(img, selection) { 
	var scaleX = <?php echo $thumb_width;?> / selection.width; 
	var scaleY = <?php echo $thumb_height;?> / selection.height; 

	$('#thumbviewimage > img').css({
		width: Math.round(scaleX * img.width) + 'px', 
		height: Math.round(scaleY * img.height) + 'px',
		marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px', 
		marginTop: '-' + Math.round(scaleY * selection.y1) + 'px' 
	});
	
	var x1 = Math.round((img.naturalWidth/img.width)*selection.x1);
	var y1 = Math.round((img.naturalHeight/img.height)*selection.y1);
	var x2 = Math.round(x1+selection.width);
	var y2 = Math.round(y1+selection.height);
	
	$('#x1').val(x1);
	$('#y1').val(y1);
	$('#x2').val(x2);
	$('#y2').val(y2);	
	
	$('#w').val(Math.round((img.naturalWidth/img.width)*selection.width));
	$('#h').val(Math.round((img.naturalHeight/img.height)*selection.height));
	
} 

$(document).ready(function () { 
	$('#save_thumb').click(function() {
		var x1 = $('#x1').val();
		var y1 = $('#y1').val();
		var x2 = $('#x2').val();
		var y2 = $('#y2').val();
		var w = $('#w').val();
		var h = $('#h').val();
		if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
			alert("Please Make a Selection First");
			return false;
		}else{
			return true;
		}
	});
}); 

$('#addJobForm').submit( function( event){
						
					var errors = '';
					if($("#job_title").val()=='' || $("#job_type").val()=="" || $("#job_category").val()==0 || $("#job_salary").val()=='' || $("#salary_basis").val()=='' || $("#job_keywords").val()=='' || $("#job_company_name").val()=='' || $("#cont_name").val()=='' || $("#cont_email").val()=='' || $("#job_desc").val()=='' || $("#req_skills").val()==''  )
					{
						
						$("#jobformerrors").html("Fields with '*' are mandatory, Please fill them...");
					}
					else if(!ValidateEmail($("#cont_email").val()))
					{
						$("#jobformerrors").html("Email you have entered not valid");
					}
					else
					{	
					
					url="<?php echo base_url(); ?>jobs/create_job/";
					$.post( url, { formdata: $(this).serialize()})
					.done(function( data ) {
						if(data == false)
						alert("Please Enter Valid Details");
						else
						$(".joblisting").html(data);
						$('#addJobForm').trigger("reset");
						$( "#canceladdjob" ).trigger( "click" );
					});
					}
					event.preventDefault();
				});
				function ValidateEmail(email) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
    };
	
	function movetogroup(userid,selectedvalue)
	{
		if(selectedvalue!=0)
		{
		url="<?php echo base_url(); ?>friends/movefriend/"+userid+'/'+selectedvalue;
					$.post( url )
					.done(function( data ) {
						if(data)
						alert(data);
						
					});
		}
	}
	
$('#pfpic').change(function()
{
	$('#upload_pfpic').ajaxSubmit();
	//$(".cmplogo").html(data);
	location.reload(true);
});	
</script>

<script language="javascript" type="text/javascript">
window.onload = function () {
    var fileUpload = document.getElementById("uploadPhotos");
    fileUpload.onchange = function () {
        if (typeof (FileReader) != "undefined") {
            var dvPreview = document.getElementById("uploadPhotosdvPreview");
            dvPreview.innerHTML = "";
            var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
            for (var i = 0; i < fileUpload.files.length; i++) {
                var file = fileUpload.files[i];
                if (regex.test(file.name.toLowerCase())) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var img = document.createElement("IMG");
                        img.height = "110";
                        img.width = "110";
                        img.src = e.target.result;
                        dvPreview.appendChild(img);
                    }
                    reader.readAsDataURL(file);
                } else {
                    alert(file.name + " is not a valid image file.");
                    dvPreview.innerHTML = "";
                    return false;
                }
            }
        } else {
            alert("This browser does not support HTML5 FileReader.");
        }
    }
};

// share post function START - by vijay on 02-04-15 

function sharePost(post_id){
	url="<?php echo base_url(); ?>profile/get_post_byid/"+post_id;
					$.post( url )
					.done(function( data ) {
						$('#sharePostPopup').html(data);
						
					});
}
function shareCmpPost(post_id){
	url="<?php echo base_url(); ?>profile/get_cmp_post_byid/"+post_id;
					$.post( url )
					.done(function( data ) {
						$('#sharePostPopup').html(data);
						
					});
}



	$('#sharePostBtn').click(function() {
		
		document.getElementById('share_form').submit(); return false;
		});


// Share post function END

//cmp_privacy form & email notifications updatte by sp

	$("form[name=about_cmp]").submit(function(event){
		alert("hai");
			   url="<?php echo base_url();?>company/updateabout/<?php echo $this->uri->segment(3,0) ?>";
				 $.ajax({
        			type: "POST",
			        url: url,
			        data: { form_data: $(this).serialize()} ,
        			success: function(html)
			        {   
            			if(html == true)
							alert("Information Updated");
						else
							alert("Something went wrong Please try after sometime");
			        }
			       });			
				event.preventDefault();
			});

$("#cmp_privacy_form").submit(function( event ){
					 url="<?php echo base_url();?>company/updateprivacy/<?php echo $this->uri->segment(3,0); ?>";
					$.post( url, { formdata: $(this).serialize() })
					.done(function( data ) {
					   	if(data == true)
							alert("Information Updated");
						else
							alert("Something Went wrong please try again after sometime");
					  });
					event.preventDefault();
			});
			
	$("#cmp_emailnotification").submit(function( event ){
				url="<?php echo base_url();?>company/updateemailnotification/<?php echo $this->uri->segment(3,0); ?>";
				$.post( url, { formdata: $(this).serialize() })
					.done(function( data ) {
					   	if(data == true)
							alert("Information Updated");
						else
							alert("Something Went wrong please try again after sometime");
					  });
					event.preventDefault();
			});			
$("form[name=cmp_postboard]").submit(function(event){
			   url="<?php echo base_url();?>company/postboard_update/<?php echo $this->uri->segment(3,0); ?>";
				 $.ajax({
        			type: "POST",
			        url: url,
			        data: { form_data: $(this).serialize()} ,
        			success: function(html)
			        {   
            			alert("Information Updated");
						
			        }
			       });			
				event.preventDefault();
			});	
			
			// add field function start
			
			function addField(fieldname)
			{
				var placeholder = fieldname.split('-');
				var placeholdertext = '';
				var h3content = $('#'+fieldname+'-li h3').html();
				for(i=0;i<placeholder.length;i++)
				{ 
					placeholdertext += placeholder[i]+' '; 
				}
				$('#'+fieldname+'-li').html("<form action='javascript:void(0)' onsubmit='addfieldSubmit(&#39;"+fieldname+"&#39;&#44;&#39;"+h3content+"&#39;); return false;' method='post'><input class='form-control' type='text' id='"+fieldname+"' name='"+fieldname+"' placeholder='add "+placeholdertext+"'/>");
			}
			function addWork(fieldname)
			{
				$('.data_fileds').hide();
				$('#'+fieldname+'-li .graphic').show();
				//var placeholder = fieldname.split('-');
//				var placeholdertext = '';
//				var h3content = $('#'+fieldname+'-li h3').html();
//				for(i=0;i<placeholder.length;i++)
//				{ 
//					placeholdertext += placeholder[i]+' '; 
//				}
//				$('#'+fieldname+'-li').html("<form action='javascript:void(0)' onsubmit='addfieldSubmit(&#39;"+fieldname+"&#39;&#44;&#39;"+h3content+"&#39;); return false;' method='post'><input class='form-control' type='text' id='"+fieldname+"' name='"+fieldname+"' placeholder='add "+placeholdertext+"'/>");
			}
			function addfieldSubmit(fieldname,h3content)
			{
				var fieldvalue = $('#'+fieldname).val();
				
				url="<?php echo base_url();?>profile/updatefield/";
				 $.ajax({
        			type: "POST",
			        url: url,
			        data: { field_name:fieldname,field_value: fieldvalue} ,
        			success: function(html)
			        {   
						var data = 
                        "<div class='inner_rights'>"+
                          "<h3>"+h3content+"</h3><p>"+fieldvalue+"<a href='javascript:void(0)' onclick='addField(&#39;"+fieldname+"&#39;)'> edit</a></p></div>"+
                        "<div class='clearfix'></div>";
						$('#'+fieldname+'-li').html(data);
			        }
					
			       });			
				//event.preventDefault();
			}
			// add field function end	
			function addWorkPlace()
			{
				var orgname = $('#org_name').val();
				var position = $('#position').val();
							
				url="<?php echo base_url();?>profile/addworkplace/";
				 $.ajax({
        			type: "POST",
			        url: url,
			        data: { org_name:orgname,position: position} ,
        			success: function(html)
			        {   
						var prev_cont = $('#profession-li .data_fileds').html();
						//var data = "<p>"+position+" at "+orgname+" <a href='javascript:void(0)' onclick='editWorkPlace()' >Edit</a></p>"
                        $('#profession-li .data_fileds').html(prev_cont+html);
						$('#profession-li .graphic').hide();
					    $('#profession-li .data_fileds').show();
			        }
					
			       });			
				//event.preventDefault();
			}
			function editWorkPlace(orgid)
			{				
				url="<?php echo base_url();?>profile/editworkplace/";
				 $.ajax({
        			type: "POST",
			        url: url,
			        data: { org_id:orgid} ,
        			success: function(html)
			        {   
                       
						$('#paragraph'+orgid).html(html);
					    
			        }
					
			       });			
				//event.preventDefault();
			}
			function updateWorkPlace(paragraphid)
			{
				var orgname = $('#org_name').val();
				var position = $('#position').val();
							
				url="<?php echo base_url();?>profile/updateworkplace/";
				 $.ajax({
        			type: "POST",
			        url: url,
			        data: { org_name:orgname,position: position,org_id: paragraphid} ,
        			success: function(html)
			        {   
						//var prev_cont = $('#profession-li .data_fileds').html();
						var data = position+" at "+orgname+" <a href='javascript:void(0)' onclick='editWorkPlace("+paragraphid+")' >edit</a>"
                        $('#paragraph'+paragraphid).html(data);
						/*$('#profession-li .graphic').hide();
					    $('#profession-li .data_fileds').show();*/
			        }
					
			       });			
				//event.preventDefault();
			}
			function canceladdWork(){
				 $('#profession-li .data_fileds').show();
				 $('#profession-li .graphic').hide();
			}
			function canceleditWork(orgname,pos,orgid){
				 var data = pos+" at "+orgname+" <a href='javascript:void(0)' onclick='editWorkPlace("+orgid+")' >edit</a>"
				 $('#paragraph'+orgid).html(data);
			}
			
//search friends functionality by sp on 10-4-2015
$('#search_frnds').keyup(function(){
	var value = $('#search_frnds').val();
	var length = value.length;
	var errors = '';
	if(value == '') 
	{
		$("#error_data").html("Search Field Shouldn't be empty").fadeOut(7000);
		location.reload();
	}
	/*if(length < 1) 
	{
		$("#error_data").html("provide more letters to Search").fadeOut(7000);
		location.reload();
	}*/
	else {
		
	url="<?php echo base_url(); ?>friends/search_frnds/"+value;
		$.ajax({
        type: "POST",
        url: url,
        success: function(data)
        {   
			$(".groupEditBlock").html(data);
		},
		cache: false
		});
		
		
	};

});
// Ghost post functionality start
function addfrndtogostpost(user_id,name){
var cur_content = $('#selectedfriends').html();
var new_content = "<span id='"+user_id+"'>"+name+"<a onclick='removefrnd("+user_id+")'><img class='as_close_btn' src='<?php echo base_url().'images/close_btn.png'; ?>'/></a></span>";
 $('#selectedfriends').html(new_content+cur_content);
 $('#searchfriends').focus();
 $('#autosuggest').hide();
var addedusers = $('#addedusers').val()
if(addedusers!='')
$('#addedusers').val(addedusers+','+user_id)
else
$('#addedusers').val(user_id)

}
function removefrnd(user_id){
	var addedusers = $('#addedusers').val();
	var len = addedusers.length;
	var newval = '';
	if(len==1)
	{ 
		newval = '';
	}
	else if(addedusers.indexOf(user_id)==(len-1)){
	newval = addedusers.replace(','+user_id,'');
	}
	else if(addedusers.indexOf(user_id)==0)
	newval = addedusers.replace(user_id+',','');
	else
	newval = addedusers.replace(user_id+',','');
	$('#addedusers').val(newval);
	$('#'+user_id).remove();
}
function keyupevent(){
	var value = $('#searchfriends').val();
	var addedusers = $('#addedusers').val();
	if(value!='')
	{	
	url="<?php echo base_url(); ?>friends/getfriendsuggestion/"+value+"/"+addedusers;
		$.ajax({
        type: "POST",
        url: url,
        success: function(data)
        {   
			if(data){
			$('#autosuggest').html(data);
			$('#autosuggest').show();
			}
		},
		cache: false
		});
	}
	else{ $('#autosuggest').hide(); }
}
function showghostinput(){
	$('#selectedfriends').toggle();
	$('#searchfriends').focus();
}
// ghost post functionality end

//business card ghostpost
function keyupevent_bc(){
	var value = $('#search_bc_friends').val();
	var addedusers = $('#added_bc_users').val();
	if(value!='')
	{	
	url="<?php echo base_url(); ?>friends/getfriend_bc_suggestion/"+value+"/"+addedusers;
		$.ajax({
        type: "POST",
        url: url,
        success: function(data)
        {   
			if(data){
			$('#auto_bc_suggest').html(data);
			$('#auto_bc_suggest').show();
			}
		},
		cache: false
		});
	}
	else{ $('#auto_bc_suggest').hide(); }
}

function addfrndtobcpost(user_id,name){
var cur_content = $('#selected_bc_friends').html();
var new_content = "<span  class='bc_mail_ids' id='"+user_id+"'>"+name+"<a onclick='removefrnd("+user_id+")'><img class='as_close_btn' src='<?php echo base_url().'images/close_post.png'; ?>'/></a></span>";
 $('#selected_bc_friends').html(new_content+cur_content);
 $('#search_bc_friends').focus();
 $('#auto_bc_suggest').hide();
var addedusers = $('#added_bc_users').val()
if(addedusers!='')
$('#added_bc_users').val(addedusers+','+user_id)
else
$('#added_bc_users').val(user_id)

}

function removefrnd(user_id){
	var addedusers = $('#added_bc_users').val();
	var len = addedusers.length;
	var newval = '';
	if(len==1)
	{ 
		newval = '';
	}
	else if(addedusers.indexOf(user_id)==(len-1)){
	newval = addedusers.replace(','+user_id,'');
	}
	else if(addedusers.indexOf(user_id)==0)
	newval = addedusers.replace(user_id+',','');
	else
	newval = addedusers.replace(user_id+',','');
	$('#added_bc_users').val(newval);
	$('#'+user_id).remove();
}













/*$('#event_form').submit( function( event)
	{
				
		url="<?php // echo base_url(); ?>events/create_event/";
		$.post( url, { formdata: $(this).serialize()})
		.done(function( data ) {
			if(data == false)
			alert("Please Enter Valid Details");
			else
			$(".joblisting").html(data);
			$('#addJobForm').trigger("reset");
			$( "#canceladdjob" ).trigger( "click" );
			});
			event.preventDefault();
		});*/
		
	// password change from profile settings
$('#pwd_change_btn').click( function()
{
		$('#change_pwd').toggle();
		$(this).hide();
});

$('#select_all_msgs').click(function(event)
{
	if(this.checked)
	{
		$('.all_inbox_msgs').each(function(event)
		{
			if($(this).parent().parent().css("display")!="none")
			this.checked = true;
		});
	}else{
		$('.all_inbox_msgs').each(function(event)
		{
			if($(this).parent().parent().css("display")!="none")
			this.checked = false;
	
		});
	}
});	
$('#select_sent_msgs').click(function(event)
{
	if(this.checked)
	{
		$('.all_sent_msgs').each(function(event)
		{
			if($(this).parent().parent().css("display")!="none")
			this.checked = true;
		});
	}else{
		$('.all_sent_msgs').each(function(event)
		{
			if($(this).parent().parent().css("display")!="none")
			this.checked = false;
	
		});
	}
});	
$('#select_trash_msgs').click(function(event)
{
	if(this.checked)
	{
		$('.all_trash_msgs').each(function(event)
		{
			if($(this).parent().parent().css("display")!="none")
			this.checked = true;
		});
	}else{
		$('.all_sent_msgs').each(function(event)
		{
			if($(this).parent().parent().css("display")!="none")
			this.checked = false;
	
		});
	}
});	

 	
// auto complete for company textbox in aboutme page
 /*$("#org_name").autocomplete({
 	minLength: 1,
 	source: function(req, add){
 		$.ajax({
 			url:'<?php //echo base_url(); ?>company/cmp_name_search/', //Controller where search is performed
 			dataType: 'json',
 			type: 'POST',
 			data: req,
 			success: function(data){
 				if(data){
 				 $('#auto_suggest_company').html(data);
				 $('#auto_suggest_company').show();
 				}
 			}
 		});
 	}
 });*/
	
	
function keyupevent_cmp(){
	var value = $('#org_name').val();
		if(value!='')
	{	
	url="<?php echo base_url(); ?>company/cmp_name_search/"+value;
		$.ajax({
        type: "POST",
        url: url,
        success: function(data)
        {   
			if(data){
			$('#auto_suggest_company').html(data);
			$('#auto_suggest_company').show();
			}
		},
		cache: false
		});
	}
	else{ $('#auto_bc_suggest').hide(); }
}

function addtocmpname(cmpname)
{
	$('input[name="org_name"]').val(cmpname);
	$('#auto_suggest_company').hide();
}


	
$('#searchbar_category li').click(function()
{
	   
	  var category = $(this).attr('id');
	  alert(category);
	  if(this.id == '')
	  {
		  category = 'all';
	  }
	 
	  var search_data = $('#cmp_header_searchbar').val();
	  alert(search_data);
	
	/*  $.ajax({
 			url:"<?php //echo base_url(); ?>company/allSearch/"+search_data+"/"+category; 
 			dataType: 'json',
 			type: 'POST',
 			data: req,
 			success: function(data){
 				//if(data.response =='true'){
 				 $('#org_name').html(data);
 				//}
 			}
 		});*/
	});  
	

	
/*
		$("#sidebar_settings").click(function(event){

						url="<?php //echo base_url(); ?>profile/sidebarEdit/";
						$.post( url )
						.done(function( data ) {
							info = JSON.parse(data);
							alert(data);
								$("input[name=pend_frnd_requests]").attr("checked","checked");
								$("input[name=latest_frnds]").attr("checked","checked");
								$("input[name=your_add_one]").attr("checked","checked");
								$("input[name=add_friends]").attr("checked","checked");
								$("input[name=companies_to_follow]").attr("checked","checked");
								$("input[name=user_following_cmps]").attr("checked","checked");
								$("input[name=companies_im_following]").attr("checked","checked");
								$("input[name=my_companies]").attr("checked","checked");
									
							$('#sidebar_modal').modal('toggle');
						});
						return false;
				});*/
				
				
				
/*$('#cmp_header_searchbar').click({
	
	
		$('#searchbar_category li').click(functon() {
			 alert(this.id);
		});
	//alert(cat);
 	//minLength: 1,
 	/*source: function(req, add){
 		$.ajax({
 			url:'<?php // echo base_url(); ?>company/allSearch/', //Controller where search is performed
 			dataType: 'json',
 			type: 'POST',
 			data: req,
 			success: function(data){
 				//if(data.response =='true'){
 				 $('#org_name').html(data);
 				//}
 			}
 		});
 	}
 

	 
});	*/
	/*function sidebar()
				{
					
	//$('#newone').submit(function(){
		document.forms['newone'].submit();
						
						url="<?php // echo base_url(); ?>customer/sidebarSettings/";
					$.post( url, { formdata: $(this).serialize() })
					.done(function( data ) {
					   	if(data == true)
							alert("Information Updated");
						else
							alert("Something Went wrong please try again after sometime");
					  });
					event.preventDefault();
	//	});
				}*/
</script>
<script>


  $(document).ready(function () {
        // number of records per page
        var pageSize = 2;
        // reset current page counter on load
        $("#hdnActivePage").val(1);
        // calculate number of pages
        var numberOfPages = $('#inbox-message tr').length / pageSize;
		
        numberOfPages = numberOfPages.toFixed();
		if(numberOfPages<1){
			$("a.next").hide();
            $("#next").hide();
		}
        // action on 'next' click
        $("a.next").on('click', function () {
			$('#start').text(parseInt($('#start').text())+pageSize);
			var totalmsgs = $('#totalmsgs').val();
		
			if(parseInt($('#last').text())>totalmsgs)
			var last = totalmsgs;
			else
			var last = parseInt($('#last').text())+1;
			$('#last').text(last);
            // show only the necessary rows based upon activePage and Pagesize
            $("#inbox-message tr:nth-child(-n+" + (($("#hdnActivePage").val() * pageSize) + pageSize) + ")").show();
            $("#inbox-message tr:nth-child(-n+" + $("#hdnActivePage").val() * pageSize + ")").hide();
            var currentPage = Number($("#hdnActivePage").val());
			
            // update activepage
            $("#hdnActivePage").val(Number($("#hdnActivePage").val()) + 1);
			
            // check if previous page button is necessary (not on first page)
            if ($("#hdnActivePage").val() != "1") {
                $("a.previous").show();
                $("#previous").show();
            }
            // check if next page button is necessary (not on last page)
            if ($("#hdnActivePage").val() == numberOfPages) {
				//$('#last').text(parseInt($('#inbox-message tr').length)- parseInt(pageSize*numberOfPages));
                $("a.next").hide();
                $("#next").hide();
            }
        });
        // action on 'previous' click
        $("a.previous").on('click', function () {
			$('#start').text(parseInt($('#start').text())-pageSize);
			$('#last').text(parseInt($('#last').text())-pageSize);
            var currentPage = Number($("#hdnActivePage").val());
            $("#hdnActivePage").val(currentPage - 1);
            // first hide all rows
            $("#inbox-message tr").hide();
            // and only turn on visibility on necessary rows
            $("#inbox-message tr:nth-child(-n+" + ($("#hdnActivePage").val() * pageSize) + ")").show();
            $("#inbox-message tr:nth-child(-n+" + (($("#hdnActivePage").val() * pageSize) - pageSize) + ")").hide();
            // check if previous button is necessary (not on first page)
            if ($("#hdnActivePage").val() == "1") {
                $("a.previous").hide();
                $("#previous").hide();
            } 
            // check if next button is necessary (not on last page)
            if ($("#hdnActivePage").val() < numberOfPages) {
                $("a.next").show();
                $("#next").show();
            } 
            if ($("#hdnActivePage").val() == 1) {
               $("#previous").hide();
            }
        });
    });    
//]]>  

</script>
</script>
<script type="text/javascript">

$(function(){
	$('#swfupload-control').swfupload({
		upload_url: "upload-file.php",
		file_post_name: 'uploadfile',
		file_size_limit : "1024",
		file_types : "*.jpg;*.png;*.gif",
		file_types_description : "Image files",
		file_upload_limit : 5,
		flash_url : "js/swfupload/swfupload.swf",
		button_image_url : 'js/swfupload/wdp_buttons_upload_114x29.png',
		button_width : 114,
		button_height : 29,
		button_placeholder : $('#button')[0],
		debug: false
	})
		.bind('fileQueued', function(event, file){
			var listitem='<li id="'+file.id+'" >'+
				'File: <em>'+file.name+'</em> ('+Math.round(file.size/1024)+' KB) <span class="progressvalue" ></span>'+
				'<div class="progressbar" ><div class="progress" ></div></div>'+
				'<p class="status" >Pending</p>'+
				'<span class="cancel" >&nbsp;</span>'+
				'</li>';
			$('#log').append(listitem);
			$('li#'+file.id+' .cancel').bind('click', function(){
				var swfu = $.swfupload.getInstance('#swfupload-control');
				swfu.cancelUpload(file.id);
				$('li#'+file.id).slideUp('fast');
			});
			// start the upload since it's queued
			$(this).swfupload('startUpload');
		})
		.bind('fileQueueError', function(event, file, errorCode, message){
			alert('Size of the file '+file.name+' is greater than limit');
		})
		.bind('fileDialogComplete', function(event, numFilesSelected, numFilesQueued){
			$('#queuestatus').text('Files Selected: '+numFilesSelected+' / Queued Files: '+numFilesQueued);
		})
		.bind('uploadStart', function(event, file){
			$('#log li#'+file.id).find('p.status').text('Uploading...');
			$('#log li#'+file.id).find('span.progressvalue').text('0%');
			$('#log li#'+file.id).find('span.cancel').hide();
		})
		.bind('uploadProgress', function(event, file, bytesLoaded){
			//Show Progress
			var percentage=Math.round((bytesLoaded/file.size)*100);
			$('#log li#'+file.id).find('div.progress').css('width', percentage+'%');
			$('#log li#'+file.id).find('span.progressvalue').text(percentage+'%');
		})
		.bind('uploadSuccess', function(event, file, serverData){
			var item=$('#log li#'+file.id);
			item.find('div.progress').css('width', '100%');
			item.find('span.progressvalue').text('100%');
			var pathtofile='<a href="uploads/'+file.name+'" target="_blank" >view &raquo;</a>';
			item.addClass('success').find('p.status').html('Done!!! | '+pathtofile);
		})
		.bind('uploadComplete', function(event, file){
			// upload has completed, try the next one in the queue
			$(this).swfupload('startUpload');
		})
	
});	


</script>




<?php /*?>
<style>
.form-mandatory{
color:red;
}
#uploadPhotosdvPreview img{margin-right:5px; }
#sharePostBtn{
	background: #609b34;
  height: 30px;
  font-size: 14px;
  line-height: 30px;
  padding: 0 15px;
  display: inline-block;
  -webkit-border-radius: 2px;
  border-radius: 2px;
  color: #fff;
  font-weight: 300;
}

</style><?php */?>
<script> //current location script
$('#add_currentcity').click(function(){
	$('#add_currentcity2').hide();
	$('#add_currentcity1').hide();
	$('ul.home > #location-li').append($('#currentcity_disp').show());

});



function close_current_city()
 {
	$('#currentcity_disp').hide();
	//$('#hme_town_one').show();
	$('#add_currentcity2').show();
	$('#add_currentcity1').show();
	$('#add_currentcity').show();
	}
	
	
	
function add_current_city()
{
	var currentcity = $('#current_location').val();
	
	url="<?php echo base_url();?>profile/addlocation/";
	 $.ajax({
		type: "POST",
		url: url,
		data: { current_city:currentcity } ,
		success: function(html)
		{   					
			//$('#currentcity_val_disp').show();
			$('#add_currentcity').hide();
			$('ul.home > #location-li').html(html);
		}
		
	   });			
			
	}


function current_city_edit()
	{
		
	$('#currentcity_val_disp').hide();
	$('ul.home > #location-li').append($('#currentcity_disp').show());

	}
	
		
function close_currentcity() {
	$('#currentcity_disp').hide();
	$('#currentcity_val_disp').show();
	
}
</script>
<script> // hometown script
$('#hometown').click(function(){
	$('#hme_town').hide();
	$('#hme_town1').hide();
	$('ul.home > #hometown-li').append($('#hometown_disp').show());

});

function add_home_town()
{
	var hometown = $('#home_town').val();
	url="<?php echo base_url();?>profile/addhometown/";
	 $.ajax({
		type: "POST",
		url: url,
		data: { home_town:hometown } ,
		success: function(html)
		{   					
			$('#hometown-li #hometown_disp').hide();
			$('#hme_town').hide();
			$('#hometown-li').html(html);
		}
		
	   });			
			
	}

	function home_town_edit()
	{
		
	$('#hometown_val_disp').hide();
	$('ul.home > #hometown-li').append($('#hometown_disp').show());

	}
		
function close_home_town() {
	$('#hometown_disp').hide();
	//$('#hme_town_one').show();
	$('#hme_town').show();
	$('#hme_town1').show();
	}
	
function close_home() {
	$('#hometown_disp').hide();
	$('#hometown_val_disp').show();
	
}
</script>
<script> //family member relations script

$('#familymembers').click(function()
{
	$('#add_f_member').hide();
	$('#add_f_member1').hide();
	$('ul.relations > #familymembers-li').append($('#family_relation').show());
//	$('#relation').show();
});

function add_fam_member()
{

	var membername = $('#family_member').val();
	var relation = $('#family_member_type').val();

	url="<?php echo base_url();?>profile/add_fam_members/";
	 $.ajax({
		type: "POST",
		url: url,
		data: { member_name:membername, member_relation:relation } ,
		success: function(html)
		{   		
					
		
			$('#add_f_member').show();
			$('#add_f_member1').show();	
			$('#familymembers-li').html(html);
			
		}
		
	   });			
			
	}
	
	function disp_add_member()
	{
		$('#add_fam_member').show();
		$('#add_f_member').show();
	}
	
	function close_add_family()
	{
		$('#family_relation').hide();
		$('#add_f_member').show();
		$('#add_f_member1').show();	
	}
	
	function close_family()
	{
		$('#family_relation').hide();
		$('#add_f_member').show();
		$('#add_f_member1').show();	
	}

</script>

<script> //about me script
$('#aboutme_a').click(function(){
	//alert('hai');
	$(this).hide();
	$('ul.details_about > #aboutme-li').append($('#aboutme_disp').show());

});

function close_about_me()
{
	$('#aboutme_disp').hide();
	$('#aboutme_a').show();
}


function add_aboutme()
{
	var aboutme = $('#about_me_data').val();
	
	url="<?php echo base_url();?>profile/addaboutme/";
	 $.ajax({
		type: "POST",
		url: url,
		data: { about_me:aboutme } ,
		success: function(html)
		{   
		
			$('#aboutme_disp').hide();
			$('#aboutme_a').hide();
			$('ul.details_about > #aboutme-li').html(html);					
			
		}
		
	   });			
			
	}
function about_me_edit()
{
	$(' #aboutme_val_disp').hide();
	$('ul.details_about > #aboutme-li').append($('#aboutme_disp').show());
	
}

function close_aboutme()
{
	$('#aboutme_disp').hide();
	$('#aboutme_val_disp').show();
}

</script>
<script> //favorite quotes sript
$('#fav_quotes').click(function(){
	//alert('hai');
	$(this).hide();
	$('ul.details_about > #favquotes-li').append($('#fav_quotes_disp').show());

});

function close_favquotes()
{
	$('#fav_quotes_disp').hide();
	$('#favquotes_val_disp').show();
	
}


function add_favquotes()
{
	var favquotes = $('#fav_quotes_data').val();
	
	url="<?php echo base_url();?>profile/addfavquotes/";
	 $.ajax({
		type: "POST",
		url: url,
		data: { fav_quotes:favquotes } ,
		success: function(html)
		{   
		
			$('#fav_quotes_disp').hide();
			$('#fav_quotes').hide();
			$('ul.details_about > #favquotes-li').html(html);					
			
		}
		
	   });			
			
	}
function fav_quotes_edit()
{
	$('#favquotes_val_disp').hide();
	$('ul.details_about > #favquotes-li').append($('#fav_quotes_disp').show());
	
}

function close_fav_quotes()
{
	$('#fav_quotes_disp').hide();
	$('#fav_quotes').show();
}

</script>

<script>

$('#relation_status').click(function()
{
	$('#relation1').hide();
	$('#relation2').hide();
	$('ul.relations > #relation-li').append($('#relation_disp').show());
	
});

function close_relationship()
{
	$('#relation_disp').hide();
	$('#relation1').show();
	$('#relation2').show();
}

function add_relation()
{
	var relation = $('#relation_type').val();
	
	url = "<?php echo base_url(); ?>profile/addrelation/";
	$.ajax({
		type: "POST",
		data: { relation : relation},
		url : url,
		success : function(html)
		{
			$('#relation_disp').hide();
	      	$('ul.relations > #relation-li').html(html);		
		
		
		}
	});
	
}

function edit_relation()
{
	$('#relation').hide();
	$('#relation_disp').show();
}

function close_relation()
{
	$('#relation_disp').hide();
	$('#relation').show();
	
}
</script>
<script>

$('#nic_oth_names').change(function()
{
	var name = $(this).val();
	var placeholder = "whats your " +name+" ?";
	$('#nic_name').prop('placeholder',placeholder);


});

$('#oth_name').click(function()
{
	$(this).hide();
	//$('#other_names').show();
	$('ul.details_about > #nic_names-li').append($('#other_names').show());
});

function close_othernames()
{
	$('#other_names').hide();
	$('#oth_name').show();
}

function add_othernames()
{
	var name_type = $('#nic_oth_names').val();
	var name = $('#nic_name').val();
	
	
		url="<?php echo base_url(); ?>profile/add_nicnames/";
	    $.ajax({
		type: "POST",
		url: url,
		data: { name:name, name_type:name_type } ,
		success: function(html)
		{   		
					
		
			$('#other_names').hide();
		    //$('#oth_name').show();
			$('#nic_names-li').html(html);
		}
		
	   });
}

function close_other_names()
{
	$('#other_names').hide();
	$('#oth_name').show();
	
}

</script>
<script>

$('#add_mbl').click(function()
{
	$('#add_mbl_block').hide();
	$('#add_mbl_disp').show();
});

function close_mobile()
{
	$('#add_mbl_disp').hide();
	$('#add_mbl_block').show();
	
}

function add_mbl()
{
	var mobile = $('#mbl_no').val();
		
	url = "<?php echo base_url(); ?>profile/addmobile/";
	$.ajax({
		type: "POST",
		data: { mobile : mobile},
		url : url,
		success : function(html)
		{
			$('#add_mbl_disp').hide();
	      	$('ul.basic_info > #mobile-li').html(html);		
		
		
		}
	});
	
	
}
 function mbl_edit()
{
	$('#mobile_val_display').hide();
	$('#add_mbl_disp').show();
}

function close_mbl()
{
	$('#add_mbl_disp').hide();
	$('#mobile_val_display').show();
}
</script>
<script>

add_web_site
$('#add_website').click(function()
{
	$('#website').hide();
	$('#website_disp').show();
});
</script>

<script> // about me workplace
work_edit();
curent_status();
$('#add_workplace').click(function()
{
	$('#work_head1').hide();
	$('#work_head2').hide();
	//$('#work_place').show();
	$('ul.backgrounds > #workplace-li .tophead').append($('#work_place').show());
});

function close_work()
{
	$('#work_place').hide();
	$('#work_head1').show();
	$('#work_head2').show();
	$('#work_form').trigger("reset");
	
}


		$("#work_form").submit(function( event){
			
					url="<?php echo base_url();?>profile/add_work/";
					$.post( url, { formdata: $(this).serialize() })
					.done(function( data ) {
					   	if(data == false)
							alert("Please Enter Valid Details");
						else
						
						$('#work_head1').hide();
						$('#work_head2').hide();
						$('ul.backgrounds > #workplace-li').html(data);		
						//$(".groupMainBlock2").html(data);
						
							//$('#organization_form').trigger("reset");
						//	$('#orgModal').modal('toggle');
							//organization_edit();
						
						
					  });
					
				event.preventDefault();
				});	


function work_edit()
{
	$('.work_edit').click(function(){
		
		organization_id = $(this).attr("id").substr(9);
		$("input[name=org_form_id]").val(organization_id)
		url="<?php echo base_url(); ?>profile/orgEdit/";
		$.post( url, { organization_id: organization_id})
		.done(function( data ) {
			info = JSON.parse(data);
			$("input[name=company]").val(info.org_name);
			$("input[name=position]").val(info.position);
			$("textarea[name=description]").val(info.org_desc);
			$("input[type='checkbox']").prop("checked","checked");
			//start_date = info.start_date.split('-')
			//$("select[name=year_attended_from]").val(start_date[0]);
			//$("select[name=month_attended_from]").val(start_date[1]);
			//end_date = info.end_date.split('-')
		//$("select[name=year_attended_to]").val(end_date[0]);
		//$("select[name=month_attended_to]").val(end_date[1]);
			//$("select[name=curent_status]").val(info.emp_status);	
			//$("input[name=org_action]").val("update")
			$('#work_place').show();
		});
		return false;

		
	});
	
	
}


function add_year()
{
	$('#add_years').hide();
	$('#frm_years').show();
	$('#frm_months_link').show();
	
}


	$('#frm_years').change(function()
	{
		if( $('#frm_years').val() == 0)
		{
		$('#frm_months_link').hide();
		$('#frm_months').hide();
		$('#frm_days').hide();
		//$('#todates_dropdowns').hide();
		$(this).hide();
		$('#add_years').show();
		//$('#to').hide();
		} else {
			
			if($('#frm_months').is(":hidden"))
			{
	$('#frm_months_link').show();
			}
		
		}
		
	});
	
	$('#frm_months_link').click(function()
	{
		
		$(this).hide();
		$('#frm_months').show();
		$('#frm_days_link').show();
	});
	
	$('#frm_months').change(function()
	{
		//alert($('#frm_months').val());
		if( $('#frm_months').val() == 0)
		{
	//	$('#todates_dropdowns').hide();
		$('#frm_days_link').hide();
		$('#frm_days').hide();
		$('#to_years_link').hide();
		$(this).hide();
		$('#frm_months_link').show();
		//$('#to').hide();
		} else {
			if($('#frm_days').is(":hidden"))
			{
		$('#frm_days_link').show();
			}}
	});
	
	$('#frm_days_link').click(function ()
	{
		$(this).hide();
		$('#frm_days').show();
		
		if( $('#curent_status').is(':checked'))
		{
			$('#to_present').show();
			$('#to').hide();
		}else{
			$('#to_present').hide();
			$('#to').show();
			$('#to_years_link').show();
		}
		
		
	});
	
	$('#frm_days').change(function()
	{
		if( $('#frm_days').val() == 0)
		{
		$(this).hide();
		$('#to_years_link').hide();
		//$('#to_years').hide();
		//$('#to').hide();
		//$('#to_months').hide();
	//	$('#to_days').hide();
		$('#frm_days_link').show();
		} else {
			
		
			
			if($('#curent_status').is(':checked'))
			{
				$('#to_present').show();
				$('#to').hide();
				$('#todates_dropdowns').hide();
			}else{
					
					
			if($('#to_years').is(":hidden"))
			{
				$('#to_years_link').show();
			}
				
				
				
				$('#to_present').hide();
				$('#to').show();
				$('#todates_dropdowns').show();
				
			}
			
	//	$('#to').show();
		//$('#to_present').hide();
		
		}
	});
	/*
	function status()
	{
	$('#curent_status').is("checked",function()
	{
		alert('hai');
		$('#to_present').hide();
		
	});
	}*/
	
	
	
  $('#curent_status').click(function ()
  {
	 if( $('#curent_status').is(':checked'))
	 {
		 $('#to_years_link').hide();
		 $('#to_present').show();
		 $('#to').hide();
	   $('#todates_dropdowns').hide();
	 } else
	 {
		 $('#to_present').hide();
		 $('#to').show();
		 $('#todates_dropdowns').show();
		 
		 if($('#to_years').is(":hidden"))
			{
				$('#to_years_link').show();
			}
		 
	 }
	  });
 
	
	$('#to_years_link').click(function()
	{
		$(this).hide();
		$('#to_years').show();
		$('#to_months_link').show();
		
	});
	
	
	$('#to_years').change(function()
	{
		if( $('#to_years').val() == 0)
		{
		$('#to_months_link').hide();
		$('#to_months').hide();
		$('#to_days').hide();
		$(this).hide();
		$('#to_years_link').show();
		} else {
			
			if($('#to_months').is(":hidden"))
			{
	$('#to_months_link').show();
			}
		
		}
		
	});
	
	
	
	$('#to_months_link').click(function()
	{
		
		$(this).hide();
		$('#to_months').show();
		$('#to_days_link').show();
	});
	
	$('#to_months').change(function()
	{
		//alert($('#frm_months').val());
		if( $('#to_months').val() == 0)
		{
		$('#to_days_link').hide();
		$('#to_days').hide();
		$(this).hide();
		$('#to_months_link').show();
		} else {
			if($('#to_days').is(":hidden"))
			{
		$('#to_days_link').show();
			}}
	});
	
		$('#to_days_link').click(function ()
	{
		$(this).hide();
		$('#to_days').show();
	});
	
	$('#to_days').change(function()
	{
		if( $('#to_days').val() == 0)
		{
		$(this).hide();
		$('#to_days_link').show();
		} 
	});
	
	function curent_status()
	{
	if($('#curent_status').is(':checked'))
	{
		$('#add_years').show();
		$('#to_present').show();
	}else
	{
		$('#add_years').show();
		$('#to').show();
		$('#to_years_link').show();
	}
	}
</script>

<?php $this->load->view('profile_models'); ?>
<script language="javascript">print_country("con");</script><!--  //for groups   --> 
<script language="javascript">print_country("contries");</script> <!-- //for companies-->

</body>
</html>