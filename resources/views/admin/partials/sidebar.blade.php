<div class="min-w-fit" :class="sidebarExpanded ? 'sidebar-expanded' : ''">
    <!-- Sidebar backdrop (mobile only) -->
    <div
        class="fixed inset-0 bg-gray-900/30 z-40 lg:hidden transition-opacity duration-200"
        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'"
        aria-hidden="true"
        @click="sidebarOpen = false"
    ></div>
    
    <!-- Sidebar -->
    <div
        id="sidebar"
        class="flex flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 h-screen overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:!w-64 2xl:!w-64 shrink-0 bg-white dark:bg-gray-800 p-4 transition-all duration-200 ease-in-out rounded-r-2xl shadow-sm"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-64'"
        @click.outside="sidebarOpen = false"
        @keydown.escape.window="sidebarOpen = false"
    >
        
        <!-- Sidebar header -->
        <div class="flex justify-between mb-10 pr-3 sm:px-2">
            <!-- Close button -->
            <button
                class="lg:hidden text-gray-500 hover:text-gray-400"
                @click.stop="sidebarOpen = !sidebarOpen"
                aria-controls="sidebar"
                :aria-expanded="sidebarOpen"
            >
                <span class="sr-only">Close sidebar</span>
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                    <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />
                </svg>
            </button>
            <!-- Logo -->
            <a href="{{ route('admin.dashboard') }}" class="block">
                <div class="flex items-center">
                    <svg class="w-8 h-8 fill-current text-violet-500" viewBox="0 0 32 32">
                        <path d="M16 0C7.163 0 0 7.163 0 16s7.163 16 16 16 16-7.163 16-16S24.837 0 16 0zm6.5 25.5h-13v-19h13v19z"/>
                    </svg>
                    <span class="ml-4 text-lg font-bold text-gray-800 dark:text-white lg:sidebar-expanded:block 2xl:block hidden">NetroHub</span>
                </div>
            </a>
        </div>
        
        <!-- Links -->
        <div class="space-y-8">
            <!-- Pages group -->
            <div>
                <h3 class="text-xs uppercase text-gray-400 dark:text-gray-500 font-semibold pl-3">
                    <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6" aria-hidden="true">•••</span>
                    <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Dashboard</span>
                </h3>
                <ul class="mt-3">
                    <!-- Dashboard -->
                    <li class="px-3 py-2 rounded-lg mb-0.5 last:mb-0 @if(request()->routeIs('admin.dashboard')) bg-violet-50 dark:bg-gradient-to-r dark:from-violet-500/[0.12] dark:to-violet-500/[0.04] @endif">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition @if(!request()->routeIs('admin.dashboard')) hover:text-gray-900 dark:hover:text-white @endif" href="{{ route('admin.dashboard') }}">
                            <div class="flex items-center justify-between">
                                <div class="grow flex items-center">
                                    <svg class="shrink-0 fill-current @if(request()->routeIs('admin.dashboard')) text-violet-500 @else text-gray-400 dark:text-gray-500 @endif" width="16" height="16" viewBox="0 0 16 16">
                                        <path d="M5 4a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2H5Z" />
                                        <path d="M4 0a4 4 0 0 0-4 4v8a4 4 0 0 0 4 4h8a4 4 0 0 0 4-4V4a4 4 0 0 0-4-4H4ZM2 4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4Z" />
                                    </svg>
                                    <span class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Dashboard</span>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Management group -->
            <div>
                <h3 class="text-xs uppercase text-gray-400 dark:text-gray-500 font-semibold pl-3">
                    <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6" aria-hidden="true">•••</span>
                    <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Management</span>
                </h3>
                <ul class="mt-3">
                    <!-- Users -->
                    <li class="px-3 py-2 rounded-lg mb-0.5 last:mb-0 @if(request()->routeIs('admin.users.*')) bg-violet-50 dark:bg-gradient-to-r dark:from-violet-500/[0.12] dark:to-violet-500/[0.04] @endif">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition @if(!request()->routeIs('admin.users.*')) hover:text-gray-900 dark:hover:text-white @endif" href="{{ route('admin.users.index') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 fill-current @if(request()->routeIs('admin.users.*')) text-violet-500 @else text-gray-400 dark:text-gray-500 @endif" width="16" height="16" viewBox="0 0 16 16">
                                    <path d="M8 8a3 3 0 1 1 0-6 3 3 0 0 1 0 6Zm0-2a1 1 0 1 0 0-2 1 1 0 0 0 0 2ZM14 14v-1a3 3 0 0 0-3-3H5a3 3 0 0 0-3 3v1a1 1 0 1 0 2 0v-1a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v1a1 1 0 1 0 2 0Z" />
                                </svg>
                                <span class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Users</span>
                            </div>
                        </a>
                    </li>
                    
                    <!-- Products -->
                    <li class="px-3 py-2 rounded-lg mb-0.5 last:mb-0 @if(request()->routeIs('admin.products.*')) bg-violet-50 dark:bg-gradient-to-r dark:from-violet-500/[0.12] dark:to-violet-500/[0.04] @endif">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition @if(!request()->routeIs('admin.products.*')) hover:text-gray-900 dark:hover:text-white @endif" href="{{ route('admin.products.index') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 fill-current @if(request()->routeIs('admin.products.*')) text-violet-500 @else text-gray-400 dark:text-gray-500 @endif" width="16" height="16" viewBox="0 0 16 16">
                                    <path d="M14.29 2.614a1 1 0 0 0-.29-.614 1 1 0 0 0-.616-.293L.583 0 0 12.8l6.41 3.212A5.925 5.925 0 0 0 8 16c.996 0 1.995-.251 2.888-.733 2.762-1.489 3.87-4.896 2.48-7.668a5.93 5.93 0 0 0-1.064-1.419l1.986-3.566ZM10 13.968A3.999 3.999 0 1 1 14 10c0 1.487-.81 2.784-2 3.48V8a1 1 0 0 0-2 0v5.968Z" />
                                </svg>
                                <span class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Products</span>
                            </div>
                        </a>
                    </li>
                    
                    <!-- Orders -->
                    <li class="px-3 py-2 rounded-lg mb-0.5 last:mb-0 @if(request()->routeIs('admin.orders.*')) bg-violet-50 dark:bg-gradient-to-r dark:from-violet-500/[0.12] dark:to-violet-500/[0.04] @endif">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition @if(!request()->routeIs('admin.orders.*')) hover:text-gray-900 dark:hover:text-white @endif" href="{{ route('admin.orders.index') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 fill-current @if(request()->routeIs('admin.orders.*')) text-violet-500 @else text-gray-400 dark:text-gray-500 @endif" width="16" height="16" viewBox="0 0 16 16">
                                    <path d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7ZM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5Z" />
                                    <path d="M15.707 14.293 13.314 11.9a8.019 8.019 0 0 1-1.414 1.414l2.393 2.393a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414Z" />
                                </svg>
                                <span class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Orders</span>
                            </div>
                        </a>
                    </li>

                    <!-- Disputes -->
                    <li class="px-3 py-2 rounded-lg mb-0.5 last:mb-0 @if(request()->routeIs('admin.disputes.*')) bg-violet-50 dark:bg-gradient-to-r dark:from-violet-500/[0.12] dark:to-violet-500/[0.04] @endif">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition @if(!request()->routeIs('admin.disputes.*')) hover:text-gray-900 dark:hover:text-white @endif" href="{{ route('admin.disputes.index') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 fill-current @if(request()->routeIs('admin.disputes.*')) text-violet-500 @else text-gray-400 dark:text-gray-500 @endif" width="16" height="16" viewBox="0 0 16 16">
                                    <path d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8Zm1 12H7V7h2v5Zm0-6H7V4h2v2Z" />
                                </svg>
                                <span class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Disputes</span>
                            </div>
                        </a>
                    </li>

                    <!-- Settings -->
                    <li class="px-3 py-2 rounded-lg mb-0.5 last:mb-0 @if(request()->routeIs('admin.settings.*')) bg-violet-50 dark:bg-gradient-to-r dark:from-violet-500/[0.12] dark:to-violet-500/[0.04] @endif">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition @if(!request()->routeIs('admin.settings.*')) hover:text-gray-900 dark:hover:text-white @endif" href="{{ route('admin.settings.index') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 fill-current @if(request()->routeIs('admin.settings.*')) text-violet-500 @else text-gray-400 dark:text-gray-500 @endif" width="16" height="16" viewBox="0 0 16 16">
                                    <path d="M14.59 8.91a5.49 5.49 0 0 0 .05-.91 5.49 5.49 0 0 0-.05-.91l1.72-1.34a.5.5 0 0 0 .12-.64l-1.63-2.83a.5.5 0 0 0-.6-.22l-2.03.82a5.74 5.74 0 0 0-1.58-.91l-.31-2.15A.5.5 0 0 0 9.04 0H6.96a.5.5 0 0 0-.49.41l-.31 2.15c-.56.2-1.09.49-1.58.91l-2.03-.82a.5.5 0 0 0-.6.22L.32 5.7a.5.5 0 0 0 .12.64l1.72 1.34c-.03.3-.05.61-.05.91 0 .31.02.61.05.91L.44 10.84a.5.5 0 0 0-.12.64l1.63 2.83a.5.5 0 0 0 .6.22l2.03-.82c.49.42 1.02.71 1.58.91l.31 2.15c.04.24.25.41.49.41h2.08c.24 0 .45-.17.49-.41l.31-2.15c.56-.2 1.09-.49 1.58-.91l2.03.82a.5.5 0 0 0 .6-.22l1.63-2.83a.5.5 0 0 0-.12-.64L14.59 8.91ZM8 11a3 3 0 1 1 .001-6.001A3 3 0 0 1 8 11Z"/>
                                </svg>
                                <span class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Settings</span>
                            </div>
                        </a>
                    </li>

                    <!-- CMS -->
                    <li class="px-3 py-2 rounded-lg mb-0.5 last:mb-0 @if(request()->routeIs('admin.cms.*')) bg-violet-50 dark:bg-gradient-to-r dark:from-violet-500/[0.12] dark:to-violet-500/[0.04] @endif">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition @if(!request()->routeIs('admin.cms.*')) hover:text-gray-900 dark:hover:text-white @endif" href="{{ route('admin.cms.index') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 fill-current @if(request()->routeIs('admin.cms.*')) text-violet-500 @else text-gray-400 dark:text-gray-500 @endif" width="16" height="16" viewBox="0 0 16 16">
                                    <path d="M2 2h12v2H2zM2 6h12v2H2zM2 10h12v2H2z"/>
                                </svg>
                                <span class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">CMS</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Expand / collapse button -->
        <div class="pt-3 hidden lg:inline-flex 2xl:hidden justify-end mt-auto">
            <div class="w-12 pl-4 pr-3 py-2">
                <button class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400" @click="sidebarExpanded = !sidebarExpanded">
                    <span class="sr-only">Expand / collapse sidebar</span>
                    <svg class="shrink-0 fill-current text-gray-400 dark:text-gray-500 sidebar-expanded:rotate-180" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M15 16a1 1 0 0 1-1-1V1a1 1 0 1 1 2 0v14a1 1 0 0 1-1 1ZM8.586 9H1a1 1 0 1 1 0-2h7.586l-2.793-2.793a1 1 0 1 1 1.414-1.414l4.5 4.5A.997.997 0 0 1 12 8a.999.999 0 0 1-.293.707l-4.5 4.5a1 1 0 1 1-1.414-1.414L8.586 9Z" />
                    </svg>
                </button>
            </div>
        </div>
        
    </div>
</div>

