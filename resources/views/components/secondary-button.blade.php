<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-blue-500 border border-gray-300 rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:text-blue-200 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-blue-100 active:bg-gray-50 disabled:opacity-25 transition']) }}>
    {{ $slot }}
</button>
