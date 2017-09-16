<ul class="nav navbar-right top-nav">

    @if(\App\Http\Controllers\Utils::getRole() == \App\Http\Controllers\Classes\LoginClass::KLIENT)
        <li>
            <a href="{!! \Illuminate\Support\Facades\URL::route('krjomsg') !!}">
                <i class="fa fa-envelope-o"></i>
            </a>
        </li>
        <li>
            <a href="{!! \Illuminate\Support\Facades\URL::route('view_card') !!}">
                <i class="fa fa-shopping-cart"></i>
            </a>
        </li>
    @endif

    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {!! \App\Http\Controllers\Utils::getUsername() !!} <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li><a href="{!! URL::route('logout') !!}">Logout</a></li>
        </ul>
    </li>
</ul>

<div class=" collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">

        @if(\App\Http\Controllers\Utils::getRole() == \App\Http\Controllers\Classes\LoginClass::ADMIN)
        <li class="">
            <a href="{!! URL::route('dashboard') !!}"><i class="fa fa-fw fa-dashboard"></i> Dashboard </a>
        </li>

        <li class="">
            <a href="{!! URL::route('listRaporte') !!}"><i class="fa fa-fw fa-line-chart"></i> Raporte </a>
        </li>
        <li class="">
            <a href="{!! URL::route('viewZhaner') !!}">
                <i class="fa fa-fw fa-th-list"></i> Kategorite
            </a>
        </li>
        <li class="">
            <a href="{!! URL::route('viewAutor') !!}">
                <i class="fa fa-user-circle"></i> Autoret
            </a>
        </li>
        @endif
        <li class="">
            <a href="{!! URL::route('listLibrat') !!}"><i class="fa fa-fw fa-book"></i> Librat </a>
        </li>
        @if(\App\Http\Controllers\Utils::getRole() <= \App\Http\Controllers\Classes\LoginClass::PUNONJES)
        <li class="">
            <a href="{!! URL::route('listKlient') !!}"><i class="fa fa-fw fa-users"></i> Klientët </a>
        </li>
        @endif
        {{--<li class="">--}}
            {{--<a href="{!! URL::route('listUsers') !!}"><i class="fa fa-fw fa-users"></i> Përdoruesit </a>--}}
        {{--</li>--}}
    </ul>

    <!-- /.modal -->
    <script>
        $(document).ready(function(){
            $('.navbar-ex1-collapse ul li:first-child').addClass("active");

            $('.navbar-ex1-collapse li').click(function() {
                $(this).siblings('li').removeClass('active');
                $(this).addClass('active');
            });
        });
    </script>
</div>
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Default Modal</h4>
            </div>
            <div class="modal-body">
                <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
    <!-- /.modal-dialog -->


