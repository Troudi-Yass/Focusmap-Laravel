<div class="mb-4">
    <label for="title" class="block text-sm font-medium text-gray-300 mb-2">Goal Title</label>
    <input type="text" name="title" id="title" class="form-input" placeholder="What do you want to achieve?" 
        value="{{ old('title', $goal->title ?? '') }}" required>
    @error('title')
        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label for="description" class="block text-sm font-medium text-gray-300 mb-2">Description</label>
    <textarea name="description" id="description" rows="3" class="form-input" 
        placeholder="Describe your goal in detail">{{ old('description', $goal->description ?? '') }}</textarea>
    @error('description')
        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
    <div>
        <label for="category" class="block text-sm font-medium text-gray-300 mb-2">Category</label>
        <select name="category" id="category" class="form-input">
            @foreach(['Personal Growth', 'Career Development', 'Education', 'Health & Fitness', 'Financial', 'Relationships', 'Other'] as $category)
                <option value="{{ $category }}" 
                    {{ old('category', $goal->category ?? '') == $category ? 'selected' : '' }}>
                    {{ $category }}
                </option>
            @endforeach
        </select>
        @error('category')
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label for="deadline" class="block text-sm font-medium text-gray-300 mb-2">Deadline</label>
        <input type="date" name="deadline" id="deadline" class="form-input" 
            value="{{ old('deadline', isset($goal->deadline) ? $goal->deadline->format('Y-m-d') : '') }}">
        @error('deadline')
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mb-6">
    <label class="block text-sm font-medium text-gray-300 mb-2">Priority Level</label>
    <div class="flex space-x-4">
        @foreach(['low', 'medium', 'high'] as $priority)
            <label class="priority-option {{ old('priority', $goal->priority ?? 'medium') == $priority ? 'selected' : '' }}">
                <input type="radio" name="priority" value="{{ $priority }}" class="hidden" 
                    {{ old('priority', $goal->priority ?? 'medium') == $priority ? 'checked' : '' }}>
                <span class="w-4 h-4 border-2 border-gray-500 rounded-full mr-2 flex items-center justify-center radio-dot">
                    <span class="w-2 h-2 rounded-full {{ old('priority', $goal->priority ?? 'medium') == $priority ? '' : 'hidden' }}"></span>
                </span>
                <span class="text-gray-300">{{ ucfirst($priority) }}</span>
            </label>
        @endforeach
    </div>
    @error('priority')
        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>