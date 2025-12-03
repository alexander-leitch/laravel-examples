<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Queue & Cache Demo</title>
    
    <!-- Theme Switcher - Inline to prevent flash -->
    <script>
        const THEME_COOKIE = 'theme_preference';
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
            return null;
        }
        function systemPrefersDark() {
            return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        }
        function applyTheme(theme) {
            const isDark = theme === 'dark' || (theme === 'auto' && systemPrefersDark());
            if (isDark) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
        const theme = getCookie(THEME_COOKIE) || 'auto';
        applyTheme(theme);
    </script>
    
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
</head>

<body class="bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50 dark:from-gray-900 dark:via-blue-900 dark:to-purple-900 min-h-screen text-gray-900 dark:text-gray-100 transition-colors duration-300">
    <!-- Theme Switcher Button -->
    <div class="fixed top-6 right-6 z-50">
        <button
            onclick="cycleTheme()"
            id="theme-switcher-btn"
            class="flex items-center gap-2 px-4 py-2 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-2 border-gray-300 dark:border-gray-600 hover:border-blue-500 dark:hover:border-blue-400 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 font-medium"
            title="Click to cycle: Auto → Light → Dark"
        >
            🔄 <span class="ml-1">Auto</span>
        </button>
    </div>
    
    <div class="container mx-auto px-4 py-16">
        <!-- Header -->
        <div class="text-center mb-16">
            <h1
                class="text-6xl font-bold mb-6 bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">
                Laravel Demo App
            </h1>
            <p class="text-2xl text-gray-600 dark:text-gray-300 mb-4">Queue System & Caching Examples</p>
            <p class="text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                Explore Laravel's powerful queue and caching systems through interactive demonstrations.
                This app showcases best practices with a modern tech stack including React, Tailwind CSS, Livewire, and
                MySQL.
            </p>
        </div>

        <!-- Demo Cards -->
        <div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto mb-16">
            <!-- Queue Demo Card -->
            <a href="/queue-demo" class="group">
                <div
                    class="bg-gray-800 rounded-2xl p-8 border-2 border-gray-700 hover:border-blue-500 transition-all duration-300 transform hover:scale-105 shadow-2xl">
                    <div class="text-6xl mb-6 group-hover:scale-110 transition-transform">⚡</div>
                    <h2 class="text-3xl font-bold mb-4 text-blue-400">Queue System</h2>
                    <p class="text-gray-300 mb-6">
                        Dispatch background jobs to Laravel's queue system. Monitor job status in real-time with
                        Livewire components.
                    </p>
                    <div class="space-y-2 text-sm text-gray-400">
                        <p>✓ Background job processing</p>
                        <p>✓ Real-time status updates</p>
                        <p>✓ Livewire integration</p>
                    </div>
                    <div
                        class="mt-6 text-blue-400 font-semibold group-hover:translate-x-2 transition-transform inline-block">
                        Explore Queue Demo →
                    </div>
                </div>
            </a>

            <!-- Cache Demo Card -->
            <a href="/cache-demo" class="group">
                <div
                    class="bg-gray-800 rounded-2xl p-8 border-2 border-gray-700 hover:border-purple-500 transition-all duration-300 transform hover:scale-105 shadow-2xl">
                    <div class="text-6xl mb-6 group-hover:scale-110 transition-transform">🚀</div>
                    <h2 class="text-3xl font-bold mb-4 text-purple-400">Cache System</h2>
                    <p class="text-gray-300 mb-6">
                        Experience dramatic performance improvements with Laravel's caching. Compare cached vs
                        non-cached requests.
                    </p>
                    <div class="space-y-2 text-sm text-gray-400">
                        <p>✓ Performance benchmarking</p>
                        <p>✓ Cache management</p>
                        <p>✓ Real-time metrics</p>
                    </div>
                    <div
                        class="mt-6 text-purple-400 font-semibold group-hover:translate-x-2 transition-transform inline-block">
                        Explore Cache Demo →
                    </div>
                </div>
            </a>
        </div>

        <!-- Tech Stack -->
        <div class="max-w-4xl mx-auto">
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl p-8 border border-gray-700">
                <h3 class="text-2xl font-semibold mb-6 text-center text-pink-400">🛠️ Tech Stack</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                    <div class="bg-gray-900 p-4 rounded-lg">
                        <p class="font-semibold text-blue-400">Laravel</p>
                        <p class="text-sm text-gray-400">Framework</p>
                    </div>
                    <div class="bg-gray-900 p-4 rounded-lg">
                        <p class="font-semibold text-blue-400">React</p>
                        <p class="text-sm text-gray-400">UI Library</p>
                    </div>
                    <div class="bg-gray-900 p-4 rounded-lg">
                        <p class="font-semibold text-cyan-400">Tailwind CSS</p>
                        <p class="text-sm text-gray-400">Styling</p>
                    </div>
                    <div class="bg-gray-900 p-4 rounded-lg">
                        <p class="font-semibold text-pink-400">Livewire</p>
                        <p class="text-sm text-gray-400">Components</p>
                    </div>
                    <div class="bg-gray-900 p-4 rounded-lg">
                        <p class="font-semibold text-yellow-400">PHP 8+</p>
                        <p class="text-sm text-gray-400">Backend</p>
                    </div>
                    <div class="bg-gray-900 p-4 rounded-lg">
                        <p class="font-semibold text-blue-300">MySQL</p>
                        <p class="text-sm text-gray-400">Database</p>
                    </div>
                    <div class="bg-gray-900 p-4 rounded-lg">
                        <p class="font-semibold text-purple-400">Docker</p>
                        <p class="text-sm text-gray-400">Containers</p>
                    </div>
                    <div class="bg-gray-900 p-4 rounded-lg">
                        <p class="font-semibold text-orange-400">Vite</p>
                        <p class="text-sm text-gray-400">Build Tool</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-16 text-gray-500 dark:text-gray-500">
            <p>Built with ❤️ using Laravel {{ Illuminate\Foundation\Application::VERSION }}</p>
        </div>
    </div>
    
    <!-- Theme Switcher Functions -->
    <script>
        function setCookie(name, value) {
            const expires = new Date();
            expires.setFullYear(expires.getFullYear() + 1);
            document.cookie = `${name}=${value};expires=${expires.toUTCString()};path=/;SameSite=Lax`;
        }
        
        function updateThemeButton(theme) {
            const button = document.getElementById('theme-switcher-btn');
            if (!button) return;
            
            const icons = { 'light': '☀️', 'dark': '🌙', 'auto': '🔄' };
            const labels = { 'light': 'Light', 'dark': 'Dark', 'auto': 'Auto' };
            
            button.innerHTML = `${icons[theme]} <span class="ml-1">${labels[theme]}</span>`;
        }
        
        function cycleTheme() {
            const current = getCookie(THEME_COOKIE) || 'auto';
            let next;
            
            if (current === 'auto') {
                next = 'light';
            } else if (current === 'light') {
                next = 'dark';
            } else {
                next = 'auto';
            }
            
            setCookie(THEME_COOKIE, next);
            applyTheme(next);
            updateThemeButton(next);
        }
        
        // Initialize button on load
        document.addEventListener('DOMContentLoaded', function() {
            const theme = getCookie(THEME_COOKIE) || 'auto';
            updateThemeButton(theme);
            
            // Listen for system theme changes when in auto mode
            if (window.matchMedia) {
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                    if ((getCookie(THEME_COOKIE) || 'auto') === 'auto') {
                        applyTheme('auto');
                    }
                });
            }
        });
    </script>
</body>

</html>