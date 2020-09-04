@props([
	'value' => 'Janeiro 2020',
])

<form id="monthform" method="POST" action="/month">
@csrf
	<label for="month">Mês :</label>
	<input name="month" id="monthYearPicker" value="{{ $value }}"/>
</form>
