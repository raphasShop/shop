/**
 *  jquery.fade-in.js
 *  제작 : 베원 (com1.kr)
 *
 *  본 코드 사용시 이 주석을 유지해주시기 바랍니다.
 *  이외에는 제약 없이 사용 가능합니다.
 */

/*
1. jquery.fade-in.js 를 head.sub.php에 넣습니다.
2. 스크롤시 fadeIn 하기를 원하는 요소 class에 fade-in 을 넣습니다.
3. (선택) fadeIn 속도를 지정합니다. (이 과정을 생략한 경우 기본 500ms로 작동합니다.)
속도는 data-fade-in-speed 어트리뷰트를 통해 지정합니다
(예제)
<div class="fade-in" data-fade-in-speed="800">fade-in을 원하는 div</div>
*/

$(document).ready(function() {
	$('.fade-in').css({"opacity":"0","position":"relative","top":"30px"});
	triggerJqueryFadeIn()
    $(window).scroll(triggerJqueryFadeIn);
});
var animateQueue = new Array();
var ready = true;
function triggerJqueryFadeIn() {
	$('.fade-in').each( function(){
		var object_top = $(this).offset().top;
		var window_bottom = $(window).scrollTop() + $(window).height();
		if( window_bottom > object_top ){
			if($(this).css("opacity") == "0") animateQueue.push(this);
		}
	}); 
	triggerJqueryFadeInQueue();
}
function triggerJqueryFadeInQueue() {
	if(animateQueue.length != 0 && ready) {
		ready = false;
		$this = animateQueue.shift();
		var speed = ($($this).attr("data-fade-in-speed") != undefined ? parseInt($($this).attr("data-fade-in-speed")) : 500);
		$($this).animate({"opacity":"1", "top":"0px"}, speed, function() {
			$($this).css("position","static");
			ready = true;
			triggerJqueryFadeInQueue();
		});
	}
}