jQuery(function($){ // use jQuery code inside this to avoid "$ is not defined" error
    $('.search-blog-1').click(function(){
		var speciality=$('#camp_specialities_search_blog_1').val();
		var symtome=$('#camp_symtome_search_blog_1').val();
		var language=$('#camp_language_search_blog_1').val();
		var button = $(this),
            data = {
            'action': 'camplastposts',
            'speciality' : speciality,
			'symtome' : symtome,
			'language' : language
        };
 
        $.ajax({ // you can also use $.post here
            url : camp_search_last_posts_params.ajaxurl, // AJAX handler
            data : data,
            type : 'POST',
            beforeSend : function ( xhr ) {
                //button.val('Loading...');  change the button text, you can also add a preloader image
				$('#camp-blog-1').remove();
				$('#camp_response_sb_1').html('<div id="notif_sb_1" style="text-align:center;" ><p style="color:green; font-size:1.3em;">Loading...</p></div>');
            },
            success : function( data ){                
					$('#notif_sb_1').remove();
                    $('#camp_response_sb_1').after(data); // insert data
                
            }
        });
        
    });
});