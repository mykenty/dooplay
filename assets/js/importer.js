/****
@since 1.2.0
***/
jQuery(document).ready(function($) {
	// Tabs
	$('ul.tabs li').click(function(){
		var tab_id = $(this).attr('data-tab')
		$('ul.tabs li').removeClass('current')
		$('.tab-content').removeClass('current')
		$(this).addClass('current')
		$('#'+tab_id).addClass('current')
	});

	// Filtrar contenido peliculas
	$('#search_imdb').submit(function(){
		var iYear = $('input[name=imdbyear]').val()
		var iPage = $('input[name=imdbpage]').val()
		console.log( DTapi.preresultadolog )
		$('#resultado').html('<div class="content"><span class="spinner"></span> '+ DTapi.preresultado +'</div>')
		$('input[name=search_data_imdb]').prop('disabled', true)
		$('input[name=search_data_imdb]').val( DTapi.loading )
		$.ajax({
			type:'POST',
			url:DTapi.ajaxurl + '?action=dbm_get_movies',
			data:$(this).serialize()
		})
		.done(function(data){
			console.log( DTapi.resultadolog )
			$('input[name=imdbpage]').val( parseFloat(iPage) + parseFloat(1))
			$('#resultado').html('<div class="content">' + data + '</div>')	
			$('input[name=search_data_imdb]').prop('disabled', false)
			$('input[name=search_data_imdb]').val( DTapi.getcontent )
			// Insertando contenido
			$('.a_import_imdb').click(function(e) {
				var Data = $(this).data("id")
				var MegaId = "#" + Data
				$('input[name=idmovie]').val(  Data  )
				$('input[name=send_id_movie]').trigger('click')
				$('#single_url_li').trigger('click')
				$( MegaId ).hide('fast')
			});
			// continuar la busqueda...
			$('#load_more_imdb_link').click(function() {
				$('input[name=search_data_imdb]').trigger('click')
				$('#filter_year_li').trigger('click');
			});
		})
		.fail(function(data){
			console.log( DTapi.resultadoerror )
			$('#resultado').html('<div class="content">' + DTapi.resultadoerror + '</div>')
		})
		return false;
	});

	// Buscando todo el contenido...
	$('#search_all').submit(function(){
		$('#resultado').html('<div class="content"><span class="spinner"></span> '+ DTapi.preresultado +'</div>')
		var tPage = $('input[name=page]').val()
		$.ajax({
			type:'POST',
			url:DTapi.ajaxurl + '?action=dbm_search_all',
			data:$(this).serialize()
		})
		.done(function(data){
			$('input[name=page]').val( parseFloat(tPage) + parseFloat(1))
			$('#resultado').html('<div class="content">' + data + '</div>')
			// Insertando Peliculas
			$('.a_import_imdb').click(function(e) {
				var Data = $(this).data("id")
				var MegaId = "#" + Data
				$('input[name=idmovie]').val(  Data  )
				$('input[name=send_id_movie]').trigger('click')
				$( MegaId ).hide('fast')
			});
			// Insertando Series
			$('.a_import_tmdb').click(function(e) {
				var Data = $(this).data("id")
				var MegaId = "#" + Data
				$('input[name=idtv]').val( Data )
				$('input[name=send_id_tv]').trigger('click')
				$( MegaId ).hide('fast')
			});
			// continuar la busqueda...
			$('#load_more_search').click(function() {
				$('button[name=search_all_data').trigger('click')
			});
		})
		.fail(function(data){
			console.log( DTapi.resultadoerror )
			$('#resultado').html('<div class="content">' + DTapi.resultadoerror + '</div>')
		})
		return false;
	});

	// Enviar contenido de peliculas a la base de datos
	$('#single_url_imdb').submit(function(){
		var URL = $('input[name=idmovie]').val()
		console.log( DTapi.agregandodatoslog )
		$('#add_data_post').html('<p><span class="spinner"></span> '+ DTapi.agregandodatos +'</p>')
		$.ajax({
			type:'POST',
			url:DTapi.ajaxurl + '?action=dbm_post_movie',
			data:$(this).serialize()
		})
		.done(function(data){
			$('input[name=idmovie]').val('');
			$('#add_data_post').html('<p>'+ data + '</p>')
			console.log( DTapi.procesocompleto )
		})
		.fail(function(data){
			console.log( DTapi.postdataerror )
			$('#add_data_post').html('<p>' + DTapi.postdataerror + '</p>')
		})
		return false;
	});

	// Filtrar contenido de series
	$('#search_tmdb').submit(function(){
		var tYear = $('input[name=tmdbyear]').val()
		var tPage = $('input[name=tmdbpage]').val()
		console.log( DTapi.preresultadolog )
		$('#resultado').html('<div class="content"><span class="spinner"></span> '+ DTapi.preresultado +'</div>')
		$('input[name=search_data_tmdb]').prop('disabled', true)
		$('input[name=search_data_tmdb]').val( DTapi.loading )
		$.ajax({
			type:'POST',
			url:DTapi.ajaxurl + '?action=dbm_get_tv',
			data:$(this).serialize()
		})
		.done(function(data){
			$('input[name=tmdbpage]').val( parseFloat(tPage) + parseFloat(1))
			console.log( DTapi.resultadolog )
			$('#resultado').html('<div class="content">'+ data + '</div>')
			$('input[name=search_data_tmdb]').prop('disabled', false)
			$('input[name=search_data_tmdb]').val( DTapi.getcontent )
			// Insertando contenido
			$('.a_import_tmdb').click(function(e) {
				var Data = $(this).data("id")
				var MegaId = "#" + Data
				$('input[name=idtv]').val( Data )
				$('input[name=send_id_tv]').trigger('click')
				$('#single_url_li').trigger('click')
				$( MegaId ).hide('fast')
			});
			// continuar la busqueda...
			$('#load_more_tmdb_link').click(function() {
				$('input[name=search_data_tmdb]').trigger('click')
				$('#filter_year_li').trigger('click');
			});
		})
		.fail(function(data){
			console.log( DTapi.postdataerror )
			$('#resultado').html('<div class="content">' + DTapi.postdataerror + '</div>')
		})
		return false;
	});
	
	// Enviar contenido a la base de datos desde TMDb
	$('#single_url_tmdb').submit(function(){
		var URL = $('input[name=idtv]').val()
		console.log( DTapi.agregandodatoslog )
		$('#add_data_post').html('<p><span class="spinner"></span> '+ DTapi.agregandodatos +'</p>')
		$.ajax({
			type:'POST',
			url:DTapi.ajaxurl + '?action=dbm_post_tv',
			data:$(this).serialize()
		})
		.done(function(data){
			$('input[name=idtv]').val('');
			$('#add_data_post').html('<p>'+ data + '</p>')
			console.log( DTapi.procesocompleto )
		})
		.fail(function(data){
			console.log( DTapi.postdataerror )
			$('#add_data_post').html('<p>' + DTapi.postdataerror + '</p>')
		})
		return false;
	});
	
	// API Server status
	$('#api_status').submit(function(){
		$('#add_data_post').html('<p><span class="spinner"></span> '+ DTapi.queryserver +'</p>')
		console.log( DTapi.preresultadolog )
		$.ajax({
			type:'POST',
			url:DTapi.ajaxurl + '?action=dbm_status',
			data:$(this).serialize()
		})
		.done(function(data){
			console.log( DTapi.resultadolog )
			$('#add_data_post').html('<p>' + DTapi.verificationsr + '</p>')
			$('#result_server').html( data )
			$('.skillbar').each(function(){
				$(this).find('.skillbar-bar').animate({
					width:$(this).attr('data-percent')
				},500);
			});
		})
		.fail(function(data){
			console.log( DTapi.postdataerror )
			$('#result_server').html( DTapi.postdataerror )
		})
		return false;
	});

	// Resetear numero de pagina IMDb
	$('input[name=imdbyear]').click(function() {
		$('input[name=imdbpage]').val('1');
	});
	
	// Resetear numero de pagina TMDb
	$('input[name=tmdbyear]').click(function() {
		$('input[name=tmdbpage]').val('1');
	});

	// Resetear numero de pagina Search
	$('input[name=query]').click(function() {
		$('input[name=page]').val('1');
	});
})