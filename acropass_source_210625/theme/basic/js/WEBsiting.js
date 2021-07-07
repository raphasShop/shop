/* copyright(c) WEBsiting.co.kr */


$(document).ready(function(){
	/* 스크롤 탑 버튼 */
	$("#top_btn").hide();
	//var topId = $("#topID").offset().top; 
	$(window).scroll(function(){ 
		if($(window).scrollTop() >= 2) {
			$("#top_btn").fadeIn(300);
			$("#hd").addClass("scDown");
		} else { 
			$("#top_btn").fadeOut(300);
			$("#hd").removeClass("scDown");
		};
		return false;
	}); 
	$("#top_btn").click(function() {
		$("html, body").animate({scrollTop:0}, "500");
		return false;
	});

	/* 모바일용 on off */
	$("#snbOpen").click(function() {
		$("html , body").addClass("ovfH");
		$("#sideBar").addClass("on");
		$("#sideBarCover").addClass("on");
		return false;
	});
	$("#snbClose,#sideBarCover").click(function() {
		$("html , body").removeClass("ovfH");
		$("#sideBar").removeClass("on");
		$("#sideBarCover").removeClass("on");
		return false;
	});
	
	
	
	/* 글쓰기 내용입력폼에 placeholder 추가 / 에디터 출력 시 제외 */
	$( '#wr_content' ).attr( 'placeholder', '내용을 입력해 주세요.' );

	
});

function addBookmark(){
	var title = document.title;
	var url = location.href;
	if(window.sidebar && window.sidebar.addPanel)
	{
		// Firefox
		window.sidebar.addPanel(title, url,"");
	}
	else if (window.opera && window.print)
	{
		// Opera
		var elem = document.createElement('a');
		elem.setAttribute('href',url);
		elem.setAttribute('title',title);
		elem.setAttribute('rel','sidebar');
		elem.click();
	}
	else if(document.all)
	{
		// Internet Explorer
		window.external.AddFavorite( url, title);
	}
	else
	{
		alert("이용하시는 웹 브라우저는 기능이 지원되지 않습니다.\n\nCtrl+D 키를 누르시면 즐겨찾기에 추가하실 수 있습니다.");
		return true;
	}
}