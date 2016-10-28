<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gestion de Tareas</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{asset('assets/landing/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{asset('assets/landing/css/landing-page.css')}}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{asset('assets/landing/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<!-- Header -->

<div class="intro-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-6">
                <div class="intro-message">
                    <h1>Gestion de Tareas</h1>
                    <h3>Planifica tu tiempo</h3>
                    <a href="{{url('callendar') }}" class="btn btn-info btn-outline"><i class="fa fa-eye fa-fw" aria-hidden="true"></i> <span class="network-name">Calendario</span></a>
                    <hr class="intro-divider">

                    <ul class="list-inline intro-social-buttons">
                        <li>

                                <div class="form-group">
                                    {!! Form::email('email',null,['class'=>'form-control','placeholder'=>'Correo','autofocus']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::password('password',['class'=>'form-control','placeholder'=>'Contraseña']) !!}
                                </div>
                                <div class="form-inline">
                                    <div class="form-group">
                                        {!! Form::checkbox('remember',null) !!}
                                        {!! Form::label('remember','Recordarme') !!}
                                    </div>
                                </div>

                        </li>

                    </ul>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container -->

</div>


<!-- jQuery -->
<script src="{{asset('assets/landing/js/jquery.js')}}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{asset('assets/landing/js/bootstrap.min.js')}}"></script>

</body>

</html>
