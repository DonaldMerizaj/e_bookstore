
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>e-Library</title>

    <!-- Bootstrap Core CSS -->
    <link href="{!! asset('/assets/css/bootstrap.css') !!}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{!! asset('/assets/css/sb-admin.css') !!}" rel="stylesheet">

    <!-- Morris Charts CSS -->

    <!-- Custom Fonts -->
    <link href="{!! asset('/assets/css/font-awesome.min.css') !!}" rel="stylesheet" type="text/css">
    <!-- Sweetalert -->
    <link rel="stylesheet" href="{!! asset('/assets/bower_components/sweetalert/dist/sweetalert.css') !!}">
    <!-- Loaders Css -->
    <link rel="stylesheet" href="{!! asset('/assets/bower_components/loaders.css/loaders.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('/assets/bower_components/chosen/chosen.css') !!}">
    <link rel="stylesheet" href="{!! asset('/assets/css/custom.css') !!}">


    <!-- jQuery -->
    <script src="{!! asset('/assets/js/jquery.js') !!}"></script>
    <!-- Sweetalert -->
    <script src="{!! asset('/assets/bower_components/sweetalert/dist/sweetalert.min.js') !!}"></script>
    <script src="{!! asset('/assets/bower_components/chosen/chosen.jquery.js') !!}" ></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
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

</head>

<body style="background-color: #ffffff !important;">

<div id="wrapper_signup">

    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="navbar-header">

            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <a class="navbar-brand" href="/">eLibrary</a>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
    </nav>

    <div id="page-wrapper">

        <div class="container-fluid">
            <div class="box box-info">
                <div class="box-header with-border row">
                    <div class="col-md-12" style="text-align: center; margin-bottom: 2em;margin-top: 2em">
                        <h3 class="box-title">Regjistrohu</h3>
                    </div>
                    <div class="col-md-12" style="text-align: center;margin-top: 2em">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row">
                    {!! Form::open(array('id'=>'registerForm', 'route'=>'signup', 'method'=>'post')) !!}
                    <div class="col-md-4 col-md-offset-1">

                        <div class="box-body">

                            <div class="row">
                                <div class="form-group">
                                    <label for="name" class="col-sm-3 control-label">Emri <span class="required_star">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="name" class="form-control" placeholder="Emri" required>
                                        <span class="validate-error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 16px;">
                                <div class="form-group">
                                    <label for="surname" class="col-sm-3 control-label">Mbiemri <span class="required_star">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="surname" class="form-control" placeholder="Mbiemri">
                                        <span class="validate-error"></span>

                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 16px;">
                                <div class="form-group">
                                    <label for="email" class="col-sm-3 control-label">Email <span class="required_star">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="email" class="form-control" placeholder="e-mail">
                                        <span class="validate-error"></span>

                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 16px;">
                                <div class="form-group">
                                    <label for="city" class="col-sm-3 control-label">Qyteti <span class="required_star">*</span></label>
                                    <div class="col-sm-9">
                                        <select name="city" id="city" class="form-control">
                                            <option value="-1" disabled selected>Zgjidh qytetin</option>
                                            <option value="1"  >Tirane</option>
                                            <option value="2">Berat</option>
                                            <option value="3">Durres</option>
                                            <option value="4">Ballsh</option>
                                            <option value="5">Fier</option>
                                            <option value="6">Elbasan</option>
                                        </select>
                                        <span class="validate-error"></span>
                                        {{--<input type="text" name="surname" class="form-control" placeholder="Mbiemri">--}}
                                    </div>


                                </div>
                            </div>
                            <div class="row" style="margin-top: 16px;">
                                <div class="form-group">
                                    <label for="nr_cel" class="col-sm-3 control-label">Nr. cel</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nr_cel" class="form-control" placeholder="06x xXx yYyx">
                                        <span class="validate-error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-md-offset-1">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group">
                                    <label for="username" class="col-sm-4 control-label">Username <span class="required_star">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" name="username" class="form-control" placeholder="Username" required>
                                        <span class="validate-error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 16px;">
                                <div class="form-group">
                                    <label for="password" class="col-sm-4 control-label">Password <span class="required_star">*</span></label>

                                    <div class="col-sm-8">
                                        <input type="password" name="password" class="form-control" placeholder="Password"
                                               >
                                        <span class="validate-error"></span>
                                        <p style="margin-top: 5px;color: grey">Min 6 karaktere dhe 1 shifer</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box-footer" style="margin-top: 3em">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" id="register"
                                       class="btn btn-success pull-right">Regjistrohu</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>

            </div>
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->



<!-- Bootstrap Core JavaScript -->
<script src="{!! asset('/assets/js/bootstrap.min.js')!!}"></script>

<!-- Morris Charts JavaScript -->
<script src="{!! asset('/assets/js/plugins/morris/raphael.min.js') !!}"></script>
<script src="{!! asset('/assets/js/plugins/morris/morris.min.js') !!}"></script>
<script src="{!! asset('/assets/js/plugins/morris/rmorris-data.js') !!}"></script>
<script src="{!! asset("assets/js/jquery.validate.js") !!}"></script>

<script>
    $(function () {
        $.validator.addMethod("regex", function(value, element, regexp) {
            return regexp.test(value)
        }, 'hiii');

        $('#registerForm').validate({
            rules: {
                name: 'required',
                surname: 'required',
                email: {
                    required:true,
                    email:true
                },
                city: 'required',
                username: 'required',
                password: {
                    required: true,
                    regex: /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/
                }
            },
            messages: {
                name: 'Vendos emrin',
                surname: 'Vendosni mbiemrin',
                city: 'Zgjidhni qytetin',
                email: {
                    required: 'Vendosni emailin tuaj',
                    email: 'Emaili nuk eshte i vlefshem'
                },
                username: 'Vendosni nje username per llogarine tuaj',
                password: {
                    required: 'Vendosni nje fjalkalim per llogarine tuaj',
                    regex: 'Fjalkalimi jo i vlefshem'
                }
            },
            errorPlacement: function (error, element) {
                $.each(element, function () {
                    $(element).parent().find(".validate-error").html(error);
                })
            }
        });


        $("#register").click(function () {
            $("#registerForm").submit();
        });
    })
</script>
</body>

</html>

