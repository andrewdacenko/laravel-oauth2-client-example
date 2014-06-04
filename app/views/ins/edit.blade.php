@extends('layouts.default')

@section('main')
<h1 class="page-header">Редактирование ИН</h1>

@include('misc.errors')

{{Form::model($in, array('route' => ['ins.update', $in['id']], 'class' => 'form-horizontal', 'method' => 'PUT'))}}

<div class="form-group">
	{{Form::label('in', 'Идентификационный Номер', array('class' => 'col-sm-3 control-label')) }}
	<div class="col-sm-9">
		{{Form::input('text', 'in', Input::old('in', $in['in']), array('class' => 'form-control')) }}
	</div>
</div>

<div class="form-group">
	<div class="col-sm-9 col-md-offset-3">
		{{Form::submit('Сохранить', array('class' => 'btn btn-success'))}}
		{{ link_to_route('ins.index', 'Отмена', null, ['class' => 'btn btn-default']) }}
	</div>
</div>

{{Form::close()}}

@stop
