jQuery(document).ready(function() {
		jQuery('.multiselect').multiselect({
			buttonClass: 'btn',
			buttonWidth: 'auto',
			buttonText: function(options) {
				if (options.length == 0) {
		            return 'None selected <b class="caret"></b>';
		        }
		        else if (options.length > 6) {
		            return options.length + ' selected  <b class="caret"></b>';
		        }
		        else {
		            var selected = '';
		            options.each(function() {
						selected += $(this).text() + ', ';
		            });
		
					return selected.substr(0, selected.length -2) + ' <b class="caret"></b>';
				}
			},
			includeSelectAllOption: true,
			selectAllText: "Select All",
			selectAllValue: 'multiselect-all',
			
		});
	});