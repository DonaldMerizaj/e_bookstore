@extends('layouts.prime')
@section('pageTitle')
    Dashboard - Zhaner
@endsection
@section('main_container')
    <div class="row">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Zhanerat e librave</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    @if(\App\Http\Controllers\Utils::getRole() == \App\Http\Controllers\Classes\LoginClass::ADMIN)
                        <div class="col-sm-2" style="margin-bottom: 16px;">
                            <a href="{!! URL::route('krijoZhaner') !!}" class="btn btn-success">
                                <i class="fa fa-plus"></i> Krijo
                            </a>
                        </div>
                    @endif
                </div>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ZHANRI</th>
                        <th>VEPRIME</th>
                    </tr>
                    </thead>

                    <tbody>
                        @foreach($zhanri as $z)
                            <tr>
                                <td>{!! $z->emri !!}</td>
                                <td>
                                    {{--<a href="{!! URL::route('editZhanri', array($z->zhanri_id)) !!}" class="btn btn-default">--}}
                                        {{--<i class="fa fa-pencil"></i>--}}
                                    {{--</a>--}}
                                    <button data-id="{!! $z->zhanri_id !!}" class="btn btn-danger deleteZhaner">
                                        <i class="fa fa-trash"></i>
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
        $(function () {
//            $("#example1").DataTable();
            $('#example1').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });

            $(".deleteZhaner").click(function () {
                var id = $(this).data("id");
                var elem = $(this);
                var url = '{!! \Illuminate\Support\Facades\URL::route('fshiZhaner') !!}';

                swal({
                    title: "A jani te sigurte qe doni ta fshini kete zhaner?",
                    type: "info",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                }, function () {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {_token: '{!! csrf_token() !!}', id:id },
                        success: function (data) {
                            if (data.sts == 1){
                                swal("U fshi!", "", "success");
                                elem.parent().parent().remove();
                            }else{
                                swal("U anulua!", "Dicka nuk shkoi mire, zhaneri nuk mund te fshihet!", "error");
                            }
                        }
                    })
                });

            })
        });
    </script>
@endsection