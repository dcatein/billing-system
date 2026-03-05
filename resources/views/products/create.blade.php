@extends('layouts.app')

@section('page-title', 'Create Product')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5>Novo Produto</h5>

        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('products.store') }}">

                @csrf

                <div class="row">

                    <div class="col-md-6">

                        <label class="form-label">Nome</label>

                        <input type="text" name="name" class="form-control" required>

                    </div>

                    <div class="col-md-3">

                        <label class="form-label">SKU</label>

                        <input type="text" name="sku" class="form-control">

                    </div>

                    <div class="col-md-2">

                        <label class="form-label">Price</label>

                        <input type="number" step="0.01" name="price" class="form-control" required>

                    </div>

                </div>

                <div class="mt-4">

                    <button class="btn btn-primary">

                        Salvar

                    </button>

                </div>

            </form>

        </div>


@endsection