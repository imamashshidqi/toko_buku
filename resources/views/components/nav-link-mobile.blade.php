@props(['active' => false])
<a {{ $attributes }}
    class="{{ $active ? 'bg-primary-900 text-white' : 'text-primary-300 hover:bg-primary-700 hover:text-white' }} block rounded-md px-3 py-2 text-base font-medium"
    aria-current="{{ $active ? 'page' : false }}">
    {{ $slot }}
</a>
