$(document).ready(function() {
	$(".fancybox").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	400,
		'speedOut'	:	200
	});

	$("a.video").click(function() {
		$.fancybox({
			//'width'               : 480,
			//'height'              : 390,
			'href'                : this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
			'type'                : 'swf',    // <--add a comma here
			'swf'                 : {'allowfullscreen':'true'} // <-- flashvars here
		});
		return false;
	});

});