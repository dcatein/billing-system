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

                    <div class="col-md-6">

                        <label class="form-label">Nome</label>

                        <input type="text" name="name" value="{{ $product->name }}" class="form-control" required>

                    </div>

                    <div class="col-md-3">

                        <label class="form-label">SKU</label>

                        <input type="text" name="sku" value="{{ $product->sku }}" class="form-control">

                    </div>

                    <div class="col-md-2">

                        <label class="form-label">Preço</label>

                        <input type="number" step="0.01" name="price" value="{{ $product->price }}" class="form-control">

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