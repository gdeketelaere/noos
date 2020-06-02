jQuery(function($){ // use jQuery code inside this to avoid "$ is not defined" error
    $('.camp_loadmore3').click(function(){
		
		var speciality=$('#camp_specialities_search_blog_3').val();
		var symtome=$('#camp_symtome_search_blog_3').val();
		var language=$('#camp_language_search_blog_3').val();
		var hidden_page_3=$('#hidden_page_3').val();
		var max_page_3=$('#max_page_3').val();
		
        var button = $(this),
            data = {
			'speciality' : speciality,
			'symtome' : symtome,
			'language' : language,
			'hidden_page_3' : hidden_page_3,
			'max_page_3' : max_page_3,
            'action': 'loadmore3'			
        };
 
        $.ajax({ // you can also use $.post here
            url : camp_loadmore_params3.ajaxurl, // AJAX handler
            data : data,
            type : 'POST',
            beforeSend : function ( xhr ) {
				$('#hidden_page_3').remove();
				$('#max_page_3').remove();
                button.text('Loading...'); // change the button text, you can also add a preloader image
            },
            success : function( data ){
                if( data ) { 
                    button.text( 'Voir plus d\'articles' ).prev().before(data);      
 
                    if ( hidden_page_3 == max_page_3 ) 
                        button.remove(); 
                } else {
                    button.remove(); // if no data, remove the button as well
                }
            }
        });
    });
});