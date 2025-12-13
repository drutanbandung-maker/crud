@extends('layout')

@section('content')
<!-- Search at Top -->
<div class="row mb-5">
    <div class="col-12">
        <form method="GET" action="{{ route('dashboard') }}" class="d-flex">
            <input type="text" name="search" class="form-control" placeholder="Search talent by name..." value="{{ $search }}">
            <button type="submit" class="btn btn-primary ms-2">Search</button>
            @if($search)
                <a href="{{ route('dashboard') }}" class="btn btn-secondary ms-2">Clear</a>
            @endif
        </form>
    </div>
</div>

<!-- Carousel -->
<div class="mb-5">
    <div id="carouselDashboard" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($carouselImages as $index => $image)
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                <img src="{{ $image }}" class="d-block w-100 rounded" alt="Slide {{ $index + 1 }}" style="height: 100px; object-fit: cover;">
            </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselDashboard" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselDashboard" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<!-- Talents List -->
<div class="row">
    @forelse($talents as $talent)
    <div class="col-12 mb-3">
        <div class="card shadow-sm">
            <div class="card-body p-3">
                <div class="d-flex gap-3 align-items-center">
                    <!-- Left: Avatar -->
                    <div style="width: 100px; height: 100px; flex-shrink: 0;">
                        <div class="bg-light d-flex align-items-center justify-content-center h-100 rounded" style="overflow: hidden;">
                            @if($talent->avatar)
                                <img src="{{ asset('storage/' . $talent->avatar) }}" alt="{{ $talent->name }}" class="w-100 h-100" style="object-fit: cover;">
                            @else
                                <div class="text-center">
                                    <div style="font-size: 2rem;">{{ strtoupper(substr($talent->name, 0, 1)) }}</div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Right: Details & Services -->
                    <div class="flex-grow-1 d-flex flex-column justify-content-center" style="min-width: 0;">
                        <h6 class="mb-0">{{ $talent->name }}</h6>
                        <p class="text-muted small mb-2">{{ $talent->email }}</p>

                        <!-- Services (horizontal, no wrap) -->
                        @if($talent->services->isNotEmpty())
                            <div class="d-flex gap-2" style="overflow-x: auto; white-space: nowrap; padding-bottom: 4px;">
                                @foreach($talent->services as $service)
                                <span class="badge bg-info text-dark flex-shrink-0" style="font-size: 0.75rem;" title="{{ $service->description }}">
                                    {{ $service->name }} ({{ $service->price }})
                                </span>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted small mb-0">No services available</p>
                        @endif
                    </div>

                    <!-- Button -->
                    <button class="btn btn-sm btn-primary flex-shrink-0" data-bs-toggle="modal" data-bs-target="#bookingModal" onclick="setTalentData({{ $talent->id }}, '{{ $talent->name }}')">
                        Book
                    </button>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <p class="text-muted">No talents found matching your search.</p>
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if($talents->total() > 0)
<div class="d-flex justify-content-center mt-4">
    {{ $talents->appends(request()->query())->links() }}
</div>
@endif

<!-- Booking Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingModalLabel">Book Talent</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Talent:</strong> <span id="talentName"></span></p>
                <p class="text-muted small">Booking feature coming soon!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Book Service</button>
            </div>
        </div>
    </div>
</div>

<script>
function setTalentData(talentId, talentName) {
    document.getElementById('talentName').textContent = talentName;
}
</script>
@endsection
