<?php 
/**
 * Class to output front end i.e favorite info
 */
class BPWF_View_Front 
{
    public function __construct($user_ids, $fav_count)
    {
        $this->show_faces($user_ids, $fav_count);
    }

    public function show_faces($user_ids, $fav_count)
    {
        $totla_fav_count = $fav_count;
        $user_to_show_face = count($user_ids);
        $more_people_string = $fav_count - $user_to_show_face;
        ?>
        <div class="bwf">
        <ul>
        <?php
        foreach($user_ids as $user_id)
        {
            $img_url = bp_core_fetch_avatar ( 
                array(  'item_id' => $user_id, 
                        'type'    => 'thumb',
                        'html'   => FALSE    
                )) ;
            echo '<li><img src="'.$img_url.'"></li>';
        }
        ?>
        
        <?php if($more_people_string > 0) {echo '<li id="bpwf-more-people"><a name="Favorited by" href="#TB_inline?width=300&height=400&inlineId=bpwf-more-people-modal-'.bp_get_activity_id().'" class="thickbox"> + <span id="favCount">'.$more_people_string.'</span> more people</a></li>';} ?>
        </ul>
        <?php add_thickbox(); ?>
        <div id="bpwf-more-people-modal-<?php echo bp_get_activity_id();?>" style="display:none;">
            <div class="bwf-modal">
                <ul>
                <div class="spinning"></div>
                </ul>
            </div>
            <div class="bwf-modal-footer">
                <a href="#" data-page="0" id="prev">Prev</a><a href="#" data-page="1" id="next"> Next</a>
            </div>
        </div>
        </div>
        <?php
    }

}