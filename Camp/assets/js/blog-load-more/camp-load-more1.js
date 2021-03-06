jQuery(function($){ // use jQuery code inside this to avoid "$ is not defined" error
    $('.camp_loadmore1').click(function(){
		
		var speciality=$('#camp_specialities_search_blog_1').val();
		var symtome=$('#camp_symtome_search_blog_1').val();
		var language=$('#camp_language_search_blog_1').val();
		var hidden_page_1=$('#hidden_page_1').val();
		var max_page_1=$('#max_page_1').val();
		
        var button = $(this),
            data = {
			'speciality' : speciality,
			'symtome' : symtome,
			'language' : language,
			'hidden_page_1' : hidden_page_1,
			'max_page_1' : max_page_1,
            'action': 'loadmore1'			
        };
 
        $.ajax({ // you can also use $.post here
            url : camp_loadmore_params1.ajaxurl, // AJAX handler
            data : data,
            type : 'POST',
            beforeSend : function ( xhr ) {
				$('#hidden_page_1').remove();
				$('#max_page_1').remove();
                button.text('Loading...'); // change the button text, you can also add a preloader image
            },
            success : function( data ){
                if( data ) { 
                    button.text( 'Voir plus d\'articles' ).prev().before(data);      
 
                    if ( hidden_page_1 == max_page_1 ) 
                        button.remove(); 
                } else {
                    button.remove(); // if no data, remove the button as well
                }
            }
        });
    });
});