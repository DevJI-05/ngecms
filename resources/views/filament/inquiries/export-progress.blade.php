@if ($status !== 'idle')
    <div wire:poll.1s="pollInquiryExportProgress" class="fi-inquiry-export-progress mt-4 space-y-2">
        @if ($status === 'processing')
            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                <span>
                    @if ($total > 0)
                        Processing {{ number_format($processed) }} of {{ number_format($total) }} records...
                    @else
                        Preparing data for export...
                    @endif
                </span>
                <span>{{ $percentage }}%</span>
            </div>
            <div class="h-2 w-full overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700">
                <div
                    class="h-full rounded-full bg-primary-600 transition-all duration-300 ease-out"
                    style="width: {{ max($percentage, 4) }}%"
                ></div>
            </div>
        @elseif ($status === 'done')
            <div class="flex items-center gap-2 rounded-lg bg-success-50 px-3 py-2 text-sm text-success-700 dark:bg-success-500/10 dark:text-success-400">
                <x-filament::icon icon="heroicon-o-check-circle" class="h-5 w-5 shrink-0" />
                <span>Excel file is ready to download ({{ number_format($processed) }} rows).</span>
            </div>
            <x-filament::button
                tag="a"
                :href="$downloadUrl"
                icon="heroicon-o-arrow-down-tray"
                target="_blank"
            >
                Download Excel
            </x-filament::button>
        @elseif ($status === 'failed')
            <div class="flex items-center gap-2 rounded-lg bg-danger-50 px-3 py-2 text-sm text-danger-700 dark:bg-danger-500/10 dark:text-danger-400">
                <x-filament::icon icon="heroicon-o-x-circle" class="h-5 w-5 shrink-0" />
                <span>Export failed: {{ $error ?? 'An unexpected error occurred.' }}</span>
            </div>
        @endif
    </div>
@endif
