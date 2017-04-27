// Ajax functions jQuery
jQuery(document).ready(function($){
	// Load Movies
	$(document).on('click','.load_list_movies', function(){
		var that 		= $(this);
		var page 		= that.data('page');
		var newPage 	= page+1;
		var user 		= that.data('user');
		var typepost 	= that.data('type');
		var ajaxurl		= dtAjax.url;
		$('#items_movies').addClass('loading');
		$.ajax({
			url : ajaxurl,
			type : 'post',
			data : {
				page : page,
				typepost : typepost,
				user : user,
				action : 'next_page_list'
			},
			error : function( response ){
				console.log(response);
			},
			success : function( response ){
				that.data('page', newPage);
				$('#items_movies').append( response );
				$('#items_movies').removeClass('loading');
			}
		});
	});

	// Delete notice report
	$(document).on('click','.delete_notice', function(){
		var that	= $(this);
		var id		= that.data('id');
		var ajaxurl = dtAjax.url;
		$.ajax({
			url : ajaxurl,
			type : 'post',
			data : {
				id : id,
				action : 'delete_notice_report',
			},
			error : function( response ) {
				console.log('Error');
			},
			success : function( response ){
				console.log('Deleted');
				$(".reports_notice_admin").hide();
			},
		});
	});

	// Update IMDb Rating
	$(document).on('click','#update_imdb_rating', function(){
		var that	= $(this);
		var id		= that.data('id');
		var imdb	= that.data('imdb');
		var ajaxurl = dtAjax.url;
		$('#repimdb').html( dtAjax.updating );
		$.ajax({
			url : ajaxurl,
			type : 'post',
			data : {
				id : id,
				imdb : imdb,
				action : 'update_imdb_rating',
			},
			error : function( response ) {
				console.log(response);
			},
			success : function( response ){
				console.log(response);
				$('#repimdb').html( response );
			},
		});
	});

	// Social count
	$(document).on('click','.dt_social', function(){
		var that = $(this);
		var id = that.data('id');
		var ajaxurl = dtAjax.url;
		$.ajax({
			url : ajaxurl,
			type : 'post',
			data : {
				id : id,
				action : 'dt_social_count'
			},
			error : function( response ){
				console.log( response );
			},
			success : function ( response ){
				$('#social_count').html( response );
			}
		});
	});

	$(document).on('click','.facebook', function(){
		$( ".facebook" ).removeClass( "dt_social" );
	});

	$(document).on('click','.twitter', function(){
		$( ".twitter" ).removeClass( "dt_social" );
	});

	$(document).on('click','.google', function(){
		$( ".google" ).removeClass( "dt_social" );
	});

	$(document).on('click','.pinterest', function(){
		$( ".pinterest" ).removeClass( "dt_social" );
	});

	$(document).on('click','.whatsapp', function(){
		$( ".whatsapp" ).removeClass( "dt_social" );
	});

	// Load TV Shows
	$(document).on('click','.load_list_tvshows', function(){
		var that 		= $(this);
		var page 		= that.data('page');
		var newPage 	= page+1;
		var user 		= that.data('user');
		var typepost 	= that.data('type');
		var ajaxurl 	= dtAjax.url;
		$('#items_tvshows').addClass('loading');
		$.ajax({
			url : ajaxurl,
			type : 'post',
			data : {
				page : page,
				typepost : typepost,
				user : user,
				action : 'next_page_list'
			},
			error : function( response ){
				console.log(response);
			},
			success : function( response ){
				that.data('page', newPage);
				$('#items_tvshows').append( response );
				$('#items_tvshows').removeClass('loading');
			}
		});
	});

	// Load more links
	$(document).on('click','.load_list_links', function(){
		var that 	= $(this);
		var page 	= that.data('page');
		var newPage = page+1;
		var user 	= that.data('user');
		var ajaxurl = dtAjax.url;
		$('#item_links').addClass('loading');
		$.ajax({
			url : ajaxurl,
			type : 'post',
			data : {
				page : page,
				user : user,
				action : 'next_page_link'
			},
			error : function( response ){
				console.log(response);
			},
			success : function( response ){
				that.data('page', newPage);
				$('#item_links').append( response );
				$('#item_links').removeClass('loading');
			}
		});
	});

	// Load more links profile
	$(document).on('click','.load_list_links_profile', function(){
		var that 	= $(this);
		var page 	= that.data('page');
		var newPage = page+1;
		var user 	= that.data('user');
		var ajaxurl = dtAjax.url;
		$('#item_links').addClass('loading');
		$.ajax({
			url : ajaxurl,
			type : 'post',
			data : {
				page : page,
				user : user,
				action : 'next_page_link_profile'
			},
			error : function( response ){
				console.log(response);
			},
			success : function( response ){
				that.data('page', newPage);
				$('#item_links').append( response );
				$('#item_links').removeClass('loading');
			}
		});
	});

	// Load more admin links
	$(document).on('click','.load_admin_list_links', function(){
		var that 	= $(this);
		var page 	= that.data('page');
		var newPage = page+1;
		var ajaxurl = dtAjax.url;
		$('#item_links_admin').addClass('loading');
		$.ajax({
			url : ajaxurl,
			type : 'post',
			data : {
				page : page,
				action : 'next_page_link_admin'
			},
			error : function( response ){
				console.log(response);
			},
			success : function( response ){
				that.data('page', newPage);
				$('#item_links_admin').append( response );
				$('#item_links_admin').removeClass('loading');
			}
		});
	});

	// Control links
	$(document).on('click','.control_link', function(){
		$('#resultado_link').html('<div class="content">' + dtAjax.updating + '</div>');
		var that = $(this);
		that.toggleClass("active");
		var post_id = that.data('id');
		var user_id = that.data('user');
		var status	= that.data('status');
		var ajaxurl = dtAjax.url;
		$.ajax({
			url: ajaxurl,
			type : 'post',
			data : {
				post_id : post_id,
				user_id : user_id,
				status	: status,
				action : 'control_link_user'
			},
			error : function( response ){
				console.log(response);
			},
			success : function( response ){
				$('#resultado_link').html('<div class="content">' + response + '</div>');
				$('#'+ post_id +' > .metas').removeClass("trash");
				$('#'+ post_id +' > .metas').removeClass("pending");
				$('#'+ post_id +' > .metas').removeClass("publish");
				$('#'+ post_id +' > .metas').addClass( status );
			}
		});
	});

	// Control admin links
	$(document).on('click','.control_admin_link', function(){
		$('#resultado_link').html('<div class="content">' + dtAjax.updating + '</div>');
		var that = $(this);
		that.toggleClass("active");
		var post_id = that.data('id');
		var user_id = that.data('user');
		var status	= that.data('status');
		var ajaxurl = dtAjax.url;
		$.ajax({
			url: ajaxurl,
			type : 'post',
			data : {
				post_id : post_id,
				user_id : user_id,
				status	: status,
				action : 'control_link_user'
			},
			error : function( response ){
				console.log(response);
			},
			success : function( response ){
				$('#resultado_link').html('<div class="content">' + response + '</div>');
				$('#adm-'+ post_id +' > .metas').removeClass("trash");
				$('#adm-'+ post_id +' > .metas').removeClass("pending");
				$('#adm-'+ post_id +' > .metas').removeClass("publish");
				$('#adm-'+ post_id +' > .metas').addClass( status );
			}
		});
	});

	// Edit Links
	$(document).on('click','.edit_link', function(){
		var that = $(this);
		var post_id = that.data('id');
		var ajaxurl = dtAjax.url;
		$.ajax({
			url : ajaxurl,
			type : 'post',
			data : {
				post_id : post_id,
				action : 'edit_user_link'
			},
			error : function( response ){
				console.log(response);
			},
			success : function( response ){
				$('#edit_link').html('<div id="result_edit_link" class="box animation-3">' + response + '</div>');
			}
		});
	});

	// Admin pending links
	$(document).on('click','#admin_pending_links', function(){
		var that = $(this);
		$("#adminlinks").show();
		$("#admin_back_links").show();
		$("#mylinks").hide();
		$("#admin_pending_links").hide();
		$("#text_link").html( dtAjax.ladmin );
	});

	$(document).on('click','#admin_back_links', function(){
		var that = $(this);
		$("#adminlinks").hide();
		$("#admin_back_links").hide();
		$("#mylinks").show();
		$("#admin_pending_links").show();
		$("#text_link").html( dtAjax.lshared );
	});

	// Save Edit link
	$(document).on('submit','#editar_link', function(){
		var that = $(this);
		var link = that.find("#url").first().val();
		var tipo = that.find("#type").first().val();
		var size = that.find("#filesize").first().val();
		var idioma = that.find("#idioma").first().val();
		var calidad = that.find("#quality").first().val();
		var post_id = that.find("#post_id").first().val();
		var ajaxurl = dtAjax.url;
		$.ajax({
			url : ajaxurl,
			type : 'post',
			data : {
				post_id : post_id,
				link : link,
				tipo : tipo,
				size : size,
				calidad : calidad,
				idioma : idioma,
				action : 'save_user_link'
			},
			error : function( response ){
				console.log(response);
			},
			success : function( response ){
				$('#result_edit_link').html(  '' + response + '');
			},
		});
		return false;
	});


	// Send report video
	$(document).on('submit','#post_report', function(){
		$('#msg').html('<div class="mensaje_report"><i class="icons-spinner9 animate-loader"></i><p>'+ dtAjax.sendingrep +'</p></div>');
		$(".reportar_form").last().addClass("generate_ajax");
		var that = $(this);
		var ajaxurl = dtAjax.url;
		$.ajax({
			url : ajaxurl + '?action=reports_ajax',
			type : 'post',
			data : that.serialize(),
			error : function( response ){
				console.log(response);
			},
			success : function( response ){
				$("#msg").html('<div class="mensaje_report">'+ response + '</div>');
				$('#report-video').delay(3000).fadeOut();
			}, 
		});
		return false;
	});

	$(document).on('click','#cerrar_form_edit_link', function(){
		$("#result_edit_link").hide();
	});
});
