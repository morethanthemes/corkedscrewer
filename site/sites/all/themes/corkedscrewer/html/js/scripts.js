jQuery(function($){



			$('.slides').cycle({ 
			fx:      'scrollHorz', 
			speed:    400, 
    		timeout:  7000,
    		pause: 	  1,
    		prev:    '#prev', 
            next:    '#next',
            pager:   '.slide-nav',
	        pagerAnchorBuilder: pagerFactory
			});

			function pagerFactory(idx, slide) {
			var s = idx > 5 ? ' style="display:none"' : '';
			return '<li'+s+'><a href="#">'+(idx+1)+'</a></li>';
			};


			$("#menu ul").superfish();
	    });