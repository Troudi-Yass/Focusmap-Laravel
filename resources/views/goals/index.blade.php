<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-cosmic">My Goals</h1>
            <a href="{{ route('goals.create') }}" class="btn btn-primary">
                <i class="ri-add-line mr-2"></i>
                Add New Goal
            </a>
        </div>

        <div class="space-y-4">
            @forelse($goals as $goal)
                <div class="cosmic-card">
                    <div class="flex justify-between items-center flex-wrap gap-2 mb-2">
                        <div>
                            <h3 class="text-xl font-semibold mb-1">{{ $goal->title }}</h3>
                            @if($goal->description)
                                <p class="text-gray-400 mb-2">{{ $goal->description }}</p>
                            @endif
                            <span class="status-badge status-{{ $goal->status }}">
                                {{ $goal->formatted_status ?? ucfirst(str_replace('_', ' ', $goal->status)) }}
                            </span>
                            <span class="ml-4 text-sm text-gray-400">
                                @if($goal->deadline)
                                    Due {{ $goal->deadline->diffForHumans() }}
                                @else
                                    No deadline
                                @endif
                            </span>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('goals.edit', $goal) }}" class="btn btn-secondary">Edit</a>
                            <form action="{{ route('goals.destroy', $goal) }}" method="POST" onsubmit="return confirm('Delete this goal?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-secondary text-red-400">Delete</button>
                            </form>
                        </div>
                    </div>
                    <div class="progress-container mt-2">
                        <div class="progress-bar" style="width: {{ $goal->progress }}%"></div>
                    </div>
                    <div class="text-sm text-gray-400 mt-2">Progress: {{ $goal->progress }}%</div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-20 cosmic-card">
                    <div class="w-20 h-20 mb-6 flex items-center justify-center bg-gray-700 rounded-full">
                        <i class="ri-flag-line text-4xl text-cyan-400"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-2">No Goals Yet</h3>
                    <p class="text-gray-400 mb-6">Start your journey by creating your first goal!</p>
                    <a href="{{ route('goals.create') }}" class="btn btn-primary">
                        <i class="ri-add-line mr-2"></i>
                        Create Your First Goal
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>