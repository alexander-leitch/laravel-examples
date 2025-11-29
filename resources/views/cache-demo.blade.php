<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cache Demo - Laravel Caching System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-gray-900 via-purple-900 to-gray-900 min-h-screen text-gray-100">
    <div class="container mx-auto px-4 py-12">
        <!-- Header -->
        <div class="mb-12 text-center">
            <h1
                class="text-5xl font-bold mb-4 bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">
                Cache System Demo
            </h1>
            <p class="text-gray-400 text-lg">Experience the performance boost of Laravel caching</p>
            <div class="mt-6 flex gap-4 justify-center">
                <a href="/" class="px-6 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg transition">Home</a>
                <a href="/queue-demo" class="px-6 py-2 bg-blue-600 hover:bg-blue-500 rounded-lg transition">← Queue
                    Demo</a>
            </div>
        </div>

        <!-- Cache Demo Section -->
        <div class="max-w-4xl mx-auto">
            <div class="bg-gray-800 rounded-2xl shadow-2xl p-8 border border-gray-700">
                <h2 class="text-2xl font-semibold mb-6 text-purple-400">Fetch Data</h2>

                <div class="space-y-6">
                    <div class="flex gap-4">
                        <button id="fetchWithCache"
                            class="flex-1 py-4 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-500 hover:to-pink-500 rounded-lg font-semibold text-lg transition-all transform hover:scale-[1.02] shadow-lg">
                            Fetch With Cache
                        </button>
                        <button id="fetchWithoutCache"
                            class="flex-1 py-4 bg-gray-700 hover:bg-gray-600 rounded-lg font-semibold text-lg transition-all">
                            Fetch Without Cache
                        </button>
                    </div>

                    <button id="clearCache"
                        class="w-full py-3 bg-red-600 hover:bg-red-500 rounded-lg font-semibold transition">
                        Clear Cache
                    </button>
                </div>

                <!-- Loading Indicator -->
                <div id="loading" class="hidden mt-8 text-center">
                    <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-purple-400"></div>
                    <p class="mt-4 text-gray-400">Loading data...</p>
                </div>

                <!-- Results Display -->
                <div id="results" class="mt-8 hidden">
                    <div class="bg-gray-900 rounded-xl p-6 border border-gray-700">
                        <!-- Performance Metrics -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div class="bg-gray-800 p-4 rounded-lg">
                                <p class="text-sm text-gray-400 mb-1">Execution Time</p>
                                <p id="executionTime" class="text-2xl font-bold text-purple-400">-</p>
                            </div>
                            <div class="bg-gray-800 p-4 rounded-lg">
                                <p class="text-sm text-gray-400 mb-1">Cache Status</p>
                                <p id="cacheStatus" class="text-2xl font-bold">-</p>
                            </div>
                            <div class="bg-gray-800 p-4 rounded-lg">
                                <p class="text-sm text-gray-400 mb-1">Performance</p>
                                <p id="performanceGain" class="text-2xl font-bold text-green-400">-</p>
                            </div>
                        </div>

                        <!-- Data Display -->
                        <div>
                            <h3 class="text-lg font-semibold mb-3 text-purple-300">Retrieved Data</h3>
                            <pre id="dataDisplay"
                                class="bg-gray-950 p-4 rounded-lg overflow-x-auto text-sm text-gray-300"></pre>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Section -->
            <div class="mt-12 bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl p-8 border border-gray-700">
                <h3 class="text-xl font-semibold mb-4 text-pink-400">💡 About This Demo</h3>
                <div class="space-y-3 text-gray-300">
                    <p><strong class="text-purple-400">With Cache:</strong> Data is stored in cache for 1 hour. First
                        request takes ~3 seconds, subsequent requests are instant.</p>
                    <p><strong class="text-purple-400">Without Cache:</strong> Every request executes the expensive
                        operation, taking ~3 seconds each time.</p>
                    <p><strong class="text-purple-400">Clear Cache:</strong> Removes all cached data. The next "with
                        cache" request will be slow again.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        const buttons = {
            withCache: document.getElementById('fetchWithCache'),
            withoutCache: document.getElementById('fetchWithoutCache'),
            clearCache: document.getElementById('clearCache')
        };

        const elements = {
            loading: document.getElementById('loading'),
            results: document.getElementById('results'),
            executionTime: document.getElementById('executionTime'),
            cacheStatus: document.getElementById('cacheStatus'),
            performanceGain: document.getElementById('performanceGain'),
            dataDisplay: document.getElementById('dataDisplay')
        };

        let lastSlowRequest = 3000; // Default baseline

        async function fetchData(useCache) {
            // Disable all buttons
            Object.values(buttons).forEach(btn => btn.disabled = true);

            // Show loading
            elements.loading.classList.remove('hidden');
            elements.results.classList.add('hidden');

            try {
                const response = await fetch(`/cache-demo/data?use_cache=${useCache ? 1 : 0}`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const result = await response.json();

                // Update metrics
                elements.executionTime.textContent = `${result.execution_time_ms} ms`;
                elements.cacheStatus.textContent = result.was_cached ? '✓ Cached' : '✗ Not Cached';
                elements.cacheStatus.className = result.was_cached
                    ? 'text-2xl font-bold text-green-400'
                    : 'text-2xl font-bold text-orange-400';

                // Calculate performance gain
                if (!result.was_cached) {
                    lastSlowRequest = result.execution_time_ms;
                    elements.performanceGain.textContent = 'Baseline';
                } else {
                    const gain = Math.round((1 - result.execution_time_ms / lastSlowRequest) * 100);
                    elements.performanceGain.textContent = `${gain}% Faster`;
                }

                // Display data
                elements.dataDisplay.textContent = JSON.stringify(result.data, null, 2);

                // Show results
                elements.loading.classList.add('hidden');
                elements.results.classList.remove('hidden');

            } catch (error) {
                console.error('Error:', error);
                alert('Error fetching data. Please try again.');
            } finally {
                // Re-enable buttons
                Object.values(buttons).forEach(btn => btn.disabled = false);
            }
        }

        async function clearCache() {
            buttons.clearCache.disabled = true;
            buttons.clearCache.textContent = 'Clearing...';

            try {
                const response = await fetch('/cache-demo/clear', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const result = await response.json();
                alert(result.message);

                // Reset results display
                elements.results.classList.add('hidden');

            } catch (error) {
                console.error('Error:', error);
                alert('Error clearing cache. Please try again.');
            } finally {
                buttons.clearCache.disabled = false;
                buttons.clearCache.textContent = 'Clear Cache';
            }
        }

        // Event listeners
        buttons.withCache.addEventListener('click', () => fetchData(true));
        buttons.withoutCache.addEventListener('click', () => fetchData(false));
        buttons.clearCache.addEventListener('click', clearCache);
    </script>
</body>

</html>