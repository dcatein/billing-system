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
                        <a href="{{ route('products.create') }}" class="btn btn-primary ">
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
                                    <th data-sortable="true" class="col-1">
                                        <button class="datatable-sorter">
                                            #
                                        </button>
                                    </th>
                                    <th data-sortable="true" class="col-2">
                                        <a href="">Status</a>
                                    </th>

                                    <th data-sortable="true" class="col-2">
                                        <a href="">User</a>
                                    </th>
                                    <th data-sortable="true" class="col-1">
                                        <a href="">Customer</a>
                                    </th>
                                    <th data-sortable="true" class="col-1">
                                        <a href="">Subtotal</a>
                                    </th>
                                    <th class="col-1">
                                        <a href="">Desconto</a>
                                    </th>
                                    <th data-sortable="true" class="col-1">
                                        <a href="">Total</a>
                                    </th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($orders as $order)

                                    <tr data-index="0">
                                        <td>
                                            {{ $order->id }}
                                        </td>

                                        <td>
                                            {{ $order->status }}
                                        </td>

                                        <td>
                                            {{ $order->user_id }}
                                        </td>

                                        <td>
                                            {{ $order->customer_id }}
                                        </td>

                                        <td>
                                            {{ number_format($order->subtotal, 2) }}
                                        </td>

                                        <td>
                                            {{ $order->discount }}
                                        </td>

                                        <td>
                                            {{ number_format($order->total, 2) }}
                                        </td>

                                        <td>
                                            AÇÕES
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
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