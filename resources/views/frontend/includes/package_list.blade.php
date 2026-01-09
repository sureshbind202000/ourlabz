<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
    @forelse($packages as $package)
    <div class="col">
        <div class="card h-100 p-3 border">
            <div class="card-body p-0 mb-4">
                <div class="d-flex gap-2">
                    <div class="border p-1 rounded-2 test-image">
                        @php
                        $icon = $package->package_icon
                        ? asset($package->package_icon)
                        : ($package->categoryDetails && $package->categoryDetails->category_image
                        ? asset($package->categoryDetails->category_image)
                        : asset('default.png'));
                        @endphp
                        <img src="{{ $icon }}" alt="">
                    </div>
                    <div>
                        <h6 class=" my-2 fw-bold ">
                            <a
                                href="{{ route('test.details', ['slug' => $package->slug]) }}">{{ $package->name }}</a>
                        </h6>
                        <div class=" d-flex gap-3 mt-2">
                            <div>
                                <h6 class="small text-muted">Parameters</h6>
                                <p class="text-muted small">{{ count($package->parameters) }} Test</p>
                            </div>
                            <div>
                                <h6 class="small text-muted">Reports Within</h6>
                                <p class="text-muted small">{{ $package->reports_within }}
                                    Hours</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex w-100 price">
                <div>
                    <span class="pe-2 text-dark fw-bold">
                        ₹{{ number_format($package->selling_price, 2) }}
                    </span>

                    @if (!empty($package->discount_label))
                    <del class="text-muted small px-0">
                        ₹{{ number_format($package->regular_price, 2) }}
                    </del>
                    <br>
                    <span class="text-danger small px-0">
                        {{ $package->discount_label }}
                    </span>
                    @endif
                </div>
                @php
                $key = get_class($package) . '_' . $package->id;
                $inCart = in_array($key, $cartItems);
                $quantity = 1;

                // if logged in or session cart has this item, get its quantity
                if ($inCart) {
                if (Auth::check()) {
                $cartRow = \App\Models\Cart::where('user_id', Auth::id())
                ->where('item_type', get_class($package))
                ->where('item_id', $package->id)
                ->first();
                $quantity = $cartRow ? $cartRow->quantity : 1;
                } else {
                $cartRow = Session::get("cart.$key");
                $quantity = $cartRow['quantity'] ?? 1;
                }
                }
                @endphp
                @if(request()->query('from') === 'lab-checkout')
                <div class="cart-action">
                    <a href="javascript:void(0);" type="button" class="btn btn-primary px-4 py-1 border-0 add-to-cart"
                        data-id="{{ $package->id }}" data-type="package">
                        Add
                    </a>
                </div>
                @else

                @if ($inCart)
                <span class="bg-primary-subtle text-primary p-1 px-3 rounded-2"
                    data-bs-toggle="tooltip"
                    data-bs-placement="left"
                    title="Test already added. Add for a new patient from Patient Details">
                    Added
                </span>





                @else
                <div class="cart-action">
                    <a href="javascript:void(0);" type="button" class="btn btn-primary px-4 py-1 border-0 add-to-cart"
                        data-id="{{ $package->id }}" data-type="package">
                        Add
                    </a>
                </div>
                @endif
                @endif

            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center mx-auto">
        <div class="alert alert-primary">No lab test found.</div>
    </div>
    @endforelse
</div>

{{-- Pagination --}}
<div class="pagination-area mt-3">
    {{ $packages->links('vendor.pagination.custom') }}
</div>