(function( $ ){  
	$(document).ready(function($) { 
	
	
		$('.buttonMAD').click( function(){	
			
			$('.buttonMAD').hide('slow');	
			$('#logoImage').lazylinepainter({
				'svgData' : svgData,
				'strokeWidth':3,  
				'strokeColor':'#FFF',
				}
			)
			
			$('#logoImage').lazylinepainter('paint');
			$('#logoI').delay(3000).fadeIn(3500);
			$('#logoImage').delay(4000).animate({
			opacity:'0'
			
			});
			$('#logoContainer').delay(7500).animate({
				marginTop:-702
			},3000);
		});
		
	});
})( jQuery );
