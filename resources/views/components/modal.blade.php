@props([
    'title' => '',
    'subtitle' => '',
    'maxWidth' => 'max-w-lg'
])

<div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:{{ $maxWidth }} sm:w-full">
            <div class="px-6 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                        <h3 class="text-xl font-bold text-white" id="modal-title">
                            {{ $title }}
                        </h3>
                        @if($subtitle)
                            <p class="mt-1 text-sm text-cyan-300">
                                {{ $subtitle }}
                            </p>
                        @endif
                        
                        <div class="mt-6 text-gray-300">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
            
            @isset($footer)
                <div class="px-6 py-4 bg-gray-700/50 flex justify-end space-x-3">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>