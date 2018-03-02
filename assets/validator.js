$('document').ready(function() {
	$('#ordered-energy').bind('input keyup change', function() {
		$('#warning').html('');
		var value = this.value;
		if (/^\.|\d+\..*\.|[^\d\.{1}]/.test(value)) this.value = value.slice(0, -1);
		if (this.value <= 16 && this.value > 0) $('#ordered-energy-info').html('I ступінь');
		else if (this.value > 16 && this.value <= 50) $('#ordered-energy-info').html('II ступінь');
		else if (this.value > 50 && this.value <= 160) $('#ordered-energy-info').html('III ступінь');
		else if (this.value == 0) $('#ordered-energy-info').html('');
		else if (this.value > 160) {
			$('#warning').html('Значення існуючої потужності не може перевищувати значення максимального розрахункового навантаження. Скорегуйте введені данні, будь-ласка.');
			$('#ordered-energy-info').html('Не вірно вказано значення напруги');
		} else $('#ordered-energy-info').html('Не вірно вказано значення напруги');
	});
	$('#ordered-energy').focusout(function () {
		this.value = correctNumericValue(this.value);
	});
	
	$('#current-energy').bind('input keyup change', function() {
		var value = this.value;
		if (/^\.|\d+\..*\.|[^\d\.{1}]/.test(value)) this.value = value.slice(0, -1);
		if (this.value > 0) $('#company').attr('disabled', false);
		else $('#company').attr('disabled', true);
	});
	$('#current-energy').focusout(function() {
		this.value = correctNumericValue(this.value);
	});

	$('.input').bind('input keyup change', function () {
		var value = this.value;
		if (/^\.|\d+\..*\.|[^\d\.{1}]/.test(value)) this.value = value.slice(0, -1);
	});
	$('.input').focusout( function () {
		this.value = correctNumericValue(this.value);
	});
});
function correctNumericValue(value) {
	var result = '';
	var length = value.length;
	var notZero = false;
	for (var i = 0; i < length; i++) {
		if (length > 1 && value[i] == '0' && notZero == false) result += '';
		else {
			if (value[i] != '0') notZero = true;
			result += value[i];
		}
	}
	if (result[result.length - 1] == '.' || result == '') result += '0';
	return result;
}