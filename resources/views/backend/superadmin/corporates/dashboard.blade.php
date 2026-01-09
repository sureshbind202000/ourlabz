@extends('backend.includes.layout')

@section('content')


<div class="row g-3 mb-3">
    {{-- Greeting --}}
    <div class="col-md-12 col-xxl-12">
        <div class="card shadow-sm border-0 h-md-100">
            <div class="card-body p-4">
                @php
                $hour = date('H');
                $greeting = $hour < 12 ? 'Good Morning' : ($hour < 18 ? 'Good Afternoon' : 'Good Evening' );
                    $user=Auth::user();
                    @endphp

                    <div class="d-flex align-items-center">
                    <div class="me-3">
                        <img src="{{ asset($user->profile ?? 'images/default.png') }}" alt="Profile"
                            class="rounded-circle border border-primary shadow-sm" height="100" width="100">
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">{{ $greeting }}, {{ $user->name }}!</h5>
                        <p class="text-muted small mb-1">
                            <strong>Corporate Id:</strong> {{ $corporate->corporate_id ?? 'N/A' }}
                        </p>
                        <p class="text-muted small mb-0">
                            <strong>Company Size :</strong> {{ $corporate->company_size ?? 'N/A' }}
                            <br>
                            <strong>Email :</strong> {{ $user->email ?? 'N/A' }}
                        </p>
                    </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-3 col-xxl-3">

    <div class="card h-md-100 ecommerce-card-min-width">

        <div class="card-header pb-0">

            <h6 class="mb-0 mt-2 d-flex align-items-center">Wallet &nbsp;<i class="fa-solid fa-wallet text-warning"></i></h6>

        </div>

        <div class="card-body d-flex flex-column justify-content-end">

            <div class="row align-items-center">

                <div class="col-auto">

                    <div class="d-flex align-items-center gap-2">

                        <p class="font-sans-serif lh-1 mb-0 fw-semibold text-success walletBalance">₹0.00</p>

                        <i class="fa-solid fa-plus text-primary cursor-pointer rounded-circle bg-white p-1 shadow-sm"

                            data-bs-toggle="modal" data-bs-target="#addWalletModal" title="Add to Wallet"

                            style="font-size: 14px;"></i>

                    </div>

                </div>

                <div class="col ps-0">

                    <div class="echart-bar-weekly-sales h-100"></div>

                </div>

            </div>

        </div>



    </div>



</div>

{{-- Total Employees --}}
<div class="col-md-3 col-xxl-3">
    <div class="card h-md-100 border-start border-4 border-primary shadow-sm">
        <div class="card-body text-center">
            <h6 class="fw-semibold text-primary mb-1">Total Employees</h6>
            <h3 class="fw-bold mb-0">{{ $employees }}</h3>
        </div>
    </div>
</div>
{{-- Pending Packages --}}
<div class="col-md-3 col-xxl-3">
    <div class="card h-md-100 border-start border-4 border-warning shadow-sm">
        <div class="card-body text-center">
            <h6 class="fw-semibold text-warning mb-1">Pending Packages</h6>
            <h3 class="fw-bold mb-0">{{ $pendingPackages }}</h3>
        </div>
    </div>
</div>

{{-- Purchased Packages --}}
<div class="col-md-3 col-xxl-3">
    <div class="card h-md-100 border-start border-4 border-success shadow-sm">
        <div class="card-body text-center">
            <h6 class="fw-semibold text-success mb-1">Purchased Packages</h6>
            <h3 class="fw-bold mb-0">{{ $purchasedPackages }}</h3>
        </div>
    </div>
</div>
</div>


<div class="modal fade" id="addWalletModal" tabindex="-1" aria-labelledby="addWalletModalLabel" aria-hidden="true">

    <div class="modal-dialog">

        <form id="addWalletForm">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">Add to Wallet</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">

                        <label for="amount" class="form-label">Amount</label>

                        <input type="number" class="form-control" name="amount" required min="1" step="0.01">

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="submit" class="btn btn-primary">Add</button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection

@section('js')

<script>
    $(document).ready(function() {





        $('#addWalletForm').on('submit', function(e) {

            e.preventDefault();

            let formData = new FormData(this);



            $.ajax({

                url: '/corporate/wallet/add',

                method: 'POST',

                data: formData,

                contentType: false,

                processData: false,

                success: function(res) {

                    if (res.success) {

                        $('#addWalletModal').modal('hide');

                        Swal.fire('Success', res.message, 'success');

                        loadWalletBalance();

                    }

                },

                error: function(xhr) {

                    Swal.fire('Error', xhr.responseJSON?.message || 'Something went wrong.', 'error');

                }

            });

        });



        // Load wallet on page load

        loadWalletBalance();



    })
</script>

@endsection