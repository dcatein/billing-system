@extends('layouts.app')

@section('page-title', 'Orders')

@section('content')


    <div class="col-12">
        <div class="card recent-sales overflow-auto shadow-lg">
            <div class="card-body">

                <div class="row justify-content-between">
                    <div class="col-4">
                        <h5 class="card-title">
                            Vendas<span>| Loja</span>
                        </h5>
                    </div>

                    <div class="col-4 p-2">
                        <a href="{{ route('orders.create') }}" class="btn btn-primary ">
                            Nova Venda
                        </a>
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
                                    <th>Customer</th>
                                    <th>Subtotal</th>
                                    <th>Desconto</th>
                                    <th>Total</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <!-- Linha principal -->
                                    <tr class="order-row" data-order-id="{{ $order->id }}">
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->status }}</td>
                                        <td>{{ $order->user->name ?? $order->user_id }}</td>
                                        <td>{{ $order->customer->name ?? $order->customer_id }}</td>
                                        <td>{{ number_format($order->subtotal, 2, ',', '.') }}</td>
                                        <td>{{ number_format($order->discount, 2, ',', '.') }}</td>
                                        <td>{{ number_format($order->total, 2, ',', '.') }}</td>
                                        <td>
                                            <a href="{{ route('orders.edit', $order->id) }}"
                                                class="btn btn-sm btn-primary">Editar</a>
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
                                @endforeach
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
                        Exibindo itens de 1 a 15
                        <nav class="datatale-pagination">
                            <ul class="pagination datatable-pagination-list">
                                <li class="page-item"><a href="#" class="page-link">Anterior</a></li>
                                <li class="page-item"><a href="#" class="page-link">1</a></li>
                                <li class="page-item"><a href="#" class="page-link">2</a></li>
                                <li class="page-item"><a href="#" class="page-link">3</a></li>
                                <li class="page-item"><a href="#" class="page-link">Proximo</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection