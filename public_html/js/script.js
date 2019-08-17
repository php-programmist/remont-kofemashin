
$(document).ready(function() {
	$('.slider').glide({
			autoplay: 13000,
			hoverpause:false,
			});
	$('.burger').click(function(event) {
	$('.grmenu').slideToggle(1000);
	});
  $('.zakzvclose').click(function(event) {
    /* Act on the event */
    $('.zakzv-wrap').slideToggle(10);
  });  
  $('.zakzv-btn').click(function(event) {
    /* Act on the event */
    $('.zakzv-wrap').slideToggle(100);
  });
  $('.modalstclose').click(function(event) {
    /* Act on the event */
    $('.modalst-wrap').slideToggle(10);
  });  
  $('.btn-vizovbespldiagn').click(function(event) {
    /* Act on the event */
    $('.modalst-wrap').slideToggle(100);
  });
  $('.btn-vibratmodel').click(function(event) {
    /* Act on the event */
    $('.spisokmodelei').slideToggle(1000);
  });

	$('.btn-seo').click(function(event) {
		/* Act on the event */
		$('.seo-none').slideToggle(1000);
		$('.btn-seo').slideToggle(1)
	});

	$('.brand-slider').slick({
		infinite: true,
		slidesToShow: 9,
		slidesToScroll: 5,
		responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 7,
        slidesToScroll: 3
      }
    },
    {
      breakpoint: 992,
      settings: {
        slidesToShow: 6,
        slidesToScroll: 3
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 576,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3
      }
    }
  ]

		});

});

