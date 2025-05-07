@section('title', 'Edit Goal')

<x-modal title="Edit Goal" subtitle="Update your objective">
    <form action="{{ route('goals.update', $goal) }}" method="POST">
        @csrf
        @method('PUT')

        @include('goals.create') <!-- Reuse create form -->

        <!-- Initialize with existing location if available -->
        @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if($goal->latitude && $goal->longitude)
                    const latLng = L.latLng({{ $goal->latitude }}, {{ $goal->longitude }});
                    map.setView(latLng, 15);
                    updateMarkerPosition(latLng);
                    document.getElementById('location-name').value = '{{ $goal->location_name }}';
                @endif
            });
        </script>
        @endpush

        <div class="mt-8 flex justify-end space-x-3">
            <a href="{{ route('goals.show', $goal) }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <i class="ri-save-line mr-2"></i>Update Goal
            </button>
        </div>
    </form>
</x-modal>