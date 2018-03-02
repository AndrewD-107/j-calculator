$('document').ready( function () {
	setRates(sendRequest('get'));
	$('#settlement-type').change( function () { sendRequest('get', null); });
	$('#reliability-category').change( function () { sendRequest('get', null); });
	$('#update').click( function () { sendRequest('update', rates()) });
});

function sendRequest(method, rates)
{
	$.ajax({
		method: 'POST',
		url: $('#admin-form').attr('action'),
		data: {
			method:method,
			settlementType: $('#settlement-type').val(),
			reliabilityCategory: $('#reliability-category').val(),
			rates: rates
		}
	}).done( function (result) {
		result = jQuery.parseJSON(result);
		switch (result['messageType']) {
			case 1: $('#error').html(result['message']); break;
			case 2: $('#warning').html(result['message']); break;
			case 3: $('#info').html(result['message']); break;
		}
		if (method == 'get') setRates(result['rates']);
	});
}

function rates() {
	return {
		"1":{
			"1":{"t":$('#stup1T1').val(),"s":$('#stup1S1').val()},
			"2":{"t":$('#stup1T2').val(),"s":$('#stup1S2').val()},
			"3":{"t":$('#stup1T3').val(),"s":$('#stup1S3').val()},
			"4":{"t":$('#stup1T4').val(),"s":$('#stup1S4').val()}
		},
		"2":{
			"1":{"t":$('#stup2T1').val(),"s":$('#stup2S1').val()},
			"2":{"t":$('#stup2T2').val(),"s":$('#stup2S2').val()},
			"3":{"t":$('#stup2T3').val(),"s":$('#stup2S3').val()},
			"4":{"t":$('#stup2T4').val(),"s":$('#stup2S4').val()}
		},
		"3":{
			"1":{"t":$('#stup3T1').val(),"s":$('#stup3S1').val()},
			"2":{"t":$('#stup3T2').val(),"s":$('#stup3S2').val()},
			"3":{"t":$('#stup3T3').val(),"s":$('#stup3S3').val()},
			"4":{"t":$('#stup3T4').val(),"s":$('#stup3S4').val()}
		}
	}
}

function setRates(rates) {
	if (rates) {
		// I ступінь
		$('#stup1T1').val(rates[1][1]['t']); $('#stup1S1').val(rates[1][1]['s']);
		$('#stup1T2').val(rates[1][2]['t']); $('#stup1S2').val(rates[1][2]['s']);
		$('#stup1T3').val(rates[1][3]['t']); $('#stup1S3').val(rates[1][3]['s']);
		$('#stup1T4').val(rates[1][4]['t']); $('#stup1S4').val(rates[1][4]['s']);
		// II ступінь
		$('#stup2T1').val(rates[2][1]['t']); $('#stup2S1').val(rates[2][1]['s']);
		$('#stup2T2').val(rates[2][2]['t']); $('#stup2S2').val(rates[2][2]['s']);
		$('#stup2T3').val(rates[2][3]['t']); $('#stup2S3').val(rates[2][3]['s']);
		$('#stup2T4').val(rates[2][4]['t']); $('#stup2S4').val(rates[2][4]['s']);
		// III ступінь
		$('#stup3T1').val(rates[3][1]['t']); $('#stup3S1').val(rates[3][1]['s']);
		$('#stup3T2').val(rates[3][2]['t']); $('#stup3S2').val(rates[3][2]['s']);
		$('#stup3T3').val(rates[3][3]['t']); $('#stup3S3').val(rates[3][3]['s']);
		$('#stup3T4').val(rates[3][4]['t']); $('#stup3S4').val(rates[3][4]['s']);
	} else {
		// I ступінь
		$('#stup1T1').val(0); $('#stup1S1').val(0); $('#stup1T2').val(0); $('#stup1S2').val(0);
		$('#stup1T3').val(0); $('#stup1S3').val(0); $('#stup1T4').val(0); $('#stup1S4').val(0);
		// II ступінь
		$('#stup2T1').val(0); $('#stup2S1').val(0); $('#stup2T2').val(0); $('#stup2S2').val(0);
		$('#stup2T3').val(0); $('#stup2S3').val(0); $('#stup2T4').val(0); $('#stup2S4').val(0);
		// III ступінь
		$('#stup3T1').val(0); $('#stup3S1').val(0); $('#stup3T2').val(0); $('#stup3S2').val(0);
		$('#stup3T3').val(0); $('#stup3S3').val(0); $('#stup3T4').val(0); $('#stup3S4').val(0);
	}
}