@extends('website.layout')

@section('content')
    <section class="section">
        <div class="section-header" style="margin-top: 30px">
            <div class="section-header-breadcrumb">
                <div style="">
                    <h5 style="font-weight: bold">Dashboard Internal</h5>
                </div>
            </div>
            <h2 style="; margin-top:20px">Discount</h2>
        </div>
        <div class="" style=" width:100%">
            <div class="card card-info card-out-line">
                <div class="card-header">
                    <a href="{{ route('exportdiscount') }}" class="btn btn-success">Export File</a>
                    {{-- <a href="#" class="btn btn-primary" id="openModalBtn" data-bs-toggle="modal" data-bs-target="#exampleModal">Import File</a> --}}
                    <button type="button"class="btn btn-primary" id="openModalBtn" data-bs-toggle="modal"
                        data-bs-target="#exampleModal"> Import File</button>
                </div>
            </div>
            <div class="card-body">
                @if (isset($message))
                    <p>{{ $message }}</p>
                @endif
                <table class="table table-responsive-sm table-striped table-vertical-align">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 40px;">Region</th>
                            <th style="width: 150px; font-size:15px">Distributor Name</th>
                            <th style="font-size: 15px; width:80px">Month</th>
                            <th style="font-size: 15px">Target</th>
                            <th style="font-size: 15px">Balance Incentive</th>
                            <th style="font-size: 15px">Total Discount</th>
                            <th style="font-size: 15px">Total Adjustment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($discounts as $key => $model)
                            <tr>
                                <td><b class="thumbnail">{{ $model->region }}</b></td>
                                <td><span>{!! $model->distributor !!}</span></td>
                                <td><span>{!! $model->month !!}</span></td>
                                <td><span>{!! $model->target_june !!}</span></td>
                                <td><span>{!! $model->balance_incentive !!}</span></td>
                                <td><span>{!! $model->total_discount_fix !!}</span></td>
                                <td><span>{!! $model->adjusment !!}</span></td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-warning dropdown-toggle" type="button"
                                            data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">Action</button>
                                        <div class="dropdown-menu" style="position: absolute;">
                                            {{-- <a class="dropdown-item" href="{{ route('website.detail_discount ', $model->id) }}">Detail</a> --}}
                                        </div>
                                    </div>
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
                <div class="card">
                    <div class="row">
                        <div class="col-lg-12 row">
                            <div class="card-header col-lg-6">
                                <h5 style="font-weight: bold">Document Need Approval</h5>
                                <div class="row" style="margin-top: 50px">
                                    <div class="col-lg-5 d-flex"
                                        style="margin-left: 15px; flex-direction: column;justify-content:center; align-items:center;">
                                        <p style="font-size: 25px">Discount Program</p>
                                        <p style="font-size: 70px; font-weight:bold">{{ $discounts->count() }}</p>
                                    </div>
                                    <div class="col-lg-5 d-flex"
                                        style="padding-left: 50px;flex-direction: column;justify-content:center; align-items:center;">
                                        <p style="font-size: 25px">Discount Calculation</p>
                                        <p style="font-size:70px; font-weight:bold">0</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-header col-lg-6">
                                <h5 style="font-weight: bold">Discount On Invoice Summary</h5>
                                <div class="" style="margin-top: 50px">
                                    <div style="font-size: 25px">Target This Month</div>
                                    <h1>1</h1>
                                    <div style="font-size: 25px; margin-top: 100px">Discount Rate Total %</div>
                                    <h1>{{ $discountRate }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form untuk upload file -->
                    <form action="{{ route('importdiscount') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Pilih file</label>
                            <input class="form-control" type="file" id="formFile" name="file" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
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
    </script>
@stop
