<div class="max-w-4xl mx-auto mt-8" wire:poll.5s="refreshJobs">
    <div class="bg-gray-800 rounded-2xl shadow-2xl p-8 border border-gray-700">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-blue-400">Queue Status</h2>
            <div class="flex items-center gap-3">
                <span class="px-4 py-2 bg-blue-900 text-blue-300 rounded-lg font-semibold">
                    {{ $pendingCount }} Pending Jobs
                </span>
                <button wire:click="refreshJobs" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg transition">
                    🔄 Refresh
                </button>
            </div>
        </div>

        @if(count($jobs) > 0)
            <div class="space-y-3">
                @foreach($jobs as $job)
                    <div class="bg-gray-900 p-4 rounded-lg border border-gray-700 hover:border-gray-600 transition">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></span>
                                    <span class="text-sm font-mono text-gray-400">Job #{{ $job->id }}</span>
                                </div>
                                <p class="text-sm text-gray-500">Queue: {{ $job->queue }}</p>
                                <p class="text-xs text-gray-600 mt-1">Attempts: {{ $job->attempts }}</p>
                            </div>
                            <div class="text-right">
                                <span class="px-3 py-1 bg-yellow-900 text-yellow-300 rounded-lg text-xs font-semibold">
                                    Pending
                                </span>
                                <p class="text-xs text-gray-500 mt-2">
                                    Created {{ \Carbon\Carbon::createFromTimestamp($job->created_at)->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-6xl mb-4">✓</div>
                <p class="text-gray-400 text-lg">No pending jobs in the queue</p>
                <p class="text-gray-500 text-sm mt-2">Dispatch a new job to see it appear here</p>
            </div>
        @endif
    </div>
</div>