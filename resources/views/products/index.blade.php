@extends('layouts.app')

@section('page-title', 'Produtos')

@section('content')

@php
function sort_link($column)
{
    $direction = request('direction') === 'asc' ? 'desc' : 'asc';
    return request()->fullUrlWithQuery([
        'sort' => $column,
        'direction' => $direction
    ]);
}
@endphp

<div class="col-12">
    <form action="{{ route('products.index') }}" method="GET" class="card shadow-lg mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                
                <div class="col-md-5">
                    <label class="form-label fw-bold">Buscar produto</label>
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Nome ou SKU..." value="{{ request('search') }}">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="bi bi-search"></i> Pesquisar
                        </button>
                    </div>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">Todos</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Ativo</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inativo</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-bold">Exibir</label>
                    <select name="per_page" class="form-select" onchange="this.form.submit()">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 por página</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 por página</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 por página</option>
                    </select>
                </div>

                <div class="col-md-2 text-end">
                    <a href="{{ route('products.create') }}" class="btn btn-primary w-100">
                        Novo Produto
                    </a>
                </div>

            </div>
        </div>
    </form>

    <div class="card recent-sales overflow-auto shadow-lg">
        <div class="card-body">
            <h5 class="card-title">Produtos <span>| Listagem</span></h5>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="col-5">
                                <a href="{{ sort_link('name') }}">Nome</a>
                            </th>
                            <th class="col-2">
                                <a href="{{ sort_link('sku') }}">SKU</a>
                            </th>
                            <th class="col-2">
                                <a href="{{ sort_link('price') }}">Preço</a>
                            </th>
                            <th class="col-1">
                                <a href="{{ sort_link('active') }}">Status</a>
                            </th>
                            <th class="col-1 text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td>{{ Str::limit($product->name, 30, '...') }}</td>
                            <td>{{ $product->sku }}</td>
                            <td>R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                            <td>
                                @if($product->active)
                                    <span class="badge bg-success rounded-pill">Ativo</span>
                                @else
                                    <span class="badge bg-secondary rounded-pill">Inativo</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary">
                                    Editar
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Nenhum produto encontrado</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted small">
                    Exibindo {{ $products->firstItem() ?? 0 }} a {{ $products->lastItem() ?? 0 }} de {{ $products->total() }} registros
                </div>
                <div>
                    {{ $products->links() }}
                </div>
            </div>

        </div>
    </div>
</div>

@endsection