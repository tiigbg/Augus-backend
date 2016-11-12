<!DOCTYPE html>
<html>
<head>
    <title>Laravel 5.3 Upload Image with Validation example</title>
    <link rel="stylesheet" href="http://getbootstrap.com/dist/css/bootstrap.css">
</head>
<body>
<div class="container">
<div class="panel panel-primary">
  <div class="panel-heading"><h2>Laravel 5.3 Upload Image with Validation example</h2></div>
  <div class="panel-body">
          @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
        </div>
        <img src="images/{{ Session::get('image') }}">
        @endif
    {!! Form::open(array('route' => 'postimage','files'=>true)) !!}
            <div class="row">
                <div class="col-md-6">
                    {!! Form::file('image_file', array('class' => 'form-control')) !!}
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-success">Upload</button>
                </div>
            </div>
    {!! Form::close() !!}
  </div>
</div>
</div>
</body>
</html>