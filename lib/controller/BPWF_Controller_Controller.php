<?php

/**
 * Class to extend the request of favorite and unfavorite action
 */

 class BPWF_Controller_Controller
 {
    private $model;

    public function __construct()
     {
         $this->model = new BPWF_Model_Model();
         add_action('bp_activity_add_user_favorite', array($this, 'add_favorite' ), 10, 2);
         add_action('bp_activity_remove_user_favorite', array($this, 'remove_favorite'), 10, 2);
         add_action('bp_activity_entry_content', array($this, 'user_who_favorited'));
         add_action( 'wp_ajax_nopriv_bpwf_get_who_fav_modal', array($this, 'bpwf_who_fav_modal' ));
         add_action( 'wp_ajax_bpwf_get_who_fav_modal', array($this, 'bpwf_who_fav_modal' ));
         add_action( 'wp_ajax_nopriv_bpwf_get_who_fav_page', array($this, 'bpwf_who_fav_page' ));
         add_action( 'wp_ajax_bpwf_get_who_fav_page', array($this, 'bpwf_who_fav_page' ));
         add_action('bp_activity_delete', array($this, 'bpwf_delete'), 10, 1);
         
     }

     public function add_favorite($activity_id, $user_id)
     {
        $this->model->add($activity_id, $user_id);
     }

     public function remove_favorite($activity_id, $user_id)
     {
        $this->model->delete($activity_id, $user_id);
     }

     public function user_who_favorited()
     {
        $activity_id =  bp_get_activity_id();
        $user_ids = $this->model->get_ids($activity_id);
        $fav_count = $this->model->get_count($activity_id);
        new BPWF_View_Front($user_ids, $fav_count); 
     }

     public function bpwf_who_fav_modal()
     {
        if(isset($_POST['activity_id']))
        {
            if(isset($_POST['pagenumber']))
            {
                $pagenumber = $_POST['pagenumber'];
            }
            else
            {
                $pagenumber = 0;
            }
            
            $user_images = $this->model->get_user_images_modal($_POST['activity_id'], $pagenumber, 1);
            echo json_encode($user_images,JSON_FORCE_OBJECT);
        } 
        
         exit;
     }
     public function bpwf_who_fav_page()
     {
        if(isset($_POST['activity_id']))
        {   
            $user_images = $this->model->get_user_images_page($_POST['activity_id'], 0 , 3);
            echo json_encode($user_images,JSON_FORCE_OBJECT);
        } 
        
         exit;
     }

     public function bpwf_delete($args)
     {
        $this->model->delete_who_fav($args['id']);
     }
 }