$(document).ready(function () {

	$('.subnavbar').find ('li').each (function (i) {
		var mod = i % 3;
		if (mod === 2) {
			$(this).addClass ('subnavbar-open-right');
		}
	});
	
	$('.datepicker').datetimepicker({
		startDate:new Date(),
		format:'Y-m-d',
		timepicker: false,
		closeOnDateSelect:true
	});
	
	$('.datetimepicker').datetimepicker({
		format:'d-m-Y H:i',
		step:5
	});
	
	 $('[data-toggle="popover"]').popover();
});