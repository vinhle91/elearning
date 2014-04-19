(function( $ ){
	jQuery.fn.searchTag = function (options)
	{
		var defaults = {
			searchTagUrl: 'ajax/searchTags/%QUERY',
			typeaheadValueKey: 'tag_name',
			typeaheadLimit: 10
		};
		
		options = jQuery.extend(defaults, options);
		
		return this.each(function (){
			var that = jQuery(this);
			
			that.typeahead({
				name: 'search-tag',
				remote: {
					url: options.searchTagUrl,
					wildcard: jQuery(this).val()
				},
				valueKey:'tag_name',
				limit: 10,
				template: function(data) {
					var retStr = '';
					
					if (typeof data.info != 'undefined') {
						retStr += '<div class="suggest-content"><p class="repo-name">' + data.info +'</p></div>';
						return retStr;
					}
					
					if (typeof data.label != 'undefined') {
						retStr += '<div class="suggest-content suggest-label"><p class="repo-name">' + data.label + '</p></div>';
						retStr += '<div class="suggest-content" style="border-top: 1px solid #ccc;"><p class="repo-number-post">' + data.number_post + '</p><p class="repo-name">#' + data.tag_name +'</p></div>';
					}else {
						retStr += '<div class="suggest-content"><p class="repo-number-post">' + data.number_post + '</p><p class="repo-name">#' + data.tag_name +'</p></div>';
					}
					return retStr;
				},                                                                 
				engine: Hogan
			}).focus(function() {
				var set = false;
				if (!jQuery(this).val()) {
					jQuery(this).typeahead('setQuery', '%40');
					jQuery(this).val('');
				}
			}).blur(function() {
				if (!jQuery(this).val() || jQuery(this).val() == '%40') {
					jQuery(this).val('');
				}
			}).keyup(function(e) {
				if (e.keyCode == 8 && !jQuery(this).val()) {
					jQuery(this).typeahead('setQuery', '%40');
					jQuery(this).val('');
				}
			});
			
			that.filter_input({
				regex:'[0-9a-zA-Z_]', 
				events:'keypress paste'
			});
			
			that.on ('keypress paste', function(evt){
			    var theEvent = evt || window.event;
			    var key = theEvent.keyCode || theEvent.which;
			    key = String.fromCharCode( key );
			    if(evt.keyCode != 8 && evt.keyCode != 46 && !key.match(/^[A_Za-z0-9_]+$/i)) {
			    	e = jQuery.event.fix(e);
					e.preventDefault();
					return false;
			    }
			});
		});
	};
})( jQuery );