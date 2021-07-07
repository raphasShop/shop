/*
-------------------------------------------------------------
아이스크림 쇼핑몰/커뮤니티에서 추가된 js를
common.js 파일을 건드리지 않고 이곳에 추가함
- 새로 추가되는 것들에 한함
-------------------------------------------------------------
*/

// 새 창(입금확인요청,구매평가 등 새창) - 아이스크림 (div onclick 방식)
function popup_form(id, url) {
	window.open(url, id, "width=810,height=680,scrollbars=1");
	return false;
}

/*
-------------------------------------
모달창 시작 {
js/tingle-master/ 의 모달창
-------------------------------------
*/
// instanciate new modal
var modal = new tingle.modal({
    footer: true,
    stickyFooter: false,
    closeMethods: ['overlay', 'button', 'escape'],
    closeLabel: "Close",
    cssClass: ['custom-class-1', 'custom-class-2'],
    onOpen: function() {
        console.log('modal open');
    },
    onClose: function() {
        console.log('modal closed');
    },
    beforeClose: function() {
        // here's goes some logic
        // e.g. save content before closing the modal
        return true; // close the modal
    	return false; // nothing happens
    }
});

// set content
modal.setContent('<h1>here\'s some content</h1>');

// add a button
modal.addFooterBtn('Button label', 'tingle-btn tingle-btn--primary', function() {
    // here goes some logic
    modal.close();
});

// add another button
modal.addFooterBtn('Dangerous action !', 'tingle-btn tingle-btn--danger', function() {
    // here goes some logic
    modal.close();
});

// open modal
modal.open();

// close modal
modal.close();

/*
-------------------------------------
} 모달창 끝
js/tingle-master/ 의 모달창
-------------------------------------
*/


/*
-------------------------------------------------------------
아이스크림 관리자모드에서 추가된 js는
adm/js/icecream.js 파일에서 수정하시면 됩니다
-------------------------------------------------------------
*/