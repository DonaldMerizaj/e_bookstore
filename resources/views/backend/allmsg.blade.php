@extends('layouts.prime')
@section('pageTitle')
    Dashboard - Mesazhet
@endsection
@section('main_container')
    <div class="row">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Mesazhet e klienteve</h3>
            </div>

            <div class="box-body">
                <div class="row">

                </div>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>KLIENTI</th>
                        <th>MESAZHI</th>
                        <th>VEPRIME</th>
                    </tr>
                    </thead>

                    <tbody id="zhaner_table">
                    @foreach($sms as $s)
                        <tr>
                            <td>{!! $s->emri !!} <br>
                                <i>{!! $s->email !!}</i>
                            </td>
                            <td>{!! $s->desc !!}</td>
                            <td>
                                {{--<a href="{!! URL::route('editZhanri', array($z->zhanri_id)) !!}" class="btn btn-default">--}}
                                {{--<i class="fa fa-pencil"></i>--}}
                                {{--</a>--}}
                                <button data-id="{!! $s->feedback_id !!}" class="btn btn-danger fshiMsg">
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
        $(
            function () {

                refreshTable();

                function refreshTable() {

                    $('#example1').DataTable({
                        "paging": true,
                        "lengthChange": true,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false
                    });
                }

                $(".fshiMsg").on('click', function () {
                    fshiZhaner(this);
                });

                function fshiZhaner(a) {
                    var id = $(a).data("id");
                    var elem = $(a);
                    var url = '{!! \Illuminate\Support\Facades\URL::route('fshiMsg') !!}';

                    swal({
                        title: "A jani te sigurte qe doni ta fshini kete mesazh?",
                        type: "info",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        showLoaderOnConfirm: true
                    }, function () {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {_token: '{!! csrf_token() !!}', id: id},
                            success: function (data) {
                                if (data.sts == 1) {
                                    swal("U fshi!", "", "success");
                                    elem.parent().parent().remove();
                                } else {
                                    swal("U anulua!", "Dicka nuk shkoi mire, mesazhi nuk mund te fshihet!", "error");
                                }
                            }
                        })
                    });
                }
            });
    </script>
@endsection