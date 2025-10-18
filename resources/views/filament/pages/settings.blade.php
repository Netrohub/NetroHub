<x-filament-panels::page>
    <div class="space-y-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                Admin Panel Theme Settings
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div>
                            <h3 class="font-medium text-gray-900 dark:text-gray-100">Light Mode</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Clean and bright interface</p>
                        </div>
                        <div class="w-16 h-10 bg-white border-2 border-gray-300 rounded-full p-1">
                            <div class="w-6 h-6 bg-gray-400 rounded-full"></div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-gray-900 dark:bg-gray-600 rounded-lg">
                        <div>
                            <h3 class="font-medium text-white">Dark Mode</h3>
                            <p class="text-sm text-gray-300">Easy on the eyes for low light</p>
                        </div>
                        <div class="w-16 h-10 bg-gray-800 border-2 border-gray-600 rounded-full p-1">
                            <div class="w-6 h-6 bg-white rounded-full ml-6"></div>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <h3 class="font-medium text-blue-900 dark:text-blue-100 mb-2">Theme Features</h3>
                        <ul class="text-sm text-blue-800 dark:text-blue-200 space-y-1">
                            <li>• Automatic system preference detection</li>
                            <li>• Manual theme switching</li>
                            <li>• Consistent color schemes</li>
                            <li>• High contrast text</li>
                            <li>• Accessible design</li>
                        </ul>
                    </div>
                    
                    <div class="p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                        <h3 class="font-medium text-green-900 dark:text-green-100 mb-2">Accessibility</h3>
                        <ul class="text-sm text-green-800 dark:text-green-200 space-y-1">
                            <li>• WCAG 2.1 AA compliant</li>
                            <li>• High contrast ratios</li>
                            <li>• Keyboard navigation</li>
                            <li>• Screen reader friendly</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                Color Scheme Preview
            </h2>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center">
                    <div class="w-full h-16 bg-primary-500 rounded-lg mb-2"></div>
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Primary</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400">#6366f1</p>
                </div>
                
                <div class="text-center">
                    <div class="w-full h-16 bg-green-500 rounded-lg mb-2"></div>
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Success</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400">#22c55e</p>
                </div>
                
                <div class="text-center">
                    <div class="w-full h-16 bg-yellow-500 rounded-lg mb-2"></div>
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Warning</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400">#eab308</p>
                </div>
                
                <div class="text-center">
                    <div class="w-full h-16 bg-red-500 rounded-lg mb-2"></div>
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Danger</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400">#ef4444</p>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
