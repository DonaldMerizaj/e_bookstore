@extends('layouts.prime')
@section('pageTitle')
    Feedback
@endsection
@section('main_container')
    <div class="row">
        <div class="box">
            <div class="box-header">
                <div style="background-color:#f5f5f5 !important; height: 60px;">
                    <h3 class="box-title" style="margin-top: 0px;">Kontakto administratoret</h3>
                </div>
            </div>

            <div class="box-body">

                @if(count($errors)> 0)
                    <h4><i class="icon fa fa-ban"></i> Kujdes!</h4>
                    <ul style="list-style: none">
                        @foreach($errors->all() as $error)
                            <li class="alert alert-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
            {!! Form::open(array('route' => 'ruajmsg', 'id'=>'savemsg', 'method'=>'post', 'files'=>true)) !!}
            <div class="col-md-6">
                <div class="form-group">
                    <label>Emri</label>
                    <input type="text" name="emri" value="{!! old('emri') !!}" class="form-control" placeholder="emri">
                    <span class="validate-error"></span>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="email" value="{!! old('email') !!}" class="form-control" placeholder="email">
                    <span class="validate-error"></span>
                </div>

                <div class="form-group">
                    <label>Përshkrimi</label>
                    <textarea name="desc" class="form-control" rows="3" placeholder="Përshkrimi">{!! old('description') !!}</textarea>
                    <span class="validate-error"></span>
                </div>

                <div class="row">
                    <div class="col-md-1" >
                        <button type="button" id="krijo" class="btn btn-success">Dergo</button>
                    </div>
                </div>

            </div>

            {!! Form::close() !!}
        </div>
    </div>

    <script>
        $(function () {

            $('#savemsg').validate({
                rules: {
                    emri: 'required',
                    email:{
                        email:true,
                        required:true
                    },
                    desc: 'required'
                },
                messages: {
                    emri: 'Vendosni emrin',
                    email:{
                        email: 'Email jo i sakte',
                        required: 'Vendosni emailin'
                    },
                    desc: 'Pershkruaj mesazhin tend'
                },
                errorPlacement: function (error, element) {
                    $.each(element, function () {
                        $(element).parent().find(".validate-error").html(error);
                    })
                }
            });

            $("#krijo").click(function () {
                $("#savemsg").submit();
            });
        })
    </script>
@endsection