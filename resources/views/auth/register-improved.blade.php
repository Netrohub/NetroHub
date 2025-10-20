<x-layouts.app>
    <x-slot name="title">{{ __('Create Account') }} - {{ config('app.name') }}</x-slot>

<section class="relative">
<div class="min-h-screen relative overflow-hidden flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <!-- Gaming Background Effects -->
    <div class="absolute inset-0 bg-dark-900">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-secondary-500/20 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-primary-500/20 rounded-full blur-3xl animate-float animation-delay-2000"></div>
        <div class="absolute top-3/4 left-3/4 w-64 h-64 bg-neon-pink/10 rounded-full blur-3xl animate-float animation-delay-4000"></div>
    </div>

    <div class="relative max-w-md w-full space-y-8">
        <!-- Gaming Header -->
        <div class="text-center animate-fade-in">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-secondary-500 to-neon-pink rounded-3xl mb-6 shadow-gaming-purple">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <h2 class="text-4xl font-black text-white mb-2 bg-gradient-to-r from-secondary-500 to-neon-pink bg-clip-text text-transparent">
                Join NXO
            </h2>
            <p class="text-muted-300">
                Create your gaming marketplace account
            </p>
        </div>

        <!-- Gaming Register Form -->
        <x-ui.card variant="glass" class="animate-fade-in animation-delay-200">
            <form class="space-y-4" method="POST" action="{{ route('register') }}">
                @csrf
                
                <!-- Full Name Field -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-white mb-2">
                        Full Name <span class="text-red-400">*</span>
                    </label>
                    <x-ui.input 
                        id="name" 
                        name="name" 
                        type="text" 
                        placeholder="Enter your full name" 
                        value="{{ old('name') }}"
                        required
                        class="w-full"
                    />
                    @error('name')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Username Field -->
                <div>
                    <label for="username" class="block text-sm font-semibold text-white mb-2">
                        Username <span class="text-red-400">*</span>
                    </label>
                    <x-ui.input 
                        id="username" 
                        name="username" 
                        type="text" 
                        placeholder="Choose a unique username" 
                        value="{{ old('username') }}"
                        required
                        class="w-full"
                    />
                    @error('username')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-muted-400">3-24 characters, letters, numbers, and underscores only</p>
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-white mb-2">
                        Email Address <span class="text-red-400">*</span>
                    </label>
                    <x-ui.input 
                        id="email" 
                        name="email" 
                        type="email" 
                        placeholder="Enter your email" 
                        value="{{ old('email') }}"
                        required
                        class="w-full"
                    />
                    @error('email')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Field (with country picker) -->
                <div>
                    <label for="phone" class="block text-sm font-semibold text-white mb-2">
                        Phone Number <span class="text-red-400">*</span>
                    </label>
                    <div class="flex gap-2">
                        <!-- Custom Searchable Country Dropdown -->
                        <div class="relative w-48" id="country-dropdown-container">
                            <!-- Selected Country Display -->
                            <div id="country-display" 
                                 class="w-full bg-dark-800 border border-gaming rounded-2xl px-4 py-3 text-white focus:ring-2 focus:ring-secondary-500 focus:border-transparent transition-all cursor-pointer text-sm flex items-center justify-between"
                                 onclick="toggleCountryDropdown()">
                                <div class="flex items-center gap-2">
                                    <span id="selected-flag">🇺🇸</span>
                                    <span id="selected-country">+1</span>
                                </div>
                                <svg class="w-4 h-4 text-muted-400 transition-transform" id="dropdown-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                            
                            <!-- Hidden input for form submission -->
                            <input type="hidden" name="country_code_display" id="country_code" value="+1">
                            
                            <!-- Dropdown Menu -->
                            <div id="country-dropdown" 
                                 class="absolute top-full left-0 right-0 mt-1 bg-dark-800 border border-gaming rounded-2xl shadow-lg z-50 max-h-60 overflow-hidden hidden">
                                
                                <!-- Search Input -->
                                <div class="p-3 border-b border-gaming">
                                    <input type="text" 
                                           id="country-search" 
                                           placeholder="Search countries..."
                                           class="w-full bg-dark-700 border border-gaming rounded-xl px-3 py-2 text-white text-sm focus:ring-2 focus:ring-secondary-500 focus:border-transparent transition-all"
                                           onkeyup="filterCountries()">
                                </div>
                                
                                <!-- Countries List -->
                                <div id="countries-list" class="max-h-48 overflow-y-auto">
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+1" onclick="selectCountry('+1', '🇺🇸', 'United States')">
                                        <span class="mr-2">🇺🇸</span>
                                        <span>United States</span>
                                        <span class="ml-auto text-muted-400">+1</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+44" onclick="selectCountry('+44', '🇬🇧', 'United Kingdom')">
                                        <span class="mr-2">🇬🇧</span>
                                        <span>United Kingdom</span>
                                        <span class="ml-auto text-muted-400">+44</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+91" onclick="selectCountry('+91', '🇮🇳', 'India')">
                                        <span class="mr-2">🇮🇳</span>
                                        <span>India</span>
                                        <span class="ml-auto text-muted-400">+91</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+86" onclick="selectCountry('+86', '🇨🇳', 'China')">
                                        <span class="mr-2">🇨🇳</span>
                                        <span>China</span>
                                        <span class="ml-auto text-muted-400">+86</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+81" onclick="selectCountry('+81', '🇯🇵', 'Japan')">
                                        <span class="mr-2">🇯🇵</span>
                                        <span>Japan</span>
                                        <span class="ml-auto text-muted-400">+81</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+49" onclick="selectCountry('+49', '🇩🇪', 'Germany')">
                                        <span class="mr-2">🇩🇪</span>
                                        <span>Germany</span>
                                        <span class="ml-auto text-muted-400">+49</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+33" onclick="selectCountry('+33', '🇫🇷', 'France')">
                                        <span class="mr-2">🇫🇷</span>
                                        <span>France</span>
                                        <span class="ml-auto text-muted-400">+33</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+61" onclick="selectCountry('+61', '🇦🇺', 'Australia')">
                                        <span class="mr-2">🇦🇺</span>
                                        <span>Australia</span>
                                        <span class="ml-auto text-muted-400">+61</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+971" onclick="selectCountry('+971', '🇦🇪', 'UAE')">
                                        <span class="mr-2">🇦🇪</span>
                                        <span>UAE</span>
                                        <span class="ml-auto text-muted-400">+971</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+966" onclick="selectCountry('+966', '🇸🇦', 'Saudi Arabia')">
                                        <span class="mr-2">🇸🇦</span>
                                        <span>Saudi Arabia</span>
                                        <span class="ml-auto text-muted-400">+966</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+20" onclick="selectCountry('+20', '🇪🇬', 'Egypt')">
                                        <span class="mr-2">🇪🇬</span>
                                        <span>Egypt</span>
                                        <span class="ml-auto text-muted-400">+20</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+55" onclick="selectCountry('+55', '🇧🇷', 'Brazil')">
                                        <span class="mr-2">🇧🇷</span>
                                        <span>Brazil</span>
                                        <span class="ml-auto text-muted-400">+55</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+52" onclick="selectCountry('+52', '🇲🇽', 'Mexico')">
                                        <span class="mr-2">🇲🇽</span>
                                        <span>Mexico</span>
                                        <span class="ml-auto text-muted-400">+52</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+34" onclick="selectCountry('+34', '🇪🇸', 'Spain')">
                                        <span class="mr-2">🇪🇸</span>
                                        <span>Spain</span>
                                        <span class="ml-auto text-muted-400">+34</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+39" onclick="selectCountry('+39', '🇮🇹 Italy (+39)')">
                                        <span class="mr-2">🇮🇹</span>
                                        <span>Italy</span>
                                        <span class="ml-auto text-muted-400">+39</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+31" onclick="selectCountry('+31', '🇳🇱 Netherlands (+31)')">
                                        <span class="mr-2">🇳🇱</span>
                                        <span>Netherlands</span>
                                        <span class="ml-auto text-muted-400">+31</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+41" onclick="selectCountry('+41', '🇨🇭 Switzerland (+41)')">
                                        <span class="mr-2">🇨🇭</span>
                                        <span>Switzerland</span>
                                        <span class="ml-auto text-muted-400">+41</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+43" onclick="selectCountry('+43', '🇦🇹 Austria (+43)')">
                                        <span class="mr-2">🇦🇹</span>
                                        <span>Austria</span>
                                        <span class="ml-auto text-muted-400">+43</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+46" onclick="selectCountry('+46', '🇸🇪 Sweden (+46)')">
                                        <span class="mr-2">🇸🇪</span>
                                        <span>Sweden</span>
                                        <span class="ml-auto text-muted-400">+46</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+47" onclick="selectCountry('+47', '🇳🇴 Norway (+47)')">
                                        <span class="mr-2">🇳🇴</span>
                                        <span>Norway</span>
                                        <span class="ml-auto text-muted-400">+47</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+45" onclick="selectCountry('+45', '🇩🇰 Denmark (+45)')">
                                        <span class="mr-2">🇩🇰</span>
                                        <span>Denmark</span>
                                        <span class="ml-auto text-muted-400">+45</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+358" onclick="selectCountry('+358', '🇫🇮 Finland (+358)')">
                                        <span class="mr-2">🇫🇮</span>
                                        <span>Finland</span>
                                        <span class="ml-auto text-muted-400">+358</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+82" onclick="selectCountry('+82', '🇰🇷 South Korea (+82)')">
                                        <span class="mr-2">🇰🇷</span>
                                        <span>South Korea</span>
                                        <span class="ml-auto text-muted-400">+82</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+65" onclick="selectCountry('+65', '🇸🇬 Singapore (+65)')">
                                        <span class="mr-2">🇸🇬</span>
                                        <span>Singapore</span>
                                        <span class="ml-auto text-muted-400">+65</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+60" onclick="selectCountry('+60', '🇲🇾 Malaysia (+60)')">
                                        <span class="mr-2">🇲🇾</span>
                                        <span>Malaysia</span>
                                        <span class="ml-auto text-muted-400">+60</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+66" onclick="selectCountry('+66', '🇹🇭 Thailand (+66)')">
                                        <span class="mr-2">🇹🇭</span>
                                        <span>Thailand</span>
                                        <span class="ml-auto text-muted-400">+66</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+63" onclick="selectCountry('+63', '🇵🇭 Philippines (+63)')">
                                        <span class="mr-2">🇵🇭</span>
                                        <span>Philippines</span>
                                        <span class="ml-auto text-muted-400">+63</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+84" onclick="selectCountry('+84', '🇻🇳 Vietnam (+84)')">
                                        <span class="mr-2">🇻🇳</span>
                                        <span>Vietnam</span>
                                        <span class="ml-auto text-muted-400">+84</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+62" onclick="selectCountry('+62', '🇮🇩 Indonesia (+62)')">
                                        <span class="mr-2">🇮🇩</span>
                                        <span>Indonesia</span>
                                        <span class="ml-auto text-muted-400">+62</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+64" onclick="selectCountry('+64', '🇳🇿 New Zealand (+64)')">
                                        <span class="mr-2">🇳🇿</span>
                                        <span>New Zealand</span>
                                        <span class="ml-auto text-muted-400">+64</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+27" onclick="selectCountry('+27', '🇿🇦 South Africa (+27)')">
                                        <span class="mr-2">🇿🇦</span>
                                        <span>South Africa</span>
                                        <span class="ml-auto text-muted-400">+27</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+234" onclick="selectCountry('+234', '🇳🇬 Nigeria (+234)')">
                                        <span class="mr-2">🇳🇬</span>
                                        <span>Nigeria</span>
                                        <span class="ml-auto text-muted-400">+234</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+254" onclick="selectCountry('+254', '🇰🇪 Kenya (+254)')">
                                        <span class="mr-2">🇰🇪</span>
                                        <span>Kenya</span>
                                        <span class="ml-auto text-muted-400">+254</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+7" onclick="selectCountry('+7', '🇷🇺 Russia (+7)')">
                                        <span class="mr-2">🇷🇺</span>
                                        <span>Russia</span>
                                        <span class="ml-auto text-muted-400">+7</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+380" onclick="selectCountry('+380', '🇺🇦 Ukraine (+380)')">
                                        <span class="mr-2">🇺🇦</span>
                                        <span>Ukraine</span>
                                        <span class="ml-auto text-muted-400">+380</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+48" onclick="selectCountry('+48', '🇵🇱 Poland (+48)')">
                                        <span class="mr-2">🇵🇱</span>
                                        <span>Poland</span>
                                        <span class="ml-auto text-muted-400">+48</span>
                                    </div>
                                    <div class="country-option px-4 py-2 text-sm text-white hover:bg-dark-700 cursor-pointer flex items-center" 
                                         data-value="+420" onclick="selectCountry('+420', '🇨🇿 Czech Republic (+420)')">
                                        <span class="mr-2">🇨🇿</span>
                                        <span>Czech Republic</span>
                                        <span class="ml-auto text-muted-400">+420</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Phone Input -->
                        <x-ui.input 
                            id="phone_number" 
                            name="phone_number_display" 
                            type="tel" 
                            placeholder="123-456-7890" 
                            value="{{ old('phone') ? preg_replace('/^\+\d+/', '', old('phone')) : '' }}"
                            class="flex-1"
                        />
                        <input type="hidden" name="phone" id="phone_hidden" value="{{ old('phone') }}">
                    </div>
                    @error('phone')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-white mb-2">
                        Password
                    </label>
                    <x-ui.input 
                        id="password" 
                        name="password" 
                        type="password" 
                        placeholder="Create a strong password" 
                        required
                        class="w-full"
                    />
                    @error('password')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-white mb-2">
                        Confirm Password
                    </label>
                    <x-ui.input 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        type="password" 
                        placeholder="Confirm your password" 
                        required
                        class="w-full"
                    />
                </div>

                <!-- Terms & Conditions -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="terms" name="terms" type="checkbox" required
                               class="h-4 w-4 text-secondary-500 focus:ring-secondary-500 border-gaming rounded bg-dark-800">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="terms" class="text-muted-300">
                            I agree to the 
                            <a href="{{ route('legal.terms') }}" target="_blank" class="text-secondary-400 hover:text-secondary-300 transition-colors">Terms & Conditions</a> 
                            and 
                            <a href="{{ route('legal.privacy') }}" target="_blank" class="text-secondary-400 hover:text-secondary-300 transition-colors">Privacy Policy</a>
                        </label>
                    </div>
                </div>
                @error('terms')
                    <p class="text-sm text-red-400">{{ $message }}</p>
                @enderror

                <!-- Turnstile Widget -->
                <div>
                    <div class="cf-turnstile" data-sitekey="{{ env('TURNSTILE_SITE_KEY') }}" data-theme="dark"></div>
                    @error('cf-turnstile-response')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Create Account Button -->
                <div>
                    <x-ui.button 
                        type="submit" 
                        variant="secondary" 
                        size="lg" 
                        glow="true"
                        class="w-full justify-center"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Create Account
                    </x-ui.button>
                </div>

                <!-- Sign In Link -->
                <div class="text-center">
                    <p class="text-sm text-muted-400">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="text-secondary-400 hover:text-secondary-300 font-semibold transition-colors">
                            Sign in
                        </a>
                    </p>
                </div>
            </form>

            <!-- Divider -->
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gaming"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-dark-800 text-muted-400 font-medium">or continue with</span>
                    </div>
                </div>
            </div>

            <!-- Social Login Buttons -->
            <div class="mt-6">
                <!-- Google -->
                <a href="{{ route('login.social', 'google') }}" 
                   class="flex items-center justify-center w-full px-4 py-3 border border-gaming text-base font-medium rounded-2xl text-white bg-dark-800/50 hover:bg-dark-700/50 hover:border-red-500 transition-all duration-300">
                    <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Continue with Google
                </a>
            </div>
        </x-ui.card>
    </div>
</div>

<!-- Turnstile Script -->
<script nonce="{{ csp_nonce() }}" src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

<!-- Country Dropdown JavaScript -->
<script nonce="{{ csp_nonce() }}">
// Country dropdown functionality
function toggleCountryDropdown() {
    const dropdown = document.getElementById('country-dropdown');
    const arrow = document.getElementById('dropdown-arrow');
    
    if (dropdown.classList.contains('hidden')) {
        dropdown.classList.remove('hidden');
        arrow.style.transform = 'rotate(180deg)';
        document.getElementById('country-search').focus();
    } else {
        dropdown.classList.add('hidden');
        arrow.style.transform = 'rotate(0deg)';
    }
}

function selectCountry(code, flag, countryName) {
    document.getElementById('country_code').value = code;
    // Show flag and country code externally
    document.getElementById('selected-flag').textContent = flag;
    document.getElementById('selected-country').textContent = code;
    document.getElementById('country-dropdown').classList.add('hidden');
    document.getElementById('dropdown-arrow').style.transform = 'rotate(0deg)';
    document.getElementById('country-search').value = '';
    filterCountries(); // Reset filter
}

function filterCountries() {
    const searchTerm = document.getElementById('country-search').value.toLowerCase();
    const countries = document.querySelectorAll('.country-option');
    
    countries.forEach(country => {
        const text = country.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            country.style.display = 'flex';
        } else {
            country.style.display = 'none';
        }
    });
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const container = document.getElementById('country-dropdown-container');
    if (!container.contains(event.target)) {
        document.getElementById('country-dropdown').classList.add('hidden');
        document.getElementById('dropdown-arrow').style.transform = 'rotate(0deg)';
    }
});

// Combine phone with country code on submit
document.querySelector('form').addEventListener('submit', function(e) {
    const phoneNumber = document.getElementById('phone_number').value.trim();
    const countryCode = document.getElementById('country_code').value;
    const hiddenPhone = document.getElementById('phone_hidden');
    
    if (phoneNumber) {
        // Combine country code and phone number
        hiddenPhone.value = countryCode + phoneNumber.replace(/[^0-9]/g, '');
    } else {
        hiddenPhone.value = '';
    }
});
</script>

<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

@keyframes fade-in {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-fade-in {
    animation: fade-in 0.8s ease-out forwards;
}

.animation-delay-200 {
    animation-delay: 0.2s;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}
</style>
@endpush

</section>

</x-layouts.app>
