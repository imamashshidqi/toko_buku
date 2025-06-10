@props(['active' => false])
<a {{ $attributes }}
    class="{{ $active ? 'bg-primary-800 text-white' : 'text-primary-300 hover:bg-primary-600 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium"
    aria-current="{{ $active ? 'page' : false }}">
    {{ $slot }}
</a>
