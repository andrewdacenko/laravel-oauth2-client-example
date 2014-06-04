@extends('layouts.default')

@section('main')

<h1 class="page-header">Все Предприятия
{{ link_to_route('usreous.create', 'Добавить новое Предприятие', null, array('class' => 'btn btn-success pull-right')) }}
</h1>

@if(count($usreous) > 0)

	@foreach($usreous as $usreou)
	<div class="well">
		<label>ID:</label> {{$usreou['id']}}<br/> 
		<label>Предприятие:</label> "{{$usreou['organization']}}"<br/> 
		<label>Руководитель:</label> {{$usreou['ceo']}}<br/>
		<label>ИН:</label> {{$usreou['in']['in']}}<br/>
		<label>Адрес:</label> {{$usreou['address']['name']}}, г.{{$usreou['address']['city']['name']}}, {{$usreou['address']['city']['region']['name']}} обл.<br/>
		<label>Телефон:</label> {{$usreou['phone']}}<br/>
		<label>Факс:</label> {{$usreou['fax']}}<br/>
		<label>E-mail:</label> {{$usreou['email']}}<br/>
		<label>Регистратор:</label> {{$usreou['registry']['name']}}, {{$usreou['registry']['address']['name']}}, г.{{$usreou['registry']['address']['city']['name']}}, {{$usreou['registry']['address']['city']['region']['name']}} обл.<br/>
		<label>Последняя выписка:</label>
			@foreach($usreou['in']['last_extract'] as $extract)
			{{$extract['series']}} {{$extract['name']}} {{$extract['created_at']}}
			@endforeach
			<br/>
		<label>Виды деятельности:</label> 
			@foreach($usreou['activities'] as $activity)
			{{$activity['name']}} 
			@endforeach
			<br/>
			<br/>
		<div class="col-md-2">
			{{ link_to_route('usreous.edit', 'Редактировать', $usreou['id'], ['class' => 'btn btn-block btn-warning'])}}
		</div>
		<div class="col-md-2">
			{{ Form::open(['route' => ['usreous.destroy', $usreou['id']], 'method' => 'DELETE']) }}
			{{ Form::submit('Удалить', array('class' => 'btn btn-danger btn-block'))}}
			{{ Form::close() }}
		</div>
		<div class="clearfix"></div>
	</div>
	@endforeach
@else
Нет пока предприятий
@endif

@stop