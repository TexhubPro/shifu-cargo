<div>
    @if($message)
    <div class="bg-yellow-50 border border-yellow-200 text-sm text-yellow-800 rounded-xl p-3 dark:bg-yellow-800/10 dark:border-yellow-900 dark:text-yellow-500"
        role="alert" tabindex="-1" aria-labelledby="hs-with-description-label">
        <div class="flex">
            <div class="shrink-0">
                <svg class="shrink-0 size-4 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path>
                    <path d="M12 9v4"></path>
                    <path d="M12 17h.01"></path>
                </svg>
            </div>
            <div class="ms-4">
                <div class="text-sm text-yellow-700">
                    {{ $message }}
                </div>
            </div>
        </div>
    </div>
    @endif
</div>