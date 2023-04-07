<button
    {{ $attributes->merge(['type' => 'submit', 'class' => ' text-gray-900 bg-transparent hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#3b5998]/55 mr-2 mb-2']) }}>
    {{ $slot }}
</button>
