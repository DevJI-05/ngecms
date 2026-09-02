<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    @php $options = $getOptions(); @endphp

    <div
        x-data="{ state: $wire.$entangle(@js($getStatePath())), open: false }"
        class="relative"
        {{ $getExtraAttributeBag() }}
    >
        <button
            type="button"
            x-on:click="open = !open"
            x-on:click.outside="open = false"
            class="flex w-full items-center gap-2 rounded-lg border border-gray-300 px-3 py-2 text-start text-sm text-gray-950 transition-colors hover:border-gray-400 dark:border-white/10 dark:text-white dark:hover:border-white/20"
        >
            <span class="flex h-6 w-6 shrink-0 items-center justify-center text-lg text-gray-500 dark:text-gray-400">
                @foreach ($options as $class => $label)
                    <i class="ti {{ $class }}" x-show="state === '{{ $class }}'" style="display: none"></i>
                @endforeach
                <i class="ti ti-help-circle" x-show="!state" style="display: none"></i>
            </span>

            <span class="flex-1">
                @foreach ($options as $class => $label)
                    <span x-show="state === '{{ $class }}'" style="display: none">{{ $label }}</span>
                @endforeach
                <span x-show="!state" style="display: none" class="text-gray-400">Choose an icon</span>
            </span>

            <i class="ti ti-chevron-down shrink-0 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''"></i>
        </button>

        <div
            x-show="open"
            x-cloak
            x-transition
            class="absolute z-10 mt-2 grid w-full max-w-xs grid-cols-6 gap-1 rounded-lg border border-gray-200 bg-white p-2 shadow-lg dark:border-white/10 dark:bg-gray-800"
        >
            @foreach ($options as $class => $label)
                <button
                    type="button"
                    x-on:click="state = '{{ $class }}'; open = false"
                    :class="state === '{{ $class }}' ? 'bg-primary-50 text-primary-600 ring-1 ring-primary-500 dark:bg-primary-500/10 dark:text-primary-400' : 'text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-white/5'"
                    class="flex items-center justify-center rounded-md p-2 text-lg"
                    title="{{ $label }}"
                >
                    <i class="ti {{ $class }}"></i>
                </button>
            @endforeach
        </div>
    </div>
</x-dynamic-component>
