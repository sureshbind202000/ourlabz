@extends('backend.includes.layout')

@section('content')

    <div class="card mb-3" id="ordersTable"

        data-list='{"valueNames":["order","date","address","status","amount"],"page":10,"pagination":true}'>

        <div class="card-header">

            <div class="row flex-between-center">

                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">

                    <h5 class="fs-9 mb-0 text-nowrap py-2 py-xl-0">Orders</h5>

                </div>

                <div class="col-8 col-sm-auto ms-auto text-end ps-0">

                    <div id="orders-actions">

                        <form>

                            <div class="input-group"><input class="form-control form-control-sm shadow-none search"

                                    type="search" placeholder="Search..." aria-label="search" />

                                <div class="input-group-text bg-transparent"><span

                                        class="fa fa-search fs-10 text-600"></span></div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive scrollbar">

                <table class="table table-sm table-striped fs-10 mb-0 overflow-hidden">

                    <thead class="bg-200">

                        <tr>

                            <th style="width: 28px;">

                                S.No.

                            </th>

                            <th class="text-900 sort pe-1 align-middle white-space-nowrap" data-sort="order">Order</th>

                            <th class="text-900 sort pe-1 align-middle white-space-nowrap" data-sort="address"

                            style="min-width: 12.5rem;">Ship To</th>

                            <th class="text-900 sort pe-1 align-middle white-space-nowrap text-center" data-sort="amount">

                                Amount

                            </th>

                            <th class="text-900 sort pe-1 align-middle white-space-nowrap text-center" data-sort="status">

                                Status

                            </th>

                            <th class="text-900 sort pe-1 align-middle white-space-nowrap text-center" data-sort="date">Date</th>

                            <th class="no-sort"></th>

                        </tr>

                    </thead>

                    <tbody class="list" id="table-orders-body">
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

        </div>

        <div class="card-footer">

            <div class="d-flex align-items-center justify-content-center"><button

                    class="btn btn-sm btn-falcon-default me-1" type="button" title="Previous"

                    data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>

                <ul class="pagination mb-0"></ul><button class="btn btn-sm btn-falcon-default ms-1" type="button"

                    title="Next" data-list-pagination="next"><span class="fas fa-chevron-right"> </span></button>

            </div>

        </div>

    </div>

@endsection

@section('js')

    <script>

        $(document).ready(function() {



            fetchOrders();



            function fetchOrders() {

                Swal.fire({

                    title: 'Loading Orders...',

                    allowOutsideClick: false,

                    didOpen: () => {

                        Swal.showLoading();

                    }

                });



                $.ajax({

                    url: "{{ route('vendor.orders.fetch') }}",

                    type: 'GET',

                    dataType: 'json',

                    success: function(response) {

                        Swal.close();

                        if (response.status) {

                            $('#table-orders-body').html(response.html);

                        } else {

                            Swal.fire('Error', 'Failed to load orders', 'error');

                        }

                    },

                    error: function(xhr) {

                        console.log(xhr);

                        Swal.fire('Error', 'Something went wrong!', 'error');

                    }

                });

            }





            $(document).on('click', '.change-status', function(e) {

                e.preventDefault();

                var orderId = $(this).data('id');

                var newStatus = $(this).data('status');



                Swal.fire({

                    title: 'Change Status?',

                    text: "Set order to '" + newStatus.charAt(0).toUpperCase() + newStatus.slice(

                        1) + "'",

                    icon: 'warning',

                    showCancelButton: true,

                    confirmButtonText: 'Yes, change it!',

                    cancelButtonText: 'Cancel'

                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({

                            url: "{{ route('order.changeStatus') }}",

                            method: 'POST',

                            data: {

                                _token: '{{ csrf_token() }}',

                                id: orderId,

                                status: newStatus

                            },

                            beforeSend: function() {

                                Swal.fire({

                                    title: 'Updating...',

                                    didOpen: () => {

                                        Swal.showLoading()

                                    },

                                    allowOutsideClick: false,

                                    allowEscapeKey: false

                                });

                            },

                            success: function(response) {

                                Swal.fire({

                                    icon: 'success',

                                    title: 'Updated!',

                                    text: response.message,

                                    timer: 1500,

                                    showConfirmButton: false

                                });



                                fetchOrders();

                            },

                            error: function(xhr) {
console.log(xhr);
                                Swal.fire('Error!', 'Something went wrong.', 'error');

                            }

                        });

                    }

                });

            });

        });

    </script>

@endsection

