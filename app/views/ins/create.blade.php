@extends('layouts.default')

@section('main')
<h1 class="page-header">Добавление нового ИН</h1>

@include('misc.errors')

{{Form::open(array( 'action' => 'InsController@store', 'class' => 'form-horizontal'), 'POST', null , false)}}

<div class="form-group">
	{{Form::label('in', 'Идентификационный Номер', array('class' => 'col-sm-3 control-label')) }}
	<div class="col-sm-9">
		{{Form::input('text', 'in', Input::old('in'), array('class' => 'form-control')) }}
	</div>
</div>

<div class="form-group">
	<div class="col-sm-3">
		{{Form::submit('Добавить', array('class' => 'btn btn-success'))}}
	</div>
</div>

{{Form::close()}}

@stop
