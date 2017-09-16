@extends('layouts.prime')
@section('pageTitle')
    Shporta ime
@endsection
@section('main_container')
    <div class="row">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Lista e librave ne shporte</h3>
            </div>

            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>TITULLI</th>
                        <th>AUTORI</th>
                        <th>ZHANRI</th>
                        <th>VITI</th>
                        <th>CMIMI</th>
                        <th>VEPRIME</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($librat as $l)
                        <tr>
                            <td style="text-align: center;">
                                @if($l->image != '' || $l->image != null)
                                    <img src="{!! asset('assets/img/'.$l->image) !!}" style="max-height: 120px;" alt="">
                                    <p>
                                        {!! $l->titulli !!}
                                    </p>
                                @else
                                    <p style="margin-top: 30px;">
                                        {!! $l->titulli !!}
                                    </p>
                                @endif
                            </td>
                            <td style="padding-top: 40px;">{!! $l->emri !!} {!! $l->mbiemri !!}</td>
                            <td style="word-break: break-all;padding-top: 40px;">
                                <?php
                                $zhanri = \App\Models\LibriToZhanriModel::select(
                                    \App\Http\Controllers\Classes\ZhanriClass::TABLE_NAME.'.'.\App\Http\Controllers\Classes\ZhanriClass::EMRI)
                                    ->join(\App\Http\Controllers\Classes\ZhanriClass::TABLE_NAME,
                                        \App\Http\Controllers\Classes\ZhanriClass::TABLE_NAME.'.'.\App\Http\Controllers\Classes\ZhanriClass::ID,
                                        \App\Http\Controllers\Classes\LibriToZhanriClass::TABLE_NAME.'.'.\App\Http\Controllers\Classes\LibriToZhanriClass::ID_ZHANRI)
                                    ->where(\App\Http\Controllers\Classes\LibriToZhanriClass::TABLE_NAME.'.'.\App\Http\Controllers\Classes\LibriToZhanriClass::ID_LIBRI,
                                        $l->libri_id)
                                    ->get();
                                if (count($zhanri) > 0){

                                    echo $zhanri[0]->emri;
                                    for($i = 1; $i < count($zhanri); $i++){
                                        echo ', '.$zhanri[$i]->emri;
                                    }
                                }
                                else{
                                    echo '--';
                                }
                                ?>
                            </td>
                            <td style="padding-top: 40px;">{!! $l->viti !!}</td>
                            <td style="padding-top: 40px;">{!! $l->cmimi !!}</td>
                            <td style="padding-top: 40px;">
                                <button data-id="{!! $l->libri_id !!}" class="btn btn-danger fshi">
                                    Hiq nga &nbsp;<i class="fa fa-shopping-cart"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
    <script>
        $(
            function () {
//            $("#example1").DataTable();
                $('#example1').DataTable({
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false
                });

                $(".fshi").click(function () {
                    var id = $(this).data("id");
                    var btn = $(this);
                    var url = '{!! \Illuminate\Support\Facades\URL::route('fshi_card') !!}';

                    swal({
                            title: "A je i sigurte?",
                            text: "Ju do te fshini librin nga Shporta",
                            showCancelButton: true,
                            closeOnConfirm: false,
                            showLoaderOnConfirm: true
                        },
                        function () {
                            $.ajax({
                                url: url,
                                type: 'POST',
                                data: {_token: '{!! csrf_token() !!}', id_libri: id},
                                success: function (data) {
                                    if (data.sts == 1) {
                                        swal("U fshi!", "", "success");

                                        btn.parent().parent().remove();
                                    } else {
                                        swal("U anulua!", "Dicka nuk shkoi mire, libri nuk u hoq nga shporta!", "error");
                                    }
                                }
                            })
                        });
                });

            });
    </script>
@endsection