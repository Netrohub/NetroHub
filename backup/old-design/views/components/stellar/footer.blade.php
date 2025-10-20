<footer>
    <div class="max-w-6xl mx-auto px-4 sm:px-6">

        <!-- Blocks -->
        <div class="grid sm:grid-cols-12 gap-8 py-8 md:py-12">

            <!-- 1st block -->
            <div class="sm:col-span-12 lg:col-span-4 order-1 lg:order-none">
                <div class="h-full flex flex-col sm:flex-row lg:flex-col justify-between">
                    <div class="mb-6 sm:mb-0">
                        <div class="mb-4">
                            <a class="inline-flex items-center" href="{{ route('home') }}" aria-label="{{ config('app.name') }}">
                                <svg class="w-8 h-8 fill-current text-purple-500" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M31.952 14.751a260.51 260.51 0 00-4.359-4.407C23.932 6.734 20.16 3.182 16.171 0c1.634.017 3.21.28 4.692.751 3.487 3.114 6.846 6.398 10.163 9.737.493 1.346.811 2.776.926 4.262zm-1.388 7.883c-2.496-2.597-5.051-5.12-7.737-7.471-3.706-3.246-10.693-9.81-15.736-7.418-4.552 2.158-4.717 10.543-4.96 16.238A15.926 15.926 0 010 16C0 9.799 3.528 4.421 8.686 1.766c1.82.593 3.593 1.675 5.038 2.587 6.569 4.14 12.29 9.71 17.792 15.57-.237.94-.557 1.846-.952 2.711zm-4.505 5.81a56.161 56.161 0 00-1.007-.823c-2.574-2.054-6.087-4.805-9.394-4.044-3.022.695-4.264 4.267-4.97 7.52a15.945 15.945 0 01-3.665-1.85c.366-3.242.89-6.675 2.405-9.364 2.315-4.107 6.287-3.072 9.613-1.132 3.36 1.96 6.417 4.572 9.313 7.417a16.097 16.097 0 01-2.295 2.275z" />
                                </svg>
                            </a>
                        </div>
                        <div class="text-sm text-slate-300">
                            © {{ date('Y') }} {{ \App\Models\SiteSetting::get('company_name', \App\Models\SiteSetting::get('site_name', config('app.name'))) }}. 
                            {{ __('All rights reserved.') }}
                        </div>
                    </div>
                    <!-- Social links -->
                    <ul class="flex">
                        <li>
                            <a class="flex justify-center items-center text-purple-500 hover:text-purple-400 transition duration-150 ease-in-out" href="#" aria-label="Twitter">
                                <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m13.063 9 3.495 4.475L20.601 9h2.454l-5.359 5.931L24 23h-4.938l-3.866-4.893L10.771 23H8.316l5.735-6.342L8 9h5.063Zm-.74 1.347h-1.457l8.875 11.232h1.36l-8.778-11.232Z" />
                                </svg>
                            </a>
                        </li>
                        <li class="ml-2">
                            <a class="flex justify-center items-center text-purple-500 hover:text-purple-400 transition duration-150 ease-in-out" href="#" aria-label="Github">
                                <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16 8.2c-4.4 0-8 3.6-8 8 0 3.5 2.3 6.5 5.5 7.6.4.1.5-.2.5-.4V22c-2.2.5-2.7-1-2.7-1-.4-.9-.9-1.2-.9-1.2-.7-.5.1-.5.1-.5.8.1 1.2.8 1.2.8.7 1.3 1.9.9 2.3.7.1-.5.3-.9.5-1.1-1.8-.2-3.6-.9-3.6-4 0-.9.3-1.6.8-2.1-.1-.2-.4-1 .1-2.1 0 0 .7-.2 2.2.8.6-.2 1.3-.3 2-.3s1.4.1 2 .3c1.5-1 2.2-.8 2.2-.8.4 1.1.2 1.9.1 2.1.5.6.8 1.3.8 2.1 0 3.1-1.9 3.7-3.7 3.9.3.4.6.9.6 1.6v2.2c0 .2.1.5.6.4 3.2-1.1 5.5-4.1 5.5-7.6-.1-4.4-3.7-8-8.1-8z" />
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Platform Links -->
            <div class="sm:col-span-6 md:col-span-3 lg:col-span-2">
                <h6 class="text-sm text-slate-50 font-medium mb-3">{{ __('Platform') }}</h6>
                <ul class="text-sm space-y-2.5">
                    <li>
                        <a class="text-slate-400 hover:text-slate-200 transition duration-150 ease-in-out" href="{{ route('products.index') }}">{{ __('Browse Products') }}</a>
                    </li>
                    <li>
                        <a class="text-slate-400 hover:text-slate-200 transition duration-150 ease-in-out" href="{{ route('sell.index') }}">{{ __('Start Selling') }}</a>
                    </li>
                    <li>
                        <a class="text-slate-400 hover:text-slate-200 transition duration-150 ease-in-out" href="{{ route('pricing.index') }}">{{ __('Pricing & Plans') }}</a>
                    </li>
                    <li>
                        <a class="text-slate-400 hover:text-slate-200 transition duration-150 ease-in-out" href="{{ route('members.index') }}">{{ __('Members') }}</a>
                    </li>
                </ul>
            </div>

            <!-- Support Links -->
            <div class="sm:col-span-6 md:col-span-3 lg:col-span-2">
                <h6 class="text-sm text-slate-50 font-medium mb-3">{{ __('Support') }}</h6>
                <ul class="text-sm space-y-2.5">
                    @auth
                        <li>
                            <a class="text-slate-400 hover:text-slate-200 transition duration-150 ease-in-out" href="{{ route('account.index') }}">{{ __('My Account') }}</a>
                        </li>
                        <li>
                            <a class="text-slate-400 hover:text-slate-200 transition duration-150 ease-in-out" href="{{ route('account.orders') }}">{{ __('My Orders') }}</a>
                        </li>
                        <li>
                            <a class="text-slate-400 hover:text-slate-200 transition duration-150 ease-in-out" href="{{ route('seller.dashboard') }}">{{ __('Seller Dashboard') }}</a>
                        </li>
                    @endauth
                    <li>
                        <a class="text-slate-400 hover:text-slate-200 transition duration-150 ease-in-out" href="{{ route('legal.refund') }}">{{ __('Refund Policy') }}</a>
                    </li>
                    <li>
                        <a class="text-slate-400 hover:text-slate-200 transition duration-150 ease-in-out" href="{{ route('legal.terms') }}">{{ __('Terms & Conditions') }}</a>
                    </li>
                    <li>
                        <a class="text-slate-400 hover:text-slate-200 transition duration-150 ease-in-out" href="{{ route('legal.privacy') }}">{{ __('Privacy Policy') }}</a>
                    </li>
                </ul>
            </div>

        </div>

    </div>
</footer>

