@props([
	'id',
	'label',
	'options' => [],
	'selected' => null,
	'name' => null,
	'variant' => 'blue',
])

@php
	$fieldName = $name ?? $id;
	$variantClasses = [
		'blue' => 'focus:border-blue-400 focus:ring-blue-100',
		'violet' => 'focus:border-violet-400 focus:ring-violet-100',
		'slate' => 'focus:border-slate-400 focus:ring-slate-100',
	];
	$selectedVariant = $variantClasses[$variant] ?? $variantClasses['blue'];
@endphp

<div>
	<label for="{{ $id }}" class="mb-2 block text-sm font-semibold text-slate-700">{{ $label }}</label>
	<select
		id="{{ $id }}"
		name="{{ $fieldName }}"
		{{ $attributes->merge([
			'class' => 'block w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm transition focus:outline-none focus:ring-4 ' . $selectedVariant,
		]) }}
	>
		@foreach ($options as $option)
			@php
				$value = is_array($option) ? $option['value'] : $option;
				$text = is_array($option) ? ($option['label'] ?? $option['name'] ?? $value) : $option;
				$languageID = is_array($option) ? $option['id'] : $option;
			@endphp

			<option value="{{ $value }}" @selected($selected == $value) @data('language-id', $languageID)>{{ $text }}</option>
		@endforeach
	</select>
</div>
