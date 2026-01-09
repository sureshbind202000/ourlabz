@extends('backend.includes.layout')

@section('content')



<div class="row justify-content-center my-5">

    <div class="col-lg-4">

        <div class="card overflow-hidden" style="min-width: 12rem">

            <div class="bg-holder bg-card"

                style="background-image:url(assets/img/icons/spot-illustrations/corner-3.png);"></div>



            <div class="card-body position-relative text-center">

                <div class="display-4 fs-5 mb-2 fw-normal font-sans-serif walletBalance">

                    ₹0.00

                </div>

                <a class="btn btn-primary w-100 mt-2" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#addWalletModal">

                    Add to Wallet <span class="fas fa-plus ms-1" data-fa-transform="down-1"></span>

                </a>

            </div>



        </div>

    </div>

</div>

<div class="row">

    <div class="d-flex mb-4">

        <span class="fa-stack me-2 ms-n1">

            <i class="fas fa-circle fa-stack-2x text-300"></i><i class="fa-inverse fa-stack-1x text-primary fas fa-list"

                data-fa-transform="shrink-2"></i>

        </span>

        <div class="col">

            <h5 class="mb-0 text-primary position-relative">

                <span class="bg-200 dark__bg-1100 pe-3">Wallet Transaction History</span>

                <span class="border position-absolute top-50 translate-middle-y w-100 start-0 z-n1"></span>

            </h5>

            <p class="mb-0">Below is a list of all your credit and debit wallet transactions.</p>

        </div>

    </div>

    <div class="col-lg-12 col-xxl-12">

        <div class="card" id="walletTable"

            data-list='{"valueNames":["date","note","type","amount"],"page":10,"pagination":true,"fallback":"wallet-table-fallback"}'>

            <div class="card-header">

                <div class="row flex-between-center">

                    <div class="col-auto col-sm-6 col-lg-7">

                        <h6 class="mb-0 text-nowrap py-2 py-xl-0">Wallet History</h6>

                    </div>

                    <div class="col-auto col-sm-6 col-lg-5">

                        <div>

                            <form>

                                <div class="input-group">

                                    <input class="search form-control form-control-sm shadow-none" type="search" placeholder="Search wallet history" aria-label="search">

                                    <button class="btn btn-sm btn-outline-secondary border-300 hover-border-secondary" type="submit">

                                        <span class="fa fa-search fs-10"></span>

                                    </button>

                                </div>



                            </form>

                        </div>

                    </div>

                </div>

            </div>

            <div class="card-body px-0 py-0">

                <div class="table-responsive scrollbar">

                    <table class="table table-bordered table-sm fs-10">

                        <thead class="bg-light">

                            <tr>

                                <th class="text-900 sort" data-sort="sno">S No</th>

                                <th class="text-900 sort" data-sort="amount">Txn. Amount</th>

                                <th class="text-900 sort" data-sort="type">Credit/Debit</th>

                                <th class="text-900 sort" data-sort="note">Description</th>

                                <th class="text-900 sort" data-sort="date">Txn. Date</th>

                            </tr>

                        </thead>

                        <tbody class="list" id="walletHistoryTableBody"></tbody>

                    </table>

                </div>

                <div class="text-center d-none" id="pages-table-fallback">

                    <p class="fw-bold fs-8 mt-3">No Page found</p>

                </div>

            </div>

            <div class="card-footer">

                <div class="row align-items-center">

                    <div class="pagination d-none"></div>

                    <div class="col">

                        <p class="mb-0 fs-10"><span class="d-none d-sm-inline-block me-2"

                                data-list-info="data-list-info"></span></p>

                    </div>

                    <div class="col-auto d-flex"><button class="btn btn-sm btn-primary" type="button"

                            data-list-pagination="prev"><span>Previous</span></button><button

                            class="btn btn-sm btn-primary px-4 ms-2" type="button"

                            data-list-pagination="next"><span>Next</span></button></div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- Add to wallet modal -->

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

                        <input type="number" class="form-control" name="amount" id="wallet_amount" required min="1" step="0.01">

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

            const amount = parseFloat($('#wallet_amount').val()); // assuming input name="amount"
            if (!amount || amount < 1) {
                Swal.fire('Error', 'Please enter a valid amount.', 'error');
                return;
            }

            Swal.fire({
                title: 'Processing Payment...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            // Step 1: Create Razorpay order
            fetch('/razorpay/checkout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body: JSON.stringify({
                        amount: amount,
                        type: 'corporate_wallet'
                    })
                })
                .then(res => res.json())
                .then(data => {
                    Swal.close();

                    if (!data.order_id) {
                        Swal.fire('Error', 'Failed to initiate payment.', 'error');
                        return;
                    }

                    // Step 2: Open Razorpay checkout popup
                    const options = {
                        key: "{{ config('services.razorpay.key') }}", // from backend
                        amount: data.amount,
                        currency: data.currency,
                        name: "Corporate Wallet Recharge",
                        description: "Add money to your wallet",
                        order_id: data.order_id,
                        handler: function(response) {
                            // Step 3: On success, save wallet transaction
                            $.ajax({
                                url: '/corporate/wallet/add',
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: {
                                    amount: amount,
                                    razorpay_payment_id: response.razorpay_payment_id,
                                    razorpay_order_id: response.razorpay_order_id,
                                    razorpay_signature: response.razorpay_signature,
                                    payment_status: 'Paid'
                                },
                                success: function(res) {
                                    if (res.success) {
                                        $('#addWalletModal').modal('hide');
                                        Swal.fire('Success', res.message, 'success').then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire('Error', res.message, 'error');
                                    }
                                },
                                error: function(xhr) {
                                    Swal.fire('Error', xhr.responseJSON?.message || 'Something went wrong.', 'error');
                                }
                            });
                        },
                        theme: {
                            color: "#528FF0"
                        }
                    };

                    const rzp = new Razorpay(options);
                    rzp.open();
                })
                .catch(err => {
                    Swal.close();
                    Swal.fire('Error', 'Something went wrong while initiating payment.', 'error');
                    console.error(err);
                });
        });




        function loadWalletBalance() {

            $.get('/corporate/wallet', function(res) {

                if (res.success) {

                    $('.walletBalance').html(new Intl.NumberFormat('en-IN', {

                        style: 'currency',

                        currency: 'INR'

                    }).format(res.wallet));

                }

            });

        }

        // Load wallet on page load

        loadWalletBalance();

        loadWalletHistory();





        function loadWalletHistory() {

            const tbody = $('#walletHistoryTableBody');

            tbody.html('<tr><td colspan="5" class="text-center">Loading...</td></tr>');



            $.ajax({

                url: '/corporate/wallet/history',

                method: 'GET',

                data: {

                    user_id: '{{ auth()->id() }}'

                },

                success: function(res) {

                    if (res.success && res.data.length > 0) {

                        let html = '';

                        res.data.forEach((item, index) => {

                            const sign = item.type === 'credit' ? '+' : '-';

                            const amountClass = item.type === 'credit' ? 'text-success' : 'text-danger';



                            const createdAt = new Date(item.created_at);

                            const day = createdAt.getDate().toString().padStart(2, '0');

                            const month = (createdAt.getMonth() + 1).toString().padStart(2, '0');

                            const year = createdAt.getFullYear();

                            let hours = createdAt.getHours();

                            const minutes = createdAt.getMinutes().toString().padStart(2, '0');

                            const ampm = hours >= 12 ? 'PM' : 'AM';

                            hours = hours % 12 || 12;

                            const formattedDate = `${day}/${month}/${year} ${hours}:${minutes} ${ampm}`;



                            html += `

                        <tr>

                        <td class="">${index + 1}</td>

                        <td class="amount ${amountClass} fw-bold">${sign} ₹${parseFloat(item.amount).toFixed(2)}</td>

                        <td class="type text-capitalize">${item.type}</td>

                        <td class="note">${item.description ?? '—'}</td>

                            <td class="date">${formattedDate}</td>

                        </tr>

                    `;

                        });



                        tbody.html(html);



                        // ✅ Initialize List.js AFTER table is rendered

                        new List('walletTable', {

                            valueNames: ['date', 'note', 'type', 'amount'],

                            page: 10,

                            pagination: true

                        });



                    } else {

                        tbody.html('<tr><td colspan="5" class="text-center">No wallet history found.</td></tr>');

                    }

                },

                error: function() {

                    tbody.html('<tr><td colspan="5" class="text-danger text-center">Failed to load history.</td></tr>');

                }

            });

        }





    })
</script>

@endsection