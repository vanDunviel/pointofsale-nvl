@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium bg-opacity-60 text-sm text-gray-700 dark:text-gray-300']) }}>
    {{ $value ?? $slot }}
</label>
