@extends('layouts.prime')
@section('pageTitle')
    @if(\App\Http\Controllers\Utils::getRole() == \App\Http\Controllers\Classes\LoginClass::ADMIN)
    Dashboard -
    @endif
    Librat

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
                <h3 class="box-title">Librat</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    @if(\App\Http\Controllers\Utils::getRole() == \App\Http\Controllers\Classes\LoginClass::ADMIN)
                    <div class="col-sm-2" style="margin-bottom: 16px;">
                        <a href="{!! URL::route('krijoLiber') !!}" class="btn btn-success">
                            <i class="fa fa-plus"></i> Krijo
                        </a>
                    </div>
                        @endif
                </div>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>TITULLI</th>
                            <th>AUTORI</th>
                            <th>ZHANRI</th>
                            <th>VITI</th>
                            <th>CMIMI</th>
                            {{--@if(\App\Http\Controllers\Utils::getRole() <= \App\Http\Controllers\Classes\LoginClass::PUNONJES)--}}
                            {{--<th>SASIA GJENDJE</th>--}}
                            {{--@endif--}}
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
                                }else{
                                    echo '--';
                                }

                                ?>
                            </td>
                            <td style="padding-top: 40px;">{!! $l->viti !!}</td>
                            <td style="padding-top: 40px;">{!! $l->cmimi !!}</td>
                            {{--@if(\App\Http\Controllers\Utils::getRole() == \App\Http\Controllers\Classes\LoginClass::KLIENT && ($l->gjendje>0))--}}
                                {{--<td style="padding-top: 40px;">Ka gjendje</td>--}}
                                {{--@elseif(\App\Http\Controllers\Utils::getRole() == \App\Http\Controllers\Classes\LoginClass::KLIENT && ($l->gjendje==0))--}}
                                    {{--<td style="padding-top: 40px;">Nuk ka gjendje</td>--}}
                                {{--@else--}}
                                {{--<td style="padding-top: 40px;">{!! $l->gjendje !!}</td>--}}
                            {{--@endif--}}
                            <td style="padding-top: 40px;">
                                @if(\App\Http\Controllers\Utils::getRole() <= \App\Http\Controllers\Classes\LoginClass::ADMIN)
                                    <a href="{!! URL::route('editLibri', array($l->libri_id)) !!}" class="btn btn-default">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                @elseif(\App\Http\Controllers\Utils::getRole() == \App\Http\Controllers\Classes\LoginClass::KLIENT)

                            <?php
                            $exists = \App\Models\BasketModel::where(
                                \App\Http\Controllers\Classes\BasketClass::TABLE_NAME.'.'.\App\Http\Controllers\Classes\BasketClass::ID_LIBRI,
                                    $l->libri_id)
                                ->where(\App\Http\Controllers\Classes\BasketClass::TABLE_NAME.'.'.\App\Http\Controllers\Classes\BasketClass::ID_KLIENT,
                                    \App\Http\Controllers\Utils::getKlientId())
                                ->where(\App\Http\Controllers\Classes\BasketClass::TABLE_NAME.'.'.\App\Http\Controllers\Classes\BasketClass::STATUS,
                                    \App\Http\Controllers\Classes\BasketClass::ACTIVE)
                                        ->first();
                            ?>
                                @if($exists)
                                    <button class="btn btn-success">
                                       <i class="fa fa-check"></i>
                                    </button>
                                @else
                                    <button data-id="{!! $l->libri_id !!}" class="btn btn-info addCard">
                                        shto ne &nbsp;<i class="fa fa-shopping-cart"></i>
                                    </button>
                                @endif


                                @endif
                                {{----}}
                                    {{--@if($l->gjendje>0)--}}
                                        {{--@if(\App\Http\Controllers\Utils::getRole() == \App\Http\Controllers\Classes\LoginClass::KLIENT )--}}

                                        {{--@elseif(\App\Http\Controllers\Utils::getRole() <= \App\Http\Controllers\Classes\LoginClass::PUNONJES)--}}
                                        {{--<a href="{!! URL::route('addCard', array($l->libri_id)) !!}" class="btn btn-default">--}}
                                        {{--<i class="fa fa-shopping-cart"></i>--}}
                                        {{--</a>--}}
                                        {{--@endif--}}
                                    {{--@endif--}}

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

                $(".addCard").click(function () {
                    var id = $(this).data("id");
                    var btn = $(this);
                    var url = '{!! \Illuminate\Support\Facades\URL::route('add_card') !!}';

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {_token: '{!! csrf_token() !!}', id_libri: id},
                        success: function (data) {
                            if (data.sts == 1) {
                                swal("U shtua!", "", "success");

                                btn.off('click');
                                btn.html('<i class="fa fa-check"></i>');
                                btn.attr('class', 'btn btn-success');
                            } else {
                                swal("U anulua!", "Dicka nuk shkoi mire, libri nuk u shtua ne shporte!", "error");
                            }
                        }
                    })
                });

            });
    </script>
@endsection