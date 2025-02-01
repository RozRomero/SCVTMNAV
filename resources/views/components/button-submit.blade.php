<!-- @props(['color' => 'green']) -->
<button {{ $attributes->merge(['type' => 'submit', 'id' => '', 'class' => 'capitalize p-1 rounded border-none bg-'.$color.'-500 hover:bg-'.$color.'-700 pointer py-2 px-4']) }}>
    {{ $slot }}
</button>