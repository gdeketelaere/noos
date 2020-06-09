jQuery(function($){ // use jQuery code inside this to avoid "$ is not defined" error
    $('.camp-save-kids').click(function(){
		
		var kid=$('input[name=input_kids_camp]:checked').val();
		var id_user_kids=$('input[name=input_id_user_kids]').val();
		var type_user_kids=$('input[name=type_user_kids]').val();
		var kids=parseInt(kid);
		alert(kids);
		
        var button = $(this),
            data = {
            'action': 'campsavekids',
            'kids' : kids,
			'id_user_kids' : id_user_kids,
			'type_user_kids' : type_user_kids
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
                    $(".camp-save-kids").text("Save");
					$(".camp-save-kids").animate({ backgroundColor: "green", color: "white" }, 1000);
					button.after('<div class="camp-kids-notif" style="color:green; font-size:1.3em;"><strong>Save complete !</strong></div>');
					$(".camp-kids-notif").fadeOut(5000);					
                } else {
					alert(response.verdict);
                    $(".camp-save-kids").text("Save");
					$(".camp-save-kids").animate({ backgroundColor: "red", color: "white" }, 1000);
					button.after('<div class="camp-kids-notif" style="color:green; font-size:1.3em;"><strong>Error ... ressayer !</strong></div>');
					$(".camp-kids-notif").fadeOut(5000);
				}
				
            }
			
        });
    });
});