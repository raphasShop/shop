/* copyright(c) WEBsiting.co.kr */


$(document).ready(function(){
	$('.mainVisualImage ul').bxSlider({
		onSliderLoad: function(){
			var effectT = $('.mvTit01'); effectT.shuffleLetters();
		},
		onSlideBefore: function(){
			var effectT = $('.mvTit01'); effectT.shuffleLetters();
		},
		onSlideAfter: function(){
			var effectT = $('.mvTit01'); effectT.shuffleLetters();
		},
		auto: true,
		useCSS: false,
		adaptiveHeight: true,
		autoControls: false,
		stopAutoOnClick: true,
		autoDelay: '100',
		pause: 6000,
		pager: true
	});
});