@extends('layouts.app')

@section('page-title', 'Orders')

@section('content')

    @php
        function sort_link($column)
        {
            $direction = request('direction') === 'asc' ? 'desc' : 'asc';
            return request()->fullUrlWithQuery([
                'sort_by' => $column,
                'sort_direction' => $direction
            ]);
        }
    @endphp

    <div class="col-12">
        <form action="{{ route('orders.index') }}" method="GET" class="card shadow-lg mb-4">
            <div class="card-body">
                <div class="row g-3 align-items-end justify-content-between">

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Vendedor</label>
                        <div class="input-group">
                            <input type="text" name="user_id" class="form-control" placeholder="Código do vendedor" value="{{ request('user_id') }}">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="bi bi-search"></i> Pesquisar
                            </button>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select" onchange="this.form.submit()">
                            <option value="">Todos</option>
                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Pendente</option>
                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Cancelado</option>
                            <option value="2" {{ request('status') === '2' ? 'selected' : '' }}>Pago</option>
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

                    <div class="col-md-2 align-self-end">
                        <a href="{{ route('orders.create') }}" class="btn btn-primary w-100">
                            Nova Venda
                        </a>
                    </div>

                </div>
            </div>
        </form>

        <div class="card recent-sales overflow-auto shadow-lg">
            <div class="card-body">

                <div class="row justify-content-between">
                    <div class="col-4">
                        <h5 class="card-title">
                            Vendas<span>| Listagem</span>
                        </h5>
                    </div>
                </div>

                <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                    <div class="datatable-top">
                        <div class="datatable-dropdown">
                            <label>
                                <select name="" id="" class="datatable-selector">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                </select>
                                Itens exibidos
                            </label>
                        </div>
                        <div class="datatable-search">
                            <input type="search" placeholder="Pesquisar" title="Pesquisar na tabela"
                                class="datatable-input">
                        </div>
                    </div>
                    <div class="datatable-container">

                        <table class="table table-striped datatable datatable-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Status</th>
                                    <th>User</th>
                                    <th>Retirada</th>
                                    <th>Subtotal</th>
                                    <th>Desconto</th>
                                    <th>Total</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <!-- Linha principal -->
                                    <tr class="order-row" data-order-id="{{ $order->id }}">
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->status }}</td>
                                        <td>{{ $order->user->name ?? $order->user_id }}</td>
                                        <td>
                                            @if($order->pickup == 'store')
                                                Loja
                                            @endif

                                            @if($order->pickup == 'delivery')
                                                Delivery
                                            @endif

                                        </td>
                                        <td>R$ {{ number_format($order->subtotal, 2, ',', '.') }}</td>
                                        <td>
                                            @if($order->discount_type == 'percentual')
                                                {{ number_format($order->discount, 2, ',', '.') }}%
                                            @elseif($order->discount_type == 'valor')
                                                R$ {{ number_format($order->discount, 2, ',', '.') }}
                                            @endif
                                        </td>
                                        <td>R$ {{ number_format($order->total, 2, ',', '.') }}</td>
                                        <td>
                                            @if($order->status == 'pending')
                                                <a href="{{ route('orders.edit',
                                                    [$order->id, 'action' => 'pay']) }}"
                                                   class="btn btn-sm btn-success">Pagar</a>
                                            @endif


                                        </td>
                                    </tr>

                                    <!-- Linha oculta com os itens -->
                                    <tr class="order-items-row d-none" id="order-items-{{ $order->id }}">
                                        <td colspan="8">
                                            <table class="table table-sm mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Produto</th>
                                                        <th>Qtd</th>
                                                        <th>Unitário</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($order->items as $item)
                                                    <tr>
                                                        <td>
                                                            {{ $item->product->name ?? $item->description }}
                                                        </td>
                                                        <td>
                                                            {{ $item->quantity }}
                                                        </td>
                                                        <td>
                                                            {{ number_format($item->unit_price, 2, ',', '.') }}
                                                        </td>
                                                        <td>
                                                            {{ number_format($item->total, 2, ',', '.') }}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">Nenhum pedido encontrado</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                document.querySelectorAll('.order-row').forEach(function (row) {
                                    row.addEventListener('click', function () {
                                        const orderId = this.dataset.orderId;
                                        const itemsRow = document.getElementById('order-items-' + orderId);
                                        itemsRow.classList.toggle('d-none');
                                    });
                                });
                            });
                        </script>


                    </div>
                    <div class="datatable-info">
                        {{$orders->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
