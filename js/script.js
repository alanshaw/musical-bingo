$(function(){
	if($('.ie7, .ie8').length) {
  	$('body').lastChild();
  }
});

function validate() {
	var cols = parseInt($('input[name="cols"]').val());
	var rows = parseInt($('input[name="rows"]').val());
	
	var needed = cols * rows;
	
	var tunes = $('textarea[name="tunes"]').val().split(',').length;
	
	if(tunes < needed) {
		alert('Not enough tunes! Need at least ' + needed + '! You only entered ' + tunes + '.');
		return false;
	} else {
		return true;
	}
}

function editSubmit() {
	var form = $('form');
	$('<input type="hidden" name="edit" value="1"/>').appendTo(form);
	form.first().submit();
}