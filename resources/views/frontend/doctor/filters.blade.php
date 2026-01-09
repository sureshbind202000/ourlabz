<div class="shop-sidebar bg-white rounded-4">

    {{-- Type Filter --}}
    <div class="shop-widget">
        <h4 class="shop-widget-title">Type</h4>
        @php
            $types = ['Online', 'In-Person'];
            $selectedTypes = (array) request()->input('type', []);
        @endphp
        @foreach ($types as $index => $type)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="type[]" value="{{ $type }}"
                    id="type_{{ $index }}" {{ in_array($type, $selectedTypes) ? 'checked' : '' }}>
                <label class="form-check-label" for="type_{{ $index }}">{{ $type }}</label>
            </div>
        @endforeach
    </div>

    {{-- Speciality Filter --}}
    <div class="shop-widget">
        <h4 class="shop-widget-title">Speciality</h4>
        @php
            $selectedSpecialities = (array) request()->input('speciality', []);
        @endphp

        @foreach ($specialities as $speciality)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="speciality[]" value="{{ $speciality->slug }}"
                    id="speciality_{{ $speciality->id }}"
                    {{ in_array($speciality->slug, $selectedSpecialities) ? 'checked' : '' }}>
                <label class="form-check-label" for="speciality_{{ $speciality->id }}">
                    {{ $speciality->speciality }}
                </label>
            </div>
        @endforeach
    </div>

    {{-- Price Range Filter --}}
    <div class="shop-widget">
        <h4 class="shop-widget-title">Price Range</h4>
        <div class="price-range-box">
            <div class="price-range-input mb-2">
                <input type="text" id="price-amount" readonly class="form-control-plaintext d-none d-lg-block">
                <input type="hidden" id="min_price" name="min_price" value="{{ request()->input('min_price', 0) }}">
                <input type="hidden" id="max_price" name="max_price"
                    value="{{ request()->input('max_price', 10000) }}">
            </div>
            <div class="price-range"></div>
        </div>
    </div>

    {{-- Rating Filter --}}
    <div class="shop-widget">
        <h4 class="shop-widget-title">Rating</h4>
        @php $selectedRatings = (array) request()->input('rating', []); @endphp
        @for ($i = 5; $i >= 1; $i--)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="rating[]" value="{{ $i }}"
                    id="rating_{{ $i }}" {{ in_array($i, $selectedRatings) ? 'checked' : '' }}>
                <label class="form-check-label" for="rating_{{ $i }}">
                    @for ($star = 1; $star <= 5; $star++)
                        <i class="{{ $star <= $i ? 'fas text-warning' : 'fal text-primary' }} fa-star"></i>
                    @endfor
                </label>
            </div>
        @endfor
    </div>

</div>
