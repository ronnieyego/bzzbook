<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Friendsmodel extends CI_Model {

	function __construct()
    {
   		parent::__construct();   		
    } 	
  public function getfriends($name='',$addedusers='',$user_id='',$limit='')
  {
	    $id = $this->session->userdata('logged_in')['account_id'];
		if($user_id!='')
		$id = $user_id;
		
		if(!$id)
		return false;
	    $condition = "(user_id ='".$id."' OR friend_id='".$id."') AND request_status='Y'";
		if($addedusers!='')
		$condition.= " AND (user_id NOT IN (".$addedusers.") AND friend_id NOT IN (".$addedusers.") )";
		if($limit!='')
		$condition .=" LIMIT 0,".$limit;
		  
		$this->db->select('*');
		$this->db->from('bzz_userfriends');
		$this->db->where($condition);
		$query = $this->db->get();
		if ($query->num_rows() >0) {
			//echo $this->db->last_query();
				
			$friends = $query->result_array();
			
			foreach($friends as $friend)
			{
				$frnds[] = $friend['user_id'];
				$frnds[] = $friend['friend_id'];	
			}
		
				if(!empty($frnds))
			{
		$usr_ids = array_unique($frnds);
		
		$key = array_search($id,$usr_ids);
		if($key!==false)
		{
  		unset($usr_ids[$key]);
		}
			
			}
			
			//print_r($usr_ids);
			//exit;
			$frnds = array();
			foreach($usr_ids as $usr_id)
			{
				//if($friend['friend_id']==$id)
			    $condition = "user_id =" . "'" . $usr_id . "'";
				//else
				//$condition = "user_id =" . "'" . $friend['friend_id'] . "'";
				if($name!='')
				{
					$condition.= " AND (user_firstname LIKE '%".$name."%' OR user_lastname LIKE '%".$name."%' )"; 
				}
				if($addedusers!=''){
					$condition.= " AND user_id NOT IN (".$addedusers.")";
				}
				//echo $condition ; exit;
				$this->db->select('*');
				$this->db->from('bzz_userinfo');
				$this->db->where($condition);
				$query = $this->db->get();
				
				$frnd = array();
				if ($query->num_rows() == 1) {
					$result = $query->result_array();	
					
					$frnd['name'] = $result[0]['user_firstname'].' '.$result[0]['user_lastname'];	
					$frnd['username'] = $result[0]['username'];
					$this->db->select('*');
				$this->db->from('bzz_user_images');
				/*if($friend['friend_id']==$id)
			    $condition = "user_id =" . "'" . $friend['user_id'] . "'";
				else
				$condition = "user_id =" . "'" . $friend['friend_id'] . "'";
				*/
				$condition = "user_id =" . "'" . $usr_id . "'";
				$this->db->where('user_id',$usr_id);
				$this->db->order_by('user_imageinfo_id','desc');
				$query = $this->db->get();
				$result = $query->result_array();
				if($result)
				$frnd['image'] = $result[0]['user_img_thumb'];
				else
				$frnd['image'] =  'default_profile_pic.png';
				/*if($friend['friend_id']==$id)
				$frnd['id'] = $friend['user_id'];
				else
				$frnd['id'] = $friend['friend_id'];*/
				$frnd['id'] = $usr_id;
				$frnds[] = $frnd;				
				}
				
			}
			return $frnds;
			
		} else {
		return false;
		}
   }

   
   public function getPendingRequests($limit)
	{
		$id = $this->session->userdata('logged_in')['account_id'];
	    $condition = "friend_id =" . "'" . $id . "' AND request_status ='W'";
		$this->db->select('*');
		$this->db->from('bzz_userfriends');
		$this->db->where($condition);
		$query = $this->db->get();
		$checklimit = 1;
		if ($query->num_rows() >= 1) {
			$friends = $query->result_array();
			$frnds = array();
			foreach($friends as $friend)
			{				
			    $condition = "bzz_userinfo.user_id =" . "'" . $friend['user_id'] . "'";
				$this->db->select('*');
				$this->db->from('bzz_userinfo');
				$this->db->join('bzz_organizationinfo',"bzz_organizationinfo.user_id=bzz_userinfo.user_id AND emp_status='wor'",'left');
				$this->db->where($condition);
				$query = $this->db->get();
				$frnd = array();

				if ($query->num_rows() == 1) {
					$result = $query->result_array();	
					$frnd['name'] = $result[0]['user_firstname'].' '.$result[0]['user_lastname'];
					if(isset($result[0]['org_name']) && isset($result[0]['position']) && $result[0]['org_name']!='' && $result[0]['position']!='')
					$frnd['job'] = $result[0]['position'].' at '.$result[0]['org_name'];
				
				}
				 $condition = "user_id =" . "'" . $friend['user_id'] . "'";
				$this->db->select('*');
				$this->db->from('bzz_user_images');
				$this->db->where($condition);
				$this->db->order_by('user_imageinfo_id','desc');
				$query = $this->db->get();
				$result = $query->result_array();
				if(!empty($result[0]['user_img_fav']))
				{
					$frnd['image'] = $result[0]['user_img_fav'];
				}
				else
				$frnd['image'] = 'default_profile_pic.png';
				$frnd['id'] = $friend['user_id'];
				$frnds[] = $frnd;
				
				if($checklimit==$limit)
				{
					break;
				}
				elseif($limit==0)
				continue;
				else
					$checklimit++;
			}
			return $frnds;
		}else{
			return false;
		}
		
	}	   
   public function confirmfriend($req_id)
	{
		$id = $this->session->userdata('logged_in')['account_id'];
		 $condition = "user_id =" . "'" . $req_id . "'" . " AND " . "friend_id =" . "'" . $id .  "'"; 
			$data = array(
               'request_status' => 'Y',
            );
			$this->db->where($condition);
			$this->db->update('bzz_userfriends', $data); 
			
			/*$frnddata = array(
			   'user_id' => $id,
			   'friend_id' => $req_id,
               'request_status' => 'Y',
            );
			
			$this->db->insert('bzz_userfriends', $frnddata);*/
			
			$pend_req = $this->getPendingRequests($limit = 2);
			$list = "";
		    if($pend_req) { foreach($pend_req as $req){
           $list .= " <li>
              <figure><img src='".base_url()."uploads/".$req['image']."' alt='".$req['name']."'></figure>
              <div class='disc'>
                <h4>".$req['name']."</h4>
                <div class='dcBtn'><a href='javascript:void(0);' onclick='acceptFrnd(".$req['id'].")'>Confirm</a><a href='javascript:void(0);' onclick='denyFrnd(".$req['id'].")'>Deny</a><a href='javascript:void(0);' onclick='blockFrnd(".$req['id'].");'>Block</a>  </div>
                </div>
            </li>";
             } }else $list = "No Requests Pending";
			 
			 echo $list;
		
	}
	
	public function denyfriend($req_id)
	{
		$id = $this->session->userdata('logged_in')['account_id'];
	    $condition ="(user_id ='" .$req_id. "' or friend_id ='".$req_id."') AND (user_id = '".$id."' or friend_id ='".$id."')";
		
			$data = array(
               'request_status' => 'N',
            );
			$this->db->where($condition);
			$this->db->update('bzz_userfriends', $data); 
			$pend_req = $this->getPendingRequests($limit = 2);
			$list = "";
		    if($pend_req) { foreach($pend_req as $req){
           $list .= " <li>
              <figure><img src='".base_url()."uploads/".$req['image']."' alt='".$req['name']."'></figure>
              <div class='disc'>
                <h4>".$req['name']."</h4>
                <div class='dcBtn'><a href='javascript:void(0);' onclick='acceptFrnd(".$req['id'].")'>Confirm</a><a href='javascript:void(0);' onclick='denyFrnd(".$req['id'].")'>Deny</a> <a href='javascript:void(0);' onclick='blockFrnd(".$req['id'].");'>Block</a></div>
                </div>
            </li>";
             } }else $list = "No Requests Pending";
			 
			 echo $list;
	
	}
	
	public function blockfriend($req_id)
	{
		$id = $this->session->userdata('logged_in')['account_id'];
	    $condition ="(user_id ='" .$req_id. "' or friend_id ='".$req_id."') AND (user_id = '".$id."' or friend_id ='".$id."')";
		
			$data = array(
               'request_status' => 'B',
            );
			$this->db->where($condition);
			$this->db->update('bzz_userfriends', $data); 
			$pend_req = $this->getPendingRequests($limit = 2);
			$list = "";
		    if($pend_req) { foreach($pend_req as $req){
           $list .= " <li>
              <figure><img src='".base_url()."uploads/".$req['image']."' alt='".$req['name']."'></figure>
              <div class='disc'>
                <h4>".$req['name']."</h4>
                <div class='dcBtn'><a href='javascript:void(0);' onclick='acceptFrnd(".$req['id'].")'>Confirm</a><a href='javascript:void(0);' onclick='denyFrnd(".$req['id'].")'>Deny</a> <a href='javascript:void(0);' onclick='blockFrnd(".$req['id'].");'>Block</a> </div>
                </div>
            </li>";
             } }else $list = "No Requests Pending";
			 
			 echo $list;
		
	}
	
	public function addFriend_Request($frnd_id)
	{
		$id = $this->session->userdata('logged_in')['account_id'];
		$frndcondition =  "user_id =" . "'" . $id . "' AND (request_status!='Y' OR request_status!='W' ) AND friend_id =" . "'" . $frnd_id . "'" ;
		$this->db->select('*');
		$this->db->from('bzz_userfriends');
		$this->db->where($frndcondition);
		$query = $this->db->get();
		$data = $query->result_array();
		if($data)
		{
	 	    $condition = "user_id =" . "'" . $id . "' AND friend_id =".$frnd_id;		
			$data = array(
               'request_status' => 'W',
            );
			$this->db->where($condition);
			$this->db->update('bzz_userfriends', $data); 
		}
		else{
			$condition = "user_id =" . "'" . $id . "' AND friend_id =".$frnd_id;		
			$data = array(
				'user_id' => $id,
				'friend_id' => $frnd_id,
               'request_status' => 'W',
            );
			$this->db->where($condition);
			$this->db->insert('bzz_userfriends', $data); 
		}
			
			$frnd_req = $this->related_friends($limit = 2);
			if(!$frnd_req)
			$frnd_req = $this->finding_friends($limit = 2);
			$list = "";
		//	print_r($frnd_req);
			//	print_r(count($frnd_req));
		    if($frnd_req)
			{
				
			
			  foreach($frnd_req as $req){
				 
				if(!empty($req[0]['user_img_thumb']))
				{
					$image = $req[0]['user_img_thumb'];
				}else
				{
						$image = 'default_profile_pic.png';
				}
				
				 
           $list .= " <li>
              <figure><img src='".base_url()."uploads/".$image."' alt='".$req[0]['user_firstname']. " ".$req[0]['user_lastname']."'></figure>
              <div class='disc'>
                <h4>".$req[0]['user_firstname']. " ".$req[0]['user_lastname']."</h4>
                <span class='skip addfrd_accept' href='javascript:void(0);' onclick='addFrnd(".$req[0]['user_id'].")'>Add Friend</span> | <span class='skip addfrd_skip' onclick='skipFrnd(".$req[0]['user_id'].");'>Skip</span>
                </div>
            </li>";
             
			 
			  } }else $list = "No Friends Found!..";
			 
			// echo $list;
			if(empty($frnd_req))
			echo '0';
		
	}
	public function skipFriend_Request($frnd_id)
	{
		$id = $this->session->userdata('logged_in')['account_id'];
		
			$condition = "user_id =" . "'" . $id . "' AND friend_id =".$frnd_id;		
			$data = array(
				'user_id' => $id,
				'friend_id' => $frnd_id,
               'request_status' => 'S',
            );
			$this->db->where($condition);
			$this->db->insert('bzz_userfriends', $data); 
			$rel_res = $this->related_friends('');
			if(empty($rel_res))
			echo '0';
			
	}
	
	// add friend functionality from search friends
	
	public function addSearchFriend_Request($frnd_id)
	{
		
		$id = $this->session->userdata('logged_in')['account_id'];
		$frndcondition = $frndcondition = "((user_id ='" .$frnd_id. "' or friend_id ='".$frnd_id."') AND (user_id = '".$id."' or friend_id ='".$id."')) AND (request_status!='Y' OR request_status!='W')"; 
		$this->db->select('*');
		$this->db->from('bzz_userfriends');
		$this->db->where($frndcondition);
		$query = $this->db->get();
		$data = $query->result_array();
		if($data)
		{
	
	    $condition = "(user_id ='" .$frnd_id. "' or friend_id ='".$frnd_id."') AND (user_id = '".$id."' or friend_id ='".$id."')"; 
		
			$data = array(
               'request_status' => 'W',
            );
			$this->db->where($condition);
			$this->db->update('bzz_userfriends', $data); 
		}
		else{
			 $condition ="(user_id ='" .$frnd_id. "' or friend_id ='".$frnd_id."') AND (user_id = '".$id."' or friend_id ='".$id."')"; 
		
			$data = array(
				'user_id' => $id,
				'friend_id' => $frnd_id,
               'request_status' => 'W',
            );
			$this->db->where($condition);
			$this->db->insert('bzz_userfriends', $data); 
		
		}
	
	}
	
	
	public function get_userinfo_byid($user_id)
	{
		$condition = "user_id =" . "'" . $user_id . "'";
		$this->db->select('*');
		$this->db->from('bzz_userinfo');
		$this->db->where($condition);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			return $result = $query->result_array();
		}
	return false;
	}
	
	public function get_frnds_frnds($id)
	{
		
		//$id = $this->session->userdata('logged_in')['account_id'];
		$condition = "(user_id ='".$id."' OR friend_id='".$id."') AND request_status='Y'";
		
		$this->db->select('*');
		$this->db->from('bzz_userfriends');
		$this->db->where($condition);
		$query = $this->db->get();
		
		
		if($query->num_rows() > 0) {
			$friends = $query->result_array();
			$frnds = array();
			foreach($friends as $friend)
			{
				$frnds[] = $friend['user_id'];
				$frnds[] = $friend['friend_id'];	
			}
		
	
		if(!empty($frnds))
			{
		$usr_ids = array_unique($frnds);
		
		$key = array_search($id,$usr_ids);
		if($key!==false)
		{
  		unset($usr_ids[$key]);
		}
		}	
		
	return($usr_ids);
		
		}
		return false;

	}
	
	public function appendFriend($frndid,$groupid)
	{
		$condition = "group_id =" . "'" . $groupid . "'";
		$this->db->select('*');
		$this->db->from('bzz_user_groups');
		$this->db->where($condition);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			$result = $query->result_array();
			$friends = explode(',',$result[0]['group_members']);
			if(!empty($result[0]['group_members']) && !in_array($frndid,$friends))
			$data = array(
               'group_members' => $result[0]['group_members'].','.$frndid,
            );
			else if(in_array($frndid,$friends))
			{
				return true;
			}
			else
			$data = array(
               'group_members' => $frndid,
            );

			$this->db->where($condition);
			if($this->db->update('bzz_user_groups', $data))
			return true;
		}
		else
		return false;
	}
// latest frnds worked by sp 8-4-2015
public function latest_frnds($limit)
{
	    $id = $this->session->userdata('logged_in')['account_id'];
	    $condition = "(user_id ='" .$id. "' or friend_id ='".$id."') AND request_status='Y' AND requested_time >= DATE_ADD( NOW(), INTERVAL - 5 MINUTE ) ";
		$this->db->select('user_id,friend_id');
		$this->db->from('bzz_userfriends');
		$this->db->order_by('userfriends_id','desc');
		if($limit != 0)
		{
		$this->db->limit(3);
		}
		$this->db->where($condition);
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			$friends = $query->result_array();
			$frnds = array();
			foreach($friends as $friend)
			{
				$frnds[] = $friend['user_id'];
				$frnds[] = $friend['friend_id'];	
			}
		}
	
		if(!empty($frnds))
			{
		$usr_ids = array_unique($frnds);
		
		$key = array_search($id,$usr_ids);
		if($key!==false)
		{
  		unset($usr_ids[$key]);
		}
		
			foreach($usr_ids as $user_id)
			{
				 $usercondition = "user_id ="."'".$user_id."'";
						 $this->db->select('*');
						 $this->db->from('bzz_user_images');
						 $this->db->where($usercondition);
						 $query = $this->db->get();
						 if($query->num_rows > 0)
						 {
							$this->db->select('*');
							$this->db->from('bzz_users');
							$this->db->join('bzz_user_images','bzz_users.user_id=bzz_user_images.user_id AND bzz_users.user_id='.$user_id);
							$this->db->join('bzz_userinfo','bzz_users.user_id=bzz_userinfo.user_id');
							$this->db->order_by('bzz_user_images.user_imageinfo_id','desc');
							$query = $this->db->get();
							$user_data =  $query->result_array();
							
						 }else{
							  $this->db->select('*');
							// $this->db->limit(2);
							  $this->db->from('bzz_users');
							  $this->db->join('bzz_userinfo','bzz_users.user_id=bzz_userinfo.user_id AND bzz_users.user_id='.$user_id);
							 // $this->db->where($followercondition);
							  $query = $this->db->get(); 
							   $user_data =  $query->result_array();
						 }
						  $userdata[] = $user_data;
					}
					
			return $userdata;
		} else {
		return false;
		}
   
}

//  worked by sp on 9-4-2015 to display other all users if dont have any friends or dont follows any companies
public function finding_friends($limit)
{
	$id = $this->session->userdata('logged_in')['account_id'];
	$usercondition = "user_id !=" . "'" . $id . "'";
	$this->db->select('user_id');
	$this->db->from('bzz_users');
	$this->db->where($usercondition);
	$query = $this->db->get();
	$users = $query->result_array();
	$user_ids = array();
	foreach($users as $user)
	{
		$user_ids[] = $user['user_id'];
	}
	//print_r($user_ids);

	$frndcondition = "user_id =" . "'" . $id . "'";
	$friends = array();
	$this->db->select('*');
	$this->db->from('bzz_userfriends');
	$this->db->where($frndcondition);
	$query = $this->db->get();
	$myfrnds = $query->result_array();
	$frnds = array();
	foreach($myfrnds as $frnd)
	{
		$frnds[] = $frnd['friend_id'];
	}
	//print_r($frnds);
	$required_ids = array();
	foreach($user_ids as $user)
				{
					if(!in_array($user,$frnds))
					{
						$required_ids[] = $user;
					}
					
				}
			if($required_ids)
				{
					$user_data = array();
					foreach($required_ids as $user_id)
					{
					  //$condition =  "user_id =" . "'" . $user_id . "'";
					  $this->db->select('*');
					  $this->db->from('bzz_users');
					  if($limit != 0)
					  {
					  $this->db->limit(2);
					  }
					  $this->db->join('bzz_user_images','bzz_users.user_id=bzz_user_images.user_id AND bzz_users.user_id='.$user_id);
					  $this->db->join('bzz_userinfo','bzz_users.user_id=bzz_userinfo.user_id');
					  $this->db->order_by('bzz_user_images.user_imageinfo_id','desc'); 
					   //$this->db->order_by('bzz_users.user_id','desc');
					  //$this->db->order_by('user_id');
				
					 // $this->db->where($condition);
					  $query = $this->db->get();
					   if ($query->num_rows() > 0) {
				       $userdata =  $query->result_array();
					   $user_data[] = $userdata;
				 	   } 
					}
				return $user_data;
				
				}
				return false;
				
		}
		
		
// displaying friends of friends or followers of companies which are im following

public function related_friends($limit)
{
	$id = $this->session->userdata('logged_in')['account_id'];
	
	//getting frnds ids
	//$condition =  "(user_id = '".$id."' or friend_id ='".$id."') AND request_status='Y'"; 
	$condition = "(user_id ='" .$id. "' or friend_id ='".$id."') AND request_status='Y'";
	$this->db->select('friend_id,user_id');
	$this->db->from('bzz_userfriends');
	$this->db->where($condition);
	$query = $this->db->get();
	$friends = $query->result_array();
	$elements = array();
	//$friends = array_unique($friends);

	
	$frnd_frnds = array();
	 foreach($friends as $frnds)
	 {
	    /*$frnd_frnds = $this->user_frnds($frnds['friend_id']);
	 		foreach($frnd_frnds as $fr)
			{
				$elements[] = $fr['friend_id'];
			}*/
	    $frnd_frnds[] = $frnds['user_id'];
		$frnd_frnds[] = $frnds['friend_id'];
	 }
	
	 $frnd_frnds = array_unique($frnd_frnds);
	//print_r($frnd_frnds);
	//exit;
	foreach($frnd_frnds as $frnd_frnd_id)
	{
	$condition = "(user_id ='" .$frnd_frnd_id. "' or friend_id ='".$frnd_frnd_id."') AND request_status='Y'";
	$this->db->select('friend_id,user_id');
	$this->db->from('bzz_userfriends');
	$this->db->where($condition);
	$query = $this->db->get();
	$multiplefriends = $query->result_array();
	foreach($multiplefriends as $mfriends)
		{
			$elements[] = $mfriends['user_id'];
			$elements[] = $mfriends['friend_id'];
		}
	}

//print_r($elements);
//	
	//my company followers
	$companies = array();
	$mycmpcondition ="user_id ="."'".$id."'";
	$this->db->select('companyinfo_id');
	$this->db->from('bzz_companyinfo');
	$this->db->where($mycmpcondition);
	$query = $this->db->get();
	$mycmps = $query->result_array();
	foreach($mycmps as $cmp)
	{
		$companies[] = $cmp['companyinfo_id'];
	}
	$cmpfollowcondition ="user_id ="."'".$id."'AND follow_status='Y'";
	$this->db->select('companyinfo_id');
	$this->db->from('bzz_cmp_follow');
	$this->db->where($cmpfollowcondition);
	$query = $this->db->get();
	$all_follow_cmps = $query->result_array();
	foreach($all_follow_cmps as $follow_cmp)
	{
		$companies[] = $follow_cmp['companyinfo_id'];
	}

if(!empty($companies))
{

$this->db->select('user_id');
$this->db->from('bzz_cmp_follow');
$this->db->where_in('companyinfo_id',$companies);
$query = $this->db->get();
$cmpfollowers = $query->result_array();

foreach($cmpfollowers as $users)
{
	$elements[] = $users['user_id'];
}
}
$usercondition ="user_id ="."'".$id."'";
//location based search for users

$this->db->where($usercondition);
$query = $this->db->get('bzz_userinfo');
$user_details = $query->result_array();

/*print_r($user_details);
echo $user_details[0]['user_id'];
exit;*/
if(!empty($user_details))
{
$userslikecondition = "user_industry like '%".$user_details[0]['user_industry']."%' or user_cmpname like '%".$user_details[0]['user_cmpname']."%' or profession like '%".$user_details[0]['profession']."%' or location like '%".$user_details[0]['location']."%' or schooling like'%".$user_details[0]['schooling']."%' or hometown like'%".$user_details[0]['hometown']."%' or interests like'%".$user_details[0]['interests']."%'";
$this->db->select('user_id');
$this->db->from('bzz_userinfo');
$this->db->where($userslikecondition);
$query = $this->db->get();
$usr_similar = $query->result_array();
foreach($usr_similar as $user)
{
	$elements[] = $user['user_id'];
}

if($elements)
{
/*	$all_ids = array_unique($elements);
print_r($all_ids);
$key = array_search($id,$all_ids);
if($key!==false){
  unset($all_ids[$key]);*/
  
  
  
  	foreach($elements as $user)
				{
					if(!in_array($user,$frnd_frnds))
					{
						$all_ids[] = $user;
					}
					
				}
  
  
  
}
$all_ids = array_unique($all_ids);

$condition = "(user_id ='" .$id. "' or friend_id ='".$id."') AND (request_status='Y' OR request_status='W'  OR request_status='S'  OR request_status='B') ";
	$this->db->select('friend_id,user_id');
	$this->db->from('bzz_userfriends');
	$this->db->where($condition);
	$query = $this->db->get();
	$friends = $query->result_array();
	
	$req_ids = array();
	foreach($friends as $frd){		
			$req_ids[] = $frd['user_id'];
			$req_ids[] = $frd['friend_id'];		
	}
	$req_ids = array_unique($req_ids);
	$real_ids = array();
	foreach($all_ids as $fr_id){
	if(!in_array($fr_id,$req_ids))
	$real_ids[] = $fr_id;	
	}
	$all_ids = $real_ids;
	
	if($all_ids)
				{

					$userdata = array();
					foreach($all_ids as $each_id)
					{
									
						
									
						 
						 $followercondition = "user_id ="."'".$each_id."'";
						 $this->db->select('*');
						 $this->db->from('bzz_user_images');
						 $this->db->where($followercondition);
						 $query = $this->db->get();
						 if($query->num_rows > 0)
						 {
								$this->db->select('*,bzz_users.user_id');
								$this->db->from('bzz_users');
								$this->db->join('bzz_user_images','bzz_users.user_id=bzz_user_images.user_id AND bzz_users.user_id='.$each_id);						$this->db->join('bzz_userinfo','bzz_users.user_id=bzz_userinfo.user_id');
								$this->db->join('bzz_organizationinfo',"bzz_users.user_id=bzz_organizationinfo.user_id AND emp_status='wor'",'left');
								$this->db->order_by('bzz_user_images.user_imageinfo_id','desc');
								
								$query = $this->db->get();
								 $user_data =  $query->result_array();
								
						 }else{
							  $this->db->select('*,bzz_users.user_id');
							  
							  $this->db->from('bzz_users');
							  $this->db->join('bzz_userinfo','bzz_users.user_id=bzz_userinfo.user_id AND bzz_users.user_id='.$each_id);							 $this->db->join('bzz_organizationinfo',"bzz_users.user_id=bzz_organizationinfo.user_id AND emp_status='wor'",'left');
							 // $this->db->where($followercondition);
							  $query = $this->db->get(); 
							   $user_data =  $query->result_array();
						 }
						  $userdata[] = $user_data;
			
					}
					
					
					
			return $userdata;
				
				}
}
return false;
}
	
public function search_friends($value)
{
	$id = $this->session->userdata('logged_in')['account_id'];
	$this->db->select('*'); 
	$this->db->from('bzz_userinfo');
	$this->db->like('user_firstname',$value); 
	$this->db->or_like('user_lastname',$value); 
	$query = $this->db->get();
	$data = $query->result_array();
	//print_r($data);
	if(!empty($data))
	{
		$userdata = array();
	foreach($data as $data)
	{
		if($data['user_id'] != $id)
		{
					
			$imgcondition = "user_id =" . "'" . $data['user_id'] . "'";
			$this->db->where($imgcondition);
			$this->db->select('*');
			$this->db->from('bzz_user_images');
			$query = $this->db->get();
						
			if($query->num_rows() > 0)
			{
			$this->db->select('*');
			$this->db->from('bzz_userinfo');
			$this->db->join('bzz_user_images','bzz_userinfo.user_id=bzz_user_images.user_id AND bzz_userinfo.user_id='.$data['user_id']);
			$this->db->order_by('bzz_user_images.user_imageinfo_id','desc');
			$query = $this->db->get();
			$searched_user = $query->result_array();
			 
			}else
			{
			$usercondition = "user_id =" . "'" . $data['user_id'] . "'";
			$this->db->select('*');
			$this->db->from('bzz_userinfo');
			$this->db->where($usercondition);
			$query = $this->db->get();
			$searched_user = $query->result_array();
			
			}
			$userdata[] = $searched_user;
	}
	}
	//print_r($userdata);

	
	$searchblock = "";
		   
          
             if($userdata) {
				 
				 $searchblock .= "
		   
      <ul class='groupEditBlock'> ";   
				  foreach($userdata as $req){
        $searchblock .= " <li class='col-md-4'>
        	<div class='fdblock'>";
			if(!empty($req[0]['user_img_thumb'])){
$searchblock .= "<figure class='myfriendspfpic'><img src='" . base_url() ."uploads/".$req[0]['user_img_thumb']."' alt='". $req[0]['user_firstname'] . " " .$req[0]['user_lastname'] ."'></figure>";
			}else{
				$searchblock .= "<figure class='myfriendspfpic'><img src='" . base_url() ."uploads/default_profile_pic.png'></figure>";
			}

		$searchblock .= " <div class='friendInfo'>
            <h3>". $req[0]['user_firstname'] . " " .$req[0]['user_lastname']."</h3>";
 $friendscount = $this->friendsmodel->get_frnds_frnds($req[0]['user_id']); if($friendscount) { $frnds = count($friendscount); }else $frnds = '0' ;
			 $searchblock .= "<span>(". $frnds ." "." friends)</span>
              <div class='disc'>";
			  
			  $myfrnd = $this->user_frnds($req[0]['user_id']);
			 if($myfrnd){
			//print_r($myfrnd);
			 if($myfrnd[0]['request_status'] == 'Y') 
				   {
               $searchblock .= "<div class='dcBtn'><a href='javascript:void(0);'>Friends</a></div>";
				   }elseif( $myfrnd[0]['request_status'] == 'W'){
			 $searchblock .= "<div class='dcBtn'><a href='javascript:void(0);'>Pending</a></div>";
				   }else{
			 $searchblock .= "<div class='dcBtn'><a id='addFrnd".$req[0]['user_id']."'
			  href='javascript:void(0);' onclick='addSearchFrnd(" .$req[0]['user_id']. ");'>Add Friend</a></div>";
				   }
			  
			 }else{
 $searchblock .= "<div class='dcBtn'><a id='addFrnd".$req[0]['user_id']."' href='javascript:void(0);' onclick='addSearchFrnd(" .$req[0]['user_id']. ");'>Add Friend</a></div>";
			 }
               $searchblock .= "</div>
			</div>
			  </li>	";
	
 } $searchblock .= "</ul>"; 
 echo $searchblock;
 }else $searchblock = "No friends Found Based On your Search!..";
		 

	}
else echo "No friends Found Based On your Search!..";

	

	
	
	/*	
$id = $this->session->userdata('logged_in')['account_id'];
//$condition = "user_firstname LIKE '%". $value . " %' OR user_lastname LIKE '%" . $value . "%'";

	
	$this->db->select('user_id'); 
	$this->db->from('bzz_userinfo');
	$this->db->where($condition);
	$this->db->like('user_firstname',$value); 
	$this->db->or_like('user_lastname',$value); 
	$query = $this->db->get();
	$data = $query->result_array();
	if(!empty($data))
	{
		$userdata = array();
	foreach($data as $data)
	{
		
		if($data[0]['user_id'] != $id )
		{
			  $this->db->select('*');
			  $this->db->from('bzz_users');
			  $this->db->join('bzz_user_images','bzz_users.user_id=bzz_user_images.user_id AND bzz_users.user_id='.$data['user_id']);
			  $this->db->join('bzz_userinfo','bzz_users.user_id=bzz_userinfo.user_id');
			  $this->db->order_by('bzz_user_images.user_imageinfo_id','desc');
			 // $this->db->where($condition);
			  $query = $this->db->get();
			  $frnds = $query->result_array();
			  $userdata[] = $frnds;
	}
	
	}
	
	$searchblock = "";
		   
          
             if($userdata) {
				 
				 $searchblock .= "
		   
      <ul class='groupEditBlock'> ";   
				  foreach($userdata as $req){
        $searchblock .= " <li class='col-md-4'>
        	<div class='fdblock'>
<figure class='myfriendspfpic'><img src='" . base_url() ."uploads/".$req[0]['user_img_thumb']."' alt='". $req[0]['user_firstname'] . " " .$req[0]['user_lastname'] ."'></figure>
		 <div class='friendInfo'>
            <h3>". $req[0]['user_firstname'] . " " .$req[0]['user_lastname']."</h3>";
 $friendscount = $this->friendsmodel->get_frnds_frnds($req[0]['user_id']); if($friendscount) { $frnds = count($friendscount); }else $frnds = '0' ;
			 $searchblock .= "<span>(". $frnds ." "." friends)</span>
              <div class='disc'>";
			  
			  $myfrnd = $this->user_frnds($req[0]['user_id']);
			 if($myfrnd){
			//print_r($myfrnd);
			 if($myfrnd[0]['request_status'] == 'Y') 
				   {
               $searchblock .= "<div class='dcBtn'><a href='javascript:void(0);'>Friends</a></div>";
				   }elseif( $myfrnd[0]['request_status'] == 'W'){
			 $searchblock .= "<div class='dcBtn'><a href='javascript:void(0);'>Request Sent</a></div>";
				   }else{
			 $searchblock .= "<div class='dcBtn'><a id='addFrnd'
			  href='javascript:void(0);' onclick='addSearchFrnd(" .$req[0]['user_id']. ");'>Add Friend</a></div>";
				   }
			  
			 }else{
 $searchblock .= "<div class='dcBtn'><a id='addFrnd' href='javascript:void(0);' onclick='addSearchFrnd(" .$req[0]['user_id']. ");'>Add Friend</a></div>";
			 }
               $searchblock .= "</div>
			</div>
			  </li>	";
	
 } $searchblock .= "</ul>"; 
 echo $searchblock;
 }else $searchblock = "No friends Found Based On your Search!..";
		 

	}
else echo "No friends Found Based On your Search!..";
*/}

public function search_members($value,$specific_search)
{
	$id = $this->session->userdata('logged_in')['account_id'];
	
	//print_r($data);
	
	$searchblock = "";
 	$searchblock .= "<ul id='country-list'> "; 
	if($specific_search=='')
	$limit = 5;
	else
	$limit = 10;
	// To get members as per search input
	if($specific_search=='' || $specific_search=='members'){
	$this->db->select('*'); 
	$this->db->from('bzz_userinfo');
	$this->db->like('user_firstname',$value); 
	$this->db->or_like('user_lastname',$value); 
	
	$this->db->limit($limit);
	$query = $this->db->get();
	$data = $query->result_array();
	if(!empty($data))
	{
		$userdata = array();
	foreach($data as $data)
	{
		if($data['user_id'] != $id)
		{
					
			$imgcondition = "user_id =" . "'" . $data['user_id'] . "'";
			$this->db->where($imgcondition);
			$this->db->select('*');
			$this->db->from('bzz_user_images');
			$query = $this->db->get();
						
			if($query->num_rows() > 0)
			{
			$this->db->select('*');
			$this->db->from('bzz_userinfo');
			$this->db->join('bzz_user_images','bzz_userinfo.user_id=bzz_user_images.user_id AND bzz_userinfo.user_id='.$data['user_id']);
			$this->db->order_by('bzz_user_images.user_imageinfo_id','desc');
			$query = $this->db->get();
			$searched_user = $query->result_array();
			 
			}else
			{
			$usercondition = "user_id =" . "'" . $data['user_id'] . "'";
			$this->db->select('*');
			$this->db->from('bzz_userinfo');
			$this->db->where($usercondition);
			$query = $this->db->get();
			$searched_user = $query->result_array();
			}
			$jobcondition = "user_id =" . "'" . $data['user_id'] . "' AND emp_status='wor'";
			$this->db->select('position,org_name');
			$this->db->from('bzz_organizationinfo');
			$this->db->where($jobcondition);
			$query = $this->db->get();
			$jobres = $query->result_array();
			if($jobres)
			$searched_user['job'] = $jobres[0]['position'].' at '.$jobres[0]['org_name'];
			$userdata[] = $searched_user;
	}
	}
	//print_r($userdata);

	
          
             if($userdata) {
				 
				  $i =0;
				  foreach($userdata as $req){
					 
        $searchblock .= " <li class='col-md-12' onclick='location.href=&#39;".base_url()."profile/user/".$req[0]['user_id']."&#39;'>
        	<div class='member-search-sug'>";
			
			$searchblock .= "<div class='categoryBlock'>";
			if($i==0) { $searchblock .="Members"; }
			$searchblock .="</div>";
			if(!empty($req[0]['user_img_thumb'])){
$searchblock .= "<figure class='member-sug-pic'><img src='" . base_url() ."uploads/".$req[0]['user_img_thumb']."' alt='". $req[0]['user_firstname'] . " " .$req[0]['user_lastname'] ."'></figure>";
			}else{
				$searchblock .= "<figure class='member-sug-pic'><img src='" . base_url() ."uploads/default_profile_pic.png'></figure>";
			}

		$searchblock .= " <div class='member-search-name'>
            <h4>". $req[0]['user_firstname'] . " " .$req[0]['user_lastname']."</h4>";
			if(isset($req['job']))
			$searchblock .= "<h6>".$req['job']."</h6>";
 $friendscount = $this->friendsmodel->get_frnds_frnds($req[0]['user_id']); if($friendscount) { $frnds = count($friendscount); }else $frnds = '0' ;
			 
			  
			 
               $searchblock .= "
			</div>
			  </li>	";
	$i++;
 } 
 }
  
}
	}
// To get companies as per search input
	if($specific_search=='' || $specific_search=='companies'){
	$this->db->select('*'); 
	$this->db->from('bzz_companyinfo');
	$this->db->like('cmp_name',$value); 
	$this->db->or_like('cmp_industry',$value); 
	$this->db->limit($limit);
	$query = $this->db->get();
	$userdata = $query->result_array();
    if($userdata) {
	  $i = 0;
	  foreach($userdata as $req){
	  $searchblock .= " <li class='col-md-12' onclick='location.href=&#39;".base_url()."company/company_disp/".$req['companyinfo_id']."&#39;'>
        	<div class='member-search-sug'>";
			$searchblock .= "<div class='categoryBlock'>";
			if($i==0) { $searchblock .="Companies"; }
			$searchblock .="</div>";
			if(!empty($req['company_image'])){
$searchblock .= "<figure class='member-sug-pic'><img src='" . base_url() ."uploads/".$req['company_image']."' alt='". $req['cmp_name'] . " '></figure>";
			}else{
				$searchblock .= "<figure class='member-sug-pic'><img src='" . base_url() ."uploads/default_profile_pic.png'></figure>";
			}

		$searchblock .= " <div class='member-search-name'>
            <h4>". $req['cmp_name']."</h4>";
			
			$searchblock .= "<h6>Industry: ".$req['cmp_industry'].", Employees:".$req['cmp_colleagues']."</h6>";
 
               $searchblock .= "</div></li>	";
			   $i++;
	
 } 
 }
	}
// To get jobs as per search input  
if($specific_search=='' || $specific_search=='jobs'){
 $this->db->select('*'); 
	$this->db->from('jobs');
	$this->db->like('job_title',$value);  
	$this->db->or_like('job_keyword',$value); 
	$this->db->or_like('job_requirements',$value);
	$this->db->limit($limit);
	$query = $this->db->get();
	$userdata = $query->result_array();
    if($userdata) {
	   
	  	if(strlen($value)>=3){
		if(strpos($userdata[0]['job_title'],$value)!==false){
			$title_split = explode(' ',$userdata[0]['job_title']);
			foreach($title_split as $part){
			if(strpos($part,$value)!== false){ $value = $part; break; }
			}
		}
		if(strpos($userdata[0]['job_keyword'],$value)!==false){
			$title_split = explode(',',$userdata[0]['job_keyword']);
			foreach($title_split as $part){
			if(strpos($part,$value)!== false){ $value = $part; break; }
			}
		}
		if(strpos($userdata[0]['job_requirements'],$value)!==false){
			$title_split = explode(',',$userdata[0]['job_requirements']);
			foreach($title_split as $part){
			if(strpos($part,$value)!== false){ $value = $part; break; }
			}
		}
	    $searchblock .= "<li class='col-md-12' onclick='location.href=&#39;".base_url()."jobs/search_jobs/".$value."&#39;'>
        	<div class='member-search-sug'>";
			$searchblock .= "<div class='categoryBlock'></div>";
			
				$searchblock .= "<figure class='member-sug-pic'><img src='" . base_url() ."images/default_search.png'></figure>";
			

		$searchblock .= " <div class='member-search-name'>
            <h4>Jobs with <span style='color:#5BC2ED'>". strtoupper($value)."</span> skills</h4>";
			
			
               $searchblock .= "</div></li>	";
		}
	  $i = 0;
	  foreach($userdata as $req){
		  
	$this->db->select('*'); 
	$this->db->from('bzz_companyinfo');
	$this->db->where('companyinfo_id',$req['company_posted_by']);
	$query = $this->db->get();
	$cmp_info = $query->result_array();
		  
		
	  $searchblock .= "<li class='col-md-12' onclick='location.href=&#39;".base_url()."jobs/job_view/".$cmp_info[0]['companyinfo_id']."/".$req['job_id']."&#39;'>
        	<div class='member-search-sug'>";
			$searchblock .= "<div class='categoryBlock'>";
			if($i==0) { $searchblock .="Jobs"; }
			$searchblock .="</div>";
			if(!empty($cmp_info[0]['company_image'])){
$searchblock .= "<figure class='member-sug-pic'><img src='" . base_url() ."uploads/".$cmp_info[0]['company_image']."' alt='". $cmp_info[0]['cmp_name'] . " '></figure>";
			}else{
				$searchblock .= "<figure class='member-sug-pic'><img src='" . base_url() ."uploads/default_profile_pic.png'></figure>";
			}

		$searchblock .= " <div class='member-search-name'>
            <h4>". $req['job_title']."</h4>";
			
			$searchblock .= "<h6>Category: ".$req['job_category']."</h6>";
 
               $searchblock .= "</div></li>	";
			   $i++;
	
 } 
 }

}
//search company events  as per search input



if($specific_search=='' || $specific_search=='events'){
 $this->db->select('*'); 
	$this->db->from('bzz_events');
	$this->db->like('event_name',$value); 
	$this->db->or_like('event_location',$value); 
	 
	$this->db->limit($limit);
	$query = $this->db->get();
	$userdata = $query->result_array();
    if($userdata) {
	  $i = 0;
	  foreach($userdata as $req){
	
	  $searchblock .= "<li class='col-md-12' onclick='location.href=&#39;".base_url()."events/get_event_byid/".$req['event_id']."/".$req['event_cr_cmp']."&#39;'>
        	<div class='member-search-sug'>";
			$searchblock .= "<div class='categoryBlock'>";
			if($i==0) { $searchblock .="Company Events"; }
			$searchblock .="</div>";
			if(!empty($req['event_image'])){
$searchblock .= "<figure class='member-sug-pic'><img src='" . base_url() ."uploads/".$req['event_image']."' alt='". $req['event_name'] . " '></figure>";
			}else{
				$searchblock .= "<figure class='member-sug-pic'><img src='" . base_url() ."uploads/default_profile_pic.png'></figure>";
			}

		$searchblock .= " <div class='member-search-name'>
            <h4>". $req['event_name']."</h4>";
			
			$searchblock .= "<h6>Location: ".$req['event_location']."</h6>";
 
               $searchblock .= "</div></li>	";
			   $i++;
	
 } 
 }
}

// query to get user events

if($specific_search=='' || $specific_search=='events'){
 $this->db->select('*'); 
	$this->db->from('bzz_user_events');
	$this->db->like('event_name',$value); 
	$this->db->or_like('event_location',$value); 
	 
	$this->db->limit($limit);
	$query = $this->db->get();
	$userdata = $query->result_array();
    if($userdata) {
	  $i = 0;
	  foreach($userdata as $req){
	
	  $searchblock .= "<li class='col-md-12' onclick='location.href=&#39;".base_url()."profile/eventview/".$req['event_id']."&#39;'>
        	<div class='member-search-sug'>";
			$searchblock .= "<div class='categoryBlock'>";
			if($i==0) { $searchblock .="User Events"; }
			$searchblock .="</div>";
			if(!empty($req['event_banner'])){
$searchblock .= "<figure class='member-sug-pic'><img src='" . base_url() ."uploads/".$req['event_banner']."' alt='". $req['event_name'] . " '></figure>";
			}else{
				$searchblock .= "<figure class='member-sug-pic'><img src='" . base_url() ."uploads/default_profile_pic.png'></figure>";
			}

		$searchblock .= " <div class='member-search-name'>
            <h4>". $req['event_name']."</h4>";
			
			$searchblock .= "<h6>Location: ".$req['event_location']."</h6>";
 
               $searchblock .= "</div></li>	";
			   $i++;
	
 } 
 }
}







$searchblock .= "</ul>"; 
 echo $searchblock;
}

public function user_frnds($frnd_id)
{
	$id = $this->session->userdata('logged_in')['account_id'];
  	$condition = "(user_id ='" .$frnd_id. "' or friend_id ='".$frnd_id."') AND (user_id = '".$id."' or friend_id ='".$id."')"; 
	$this->db->select('*');
	$this->db->from('bzz_userfriends');
	$this->db->where($condition);
	$query = $this->db->get();
	if($query->num_rows >0)
	{
	return $query->result_array();
}return false;
}

public function user_frnds_by_id($limit,$event_id)
{
	
	    $id = $this->session->userdata('logged_in')['account_id'];
	    $condition = "(user_id ='" .$id. "' or friend_id ='".$id."') AND request_status='Y'";
		$this->db->select('user_id,friend_id');
		$this->db->from('bzz_userfriends');
			 if($limit)
						{
							
						$this->db->limit($limit);
						
						}else{
						$this->db->limit(9);
						}
	
		$this->db->where($condition);
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			$friends = $query->result_array();
			$frnds = array();
			foreach($friends as $friend)
			{
				$frnds[] = $friend['user_id'];
				$frnds[] = $friend['friend_id'];	
			}
		}
		
		//print_r($frnds);
		     $this->db->select('frnd_id');
			 $this->db->from('bzz_user_event_invites');
			  $condition =  "user_id =" . "'" . $id . "'" . " AND " . "event_id = ". "'" .$event_id."'";
			 $this->db->where($condition);
			
			 $query = $this->db->get();
			 $data =  $query->result_array();
			  if($data)
			  $invited_users = array();
			 foreach($data as $data)
			 {
				$invited_users[] = $data['frnd_id'];
		
			 
			 
			// print_r($invited_users);
			 
	
		$all_users = array_merge($frnds,$invited_users);
		//print_r($all_users);
		
		$invited_frnds = array_unique(array_diff($all_users,$invited_users));
		//print_r($invited_frnds);
			 }

		if(!empty($invited_frnds))
			{
		$usr_ids = array_unique($invited_frnds);
			}else
			{
		$usr_ids = array_unique($frnds);
			}
			
			
		$key = array_search($id,$usr_ids);
		if($key!==false)
		{
  		unset($usr_ids[$key]);
		}
		 $userdata = array();
		 if($usr_ids)
		 {
			foreach($usr_ids as $user_id)
			{
				 $usercondition = "user_id ="."'".$user_id."'";
						 $this->db->select('*');
						 $this->db->from('bzz_user_images');
						 $this->db->where($usercondition);
				
						 $query = $this->db->get();
						 if($query->num_rows > 0)
						 {
							$this->db->select('*');
							$this->db->from('bzz_users');
							$this->db->join('bzz_user_images','bzz_users.user_id=bzz_user_images.user_id AND bzz_users.user_id='.$user_id);
							$this->db->join('bzz_userinfo','bzz_users.user_id=bzz_userinfo.user_id');
							$this->db->order_by('bzz_user_images.user_imageinfo_id','desc');
							$query = $this->db->get();
							$user_data =  $query->result_array();
							
						 }else{
							  $this->db->select('*');
							// $this->db->limit(2);
							  $this->db->from('bzz_users');
							  $this->db->join('bzz_userinfo','bzz_users.user_id=bzz_userinfo.user_id AND bzz_users.user_id='.$user_id);
							 // $this->db->where($followercondition);
							  $query = $this->db->get(); 
							   $user_data =  $query->result_array();
						 }
						  $userdata[] = $user_data;
					}
					
			return $userdata;
		 }else
		 return false;
		

}

	public function addFollowFriend_Request($frnd_id)
	{
		
		$id = $this->session->userdata('logged_in')['account_id'];
	$frndcondition = "((user_id ='" .$frnd_id. "' or friend_id ='".$frnd_id."') AND (user_id = '".$id."' or friend_id ='".$id."')) AND (request_status!='Y' OR request_status!='W')"; 
		
		//$frndcondition =  "user_id =" . "'" . $frnd_id . "' AND (request_status!='Y' OR request_status!='W') AND friend_id =" . "'" . $id . "'" ;
		$this->db->select('*');
		$this->db->from('bzz_userfriends');
		$this->db->where($frndcondition);
		$query = $this->db->get();
		$data = $query->result_array();
		if($data)
		{
	
	    $condition = "(user_id ='" .$frnd_id. "' or friend_id ='".$frnd_id."') AND (user_id = '".$id."' or friend_id ='".$id."')"; 
		
			$data = array(
               'request_status' => 'W',
            );
			$this->db->where($condition);
			$this->db->update('bzz_userfriends', $data); 
		}
		else{
			 $condition = "(user_id ='" .$frnd_id. "' or friend_id ='".$frnd_id."') AND (user_id = '".$id."' or friend_id ='".$id."')"; 
		
			$data = array(
				'user_id' => $id,
				'friend_id' => $frnd_id,
               'request_status' => 'W',
            );
			$this->db->where($condition);
			$this->db->insert('bzz_userfriends', $data); 
		
		}
	
	}
	
	
	
	 public function invite_friends_to_user_event($name='',$addedusers='',$user_id='',$limit='')
  {
	  
	    $id = $this->session->userdata('logged_in')['account_id'];
		
		if($user_id!='')
		$id = $user_id;
	    $condition = "(user_id ='".$id."' OR friend_id='".$id."') AND request_status='Y'";
		if($addedusers!='')
		{
		$condition.= " AND (user_id NOT IN (".$addedusers.") AND friend_id NOT IN (".$addedusers.") )";
		}
		 $this->db->select('*');
			 $this->db->from('bzz_user_event_invites');
			 $this->db->where('user_id',$id);
			 $query = $this->db->get();
			 $data =  $query->result_array();
			  if(!empty($data))
			 foreach($data as $data){
				
		$condition.= " AND (user_id NOT IN (".$data['frnd_id'].") AND friend_id NOT IN (".$data['frnd_id'].") )";
			 }
		
		if($limit!='')
		$condition .=" LIMIT 0,".$limit;
		//echo $condition ; exit;
		$this->db->select('*');
		$this->db->from('bzz_userfriends');
		$this->db->where($condition);
		$query = $this->db->get();
		if ($query->num_rows() >0) {
			$friends = $query->result_array();
			$frnds = array();
			foreach($friends as $friend)
			{
				if($friend['friend_id']==$id)
			    $condition = "user_id =" . "'" . $friend['user_id'] . "'";
				else
				$condition = "user_id =" . "'" . $friend['friend_id'] . "'";
				if($name!='')
				{
					$condition.= " AND (user_firstname LIKE '%".$name."%' OR user_lastname LIKE '%".$name."%' )"; 
				}
				if($addedusers!=''){
					$condition.= " AND user_id NOT IN (".$addedusers.")";
				}
				
				$this->db->select('*');
				$this->db->from('bzz_userinfo');
				$this->db->where($condition);
				$query = $this->db->get();
				$frnd = array();
				if ($query->num_rows() == 1) {
					$result = $query->result_array();	
					$frnd['name'] = $result[0]['user_firstname'].' '.$result[0]['user_lastname'];	
					$this->db->select('*');
				$this->db->from('bzz_user_images');
				if($friend['friend_id']==$id)
			    $condition = "user_id =" . "'" . $friend['user_id'] . "'";
				else
				$condition = "user_id =" . "'" . $friend['friend_id'] . "'";
				$this->db->where($condition);
				$this->db->order_by('user_imageinfo_id','desc');
				$query = $this->db->get();
				$result = $query->result_array();
				if($result)
				$frnd['image'] = $result[0]['user_img_thumb'];
				else
				$frnd['image'] =  'default_profile_pic.png';
				if($friend['friend_id']==$id)
				$frnd['id'] = $friend['user_id'];
				else
				$frnd['id'] = $friend['friend_id'];
				$frnds[] = $frnd;				
				}
				
			}
			return $frnds;
		} else {
		return false;
		}
   }

   public function get_online_frnds($name){
	   $frnds = $this->getfriends($name); 
	  
	   if($frnds){
			$friends = array();
			foreach($frnds as $frnd){
			//$friends  .= $frnd['id'].','; 	
			$condition = "user_id = '".$frnd['id']."'";
			$this->db->select('*');
			$this->db->from('bzz_user_activity_log');
			$this->db->where($condition);
			$query = $this->db->get();
				if ($query->num_rows() == 1) {		
						$user_activity = $query->result_array();
						$frnd['last_active'] = $user_activity[0]['last_active'];		
				}else{ $frnd['last_active'] = 0;}
				$friends[] = $frnd;
			}
			return $friends;
	   }else{
		   return false;
	   }
   }

	
}
?>