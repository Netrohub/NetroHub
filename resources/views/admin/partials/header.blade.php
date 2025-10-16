<header class="sticky top-0 before:absolute before:inset-0 before:backdrop-blur-md max-lg:before:bg-white/90 dark:max-lg:before:bg-gray-800/90 before:-z-10 z-30 border-b border-gray-200 dark:border-gray-700/60">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 -mb-px">
            
            <!-- Header: Left side -->
            <div class="flex">
                <!-- Hamburger button -->
                <button
                    class="text-gray-500 hover:text-gray-600 lg:hidden"
                    @click.stop="sidebarOpen = !sidebarOpen"
                    aria-controls="sidebar"
                    :aria-expanded="sidebarOpen"
                >
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <rect x="4" y="5" width="16" height="2" />
                        <rect x="4" y="11" width="16" height="2" />
                        <rect x="4" y="17" width="16" height="2" />
                    </svg>
                </button>
            </div>
            
            <!-- Header: Right side -->
            <div class="flex items-center space-x-3">
                
                <!-- Search -->
                <div class="relative hidden md:block">
                    <form action="{{ route('admin.dashboard') }}" method="GET">
                        <label for="search" class="sr-only">Search</label>
                        <input
                            id="search"
                            class="form-input w-full pl-9 py-2 text-sm bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 focus:border-violet-500 rounded-lg"
                            type="search"
                            placeholder="Search…"
                            name="search"
                        />
                        <button class="absolute inset-0 right-auto group" type="submit" aria-label="Search">
                            <svg class="w-4 h-4 shrink-0 fill-current text-gray-400 dark:text-gray-500 group-hover:text-gray-500 dark:group-hover:text-gray-400 ml-3 mr-2" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                                <path d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                            </svg>
                        </button>
                    </form>
                </div>
                
                <!-- Dark mode toggle -->
                <button
                    class="w-8 h-8 flex items-center justify-center hover:bg-gray-100 dark:hover:bg-gray-700/50 rounded-full"
                    @click="dark = !dark"
                    x-data="{ dark: localStorage.getItem('dark-mode') === 'true' }"
                    x-init="$watch('dark', val => { localStorage.setItem('dark-mode', val); document.documentElement.classList.toggle('dark', val) })"
                >
                    <svg class="w-5 h-5 dark:hidden" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                        <path class="fill-gray-400" d="M7 0h2v2H7V0Zm5.88 1.637 1.414 1.415-1.415 1.413-1.414-1.414 1.415-1.414ZM14 7h2v2h-2V7Zm-1.05 7.433-1.415-1.414 1.414-1.414 1.415 1.413-1.414 1.415ZM7 14h2v2H7v-2Zm-4.02.363L1.566 12.95l1.415-1.414 1.414 1.415-1.415 1.413ZM0 7h2v2H0V7Zm3.05-5.293L4.465 3.12 3.05 4.535 1.636 3.121 3.05 1.707Z" />
                        <path class="fill-gray-600" d="M8 4C5.8 4 4 5.8 4 8s1.8 4 4 4 4-1.8 4-4-1.8-4-4-4Z" />
                    </svg>
                    <svg class="w-5 h-5 hidden dark:block" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                        <path class="fill-gray-400" d="M6.2 2C3.2 2.8 1 5.6 1 8.9 1 12.8 4.2 16 8.1 16c3.3 0 6-2.2 6.9-5.2C9.7 11.2 4.8 6.3 6.2 2Z" />
                        <path class="fill-gray-600" d="M12.5 6a.625.625 0 0 1-.625-.625 1.252 1.252 0 0 0-1.25-1.25.625.625 0 1 1 0-1.25 1.252 1.252 0 0 0 1.25-1.25.625.625 0 1 1 1.25 0c.001.69.56 1.249 1.25 1.25a.625.625 0 1 1 0 1.25c-.69.001-1.249.56-1.25 1.25A.625.625 0 0 1 12.5 6Z" />
                    </svg>
                </button>
                
                <!-- Divider -->
                <hr class="w-px h-6 bg-gray-200 dark:bg-gray-700/60 border-none" />
                
                <!-- User button -->
                <div class="relative inline-flex" x-data="{ open: false }">
                    <button
                        class="inline-flex justify-center items-center group"
                        aria-haspopup="true"
                        @click.prevent="open = !open"
                        :aria-expanded="open"
                    >
                        <div class="flex items-center truncate">
                            <span class="truncate ml-2 text-sm font-medium text-gray-600 dark:text-gray-100 group-hover:text-gray-800 dark:group-hover:text-white">{{ auth()->user()->name }}</span>
                            <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400" viewBox="0 0 12 12">
                                <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                            </svg>
                        </div>
                    </button>
                    <div
                        class="origin-top-right z-10 absolute top-full right-0 min-w-44 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 py-1.5 rounded-lg shadow-lg overflow-hidden mt-1"
                        @click.outside="open = false"
                        @keydown.escape.window="open = false"
                        x-show="open"
                        x-transition:enter="transition ease-out duration-200 transform"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-out duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        style="display: none;"
                    >
                        <div class="pt-0.5 pb-2 px-3 mb-1 border-b border-gray-200 dark:border-gray-700/60">
                            <div class="font-medium text-gray-800 dark:text-gray-100">{{ auth()->user()->name }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 italic">{{ auth()->user()->email }}</div>
                        </div>
                        <ul>
                            <li>
                                <a class="font-medium text-sm text-violet-500 hover:text-violet-600 dark:hover:text-violet-400 flex items-center py-1 px-3" href="{{ url('/') }}" @click="open = false">
                                    Public Site
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="font-medium text-sm text-violet-500 hover:text-violet-600 dark:hover:text-violet-400 flex items-center py-1 px-3 w-full text-left">
                                        Sign Out
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                
            </div>
            
        </div>
    </div>
</header>

