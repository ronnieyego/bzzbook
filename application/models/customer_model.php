<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class customer_model extends CI_Model {

	function __construct()
   { 
   		parent::__construct(); 
  		$this->load->database("bzzbook"); 
    } 

	   
	   public function sign_up($data)
	   {
		    
		    $this->db->insert('cust_sign_up',$data);

	   }
	   public function post_buzz($data)
	   {
		   
		    $this->db->insert('posts',$data);
	   }
	   
	   public function view_post()
	   {
		  $query =  $this->db->get('posts');
	       return $query->result();
	   }
	   		
}
?>
