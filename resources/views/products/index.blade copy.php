@extends('layouts.app')

@section('page-title','Products')

@section('content')

@php
function sort_link($column){
    $direction = request('direction') === 'asc' ? 'desc' : 'asc';

    return request()->fullUrlWithQuery([
        'sort' => $column,
        'direction' => $direction
    ]);
}
@endphp


<div class="">

<div class="">

<form method="GET" action="{{ route('products.index') }}">

<div class="row">

    <div class="col-3">

        {{-- <label class="form-label">Search</label> --}}

        <input
        type="text"
        name="name"
        value="{{ request('name') }}"
        class="form-control">

    </div>

{{-- <div class="filter-field">

<label class="form-label">SKU</label>

<input
type="text"
name="sku"
value="{{ request('sku') }}"
class="form-control">

</div> --}}

{{-- <div class="filter-field">

<label class="form-label">Status</label>

<select name="active" class="form-control">

<option value="">All</option>

<option value="1" {{ request('active') === "1" ? "selected" : "" }}>
Active
</option>

<option value="0" {{ request('active') === "0" ? "selected" : "" }}>
Inactive
</option>

</select>

</div> --}}

    <div class="col-3" style="">

        <label class="form-label">&nbsp;</label>

        <button type="submit" class="btn btn-primary filter-button">
        Filter
        </button>

    </div>

</div>

</form>

</div>

</div>


<div class="card">

<div class="row card-header d-flex justify-content-between">

<h5 class="mb-0">Products</h5>

<a
href="{{ route('products.create') }}"
class="btn btn-primary btn-sm">

New Product

</a>

</div>

<div class="card-body">

<div class="table-responsive">

<table class="table table-sm table-striped">

<thead>

<tr>

<th>
<a href="{{ sort_link('id') }}">ID</a>
</th>

<th>
<a href="{{ sort_link('name') }}">Name</a>
</th>

<th>
<a href="{{ sort_link('sku') }}">SKU</a>
</th>

<th>
<a href="{{ sort_link('price') }}">Price</a>
</th>

<th>
<a href="{{ sort_link('active') }}">Status</a>
</th>

<th></th>

</tr>

</thead>

<tbody>

@foreach($products as $product)

<tr>

<td>{{ $product->id }}</td>

<td>{{ $product->name }}</td>

<td>{{ $product->sku }}</td>

<td>${{ number_format($product->price,2) }}</td>

<td>

@if($product->active)
<span class="badge bg-success">Active</span>
@else
<span class="badge bg-danger">Inactive</span>
@endif

</td>

<td>

<a
href="{{ route('products.edit',$product->id) }}"
class="btn btn-sm btn-outline-secondary">
Edit
</a>

<form
action="{{ route('products.destroy',$product->id) }}"
method="POST"
style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-sm btn-outline-danger">
Delete
</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

<div class="mt-3">
{{ $products->appends(request()->query())->links() }}
</div>

</div>

</div>

@endsection