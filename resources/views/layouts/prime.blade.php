<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>e-Library</title>

    <style>

        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #000;
            filter:alpha(opacity=50);
            -moz-opacity:0.5;
            -khtml-opacity: 0.5;
            opacity: 0.5;
            z-index: 10000;
        }

        .loader-inner.ball-pulse {
            position: absolute;
            left: 50%;
            top: 50%;
            color: white;
        }
    </style>
   @include('layouts.headerScripts')
</head>

<body style="background-color: #ffffff !important;">

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">e-Library</a>
            </div>
            <!-- Top Menu Items -->
            @include('layouts.asideMenu')
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">
                <div id="overlay" class="hidden">
                    <div class="loader-inner ball-pulse"><div></div><div></div><div></div></div>
                </div>
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-angle-right">@yield('pageTitle')</i>
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                @yield('main_container')

            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <script src="{!! asset('/assets/js/daterangepicker.js')!!}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{!! asset('/assets/js/bootstrap.min.js')!!}"></script>
    <script src="{!! asset('/assets/js/datatable/jquery.dataTables.js')!!}"></script>

    <script src="{!! asset('/assets/js/datatable/dataTables.bootstrap.js')!!}"></script>
    <script src="{!! asset('/assets/js/app.js')!!}"></script>
    <script src="{!! asset('/assets/js/select2.min.js')!!}"></script>
    <script src="{!! asset('/assets/js/select2.full.min.js')!!}"></script>

    <!-- Morris Charts JavaScript -->
    <script src="{!! asset('/assets/js/plugins/morris/raphael.min.js') !!}"></script>
    <script src="{!! asset('/assets/js/plugins/morris/morris.min.js') !!}"></script>
    {{--<script src="{!! asset('/assets/js/plugins/morris/rmorris-data.js') !!}"></script>--}}
    <script src="{!! asset("assets/js/jquery.validate.js") !!}"></script>

    <script>
        @if(\Illuminate\Support\Facades\Session::has("error"))
    $(function () {
            toastr.error(('{{$error}}'));

            toastr.options = {
                "closeButton": true,
                "debug": false,
                "positionClass": "toast-top-right",
                "onclick": null,
                "showDuration": "1000",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
        });
        @endif

        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
    $(function () {
//                alert();
            toastr.error(('{{$error}}'));

            toastr.options = {
                "closeButton": true,
                "debug": false,
                "positionClass": "toast-top-right",
                "onclick": null,
                "showDuration": "1000",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
        });
        @endforeach
        @endif

    </script>
</body>

</html>
