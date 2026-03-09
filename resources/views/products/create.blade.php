@extends('layouts.app')

@section('page-title', 'Create Product')

@section('content')

<div class="card">

    <div class="card-header">
        <h5>Novo Produto</h5>
    </div>

    <div class="card-body">

        {{-- Erros de validação --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Mensagem de erro --}}
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- Mensagem de sucesso --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('products.store') }}">

            @csrf

            <div class="row">

                <div class="col-md-6">

                    <label class="form-label">Nome</label>

                    <input 
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
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
                        value="{{ old('sku') }}"
                        class="form-control @error('sku') is-invalid @enderror"
                    >

                    @error('sku')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="col-md-2">

                    <label class="form-label">Price</label>

                    <input 
                        type="number"
                        step="0.01"
                        name="price"
                        value="{{ old('price') }}"
                        class="form-control @error('price') is-invalid @enderror"
                        required
                    >

                    @error('price')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>

            <div class="mt-4">

                <button class="btn btn-primary">
                    Salvar
                </button>

            </div>

        </form>

    </div>

</div>

@endsection