$('document').ready( function() {
	$('#button').click( function() {
		$.ajax({
			method: 'POST',
			url: $('#calculator-form').attr('action'),
			data: {
				settlementType: $('#settlement-type').val(),
				orderedEnergy: $('#ordered-energy').val(),
				reliabilityCategory: $('#reliability-category').val(),
				scheme: $('#scheme').val(),
				voltage: $('#voltage').val(),
				currentEnergy: $('#current-energy').val(),
				company: $('#company').val()
			}
		}).done( function (result) {
			$('#warning').html(result);
			result = jQuery.parseJSON(result);
			$('#grn').html(Math.floor(result.value));
			$('#kop').html(Math.round((result.value - Math.floor(result.value)).toFixed(2) * 100));
			$('#pdv-grn').html(Math.floor(result.pdv));
			$('#pdv-kop').html(Math.round((result.pdv - Math.floor(result.pdv)).toFixed(2) * 100));
			$('#warning').html(result.message);
		});
	});
});