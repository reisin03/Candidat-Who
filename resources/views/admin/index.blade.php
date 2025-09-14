<!-- Barangay Captain -->
@if($captain)
<div class="col-md-4">
    <div class="card border-0 shadow-sm h-100" style="background-color: #f8f9fa;">
        <div class="card-body text-center">
            <img src="{{ $captain->photo ? asset('storage/'.$captain->photo) : 'https://via.placeholder.com/150' }}" 
                 alt="Barangay Captain Photo" 
                 class="rounded-circle mb-3 border border-3"
                 style="border-color: #cce5ff;">
            <h5 class="card-title fw-bold text-dark">{{ $captain->name }}</h5>
            <p class="text-muted mb-2">{{ $captain->position }}</p>
            <p class="small mb-2">
                📞 {{ $captain->phone }} <br>
                ✉️ {{ $captain->email }}
            </p>
            <p class="small">{{ $captain->description }}</p>
            <a href="{{ route('brgyofficials.edit', $captain) }}" class="btn btn-sm btn-primary mt-2">Edit</a>
            <form action="{{ route('brgyofficials.destroy', $captain) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger mt-2" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Barangay Kagawads -->
@foreach($kagawads as $kagawad)
<div class="col-md-4 col-lg-3">
    <div class="card border-0 shadow-sm h-100" style="background-color: #f8f9fa;">
        <div class="card-body text-center">
            <img src="{{ $kagawad->photo ? asset('storage/'.$kagawad->photo) : 'https://via.placeholder.com/150' }}" 
                 alt="Kagawad Photo" 
                 class="rounded-circle mb-3 border border-3"
                 style="border-color: #cce5ff;">
            <h5 class="card-title fw-bold text-dark">{{ $kagawad->name }}</h5>
            <p class="text-muted mb-2">{{ $kagawad->position }}</p>
            <p class="small mb-2">
                📞 {{ $kagawad->phone }} <br>
                ✉️ {{ $kagawad->email }}
            </p>
            <p class="small">{{ $kagawad->description }}</p>
            <a href="{{ route('brgyofficials.edit', $kagawad) }}" class="btn btn-sm btn-primary mt-2">Edit</a>
            <form action="{{ route('brgyofficials.destroy', $kagawad) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger mt-2" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </div>
    </div>
</div>
@endforeach
