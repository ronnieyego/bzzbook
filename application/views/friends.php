<?php
foreach($friends as $friend)
{
	?>
    <div>
	<img src="<?php echo base_url(); ?>uploads/<?php echo $friend['image']; ?>" /><br />
      <a href="#"><?php echo $friend['name'] ; ?> </a></div>
      <?php } 

?>