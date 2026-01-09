@extends('frontend.includes.dashboard_layout')

@section('css')



@endsection

@section('dash_content')



<div class="user-wrapper">

    <div class="row">

        <div class="col-lg-12">

            <div class="user-card">

                <div class="user-card-header mb-0">

                    <h4 class="user-card-title">All Reports</h4>

                    <div class="user-card-header-right">

                        <div class="user-card-search">

                            <div class="form-group">

                                <input type="text" class="form-control" id="customSearch" placeholder="Search...">

                                <i class="far fa-search"></i>

                            </div>

                        </div>

                    </div>



                </div>

                <div class="table-responsive">

                    <table class="table table-borderless text-nowrap" id="order-list">

                        <thead>

                            <tr>

                                <th>S.No.</th>

                                <th>Name</th>

                                <th>Test</th>

                                <th>Report</th>

                                <th>Date</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($reports as $report)

                            <tr>

                                <td><span class="table-list-code">#{{ $loop->index + 1 }}</span></td>

                                <td>{{ $report->name }}</td>

                                <td class="text-wrap">
                                    {{$report->test}}
                                </td>


                                <td><a href="{{asset($report->report)}}" target="_blank" class="text-danger"><img width="40" height="40" src="https://img.icons8.com/office/40/pdf-2.png" alt="pdf-2" /></a></td>

                                <td>{{$report->date}}</td>

                            </tr>

                            @endforeach



                        </tbody>

                    </table>

                </div>



            </div>

        </div>

    </div>

</div>



@endsection

@section('js')

<script>
    let table = new DataTable('#order-list', {

        dom: 'rtp',

        ordering: false

    });



    $('#customSearch').on('keyup', function() {

        table.search(this.value).draw();

    });



    // 🔽 Status Dropdown Filter

    $('#statusFilter').on('change', function() {

        let selected = this.value;



        let statusColumnIndex = 3;



        table.column(statusColumnIndex).search(selected).draw();

    });
</script>



@endsection