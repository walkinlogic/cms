;(function () {
	
	'use strict';

	var isMobile = {
		Android: function() {
			return navigator.userAgent.match(/Android/i);
		},
			BlackBerry: function() {
			return navigator.userAgent.match(/BlackBerry/i);
		},
			iOS: function() {
			return navigator.userAgent.match(/iPhone|iPad|iPod/i);
		},
			Opera: function() {
			return navigator.userAgent.match(/Opera Mini/i);
		},
			Windows: function() {
			return navigator.userAgent.match(/IEMobile/i);
		},
			any: function() {
			return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
		}
	};

	var mobileMenuOutsideClick = function() {

		$(document).click(function (e) {
			if($("#design-offcanvas, .js-design-nav-toggle").length > 0){
				var container = $("#design-offcanvas, .js-design-nav-toggle");
				if (!container.is(e.target) && container.has(e.target).length === 0) {

					if ( $('body').hasClass('offcanvas') ) {

						$('body').removeClass('offcanvas');
						$('.js-design-nav-toggle').removeClass('active');
						
					}
				
					
				}
			}
		});

	};


	var offcanvasMenu = function() {

		$('#page').prepend('<div id="design-offcanvas" />');
		$('#page').prepend('<a href="#" class="js-design-nav-toggle design-nav-toggle design-nav-white"><i></i></a>');
		var clone1 = $('.menu-1 > ul').clone();
		if($('#design-offcanvas').length > 0){$('#design-offcanvas').append(clone1);}
		var clone2 = $('.menu-2 > ul').clone();
		if($('#design-offcanvas').length > 0){$('#design-offcanvas').append(clone2);}

		if($('#design-offcanvas .has-dropdown').length > 0){$('#design-offcanvas .has-dropdown').addClass('offcanvas-has-dropdown');}
		if($('#design-offcanvas').length > 0){
			$('#design-offcanvas')
				.find('li')
				.removeClass('has-dropdown');
		}
		if($('.offcanvas-has-dropdown').length > 0){
			$('.offcanvas-has-dropdown').mouseenter(function(){
				var $this = $(this);

				$this
					.addClass('active')
					.find('ul')
					.slideDown(500, 'easeOutExpo');				
			}).mouseleave(function(){

				var $this = $(this);
				$this
					.removeClass('active')
					.find('ul')
					.slideUp(500, 'easeOutExpo');				
			});

		}
		$(window).resize(function(){

			if ( $('body').hasClass('offcanvas') ) {

    			$('body').removeClass('offcanvas');
    			$('.js-design-nav-toggle').removeClass('active');
				
	    	}
		});
	};

	var burgerMenu = function() {
		if($('.js-design-nav-toggle').length > 0){
			$('body').on('click', '.js-design-nav-toggle', function(event){
				var $this = $(this);


				if ( $('body').hasClass('overflow offcanvas') ) {
					$('body').removeClass('overflow offcanvas');
				} else {
					$('body').addClass('overflow offcanvas');
				}
				$this.toggleClass('active');
				event.preventDefault();

			});
		}
	};
	

	var contentWayPoint = function() {
		var i = 0;
		if($('.animate-box').length > 0){
			$('.animate-box').waypoint( function( direction ) {

				if( direction === 'down' && !$(this.element).hasClass('animated-fast') ) {
					
					i++;

					$(this.element).addClass('item-animate');
					setTimeout(function(){
						if($('body .animate-box.item-animate').length > 0){
							$('body .animate-box.item-animate').each(function(k){
								var el = $(this);
								setTimeout( function () {
									var effect = el.data('animate-effect');
									if ( effect === 'fadeIn') {
										el.addClass('fadeIn animated-fast');
									} else if ( effect === 'fadeInLeft') {
										el.addClass('fadeInLeft animated-fast');
									} else if ( effect === 'fadeInRight') {
										el.addClass('fadeInRight animated-fast');
									} else {
										el.addClass('fadeInUp animated-fast');
									}

									el.removeClass('item-animate');
								},  k * 200, 'easeInOutExpo' );
							});
						}
					}, 100);
					
				}

			} , { offset: '85%' } );
		}
	};


	var dropdown = function() {
		if($('.has-dropdown').length > 0){
			$('.has-dropdown').mouseenter(function(){

				var $this = $(this);
				$this
					.find('.dropdown')
					.css('display', 'block')
					.addClass('animated-fast fadeInUpMenu');

			}).mouseleave(function(){
				var $this = $(this);

				$this
					.find('.dropdown')
					.css('display', 'none')
					.removeClass('animated-fast fadeInUpMenu');
			});
		}
	};


	var goToTop = function() {
		if($('.js-gotop').length > 0){
			$('.js-gotop').on('click', function(event){
				
				event.preventDefault();

				$('html, body').animate({
					scrollTop: $('html').offset().top
				}, 500, 'easeInOutExpo');
				
				return false;
			});
		}
		$(window).scroll(function(){

			var $win = $(window);
			if ($win.scrollTop() > 200) {
				if($('.js-top').length > 0){$('.js-top').addClass('active');}
			} else {
				if($('.js-top').length > 0){$('.js-top').removeClass('active');}
			}

		});
	
	};


	// Loading page
	var loaderPage = function() {
		if($(".design-loader").length > 0){$(".design-loader").fadeOut("slow");}
	};

	var counter = function() {
		if($('.js-counter').length > 0){
			$('.js-counter').countTo({
				 formatter: function (value, options) {
			  return value.toFixed(options.decimals);
			},});
		}
	};


	var counterWayPoint = function() {
		if ($('#design-counter').length > 0 ) {
			$('#design-counter').waypoint( function( direction ) {
										
				if( direction === 'down' && !$(this.element).hasClass('animated') ) {
					setTimeout( counter , 400);					
					$(this.element).addClass('animated');
				}
			} , { offset: '90%' } );
		}
	};

	var sliderMain = function() {
		if($('#design-hero .flexslider').length > 0){
			$('#design-hero .flexslider').flexslider({
				animation: "fade",
				slideshowSpeed: 5000,
				directionNav: true,
				start: function(){
					setTimeout(function(){
						if($('.slider-text').length > 0){$('.slider-text').removeClass('animated fadeInUp');}
						if($('.flex-active-slide').length > 0){$('.flex-active-slide').find('.slider-text').addClass('animated fadeInUp');}
					}, 500);
				},
				before: function(){
					setTimeout(function(){
						if($('.slider-text').length > 0){$('.slider-text').removeClass('animated fadeInUp');}
						if($('.flex-active-slide').length > 0){$('.flex-active-slide').find('.slider-text').addClass('animated fadeInUp');}
					}, 500);
				}

			});
		}

	};

	var parallax = function() {

		if ( !isMobile.any() ) {
			$(window).stellar({
				horizontalScrolling: false,
				hideDistantElements: false, 
				responsive: true

			});
		}
	};

	// Owl Carousel
	var owlCrouselFeatureSlide = function() {
		if($('.owl-carousel1').length > 0){
			var owl = $('.owl-carousel1'); 	
			owl.owlCarousel({
				animateOut: 'slideOutDown',
			    animateIn: 'flipInX',
				autoplay: true,
				items: 1,
			    loop: ($(".owl-carousel1 .item").length > 1) ? true : false,
				center:true,
			    margin: 0,
			    responsiveClass: true,
			    nav: true,
			    dots: false,
			    smartSpeed: 500,
			    navText: [
				  "<i class='icon-left-big owl-direction'></i>",
				  "<i class='icon-right-big owl-direction'></i>"
				]
			});
		}
		if($('.owl-carousel2').length > 0){
			$('.owl-carousel2').owlCarousel({
				 animateOut: 'slideOutDown',
				animateIn: 'flipInX',
				 autoplay: true,
				loop:($(".owl-carousel2 .item").length > 1) ? true : false,
				items: 1,
				center:true,
				margin:30,
				nav:true,
				dots: true,
				autoplayHoverPause: true,
				responsive:{
					0:{
						items:1
					},
				},
				navText: [
				  "<i class='icon-left-big owl-direction'></i>",
				  "<i class='icon-right-big owl-direction'></i>"
				]
			});
		}
		if($('.owl-carousel3').length > 0){ 
			$('.owl-carousel3').owlCarousel({
				 animateOut: 'slideOutDown',
				animateIn: 'flipInX',
				 autoplay: true,
				loop:($(".owl-carousel3 .item").length > 1) ? true : false,
				center:true,
				margin:30,
				items: 1,
				nav:true,
				dots: true,
				autoplayHoverPause: true,
				responsive:{
					0:{
						items:1
					},
				},
				navText: [
				  "<i class='icon-left-big owl-direction'></i>",
				  "<i class='icon-arrow-right3 owl-direction'></i>"
				]
			});
		}
		if($('.owl-carousel4').length > 0){ 
			$('.owl-carousel4').owlCarousel({
				 animateOut: 'slideOutDown',
				animateIn: 'flipInX',
				 autoplay: true,
				loop:($(".owl-carousel4 .item").length > 1) ? true : false,
				center:true,
				margin:30,
				items: 1,
				nav:true,
				dots: true,
				autoplayHoverPause: true,
				responsive:{
					0:{
						items:1
					},
				},
				navText: [
				  "<i class='icon-left-big owl-direction'></i>",
				  "<i class='icon-right-big owl-direction'></i>"
				]
			});
		}
		if($('.owl-carousel5').length > 0){ 
			$('.owl-carousel5').owlCarousel({
				 animateOut: 'slideOutDown',
				animateIn: 'flipInX',
				 autoplay: true,
				loop:($(".owl-carousel5 .item").length > 1) ? true : false,
				center:true,
				margin:30,
				items: 1,
				nav:true,
				dots: true,
				autoplayHoverPause: true,
				responsive:{
					0:{
						items:1
					},
				},
				navText: [
				  "<i class='icon-left-big owl-direction'></i>",
				  "<i class='icon-right-big owl-direction'></i>"
				]
			});
		}
		if($('.owl-carousel6').length > 0){ 
			$('.owl-carousel6').owlCarousel({
				 animateOut: 'slideOutDown',
				animateIn: 'flipInX',
				 autoplay: true,
				loop:($(".owl-carousel6 .item").length > 1) ? true : false,
				center:true,
				margin:30,
				items: 1,
				nav:true,
				dots: true,
				autoplayHoverPause: true,
				responsive:{
					0:{
						items:1
					},
				},
				navText: [
				  "<i class='icon-left-big owl-direction'></i>",
				  "<i class='icon-right-big owl-direction'></i>"
				]
			});
		}
	};
 

	
	$(function(){
		
	 
		
		mobileMenuOutsideClick();
		offcanvasMenu();
		burgerMenu();
		contentWayPoint();
		sliderMain();
		dropdown();
		goToTop();
		loaderPage();
		counter();
		counterWayPoint();
		parallax();
		owlCrouselFeatureSlide();
	});


// this is the id of the form
$("#subscribeform").submit(function(e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.

    var form = $(this);
    var url = form.attr('action');
    
    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), // serializes the form's elements.
           success: function(data)
           {
               alert(data); // show response from the php script.
           }
         });

    
});

}());