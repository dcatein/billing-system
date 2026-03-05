@extends('layouts.app')

@section('page-title', 'Products')

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
    <div class="card recent-sales overflow-auto shadow-lg">
      <div class="card-body">

        <div class="row justify-content-between">
          <div class="col-4">
            <h5 class="card-title">
              Produtos<span>| Loja</span>
            </h5>
          </div>

          <div class="col-4 p-2">
            <a href="{{ route('products.create') }}" class="btn btn-primary ">
              Novo Produto
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
              <input type="search" placeholder="Pesquisar" title="Pesquisar na tabela" class="datatable-input">
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
                  <th data-sortable="true" class="col-5">
                    <a href="{{ sort_link('name') }}">Name</a>
                  </th>

                  <th data-sortable="true" class="col-2">
                    <a href="{{ sort_link('sku') }}">SKU</a>
                  </th>
                  <th data-sortable="true" class="col-1">
                    <a href="{{ sort_link('price') }}">Preço</a>
                  </th>
                  {{-- <th data-sortable="true" style="width: 5%;">
                    <button class="datatable-sorter">
                      Unidades
                    </button>
                  </th> --}}

                  <th class="col-1">
                    <a href="{{ sort_link('active') }}">Status</a>
                  </th>

                  <th></th>
                </tr>
              </thead>

              <tbody>

                @foreach($products as $product)

                  <tr data-index="0">
                    <td>
                      {{ $product->id }}
                    </td>

                    <td>
                      {{ $product->name }}
                    </td>

                    <td>
                      {{ $product->sku }}
                    </td>

                    <td>
                      {{ number_format($product->price, 2) }}
                    </td>

                    <td>
                      @if($product->active)
                        <span class="badge bg-success">Active</span>
                      @else
                        <span class="badge bg-danger">Inactive</span>
                      @endif
                    </td>

                    <td>
                      <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-secondary">
                        Edit
                      </a>

                      <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-sm btn-outline-danger">
                          Delete
                        </button>

                      </form>

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