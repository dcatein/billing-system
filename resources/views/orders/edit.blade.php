@extends('layouts.app')

@section('page-title', 'Edit Order')

@section('content')

    <div class="card">
        <div class="card-header">
            <h5>Editar Venda</h5>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('orders.pay', $fullOrder['id']) }}">
                @csrf
                @method('PUT')

                <!-- Exibir dados da Order -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Vendedor</label>
                        <p>{{ $fullOrder['user']['name'] }}</p>
                    </div>
                </div>

                <!-- Produtos -->
                <div class="row mb-3">
                    <div class="table-responsive">
                        <h5>Itens adicionados</h5>
                        <table class="table table-sm table-striped">
                            <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Unitário</th>
                                <th>Qtd</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($fullOrder['items'] as $item)
                                <tr>
                                    <td>{{ $item['product']['name'] ?? 'Não informado' }}</td>
                                    <td>R$ {{ number_format($item['unit_price'], 2, ',', '.') }}</td>
                                    <td>{{ $item['quantity'] }}</td>
                                    <td>R$ {{ number_format($item['total'], 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <h5>Pagamentos</h5>
                <!-- Desconto e Total -->
                <div class="row mb-3">
                    <div class="col-md-1">
                        <label class="form-label">Desconto</label>
                        <p>
                            @if($fullOrder['discount_type'] == 'percentual')
                                {{ number_format($fullOrder['discount'], 2, ',', '.') }}%
                            @elseif($fullOrder['discount_type'] == 'valor')
                                R$ {{ number_format($fullOrder['discount'], 2, ',', '.') }}
                            @else
                                0
                            @endif
                        </p>


                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Total</label>
                        <p>{{ $fullOrder['total'] }}</p>
                    </div>
                </div>

                <input type="hidden" id="subtotal-hidden" name="subtotal" value={{$fullOrder['subtotal']}}>
                <input type="hidden" id="total-hidden" name="total" value={{$fullOrder['total']}}>
                <!-- Pagamentos -->
                @include('orders.partials.payments')

                <div class="mt-4">
                    <button class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>

@endsection
