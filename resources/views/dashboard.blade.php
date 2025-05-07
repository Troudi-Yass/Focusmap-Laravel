@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cosmic.css') }}">
@endpush

<!-- Cosmic Dashboard Layout -->
<x-app-layout>
    <!-- Stars background -->
    <div class="stars">
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
    </div>
    <div class="cosmic-bg">
        <!-- Welcome Message -->
        <div class="cosmic-card mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-cosmic">Welcome back, {{ Auth::user()->name }}! 👋</h1>
                    <p class="text-cyan-300 mt-1">One star at a time ⭐</p>
                </div>
                <div class="text-gray-400 italic">{{ now()->format('F j, Y') }}</div>
            </div>
        </div>
        
        <!-- Goal Summary -->
        <div class="cosmic-card mb-6">
            <h2 class="text-xl font-bold text-cosmic mb-4">Your Goals</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="cosmic-card bg-opacity-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-400">In Progress</p>
                            <h4 class="text-2xl font-bold text-white">{{ $goals->where('status', '!=', 'completed')->count() }}</h4>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-blue-500 bg-opacity-20 flex items-center justify-center">
                            <i class="ri-time-line text-blue-400"></i>
                        </div>
                    </div>
                </div>
                
                <div class="cosmic-card bg-opacity-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-400">Completed</p>
                            <h4 class="text-2xl font-bold text-white">{{ $goals->where('status', 'completed')->count() }}</h4>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-green-500 bg-opacity-20 flex items-center justify-center">
                            <i class="ri-check-double-line text-green-400"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Goals List -->
        <div class="cosmic-card">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-cosmic">Recent Goals</h2>
                <a href="{{ route('goals.create') }}" class="btn btn-primary">
                    <i class="ri-add-line mr-2"></i>
                    Add New Goal
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($goals->take(6) as $goal)
                    <x-goal-card :goal="$goal" />
                @empty
                    <div class="col-span-full">
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
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>