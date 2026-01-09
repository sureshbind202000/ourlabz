@extends('backend.includes.layout')

@section('content')

<div class="card mb-3">

    <div class="card-header">

        <div class="row flex-between-end">

            <div class="col-auto align-self-center">

                <h5 class="mb-0" data-anchor="data-anchor">All Payments</h5>

            </div>

        </div>

    </div>

    <div class="card-body pt-0">

        <div class="tab-content">



            <div id="tableExample3"

                data-list='{"valueNames":["txnid","paymentfor","subtotal","discount","total","date","status"],"page":10,"pagination":true}'>

                <div class="row justify-content-end g-0">

                    <div class="col-auto col-sm-5 mb-3">

                        <form>

                            <div class="input-group"><input class="form-control form-control-sm shadow-none search"

                                    type="search" placeholder="Search..." aria-label="search" />

                                <div class="input-group-text bg-transparent"><span

                                        class="fa fa-search fs-10 text-600"></span></div>

                            </div>

                        </form>

                    </div>

                    <div class="col-auto ms-auto">





                    </div>

                </div>

                <div class="table-responsive scrollbar">

                    <table class="table table-bordered table-striped fs-10 mb-0">

                        <thead class="bg-200">

                            <tr>

                                <th class="text-900">S.No.</th>

                                <th class="text-900" data-sort="txnid">Txn. Id</th>

                                <th class="text-900" data-sort="paymentfor">Payment For</th>

                                <th class="text-900" data-sort="subtotal">Subtotal</th>

                                <th class="text-900" data-sort="discount">Discount</th>

                                <th class="text-900" data-sort="total">Total</th>

                                <th class="text-900" data-sort="date">Date</th>

                                <th class="text-900" data-sort="status">Status</th>

                            </tr>

                        </thead>

                        <tbody class="list">

                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                        </tbody>

                    </table>

                </div>

                <div class="d-flex justify-content-center mt-3"><button class="btn btn-sm btn-falcon-default me-1"

                        type="button" title="Previous" data-list-pagination="prev"><span

                            class="fas fa-chevron-left"></span></button>

                    <ul class="pagination mb-0"></ul><button class="btn btn-sm btn-falcon-default ms-1" type="button"

                        title="Next" data-list-pagination="next"><span class="fas fa-chevron-right"> </span></button>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@section('js')

<script>
    $(document).ready(function() {

        fetchPayments();

        function formatDate(dateString) {

            let date = new Date(dateString);

            let day = date.getDate().toString().padStart(2, '0');

            let month = (date.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-based

            let year = date.getFullYear();

            return `${day}/${month}/${year}`;

        }


        function fetchPayments() {
            $.ajax({
                url: "{{ route('corporate.payments.list') }}",
                type: "GET",
                success: function(response) {
                    console.log(response);
                    const tbody = $('.list');
                    tbody.empty();

                    if (response.success && response.payments.length > 0) {
                        response.payments.forEach((payment, index) => {
                            const status = (payment.payment_status || 'Pending').toString().toLowerCase(); // 👈 safe conversion

                            let row = `
            <tr>
                <td>${index + 1}</td>
                <td>${payment.transaction_id ?? '-'}</td>
                <td>${payment.type ?? '-'}</td>
                <td>₹${Number(payment.subtotal || 0).toLocaleString('en-IN')}</td>
                <td>₹${Number(payment.discount || 0).toLocaleString('en-IN')}</td>
                <td><strong>₹${Number(payment.total || 0).toLocaleString('en-IN')}</strong></td>
                <td>${formatDate(payment.created_at) ?? '-'}</td>
                <td>
                    <span class="badge ${status === 'paid' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning'}">
                        ${payment.payment_status ?? 'Pending'}
                    </span>
                </td>
            </tr>
        `;
                            tbody.append(row);
                        });
                    } else {
                        tbody.append('<tr><td colspan="8" class="text-center">No payments found.</td></tr>');
                    }

                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }


    });
</script>

@endsection