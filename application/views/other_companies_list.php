<<<<<<< HEAD
<?php 
$cmp_reqs = $this->companies->get_companies_to_follow();
/*print_r($cmp_reqs);
exit;*/
?> 
 
 <div class="pendingRequest">
          <h3> Companies to follow </h3>
        
          <ul id="cmpfollow">
          <?php if($cmp_reqs) {  foreach($cmp_reqs as $req) { ?>
           
            <li>
              <figure><img src="<?php echo base_url()?>uploads/<?php echo $req['company_image'] ?>" alt="<?php echo base_url()?>uploads/<?php echo $req['company_image'] ?>"></figure>
              <div class="disc">
                <h4><?php echo $req['cmp_name'] ?></h4>
                <div class="dcBtn"><a href="<?php echo base_url("company/company_disp/".$req['companyinfo_id']) ?>"> View </a>
                  <a href="javascript:void(0);" data-id="<?php echo $req['companyinfo_id']; ?>" data-toggle="modal" data-target="#followModal1"> Follow </a>
              <!--  <a href="javascript:void(0);"  onclick="cmpFollow(<?php echo $req['companyinfo_id']; ?>);"> Follow </a>-->
                 <!--<a href="javascript:void(0);" onclick="blockFrnd(<?php // echo $req['id']; ?>);"> </a> --></div>
                </div>
            </li>
          
            <?php }  } else echo "No Companies Available"; ?>
          </ul>
          <a href="#" class="link">View all</a> 
          
=======
<?php 
$cmp_reqs = $this->companies->get_companies_to_follow();
/*print_r($cmp_reqs);
exit;*/
?> 
 
 <div class="pendingRequest">
          <h3> Companies to follow </h3>
        
          <ul id="cmpfollow">
          <?php if($cmp_reqs) {  foreach($cmp_reqs as $req) { ?>
           
            <li>
              <figure><img src="<?php echo base_url()?>uploads/<?php echo $req['company_image'] ?>" alt="<?php echo base_url()?>uploads/<?php echo $req['company_image'] ?>"></figure>
              <div class="disc">
                <h4><?php echo $req['cmp_name'] ?></h4>
                <div class="dcBtn"><a href="<?php echo base_url("company/company_disp/".$req['companyinfo_id']) ?>"> View </a>
                  <a href="javascript:void(0);" onclick="cmpFollow(<?php echo //$req['companyinfo_id']; ?>);"> Follow </a>
              <!--  <a href="javascript:void(0);"  id="follow-btn" data-toggle="modal" data-target="#followModal" onclick="cmpFollow(<?php echo //$req['companyinfo_id']; ?>);"> Follow </a>-->
                 <!--<a href="javascript:void(0);" onclick="blockFrnd(<?php // echo $req['id']; ?>);"> </a> --></div>
                </div>
            </li>
          
            <?php }  } else echo "No Companies Available"; ?>
          </ul>
          <a href="#" class="link">View all</a> 
          
>>>>>>> 50f4e2b21a6050afbe4c30d0a2803c6f38f7475f
 </div>