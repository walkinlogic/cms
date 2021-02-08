$(document).ready(function() {
    if($('.gallery').length > 0 ){
		$('.gallery').mauGallery({
			columns: {
				xs: 1,
				sm: 2,
				md: 4,
				lg: 6,
				xl: 6
			},
			lightBox: true,
			lightboxId: 'myAwesomeLightbox',
			showTags: true,
			tagsPosition: 'top'
		});
	}
});