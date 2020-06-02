jQuery(function($){ // use jQuery code inside this to avoid "$ is not defined" error
    $('.search-blog-2').click(function(){
		var speciality=$('#camp_specialities_search_blog_2').val();
		var symtome=$('#camp_symtome_search_blog_2').val();
		var language=$('#camp_language_search_blog_2').val();
		var button = $(this),
            data = {
            'action': 'camptopread',
            'speciality' : speciality,
			'symtome' : symtome,
			'language' : language
        };
 
        $.ajax({ // you can also use $.post here
            url : camp_search_top_read_params.ajaxurl, // AJAX handler
            data : data,
            type : 'POST',
            beforeSend : function ( xhr ) {
                //button.val('Loading...');  change the button text, you can also add a preloader image
				$('#camp-blog-2').remove();
				$('#camp_response_sb_2').html('<div id="notif_sb_2" style="text-align:center;" ><p style="color:green; font-size:1.3em;">Loading...</p></div>');
            },
            success : function( data ){                
					
					$('#notif_sb_2').remove();
                    $('#camp_response_sb_2').after(data); // insert data
                
            }
        });
        
    });
});