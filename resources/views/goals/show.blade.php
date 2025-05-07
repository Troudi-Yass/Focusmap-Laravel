<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <a href="{{ route('goals.index') }}" class="text-cyan-400 hover:text-cyan-300">
                <i class="ri-arrow-left-line mr-2"></i>Back to Goals
            </a>
        </div>

        <div class="cosmic-card">
            <!-- Goal Header -->
            <div class="flex justify-between items-start mb-6">
                <div>
                    <div class="flex items-center gap-3">
                        <i class="{{ $goal->icon }} text-3xl text-cyan-400"></i>
                        <h1 class="text-3xl font-bold text-cosmic">{{ $goal->title }}</h1>
                    </div>
                    <p class="text-gray-400 mt-2">{{ $goal->description }}</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('goals.edit', $goal) }}" class="btn btn-secondary">
                        <i class="ri-edit-line mr-2"></i>Edit
                    </a>
                    <form action="{{ route('goals.destroy', $goal) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-secondary bg-red-900/20 border-red-400 text-red-400 hover:bg-red-900/30" 
                                onclick="return confirm('Are you sure?')">
                            <i class="ri-delete-bin-line mr-2"></i>Delete
                        </button>
                    </form>
                </div>
            </div>

            <!-- Goal Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="cosmic-card bg-opacity-50">
                    <h3 class="text-lg font-semibold text-cosmic mb-2">Details</h3>
                    <div class="space-y-4">
                        <div>
                            <span class="text-gray-400">Category:</span>
                            <span class="text-white ml-2">{{ $goal->category }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400">Status:</span>
                            <span class="status-badge status-{{ $goal->status }} ml-2">
                                {{ ucfirst(str_replace('_', ' ', $goal->status)) }}
                            </span>
                        </div>
                        <div>
                            <span class="text-gray-400">Priority:</span>
                            <span class="text-white ml-2">{{ ucfirst($goal->priority) }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400">Deadline:</span>
                            <span class="text-white ml-2">
                                {{ $goal->deadline ? $goal->deadline->format('F j, Y') : 'No deadline' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="cosmic-card bg-opacity-50">
                    <h3 class="text-lg font-semibold text-cosmic mb-2">Progress</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-400">Overall Progress:</span>
                            <span class="text-white">{{ $goal->progress }}%</span>
                        </div>
                        <div class="progress-container">
                            <div class="progress-bar" style="width: {{ $goal->progress }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tasks Section -->
            <div class="mt-8">
                <h2 class="text-xl font-bold text-cosmic mb-4">Tasks</h2>
                <div class="space-y-4">
                    @forelse($goal->tasks as $task)
                        <div class="cosmic-card bg-opacity-50">
                            <div class="flex items-center justify-between p-4">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" class="custom-checkbox" 
                                           {{ $task->completed ? 'checked' : '' }}
                                           onchange="toggleTask({{ $task->id }})">
                                    <span class="{{ $task->completed ? 'line-through text-gray-400' : 'text-white' }}">
                                        {{ $task->title }}
                                    </span>
                                </div>
                                <span class="text-gray-400 text-sm">
                                    {{ $task->due_date ? $task->due_date->format('M j') : '' }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-gray-400">No tasks added yet</p>
                            <button class="btn btn-secondary mt-4" onclick="showAddTaskModal()">
                                <i class="ri-add-line mr-2"></i>Add Task
                            </button>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function toggleTask(taskId) {
            fetch(`/tasks/${taskId}/toggle`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            }).then(() => window.location.reload());
        }
    </script>
    @endpush
</x-app-layout>