jQuery(document).ready(function($){
    $('#form_post_link_ajax').submit(function(){
        $('#msg').html( msg_ok );
		$(".generador_form").last().addClass("generate_ajax");
        $.ajax({
            type: 'POST',
            url: SendLinks.ajaxurl,
			action: 'post_links',
            data: $(this).serialize()
        })
        .done(function(data){
			/* location.reload(); */
        })
        return false;

    });
});