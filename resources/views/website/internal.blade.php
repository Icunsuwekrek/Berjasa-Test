@extends('website.layout')

@section('content')
    <section class="section w-100%">
        <div class="section-header" style="margin-top: 30px">
            <div class="section-header-breadcrumb">
                {{-- <div class="breadcrumb-item">
                    <a href="{{ route('admin.index') }}">Dashboard</a>
                </div> --}}
                <div >
                   <h4> Internal</h4>
                </div>
            </div>

            <h2>Approval Flow Discount Program List</h2>
        </div>
        <div class="card" style="width:100%">
            <div class="card-header">
                <a href="{{ route('internal.edit') }}" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add Internal</a>
            </div>
            <div class="card-body">
                @if (isset($message))
                    <p>{{ $message }}</p>
                @endif
                <table class="table table-responsive-sm table-striped table-vertical-align">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th style="width: 150px;">Level</th>
                            <th>Title Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($internal as $key => $model)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <b class="thumbnail">{{ $model->level }}</b> <br>
                                </td>
                                <td>
                                    <a href="/discount-internal" class="no-style" style="font-weight: bold">
                                        <span>{!! $model->title_name !!}</span>
                                    </a>    
                                </td>
                            </tr>
                        @endforeach
                        @if ($internal->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center"><b>Table is empty</b></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <style>
        a.no-style {
            text-decoration: none; /* Menghapus underline */
            color: inherit; /* Mengatur warna teks agar sama dengan teks di sekitarnya */
        }

        a.no-style:hover,
        a.no-style:focus,
        a.no-style:active {
            text-decoration: none; /* Menghapus underline saat hover, fokus, atau aktif */
            color: inherit; /* Mengatur warna teks agar sama dengan teks di sekitarnya */
        }
    </style>
@stop
