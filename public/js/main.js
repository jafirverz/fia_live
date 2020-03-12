function respon() {	
	var hfoot = $('.footer-container').outerHeight(),
		hhead = $('.header-container').outerHeight(),
		hscreen = $(window).outerHeight(),
		hintro = $('.banner .intro').outerHeight(),
		whead = $('.header-container .container').outerWidth(),
		wscreen = $(window).outerWidth(),
		htitle = $('.about-wrap .title').outerHeight(),
		hbreadcrumb = $('.breadcrumb').outerHeight(),
		hsearch = $('.banner .search-wrap').outerHeight(),
		hbanner = hscreen - hhead - hintro;
	$('.page').css({marginBottom:-hfoot});
	$('.main-wrap').css({paddingBottom:hfoot,paddingTop:hhead});
	$('.thanks-wrap .col').css({height:hscreen-hfoot,paddingTop:hhead});
	$('.spleft').css({paddingLeft:(wscreen-whead)/2});	
	$('.spright').css({paddingRight:(wscreen-whead)/2});	
	$('.spbtop').css({paddingTop:hbreadcrumb});	
	$('.wleft').css({width:(wscreen-whead)/2+15,left:-(wscreen-whead)/2-15});
	$('.wright').css({width:(wscreen-whead)/2+15,right:-(wscreen-whead)/2-15});	
	$('.banner .item').css({height:hscreen-hhead});
	$('.no-bn').css({paddingTop:hhead});	
	$('.banner .search-wrap').css({marginTop:-hsearch/2});	
	
	
		
	$('.map-wrap .pin').each(function(){
		var currentid = $(this).attr('href'),
		curidopen = $('.map-wrap .map-pins').find('.open').attr('href');
	  if (wscreen > 890) {
		$(curidopen).addClass('openpp');
	   }
	   else {
		$(curidopen).removeClass('openpp');
	   }
		$(this).click(function(e){
	        e.preventDefault();
			 $('.map-wrap .pin').removeClass('open');
			 $('.map-wrap .pin-pp').removeClass('openpp');
			 $(this).addClass('open');
			 $(currentid).addClass('openpp');
		});	
	});	
		
	$('.map-wrap .fa-times').each(function(){
		$(this).click(function(e){
	        e.preventDefault();
			 $('.map-wrap .pin').removeClass('open');
			 $('.map-wrap .pin-pp').removeClass('openpp');
		});	
	});	
} 

$(window).scroll(function(){
  if ($(window).scrollTop() >= 55) {
    $('.gotop').css({opacity:1});
   }
   else {
    $('.gotop').css({opacity:0});
   }
});


$(document).ready(function(){
	respon();
	
	var md = new MobileDetect(window.navigator.userAgent);
	if(md.mobile() == "iPhone"){
	  $("body").addClass("ios");
	}
	
	stickyHeader();
	$('.show-tooltip').tooltip();
	
	$(".menu li").find("ul").prev().addClass("fas fa-angle-down");
	$(".menu li").find("ul").parent().append("<span class='subarrow'></span>");
	
	$(".menu li" ).hover(
	  function() {
		$(this).addClass('hover');
	  }, function() {
		$(this).removeClass('hover');
	  }
	);
	
	$('.menu .subarrow').each(function(){
		var currentid = $(this).attr('href');
		$(this).click(function(e){
	        e.preventDefault();
			 $(this).prev().toggle();
			 $(this).toggleClass('open');
		});	
	});	
		
	$('.control-page').each(function(){
		var currentid = $(this).attr('href');
		$(this).click(function(e){
	        e.preventDefault();
			 $(this).toggleClass('active-burger');
			 $(currentid).toggleClass('open-sub');
			 $('body').toggleClass('open-page');
		});	
	});	
		
	$('.control-sub').each(function(){
		var currentid = $(this).find('.control'),
		currentcontent = $(this).find('.control').attr('href');
		$(currentid).click(function(e){
	        e.preventDefault();
			e.stopPropagation(); 
			var current = $(this).attr('href');
			//$(current).toggle();
			//$(currentid).toggleClass('active');
			if ($(this).hasClass('active')){
				$(this).removeClass('active');
				$(currentcontent).hide();
			} else {
				$('.control-sub .control').removeClass('active');
				$('.control-sub .dropsub').hide();
				$(this).addClass('active');
				$(currentcontent).show();
			}
		});
		
		$(currentcontent).click(function(e){
			e.stopPropagation();
		});
		
		$(document).click(function(){
			$(".control-sub .dropsub").hide();
			$(".control-sub .control").removeClass('active');
		});
	});	
	
		
	$('.btn-control').each(function(){
		var currentid = $(this).attr('href');
		$(this).click(function(e){
	        e.preventDefault();
			 $(this).toggleClass('open');
			 $(currentid).toggleClass('opensub');
		});	
	});	
	
	
	/* bg appointment */
	$('.bg').each(function() {
		var imgUrl1 = $(this).find('.bgimg').attr('src');
		$(this).fixbg({ srcimg : imgUrl1});           
    });
	
	$('.fancybox').fancybox({
		padding: 2,
		helpers: {
			title : {
				type : 'over'
			},
			overlay : {
				locked: false
			}
		}
	});
	
	
	/* btn scroll to element */
	$('.smoothscroll').bind('click',function (e) {
        e.preventDefault();
        var target = this.hash,
        $target = $(target);
        $('html, body').stop().animate( {
            'scrollTop': $target.offset().top
        }, 1000, 'swing', function () {
            window.location.hash = target;
        } );
    } );
	
	
	/*$('.panel .panel-title a').bind('click',function (e) {
        e.preventDefault();
		if ($(this).hasClass("collapsed")) {						
			var target = this.hash,
			$target = $(target);
			$('html, body').stop().animate( {
				'scrollTop': $target.offset().top 
			}, 700, 'swing', function () {
				window.location.hash = target;
			} );
		} 
    } );*/
	
	$('.form-ani .form-control').each(function(){
		var tmpval = $(this).val();
		if(tmpval == "") {
			$(this).parent().addClass('empty');
			$(this).parent().removeClass('not-empty');
		} else {
			$(this).parent().addClass('not-empty');
			$(this).parent().removeClass('empty');
		}
	});	
	
	 $('.form-ani .form-control').focus(function() {
	  $(this).parent().addClass('focus');
	});
	 $('.form-ani .form-control').focusout(function() {
	  $(this).parent().removeClass('focus');
	});
	$('.form-ani .form-control').blur(function(){
		var tmpval = $(this).val();
		if(tmpval == "") {
			$(this).parent().addClass('empty');
			$(this).parent().removeClass('not-empty');
		} else {
			$(this).parent().addClass('not-empty');
			$(this).parent().removeClass('empty');
		}
	});
	
	// show full content	
	$('.head-box').each(function(){
		var hbheight = $(this).attr("data-height");
			$(this).next().css({height:hbheight});
		var bheight = $(".open").find(".document").outerHeight();
		$(".open").find(".content-box").css({height:bheight});
		$(this).click(function(e){
			e.preventDefault();
		  var newHeight = 0,
			  bheight = $(this).next().find('.document').outerHeight(),
			  idbox = $(this).attr('href');
		  if ($(this).parent().hasClass("open")) {
			$(this).parent().removeClass("open");
			$(this).next().css({height:hbheight});
		  } else {
			$(this).parent().addClass("open");
			$(this).next().css({height:bheight});
		  }
		});
	});	

	
	
	
});

$(window).load(function() {
	
	respon();
	
	
	$('.page').css({opacity:1});
	$('.slick-1, #slider').css({height:'auto',overflow:'visible'});
	
	$('#slider').slick({
		autoplay: true,
		autoplaySpeed: 5000,
		fade: true,
		dots: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		speed: 1500
	});	
	
	
	$('.slick-1').slick({
		autoplay: true,
		autoplaySpeed: 3000,
		slidesToShow: 4,
		slidesToScroll: 1,
		speed: 2000,
		responsive: [
			{
			  breakpoint: 1480,
			  settings: {
				slidesToShow: 3
			  }
			},
			{
			  breakpoint: 1199,
			  settings: {
				slidesToShow: 2
			  }
			},
			{
			  breakpoint: 480,
			  settings: {
				slidesToShow: 1
			  }
			}
		  ]
	});	

	$('.slider-for').slick({
	  slidesToShow: 1,
	  slidesToScroll: 1,
	  asNavFor: '.slider-nav',
		infinite: false
	});
	$('.slider-nav').slick({
	  slidesToShow: 4,
	  slidesToScroll: 1,
	  asNavFor: '.slider-for',
	  focusOnSelect: true,
		infinite: false,
		responsive: [
			{
			  breakpoint: 991,
			  settings: {
				slidesToShow: 3
			  }
			},
			{
			  breakpoint: 720,
			  settings: {
				slidesToShow: 4
			  }
			},
			{
			  breakpoint: 640,
			  settings: {
				slidesToShow: 3
			  }
			},
			{
			  breakpoint: 480,
			  settings: {
				slidesToShow: 2
			  }
			}
		  ]
	});
	
	$('.eheight').each(function() {
		$(this).find('.ecol').matchHeight();
	});
	
	/*$('.grid-2').each(function() {
		$(this).find('figure').matchHeight();
		$(this).find('.content').matchHeight();
	});*/
	
	$(".scroll").mCustomScrollbar();
	

	
	
	
	/*$('.mlist-wrap').each(function(){
		var numlist = $(this).find('.mlist').attr('data-num'),
			line = $(this).find('.mlist-line'),
			btn = $(this).find('.see-all'),
			n = $(line).length;		
		$(line).slice(0, numlist).show();
		$(btn).click(function(e){
			e.preventDefault();	
			if ($(this).hasClass("full")) {
				$(this).removeClass("full");
				$(line).slice(5, n).hide();
			 } else {
				$(this).addClass("full");
				$(line).fadeIn('slow');
			 }		  
		});
	});	*/
	
	$('.mlist-wrap').each(function(){
		var numlist = $(this).find('.mlist').attr('data-num'),
			line = $(this).find('.mlist-line'),
			btn = $(this).find('.see-all'),
			n = $(line).length;		
		$(line).slice(0, numlist).show();
		$(btn).click(function(e){
			e.preventDefault();				
			$(this).hide();
			$(line).fadeIn('slow');	  
		});
	});
	
	
});



function showMore() {
      setTimeout(function(){
        $('.mbox-wrap').each(function(){
            var numshow = parseInt($(this).attr('data-num')),
                item = $(this).find('.mbox'),
                btn = $(this).find('.load-more, .mbox-load'),
                countItem = item.length,
                indexShow = 1;
                item.hide();	
                if(countItem < numshow){
                    btn.hide();
                    item.show();
                }else{
                    item.filter(":lt(" + numshow + ")").show();
                }
                console.log(countItem);
                console.log(indexShow);
                console.log(numshow);
                console.log(item);
                console.log(btn);
                
                btn.on('click', function (e) {
                    e.preventDefault();	
                    indexShow++;
                    if(numshow*indexShow < countItem){
                        item.filter(":lt(" + numshow*indexShow + ")").fadeIn('slow');
                        //item.slice(0, numshow*indexShow).fadeIn('slow');
                    }else{
                        item.filter(":lt(" + countItem + ")").fadeIn('slow');
                        //item.slice(0, countItem).fadeIn('slow');
                        btn.hide();
                    }
                    console.log(countItem);
                    console.log(indexShow);
                    //$('html,body').animate({
                        //scrollTop: $(this).offset().top
                    //}, 1500);
                });
        });	

      }, 100);

}

$(window).load(function() {
	/*$('.masony').each(function(){
	  var maid = "#" + $(this).attr("id"),
		  btnid = $(this).attr("data-load");
			
	  // init Isotope	
	  var $container = $(maid).isotope({
		itemSelector: '.item',
		percentPosition: true,
		layoutMode: 'masonry',
		masonry: {
		  columnWidth: '.grid-sizer',
		}
	  });
		$container.imagesLoaded().progress( function() {
		  $container.isotope('layout');
		});


	  
		
  });*/

		showMore();
	
  
});
$(window).resize(function() {
	respon();
});