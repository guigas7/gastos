@props([
	'type' => 'success',
	'colors' => [
		'success' => 'bg-green-500',
		'error' => 'bg-red-500',
		'warning' => 'bg-orange-500',
	]

])

<section {{ $attributes->merge(['class' => "{$colors[$type]} border-b p-4"]) }}>
	<div class="flex justify-between">
		<p>
			{{ slot }}
		</p>
	</div>
</section>