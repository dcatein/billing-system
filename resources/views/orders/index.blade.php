@extends('layouts.app')

@section('page-title', 'Orders')

@section('content')

    @php
        function sort_link($column, $label)
        {
            $direction = request('sort_by') === $column && request('sort_direction') === 'asc' ? 'desc' : 'asc';
            $url = request()->fullUrlWithQuery([
                'sort_by' => $column,
                'sort_direction' => $direction
            ]);

            $indicator = '';
            if (request('sort_by') === $column) {
                $indicator = request('sort_direction') === 'asc' ? ' ▲' : ' ▼';
            }

            return '<a href="'.$url.'">'.$label.$indicator.'</a>';
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

                    <div class="col-md-1">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select" onchange="this.form.submit()">
                            <option value="">Todos</option>
                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Pendente</option>
                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Cancelado</option>
                            <option value="2" {{ request('status') === '2' ? 'selected' : '' }}>Pago</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Data de criação</label>
                        <div class="input-group">
                            <input type="date" name="created_at_start" class="form-control" value="{{ request('created_at_start') }}" aria-label="Início" onchange="this.form.submit()">
                            <input type="date" name="created_at_end" class="form-control" value="{{ request('created_at_end') }}" aria-label="Fim" onchange="this.form.submit()">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-bold">Exibir</label>
                        <select name="per_page" class="form-select" onchange="this.form.submit()">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 por página</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 por página</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 por página</option>
                        </select>
                    </div>

                    <div class="col-md-1 align-self-end">
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary w-100">
                            Limpar filtros
                        </a>
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
                    <div class="datatable-container">

                        <table class="table table-striped datatable datatable-table">
                            <thead>
                                <tr>
                                    <th>{!! sort_link('id', '#') !!}</th>
                                    <th>{!! sort_link('status', 'Status') !!}</th>
                                    <th>{!! sort_link('user_id', 'Vendedor') !!}</th>
                                    <th>{!! sort_link('pickup', 'Retirada') !!}</th>
                                    <th>{!! sort_link('subtotal', 'Subtotal') !!}</th>
                                    <th>{!! sort_link('discount', 'Desconto') !!}</th>
                                    <th>{!! sort_link('total', 'Total') !!}</th>
                                    <th>{!! sort_link('created_at', 'Data da Venda') !!}</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <!-- Linha principal -->
                                    <tr class="order-row" data-order-id="{{ $order->id }}">
                                        <td>{{ $order->id }}</td>
                                        <td>
                                            @if($order->status == 'paid')
                                                Pago
                                            @elseif($order->status == 'cancelled')
                                                Cancelado
                                            @elseif($order->status == 'pending')
                                                Pendente
                                            @endif
                                        </td>
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
                                        <td>{{ ($order->created_at)->format('d/m/Y')  }}</td>
                                        <td>
                                            @if($order->status == 'pending')
                                                <a href="{{ route('orders.edit',
                                                    [$order->id, 'action' => 'pay']) }}"
                                                   class="btn btn-sm btn-success">Pagar
                                                </a>

                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#cancelModal"
                                                    data-order-id="{{ $order->id }}">
                                                    Cancelar
                                                </button>
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

 @include('orders.partials.cancel-modal')

@endsection
