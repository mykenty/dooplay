/****
@since 1.2.0
***/
jQuery( document ).ready(function( $ ) {
	var delay = (function(){
		var timer = 0;
		return function(callback, ms){
			clearTimeout (timer);
			timer = setTimeout(callback, ms);
		}
	})();
	var searchRequest = false,
		enterActive = true;
	$('input[name="s"]').on("input", function() {
		var s = this.value;
		delay(function(){
		if( s.length <= 2 ) {
			$(dtGonza.area).hide();
			$(dtGonza.button).find('span').removeClass('icons-spinner9').removeClass('animate-loader');
			return;
		}
		if(!searchRequest) {
	    	searchRequest = true;
			$(dtGonza.button).find('span').addClass('icons-spinner9').addClass('animate-loader');
			$(dtGonza.area).find('ul').addClass('process').addClass('noselect');
			$.ajax({
		      type:'GET',
		      url: dtGonza.api,
		      data: 'keyword=' + s + '&nonce=' + dtGonza.nonce,
		      dataType: "json",
		      success: function(data){
				if( data['error'] ) {
					$(dtGonza.area).hide();
					return;
				}
				$(dtGonza.area).show();
					var res = '<span class="icon-search-1">' + s + '</span>',
						moreReplace = dtGonza.more.replace('%s', res),
						moreText = '<li class="ctsx"><a class="more" href="javascript:;" onclick="document.getElementById(\'searchform\').submit();">' + moreReplace + '</a></li>';
						moreText2 = '<li class="ctsv"><a class="more" href="javascript:;" onclick="document.getElementById(\'form-search-resp\').submit();">' + moreReplace + '</a></li>';
					var items = [];
					$.each( data, function( key, val ) {
					  	name = '';
					  	date = '';
					  	imdb = '';
					  	if( val['extra']['date'] !== false )
					  		date = "<span class='release'>(" + val['extra']['date'] + ")</span>";

					  	if( val['extra']['names'] !== false )
					  		name = val['extra']['names'];

					  	if( val['extra']['imdb'] !== false )
					  		imdb = "<div class='imdb'><span class='icon-star'></span> " + val['extra']['imdb'] + "</div>";

					   	items.push("<li id='" + key + "'><a href='" + val['url'] + "' class='clearfix'><div class='poster'><img src='" + val['img'] + "' /></div><div class='title'>" + val['title'] + date + "</div>" + imdb + "</a></li>");
					});
					$(dtGonza.area).html('<ul>' + items.join("") + moreText + moreText2 +'</ul>');
				},
				complete: function() {
			      	searchRequest = false;
			      	enterActive = false;
					$(dtGonza.button).find('span').removeClass('icons-spinner9').removeClass('animate-loader');
					$(dtGonza.area).find('ul').removeClass('process').removeClass('noselect');
				}
		   	});
		}	 
		}, 500 ); 
	});
	$(document).on("keypress", "#search-form", function(event) { 
		if( enterActive ) {
			return event.keyCode != 13;
		}
	});
	$(document).click(function() {
		var target = $(event.target);
		if ($(event.target).closest('input[name="s"]').length == 0) {
			$(dtGonza.area).hide();
		} else {
			$(dtGonza.area).show();
		}
	});
});