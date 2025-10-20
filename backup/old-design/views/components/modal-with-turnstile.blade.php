{{-- 
    Example Modal with Turnstile Integration
    Usage: <x-modal-with-turnstile />
--}}

<div x-data="modalWithTurnstile()" x-init="init()">
    <!-- Modal Trigger Button -->
    <button @click="show()" class="btn bg-purple-500 hover:bg-purple-600 text-white">
        Open Modal with Turnstile
    </button>

    <!-- Modal -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;">
        
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="hide()"></div>

            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                Modal with Turnstile
                            </h3>
                            
                            <!-- Turnstile Widget -->
                            <x-turnstile-modal container-id="modal-turnstile" />
                            
                            <div class="mt-4">
                                <p class="text-sm text-gray-500">
                                    This modal demonstrates Turnstile integration. The widget will initialize when the modal becomes visible.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" 
                            @click="hide()"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('modalWithTurnstile', () => ({
            open: false,
            
            init() {
                // Ensure Turnstile script is loaded
                this.loadTurnstileScript();
            },
            
            loadTurnstileScript() {
                if (window.turnstile) return;
                
                const script = document.createElement('script');
                script.src = 'https://challenges.cloudflare.com/turnstile/v0/api.js';
                script.async = true;
                script.defer = true;
                document.head.appendChild(script);
            },
            
            show() {
                this.open = true;
                // Initialize Turnstile after modal becomes visible
                setTimeout(() => {
                    if (window.initTurnstileModalTurnstile) {
                        window.initTurnstileModalTurnstile();
                    }
                }, 100);
            },
            
            hide() {
                this.open = false;
            }
        }));
    });
</script>
