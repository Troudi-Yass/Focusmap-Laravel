<x-app-layout>
    <x-modal title="Create New Goal" subtitle="Define your new objective">
        <form action="{{ route('goals.store') }}" method="POST">
            @csrf
            
            <!-- Icon Selection -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-300 mb-3">Icon</label>
                <div class="grid grid-cols-6 gap-3">
                    @foreach(['ri-flag-line', 'ri-star-line', 'ri-trophy-line', 'ri-book-line', 'ri-code-line', 'ri-run-line'] as $icon)
                        <label class="goal-icon-option">
                            <input type="radio" name="icon" value="{{ $icon }}" 
                                   class="hidden" {{ $loop->first ? 'checked' : '' }}>
                            <div class="w-full h-full flex flex-col items-center justify-center p-2 rounded-lg border border-transparent hover:border-cyan-400 transition-colors">
                                <i class="{{ $icon }} text-2xl text-cyan-400"></i>
                                <span class="text-xs mt-1 text-gray-300">
                                    {{ str_replace(['ri-', '-line'], '', $icon) }}
                                </span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Form Fields -->
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Title*</label>
                    <input type="text" name="title" required 
                           class="form-input" placeholder="What do you want to achieve?">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Description</label>
                    <textarea name="description" rows="3" class="form-input" 
                              placeholder="Describe your goal"></textarea>
                </div>

                <!-- Location Picker -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Location</label>
                    <div class="flex gap-2 mb-2">
                        <input type="text" id="location-search" class="form-input flex-1" placeholder="Search location...">
                        <button type="button" id="search-location" class="btn btn-secondary">Search</button>
                    </div>
                    <div id="map" class="h-64 rounded-lg border border-gray-600"></div>
                    <div class="mt-2 grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Latitude</label>
                            <input type="text" name="latitude" id="latitude" class="form-input" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Longitude</label>
                            <input type="text" name="longitude" id="longitude" class="form-input" readonly>
                        </div>
                    </div>
                    <input type="hidden" name="location_name" id="location-name">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Category*</label>
                        <select name="category" required class="form-input">
                            <option value="">Select category</option>
                            @foreach(['Personal', 'Career', 'Education', 'Health', 'Financial', 'Other'] as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Deadline</label>
                        <input type="date" name="deadline" class="form-input">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Priority*</label>
                    <div class="flex gap-3 mt-2">
                        @foreach(['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'] as $value => $label)
                            <label class="flex items-center">
                                <input type="radio" name="priority" value="{{ $value }}" 
                                       {{ $value === 'medium' ? 'checked' : '' }}
                                       class="h-4 w-4 text-cyan-400 focus:ring-cyan-500">
                                <span class="ml-2 text-gray-300">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('goals.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="ri-save-line mr-2"></i>Save Goal
                </button>
            </div>
        </form>
    </x-modal>

    @push('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize map
            const map = L.map('map').setView([0, 0], 2);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            let marker = null;
            
            // On map click
            map.on('click', function(e) {
                updateMarkerPosition(e.latlng);
                reverseGeocode(e.latlng);
            });

            // Location search
            document.getElementById('search-location').addEventListener('click', function() {
                const query = document.getElementById('location-search').value;
                if (!query) return;
                
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            const firstResult = data[0];
                            const latLng = L.latLng(firstResult.lat, firstResult.lon);
                            map.setView(latLng, 15);
                            updateMarkerPosition(latLng);
                            document.getElementById('location-name').value = firstResult.display_name;
                        }
                    });
            });

            function updateMarkerPosition(latLng) {
                if (marker) {
                    map.removeLayer(marker);
                }
                marker = L.marker(latLng).addTo(map);
                document.getElementById('latitude').value = latLng.lat;
                document.getElementById('longitude').value = latLng.lng;
            }

            function reverseGeocode(latLng) {
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${latLng.lat}&lon=${latLng.lng}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('location-name').value = data.display_name || 'Selected location';
                    });
            }
        });
    </script>
    @endpush
</x-app-layout>