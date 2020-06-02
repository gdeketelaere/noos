jQuery(function($){ // use jQuery code inside this to avoid "$ is not defined" error
    $('#_camp_see_more_articles').click(function(){
		var _sm_link = $('#_camp_see_more_articles_link').val();
		var _linked_profile = $('#_linked_profile').val();
        var button = $(this),
            data = {
            'action': 'campseemore',
			'_linked_profile': _linked_profile
        };
 
        $.ajax({ 
            url : camp_see_more_params.ajaxurl, // AJAX handler
            data : data,
            type : 'POST',
            beforeSend : function ( xhr ) {
                button.text('Redirection ...'); // change the button text, you can also add a preloader image
            },
            success : function( response ){          
				
				button.text("Voir plus");
				window.location.href = _sm_link;
            }
			
        });
    });
});