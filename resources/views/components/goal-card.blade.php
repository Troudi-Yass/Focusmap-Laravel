@props(['goal'])

<div class="cosmic-card group relative hover:shadow-lg transition-shadow duration-200">
    <div class="flex justify-between items-start gap-4">
        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-3 mb-2">
                <div class="flex-shrink-0 bg-gray-700 p-2 rounded-full">
                    <i class="{{ $goal->icon }} text-xl text-cyan-400"></i>
                </div>
                <h3 class="text-lg font-semibold truncate text-white">
                    {{ $goal->title }}
                </h3>
            </div>
            
            @if($goal->description)
                <p class="text-gray-400 line-clamp-2 mb-3">
                    {{ $goal->description }}
                </p>
            @endif
            
            <div class="flex items-center justify-between flex-wrap gap-2">
                <span class="status-badge status-{{ $goal->status }}">
                    {{ ucfirst(str_replace('_', ' ', $goal->status)) }}
                </span>
                
                <span class="text-sm text-gray-400">
                    @if($goal->deadline)
                        Due {{ $goal->deadline->diffForHumans() }}
                    @else
                        No deadline
                    @endif
                </span>
            </div>
        </div>
    </div>
    
    <div class="mt-4">
        <div class="flex items-center justify-between mb-1">
            <span class="text-sm text-gray-400">Progress</span>
            <span class="text-sm font-medium text-white">{{ $goal->progress }}%</span>
        </div>
        <div class="progress-container">
            <div class="progress-bar" style="width: {{ $goal->progress }}%"></div>
        </div>
    </div>
    
    <a href="{{ route('goals.show', $goal) }}" class="absolute inset-0" aria-label="View goal"></a>
</div>