jQuery(document).ready(function($){
	sh_highlightDocument();
	function arrange() {
		if($(".navigation").height()+20 > $(window).height()) {
			var f = $("html").scrollTop()/$("html").height();
			var p = ($(".navigation").height()+128)-$(window).height();
			$(".navigation").css({'top' : -(p*f)+30});
		} else {
			$(".navigation").css({'top' : 30});
		}
	}
	arrange();
	$(window).scroll(function () {
		arrange();
	});

	var _openclosetest = function($cntr, e)
	{
		console.log($cntr);

	};

	var ignoreHashChange = false;

	$('.test').click(function(e) {
		if ($(e.target).hasClass('test') || $(e.target).hasClass('toggle')) {
			ignoreHashChange = true;
			var $cntr = $(this).closest('.test'),
				id = '#'+$cntr.attr('id').replace('test_', '');
			if (window.location.hash === id) {
				window.location.hash = '#/';
			} else {
				window.location.hash = id;
			}
			$(this).find('.collapsable').toggleClass('open');
		}
	});


	var openCurrent = function() {
		$('nav a.current').removeClass('current');

		if (window.location.hash === '#/') {
			return;
		}

		var t = window.location.hash.replace('#', '#test_');
		$('.navigation a[href="'+window.location.hash+'"]').addClass('current');

		if (!ignoreHashChange) {
			if ($(t).length && (!$(t).find('.collapsable').hasClass('open') || init)) {
				init = false;
				$c = $(t);
				$c.find('.collapsable').addClass('open');
				$('html,body').animate({
					scrollTop: $c.offset().top-10
				}, 500);
			}
		}
		ignoreHashChange = false;
	};
	init = true;
	openCurrent();
	$(window).bind('hashchange', openCurrent);
});