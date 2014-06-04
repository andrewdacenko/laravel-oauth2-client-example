@extends('layouts.default')

@section('main')
<h1 class="page-header">Добавление нового Предприятия</h1>

@include('misc.errors')

{{Form::open(array( 'action' => 'UsreousController@store', 'class' => 'form-horizontal'), 'POST', null , false)}}

<div class="form-group">
	{{Form::label('organization', 'Организация', array('class' => 'col-sm-3 control-label')) }}
	<div class="col-sm-9">
		{{Form::input('text', 'organization', Input::old('organization'), array('class' => 'form-control')) }}
	</div>
</div>

<div class="form-group">
	{{Form::label('in_id', 'ИН', array('class' => 'col-sm-3 control-label'))}}
	<div class="col-sm-9">
		{{Form::select('in_id', $ins, Input::old('in_id'), array('class' => 'form-control')) }}
	</div>
</div>

<div class="form-group">
	{{Form::label('address_id', 'Адрес', array('class' => 'col-sm-3 control-label'))}}
	<div class="col-sm-9">
		{{Form::select('address_id', $addresses, Input::old('address_id'), array('class' => 'form-control')) }}
	</div>
</div>

<div class="form-group">
	{{Form::label('ceo', 'ФИО руководителя', array('class' => 'col-sm-3 control-label'))}}
	<div class="col-sm-9">
		{{Form::input('text', 'ceo', Input::old('ceo'), array('class' => 'form-control')) }}
	</div>
</div>

<div class="form-group">
	{{Form::label('phone', 'Контактный телефон', array('class' => 'col-sm-3 control-label'))}}
	<div class="col-sm-9">
		{{Form::input('text', 'phone', Input::old('phone'), array('class' => 'form-control')) }}
	</div>
</div>

<div class="form-group">
	{{Form::label('fax', 'Факс', array('class' => 'col-sm-3 control-label'))}}
	<div class="col-sm-9">
		{{Form::input('text', 'fax', Input::old('fax'), array('class' => 'form-control')) }}
	</div>
</div>

<div class="form-group">
	{{Form::label('email', 'E-mail', array('class' => 'col-sm-3 control-label'))}}
	<div class="col-sm-9">
		{{Form::input('text', 'email', Input::old('email'), array('class' => 'form-control')) }}
	</div>
</div>

<div class="form-group">
	{{Form::label('registry_id', 'Регистратор', array('class' => 'col-sm-3 control-label'))}}
	<div class="col-sm-9">
		{{Form::select('registry_id', $registries, Input::old('registry_id'), array('class' => 'form-control')) }}
	</div>
</div>

<div class="form-group">
	{{Form::label('activity_id', 'Вид деятельности', array('class' => 'col-sm-3 control-label'))}}
	<div class="col-sm-9">
		{{Form::select('activity_id', $activities, Input::old('activity_id'), array('class' => 'form-control')) }}
	</div>
</div>

<div class="form-group">
	<div class="col-sm-3">
		{{Form::submit('Добавить', array('class' => 'btn btn-success'))}}
	</div>
</div>

{{Form::close()}}

@stop
