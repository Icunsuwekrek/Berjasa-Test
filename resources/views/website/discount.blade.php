@extends('website.layout')

@section('content')
    <section class="section" style="width: 100%">
        <div class="section-header" style="margin-top: 30px">
            <div class="section-header-breadcrumb">
                <div style="">
                    <h5 class="card header" style="font-weight: bold;  height:40px; border-top:none; padding-left: 10px">
                        Dashboard Discount</h5>
                </div>
            </div>
        </div>

        <div class="row m-0 g-5">
            <div class="col-4 d-flex flex-column gap-4">
                <div class="p-4" style="background-color: rgba(144, 238, 144, 0.3);  display:flex; align-items:center">
                    <div class="w-100">
                        <b style="color:green; font-size:20px">Welcome Back!</b>
                        <h5 style="font-size: 18px; color:green">YID Freezer dashboard</h5>
                    </div>
                    <img src="/images/developer.svg" alt="working" style="width: 120px">
                </div>
                <div class="card col-lg-12" style="height: 200px;">
                    <div class="header"
                        style="background-color: rgba(128, 128, 128, 0.25); width:fit-content; padding:4px 12px; border-radius:4px">
                        <i class="fa-regular fa-file" style="margin-right: 8px;"></i>Document that reads your approval
                    </div>

                    <div class="row mt-3" style="padding: 4px 12px">
                        <div class="col-lg-6">
                            <p style="font-size: 20px">Freezer Budget</p>
                            <p style="font-size: 30px; font-weight:bold">0</p>
                        </div>
                        <div class="col-lg-6">
                            <p style="font-size: 20px">Freezer Buyback</p>
                            <p style="font-size: 30px; font-weight:bold">0</p>
                        </div>
                    </div>
                </div>
                <div class="card col-lg-12" style="height: 200px;">
                    <div class="header"
                        style="background-color: rgba(253, 255, 210, 0.5); width:fit-content; padding:4px 12px; border-radius:4px">
                        <i class="fa-regular fa-clock" style="margin-right: 8px;"></i> Currently being reviewed document
                    </div>

                    <div class="row mt-3" style="padding: 4px 12px">
                        <div class="col-lg-6">
                            <p style="font-size: 20px">Freezer Budget</p>
                            <p style="font-size: 30px; font-weight:bold">0</p>
                        </div>
                        <div class="col-lg-6">
                            <p style="font-size: 20px">Freezer Buyback</p>
                            <p style="font-size: 30px; font-weight:bold">0</p>
                        </div>
                    </div>
                </div>
                <div class="card " style="height:300px;">

                    <div class="header" style="padding: 4px 12px">
                        <i class="fa-solid fa-tag"></i> Discount Rate Total %

                    </div>

                    <div
                        style="display:flex; flex-direction:column; justify-content:center; align-items:flex-start; padding:4px 12px">
                        <h5 style="font-size: 24px">{{ $discountRate }}%</h5>
                        <p>{{ $discounts->count() }} Documents</p>
                    </div>

                    <div id="chart" style="height: fit-content%; weight:100%"></div>

                </div>
                <div class="card " style="height:300px;">

                    <div class="header" style="padding: 4px 12px">
                        <i class="fa-solid fa-tag"></i> Discount Target

                    </div>

                    <div
                        style="display:flex; flex-direction:column; justify-content:center; align-items:flex-start; padding:4px 12px">
                        <h5 style="font-size: 24px">Rp {{$totalTargetFixSumFormatted}}JT</h5>
                        <p>{{ $discounts->count() }} Documents</p>
                    </div>

                    <div id="targetChart" style="height: fit-content%; weight:100%"></div>

                </div>
            </div>
            <div class="card col-8">
                @if (isset($message))
                    <p>{{ $message }}</p>
                @endif
                <div class="w-100%">
                    <b style="font-size: 30px">Historical Discount</b>
                </div>
                <table class="table table-responsive-sm table-striped table-vertical-align mt-5">
                    <thead style="background-color: rgba(0, 0, 0, 0.45);">
                        <tr>
                            <th style="width: 40px; border-bottom:none;">Region</th>
                            <th style="width: 150px; font-size:15px; border-bottom:none;">Distributor Name</th>
                            <th style="font-size: 15px; width:70px; border-bottom:none;">Month</th>
                            <th style="font-size: 15px; border-bottom:none;">Target</th>
                            <th style="font-size: 15px; border-bottom:none;">Balance Incentive</th>
                            <th style="font-size: 15px; border-bottom:none;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($discounts as $key => $model)
                            <tr>
                                <td><b class="thumbnail">{{ $model->region }}</b></td>
                                <td><span>{!! $model->distributor !!}</span></td>
                                <td><span>{!! $model->month !!}</span></td>
                                <td><span>Rp {!! $model->target_june !!}</span></td>
                                <td><span>Rp {!! $model->balance_incentive !!}</span></td>
                                <td>
                                    <a class="btn btn-warning" href="{{ route('discountShow', $model->id) }}">Detail</a>

                                </td>
                            </tr>
                        @endforeach
                        @if ($discounts->isEmpty())
                            <tr>
                                <td colspan="12" class="text-center"><b>Table is empty</b></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </section>

@stop

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ensure the modal is not shown on page load
            var modalElement = document.getElementById('exampleModal');
            var modal = new bootstrap.Modal(modalElement);
            modal.hide();

            // Add an event listener to the button to show the modal
            document.getElementById('openModalBtn').addEventListener('click', function() {
                modal.show();
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            Highcharts.chart('chart', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: null // Menghapus judul
                },
                xAxis: {
                    categories: @json($discounts_label),
                    labels: {
                        enabled: true // Menyembunyikan label sumbu X
                    },
                    gridLineWidth: 0 // Menghapus garis grid sumbu X
                },
                yAxis: {
                    title: {
                        text: null // Menghapus judul sumbu Y
                    },
                    labels: {
                        enabled: false // Menyembunyikan label sumbu Y
                    },
                    gridLineWidth: 0 // Menghapus garis grid sumbu Y
                },
                legend: {
                    enabled: false // Menyembunyikan legenda
                },
                tooltip: {
                    enabled: false // Menyembunyikan tooltip
                },
                plotOptions: {
                    series: {
                        allowPointSelect: true,
                        marker: {
                            enabled: false // Menyembunyikan marker data point
                        },
                        enableMouseTracking: false // Menonaktifkan tracking mouse
                    }
                },
                series: [{
                    data: @json($discounts_graph)
                }]
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            Highcharts.chart('targetChart', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: null // Menghapus judul
                },
                xAxis: {
                    categories: @json($target_label),
                    labels: {
                        enabled: true // Menyembunyikan label sumbu X
                    },
                    gridLineWidth: 0 // Menghapus garis grid sumbu X
                },
                yAxis: {
                    title: {
                        text: null // Menghapus judul sumbu Y
                    },
                    labels: {
                        enabled: false // Menyembunyikan label sumbu Y
                    },
                    gridLineWidth: 0 // Menghapus garis grid sumbu Y
                },
                legend: {
                    enabled: false // Menyembunyikan legenda
                },
                tooltip: {
                    enabled: false // Menyembunyikan tooltip
                },
                plotOptions: {
                    series: {
                        allowPointSelect: true,
                        marker: {
                            enabled: false // Menyembunyikan marker data point
                        },
                        enableMouseTracking: false // Menonaktifkan tracking mouse
                    }
                },
                series: [{
                    data: @json($discounts_graph)
                }]
            });
        });
    </script>
@stop
