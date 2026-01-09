<div class="shop-sidebar bg-white rounded-4">



    {{-- Type Filter --}}

    <div class="shop-widget">

        <h4 class="shop-widget-title">Type</h4>

        @foreach ($types as $type)

            <div class="form-check">

                <input class="form-check-input" type="checkbox" name="type[]" value="{{ $type->id }}"

                    id="type_{{ $type->id }}"

                    {{ in_array($type->id, (array) request()->input('type')) ? 'checked' : '' }}>

                <label class="form-check-label" for="type_{{ $type->id }}">{{ $type->name }}</label>

            </div>

        @endforeach

    </div>





    {{-- Category Filter --}}

    <div class="shop-widget">

        <h4 class="shop-widget-title">Category</h4>

        @foreach ($categories as $category)

            <div class="form-check">

                <input class="form-check-input" type="checkbox" name="category[]" value="{{ $category->slug }}"

                    id="cat_{{ $category->id }}"

                    {{ in_array($category->slug, (array) request()->input('category')) ? 'checked' : '' }}>

                <label class="form-check-label" for="cat_{{ $category->id }}">{{ $category->name }}</label>

            </div>

        @endforeach

    </div>



    {{-- Subcategory Filter --}}

    <div class="shop-widget">

        <h4 class="shop-widget-title">Subcategory</h4>

        @foreach ($subcategories as $subcategory)

            <div class="form-check">

                <input class="form-check-input" type="checkbox" name="subcategory[]" value="{{ $subcategory->slug }}"

                    id="subcat_{{ $subcategory->id }}"

                    {{ in_array($subcategory->slug, (array) request()->input('subcategory')) ? 'checked' : '' }}>

                <label class="form-check-label" for="subcat_{{ $subcategory->id }}">{{ $subcategory->name }}</label>

            </div>

        @endforeach

    </div>



    {{-- Price Range Filter --}}

    <div class="shop-widget">

        <h4 class="shop-widget-title">Price Range</h4>

        <div class="price-range-box">

            <div class="price-range-input">

                <input type="text" id="price-amount" readonly>

                <input type="hidden" id="min_price" name="min_price" value="{{ request()->input('min_price', 0) }}">

                <input type="hidden" id="max_price" name="max_price"

                    value="{{ request()->input('max_price', 100000) }}">

            </div>

            <div class="price-range"></div>

        </div>

    </div>



    {{-- Rating Filter --}}

    <div class="shop-widget">

        <h4 class="shop-widget-title">Rating</h4>

        @for ($i = 5; $i >= 1; $i--)

            <div class="form-check">

                <input class="form-check-input" type="checkbox" name="rating[]" value="{{ $i }}"

                    id="rating_{{ $i }}"

                    {{ in_array($i, (array) request()->input('rating')) ? 'checked' : '' }}>

                <label class="form-check-label" for="rating_{{ $i }}">

                    @for ($star = 1; $star <= 5; $star++)

                        <i class="{{ $star <= $i ? 'fas text-warning' : 'fal text-primary' }} fa-star"></i>

                    @endfor

                </label>

            </div>

        @endfor

    </div>



</div>

