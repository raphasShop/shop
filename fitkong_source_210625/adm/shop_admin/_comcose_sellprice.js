$(document).ready(function () {
	var num_only = /[^0-9]/gi;
	$(document).on("keyup", ".num_only", function() {
		if (num_only.test($(this).val())) {
		$(this).val( $(this).val().replace(num_only,"") );
		alert("숫자만 입력 가능합니다.");
		}
	});
});