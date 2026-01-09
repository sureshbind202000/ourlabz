@if ($coupons->count())
    @foreach ($coupons as $coupon)
        @php
            $eligible = !$coupon->min_cart_amount || $cartTotal >= $coupon->min_cart_amount;
        @endphp


        <div class="border rounded p-3 mb-2 d-flex justify-content-between align-items-start" @if (session('applied_coupon') == $coupon->code) style="background-color: #0095d91f;"
        @elseif(!$eligible) style="background-color: #fb75751f;"
        @endif>

            <!-- LEFT -->
            <div>
                <h6 class="mb-1">{{ $coupon->code }}</h6>
                <small class="text-muted">{{ $coupon->title }}</small><br>

                @if ($coupon->discount_type == 'percentage')
                   <small>
                        Save {{ rtrim(rtrim(number_format($coupon->discount_value, 2), '0'), '.') }}%
                        on a minimum order of ₹{{ number_format($coupon->min_cart_amount, 0) }}
                    </small>
                @elseif($coupon->discount_type == 'flat')
                    <small>
                        Save ₹{{ number_format($coupon->discount_value, 0) }}
                        on a minimum order of ₹{{ number_format($coupon->min_cart_amount, 0) }}
                    </small>
                @elseif($coupon->discount_type == 'free_delivery')
                    <small>Free on a minimum order of ₹{{ $coupon->min_cart_amount }}</small>
                @endif

                @if (!$eligible)
                    <div class="text-danger small">
                        Add ₹{{ $coupon->min_cart_amount - $cartTotal }} more to apply
                    </div>
                @endif
            </div>

            <!-- RIGHT -->
            <div class="text-end">
                @if(session('applied_coupon') == $coupon->code)
                <button class="btn btn-sm btn-outline-primary applyCouponBtn" data-code="{{ $coupon->code }}" disabled>
                    Applied
                </button>
                @else
                <button class="btn btn-sm btn-outline-primary applyCouponBtn" data-code="{{ $coupon->code }}"
                    {{ $eligible ? '' : 'disabled' }}>
                    Apply
                </button>
                @endif
            </div>

        </div>
    @endforeach
@else
    <div class="text-center text-muted">No coupons available</div>
@endif
