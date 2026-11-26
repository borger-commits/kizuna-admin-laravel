<!-- resources/views/filament/components/color-badge.blade.php -->
<div class="p-4 rounded-xl border flex items-center justify-between gap-4 
            bg-primary-50/40 border-primary-200 text-primary-800
            dark:bg-primary-950/20 dark:border-primary-800 dark:text-primary-300">
    
    <div class="flex items-center gap-3">
        <!-- Pulse Status Dot -->
        <span class="relative flex h-3 w-3">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75 bg-primary-400"></span>
            <span class="relative inline-flex rounded-full h-3 w-3 bg-primary-500"></span>
        </span>
        
        <div>
            <p class="font-semibold text-gray-900 dark:text-white text-sm">
                Live Status Tracker
            </p>
            <p class="text-xs text-gray-500 dark:text-gray-400">
                Current item: 
                <span class="font-bold text-primary-600 dark:text-primary-400">
                    {{ filled($get('name')) ? $get('name') : 'Unnamed Item' }}
                </span>
            </p>
        </div>
    </div>

    <!-- Condition-based Danger Badge -->
    @if($get('is_urgent'))
        <span class="px-2.5 py-1 text-xs font-medium rounded-full ring-1 ring-inset
                     bg-danger-50 text-danger-700 ring-danger-600/20
                     dark:bg-danger-500/10 dark:text-danger-400 dark:ring-danger-500/20">
            Urgent Review
        </span>
    @endif
</div>
