@props([
	'month' => 'Janeiro',
	'year' => '2020',
])

<form id="monthform" class="w-75 cent" method="POST" action="/month">
	@csrf
	<label for="month">Mês: </label> 
	<select name="month" id="monthPicker">
		<option value="1" {{ ($month == "Janeiro" ? 'selected' : '') }}>Janeiro</option>
		<option value="2" {{ ($month == "Fevereiro" ? 'selected' : '') }}>Fevereiro</option>
		<option value="3" {{ ($month == "Março" ? 'selected' : '') }}>Março</option>
		<option value="4" {{ ($month == "Abril" ? 'selected' : '') }}>Abril</option>
		<option value="5" {{ ($month == "Maio" ? 'selected' : '') }}>Maio</option>
		<option value="6" {{ ($month == "Junho" ? 'selected' : '') }}>Junho</option>
		<option value="7" {{ ($month == "Julho" ? 'selected' : '') }}>Julho</option>
		<option value="8" {{ ($month == "Agosto" ? 'selected' : '') }}>Agosto</option>
		<option value="9" {{ ($month == "Setembro" ? 'selected' : '') }}>Setembro</option>
		<option value="10" {{ ($month == "Outubro" ? 'selected' : '') }}>Outubro</option>
		<option value="11" {{ ($month == "Novembro" ? 'selected' : '') }}>Novembro</option>
		<option value="12" {{ ($month == "Dezembro" ? 'selected' : '') }}>Dezembro</option>
	</select>

	<label for="year">Ano: </label> 
	<select name="year" id="YearPicker">
		@foreach (yearRange() as $range)
			<option value="{{ $range }}" {{ ($range == $year ? 'selected' : '') }}>{{ $range }}</option>
		@endforeach
	</select>
	<button id="enviar" type="submit" class="btn btn-primary bt btn-selecionar mx-2 mb-2 align-middle">
        Selecionar
    </button>
</form>