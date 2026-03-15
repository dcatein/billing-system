@extends('layouts.app')

@section('page-title', 'Edit Product')

@section('content')

<div class="card">

    <div class="card-header">
        <h5>Edit Product</h5>
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('products.update', $product->id) }}">

            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-5">

                    <label class="form-label">Nome</label>

                    <input 
                        type="text"
                        name="name"
                        value="{{ old('name', $product->name) }}"
                        class="form-control @error('name') is-invalid @enderror"
                        required
                    >

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="col-md-3">

                    <label class="form-label">SKU</label>

                    <input 
                        type="text"
                        name="sku"
                        value="{{ old('sku', $product->sku) }}"
                        class="form-control @error('sku') is-invalid @enderror"
                    >

                        @error('sku')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                </div>

                <div class="col-md-2">

                    <label class="form-label">Preço</label>

                    <input 
                        type="number"
                        step="0.01"
                        name="price"
                        value="{{ old('price', $product->price) }}"
                        class="form-control @error('price') is-invalid @enderror"
                        required
                    >

                    @error('price')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="col-md-2">

                    <label class="form-label d-block">Status</label>

                    <div class="form-check form-switch">

                        <input type="hidden" name="active" value="0">

                        <input 
                            type="checkbox"
                            name="active"
                            value="1"
                            class="form-check-input"
                            {{ old('active', $product->active) ? 'checked' : '' }}
                        >

                        <label class="form-check-label">
                            Ativo
                        </label>

                    </div>

                </div>

            </div>

            <div class="mt-4">

                <button class="btn btn-primary">
                    Atualizar
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
