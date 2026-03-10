<div class="page-title">
  <h1>
    @if(Route::is('products.*')) Produtos 
    @elseif(Route::is('orders.*')) Vendas 
    @else Painel 
    @endif
  </h1>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Início</a></li>
      <li class="breadcrumb-item active" aria-current="page">
        {{ Route::is('products.*') ? 'Produtos' : (Route::is('orders.*') ? 'Vendas' : 'Painel') }}
      </li>
    </ol>
  </nav>
</div>