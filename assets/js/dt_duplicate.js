/* Verificar contendio duplicado */
jQuery(document).ready(function($){
    function dtDuplicateAjax(title, id) {
        var data = {
            action: 'dt_duplicate',
            post_title: title,
            post_id: id
        };
        $.post(ajaxurl, data, function(respuesta) {
            $('#message').remove();
            $('#postbox-container-2').prepend('<div id=\"message\">'+respuesta+'</div>');
        }); 
    };

    $('#comprovate').click(function() {
        var title = $('#title').val();
        var id = $('#post_ID').val();
        dtDuplicateAjax(title, id);
    });

	// Segundo modo
	function dtDuplicateAjax2(title, id) {
        var data = {
            action: 'dt_duplicate',
            post_title: title,
            post_id: id
        };
        $.post(ajaxurl, data, function(respuesta) {
            $('#message2').remove();
            $('#postdivrich').prepend('<div id=\"message2\">'+respuesta+'</div>');
        }); 
    };

	$('#publish').hover(function() {
        var title = $('#title').val();
        var id = $('#post_ID').val();
        dtDuplicateAjax2(title, id);
    });

	$('#title').click(function() {
        var title = $('#title').val();
        var id = $('#post_ID').val();
        dtDuplicateAjax2(title, id);
    });
});
