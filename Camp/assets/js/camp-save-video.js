jQuery(function($){ // use jQuery code inside this to avoid "$ is not defined" error
    $('.camp-save-video').click(function(){
		
		var url_video=$('input[name=input_video_camp]').val();
		var id_user_video=$('input[name=input_id_user_video]').val();
		var type_user_video=$('input[name=type_user_video]').val();
		
        var button = $(this),
            data = {
            'action': 'campsavevideo',
            'url_video' : url_video,
			'id_user_video' : id_user_video,
			'type_user_video' : type_user_video
        };
 
        $.ajax({ // you can also use $.post here
            url : camp_save_video_params.ajaxurl, // AJAX handler
            data : data,
			dataType: "json",
            type : 'POST',
            beforeSend : function ( xhr ) {
                button.text('Loading...'); // change the button text, you can also add a preloader image
            },
            success : function( response ){                
				if( response.verdict==1 ) { 
                    $(".camp-save-video").text("Save");
					$(".camp-save-video").animate({ backgroundColor: "green", color: "white" }, 1000);
					button.after('<div class="camp-video-notif" style="color:green; font-size:1.3em;"><strong>Save complete !</strong></div>');
					$(".camp-video-notif").fadeOut(5000);					
                } else {
					alert(response.verdict);
                    $(".camp-save-video").text("Save");
					$(".camp-save-video").animate({ backgroundColor: "red", color: "white" }, 1000);
					button.after('<div class="camp-video-notif" style="color:green; font-size:1.3em;"><strong>Error ... ressayer !</strong></div>');
					$(".camp-video-notif").fadeOut(5000);
				}
				
            }
			
        });
    });
});