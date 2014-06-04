@extends('layouts.default')

@section('main')

<h1 class="page-header">Все Идентификационные Номера
{{ link_to_route('ins.create', 'Добавить новый ИН', null, array('class' => 'btn btn-success pull-right')) }}
</h1>

@if(count($ins) > 0)

	@foreach($ins as $in)
	<div class="well">
		<label>ID:</label> {{$in['id']}}<br/> 
		<label>ИН:</label> {{$in['in']}}<br/> 
		<div class="col-md-2">
			{{ link_to_route('ins.edit', 'Редактировать', $in['id'], ['class' => 'btn btn-block btn-warning'])}}
		</div>
		<div class="col-md-2">
			{{ Form::open(['route' => ['ins.destroy', $in['id']], 'method' => 'DELETE']) }}
			{{ Form::submit('Удалить', array('class' => 'btn btn-danger btn-block'))}}
			{{ Form::close() }}
		</div>
		<div class="clearfix"></div>
	</div>
	@endforeach
@else
Нет пока ИН
@endif

@stop