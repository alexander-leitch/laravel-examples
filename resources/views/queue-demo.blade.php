<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Queue Demo - Laravel Queue System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 min-h-screen text-gray-100">
    <div class="container mx-auto px-4 py-12">
        <!-- Header -->
        <div class="mb-12 text-center">
            <h1
                class="text-5xl font-bold mb-4 bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">
                Queue System Demo
            </h1>
            <p class="text-gray-400 text-lg">Dispatch jobs to the queue and monitor their execution</p>
            <div class="mt-6 flex gap-4 justify-center">
                <a href="/" class="px-6 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg transition">Home</a>
                <a href="/cache-demo" class="px-6 py-2 bg-purple-600 hover:bg-purple-500 rounded-lg transition">Cache
                    Demo →</a>
            </div>
        </div>

        <!-- Queue Dispatch Form -->
        <div class="max-w-2xl mx-auto mb-8">
            <div class="bg-gray-800 rounded-2xl shadow-2xl p-8 border border-gray-700">
                <h2 class="text-2xl font-semibold mb-6 text-blue-400">Dispatch New Job</h2>

                <form id="queueForm" class="space-y-6">
                    <div>
                        <label for="taskName" class="block text-sm font-medium text-gray-300 mb-2">Task Name</label>
                        <input type="text" id="taskName" name="task_name"
                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-white"
                            placeholder="Enter task name..." value="Demo Task">
                    </div>

                    <div>
                        <label for="duration" class="block text-sm font-medium text-gray-300 mb-2">
                            Duration (seconds): <span id="durationValue" class="text-blue-400">10</span>
                        </label>
                        <input type="range" id="duration" name="duration" min="5" max="30" value="10"
                            class="w-full h-2 bg-gray-700 rounded-lg appearance-none cursor-pointer">
                    </div>

                    <button type="submit"
                        class="w-full py-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 rounded-lg font-semibold text-lg transition-all transform hover:scale-[1.02] shadow-lg">
                        Dispatch Job to Queue
                    </button>
                </form>

                <div id="responseMessage" class="mt-6 hidden"></div>
            </div>
        </div>

        <!-- Livewire Component -->
        @livewire('queue-status')

        <!-- Info Section -->
        <div class="max-w-4xl mx-auto mt-12">
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl p-8 border border-gray-700">
                <h3 class="text-xl font-semibold mb-4 text-purple-400">📋 How to Process Queue Jobs</h3>
                <p class="text-gray-300 mb-4">To process jobs in the queue, run the following command in your terminal:
                </p>
                <pre
                    class="bg-gray-900 p-4 rounded-lg overflow-x-auto border border-gray-700"><code class="text-green-400">php artisan queue:work</code></pre>
                <p class="text-gray-400 text-sm mt-4">Jobs will remain in the "pending" state until the queue worker
                    processes them.</p>
            </div>
        </div>
    </div>

    <script>
        // Update duration value display
        document.getElementById('duration').addEventListener('input', (e) => {
            document.getElementById('durationValue').textContent = e.target.value;
        });

        // Handle form submission
        document.getElementById('queueForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData);

            const button = e.target.querySelector('button[type="submit"]');
            button.disabled = true;
            button.textContent = 'Dispatching...';

            try {
                const response = await fetch('/queue-demo/dispatch', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                const messageDiv = document.getElementById('responseMessage');
                messageDiv.className = 'mt-6 p-4 rounded-lg bg-green-900 border border-green-700';
                messageDiv.innerHTML = `
                    <p class="font-semibold text-green-400">✓ ${result.message}</p>
                    <p class="text-sm text-gray-300 mt-2">${result.info}</p>
                `;
                messageDiv.classList.remove('hidden');

                // Trigger Livewire refresh
                setTimeout(() => {
                    window.Livewire.dispatch('refreshJobs');
                }, 500);

            } catch (error) {
                console.error('Error:', error);
                const messageDiv = document.getElementById('responseMessage');
                messageDiv.className = 'mt-6 p-4 rounded-lg bg-red-900 border border-red-700';
                messageDiv.innerHTML = '<p class="text-red-400">Error dispatching job. Please try again.</p>';
                messageDiv.classList.remove('hidden');
            } finally {
                button.disabled = false;
                button.textContent = 'Dispatch Job to Queue';
            }
        });
    </script>
    @livewireScripts
</body>

</html>