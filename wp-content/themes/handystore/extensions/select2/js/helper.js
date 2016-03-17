
jQuery(document).ready(function($){
	$(function() {
		"use strict";

		var select = $('select:not(#rating):not(.country_select)');

		select.each(function(){
			if ( $(this).hasClass('orderby') || 
				 $(this).hasClass('filters-group') ||
				 $(this).parent().hasClass('value') ||
				 $(this).hasClass('search-select')
			){
				$(this).select2({
					minimumResultsForSearch: -1,
				});
			} else {
				$(this).select2();
			}
		});

	})
});