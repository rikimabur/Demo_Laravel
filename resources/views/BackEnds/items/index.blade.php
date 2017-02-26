@extends('BackEnds.layouts.master')
 
@section('content')
	<div class="row">
	    <div class="col-lg-12 margin-tb">
	        <div class="pull-left">
	            <h2>Items CRUD</h2>
	        </div>
	        <div class="pull-right">
	        	@permission('item-create')
	            <a class="btn btn-success" href="{{ route('item.create') }}"> Create New Item</a>
	            @endpermission
	        </div>
	    </div>
	</div>
	@if ($message = Session::get('success'))
		<div class="alert alert-success">
			<p>{{ $message }}</p>
		</div>
	@endif
	@if(!empty($items))
	<table class="table table-bordered">
		<tr>
			<th>No</th>
			<th>Title</th>
			<th>Description</th>
			<th width="280px">Action</th>
		</tr>
	@foreach ($items as $key => $item)
	<tr>
		<td>{{ ++$i }}</td>
		<td>{{ $item->title }}</td>
		<td>{{ $item->description }}</td>
		<td>
			<a class="btn btn-info" href="{{ route('item.show',$item->id) }}">Show</a>
			@permission('item-edit')
			<a class="btn btn-primary" href="{{ route('item.edit',$item->id) }}">Edit</a>
			@endpermission
			@permission('item-delete')
			{!! Form::open(['method' => 'DELETE','route' => ['item.destroy', $item->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
        	{!! Form::close() !!}
        	@endpermission
		</td>
	</tr>
	@endforeach
	</table>
	{!! $items->render() !!}
	@endif
@endsection