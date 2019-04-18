<?php 
/**
 * Class to add and delete the favorite action 
 */
class BPWF_Model_Model 
{
    private $db;

    public function __construct()
    {
        global $wpdb;
        $this->db = $wpdb;
    }

    public function add($activity_id, $user_id)
    {
        $table_name = $this->db->prefix . 'bpwhofav';
        $this->db->insert( 
	        $table_name, 
	        array( 
		        'time' => current_time( 'mysql' ), 
                'activity_id' => $activity_id,
                'fav_user_id' => $user_id 
	        ) 
        );
    }

    public function delete($activity_id, $user_id)
    {
        $table_name = $this->db->prefix . 'bpwhofav';  
        $this->db->delete( 
	        $table_name, 
	        array(  
                'activity_id' => $activity_id,
                'fav_user_id' => $user_id 
	        ) 
        );

    }
    /**
     * Get all user ids who favorited the activity
     * @param int activity_id
     * @return array user_ids
     */

    public function get_ids($activity_id)
    {
        $table_name = $this->db->prefix . 'bpwhofav';  
        $fav_user_ids = $this->db->get_results('SELECT fav_user_id FROM '.$table_name.' WHERE activity_id = '.$activity_id.' ORDER BY time DESC LIMIT 0,3', ARRAY_N);
        foreach ($fav_user_ids as $user_id)
        {
            $user_ids[] = $user_id[0];
        }
        return $user_ids;
    }

    public function get_user_images_modal($activity_id,$offset,$count)
    {
        $table_name = $this->db->prefix . 'bpwhofav';  
        $fav_user_ids = $this->db->get_results('SELECT fav_user_id FROM '.$table_name.' WHERE activity_id = '.$activity_id.' ORDER BY time DESC LIMIT '.$offset.','.$count, ARRAY_N);
        $count = $this->get_count($activity_id);
        $users[] = array('count'=> $count);
        foreach ($fav_user_ids as $user_id)
        {
            $img_url =  bp_core_fetch_avatar ( 
                                array(  'item_id' => $user_id[0], 
                                        'type'    => 'thumb',
                                        'html'   => FALSE    
                               )) ;
            $user_url = bp_core_get_userlink($user_id[0], '', true);
            $user_name = bp_core_get_userlink($user_id[0], true, '');
            $users[] = array(
                'name' => $user_name,
                'url' => $user_url,
                'img' => $img_url
            );
        }
        return $users;
    }

    public function get_user_images_page($activity_id,$offset,$count)
    {
        
        $table_name = $this->db->prefix . 'bpwhofav';  
        $fav_user_ids = $this->db->get_results('SELECT fav_user_id FROM '.$table_name.' WHERE activity_id = '.$activity_id.' ORDER BY time DESC LIMIT '.$offset.','.$count, ARRAY_N);
        foreach ($fav_user_ids as $user_id)
        {
            $img_url =  bp_core_fetch_avatar ( 
                                array(  'item_id' => $user_id[0], 
                                        'type'    => 'thumb',
                                        'html'   => FALSE    
                               )) ;
            $user_url = bp_core_get_userlink($user_id[0], '', true);
            $user_name = bp_core_get_userlink($user_id[0], true, '');
            $users[] = array(
                'name' => $user_name,
                'url' => $user_url,
                'img' => $img_url
            );
        }
        $count = $this->get_count($activity_id);
        $users[] = array('count'=> $count);
        return $users;
    }

    public function get_count($activity_id)
    {
        $table_name = $this->db->prefix . 'bpwhofav';  
        $fav_count = $this->db->get_var('SELECT COUNT(*) FROM '.$table_name.' WHERE activity_id = '.$activity_id);
        return $fav_count;   
    }

    public function delete_who_fav($activity_id)
    {
        $table_name = $this->db->prefix . 'bpwhofav';

        $this->db->delete( $table_name, array( 'activity_id' => $activity_id ), array( '%d' ) );
        
        
    }
}