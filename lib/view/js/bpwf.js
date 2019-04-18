(function($){
    $(document).ready(function () {
        

        $(document).bind('bpwfcallback','div.activity-meta', function(event) {
            
            var target = $(event.target);
    
            /* Favoriting activity stream items */
            if ( target.hasClass('fav') || target.hasClass('unfav') ) {
                var parent = target.closest('.activity-item');
                var parent_id = parent.attr('id').substr( 9, parent.attr('id').length );
               function who_favorited()
               {
                    $.ajax({
                    url: bpwfAjax.ajaxurl,
                    type: 'post',
                    dataType: 'json',
                    data: {
                        activity_id: parent_id,
                        action: 'bpwf_get_who_fav_page'
                    },
                    success : function(response) {
                            var option ='';
                            $.each(response, function(index,value){
                                if(index == 3 && value.count > 3)
                                {
                                    tb_init('.thickbox');
                                    option = option + '<li id="bpwf-more-people"><a name="Favorited by" href="#TB_inline?width=300&height=400&inlineId=bpwf-more-people-modal-'+parent_id+'" class="thickbox"> + <span id="favCount"> '+(value.count-3)+'</span> more people</a></li>';
                                }else if(index !=3)
                                {
                                    option = option + '<li><img src="' + value.img + '"></li>';
                                }
                            });
                            target.closest('div').parent().find('.bwf ul').empty();
                            target.closest('div').parent().find('.bwf ul').append(option);
                            
                            
                    }
                    });
               }
               who_favorited();
                
            }
        });

        // Function to make ajax call to get users who favorited
        var activityId;
        var pageNumber;
        function getUserWhoFav(activityId, pageNumber)
        {
            $.ajax({
                url: bpwfAjax.ajaxurl,
                type: 'post',
                dataType: 'json',
                data: {
                    activity_id: activityId,
                    action: 'bpwf_get_who_fav_modal',
                    pagenumber: pageNumber
                },
                success : function(response) {      
                        var option ='';
                        $.each(response, function(index,value){
                            if(index == 0)
                            {
                               // $('#TB_ajaxContent .bwf-modal-footer').html('');
                            }else
                            {
                            option = option + '<li><a href="'+value.url+'" data-bp-tooltip="'+value.name+'"><img src="' + value.img + '"><span class="name">'+value.name+'</span></a></li>';
                            }    
                        });

                        $('#TB_ajaxContent .bwf-modal ul').html(option);
                        
                }
                
            }); 
        }


        // Ajax Modal Call
        $('.thickbox').click(function(event){
            var target = $(event.target);
            var parent = target.closest('.activity-item');
            var parent_id = parent.attr('id').substr( 9, parent.attr('id').length );
            getUserWhoFav(parent_id,0);
        })

        
        $( document ).on( 'click', '#TB_ajaxContent .bwf-modal-footer a#next', function(event) {
            event.preventDefault();
            pageNumber = $(this).attr('data-page');
            getUserWhoFav(5,pageNumber);

            $("#TB_ajaxContent .bwf-modal-footer a#prev").attr('data-page', pageNumber-1);    
            $("#TB_ajaxContent .bwf-modal-footer a#next").attr('data-page', ++pageNumber);
                

            
        });

                
        $( document ).on( 'click', '#TB_ajaxContent .bwf-modal-footer a#prev', function(event) {
            event.preventDefault();
            pageNumber = $(this).attr('data-page');
            getUserWhoFav(5,pageNumber);

                $("#TB_ajaxContent .bwf-modal-footer a#prev").attr('data-page', pageNumber-1);
                $("#TB_ajaxContent .bwf-modal-footer a#next").attr('data-page', ++pageNumber);

            
        });
    });
})(jQuery);