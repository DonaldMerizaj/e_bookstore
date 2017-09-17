@extends('layouts.prime')
@section('pageTitle')
    Dashboard - Klientë
@endsection
@section('main_container')
    {{--<div class="row">--}}
    {{--<div class="col-sm-12">--}}
    {{--<h1>Menaxho librat</h1>--}}
    {{--</div>--}}
    {{--</div>--}}
    <div class="row">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Klientë</h3>
            </div>

            <div class="box-body">
                <div class="row">
                <div class="col-sm-2" style="margin-bottom: 16px;">
                    {{--<a href="{!! URL::route('krijoKlient') !!}" class="btn btn-success">--}}
                        {{--<i class="fa fa-plus"></i> Krijo--}}
                    {{--</a>--}}
                </div>
                </div>
            <div class="row">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>EMRI</th>
                        <th>MBIEMRI</th>
                        <th>EMAIL</th>
                        <th>CEL</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($klient as $l)
                        <tr>
                            <td>{!! $l->emri !!}</td>
                            <td>{!! $l->mbiemri !!}</td>
                            <td>{!! $l->email !!}</td>
                            <td>{!! $l->cel !!}</td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
    <script>
        $(function () {
//            $("#example1").DataTable();
            $('#example1').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true
            });
        });
    </script>
@endsection