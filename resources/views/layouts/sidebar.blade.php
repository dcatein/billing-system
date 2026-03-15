<aside class="collapse collapse-horizontal collapse-expand sidebar" id="sidebar">
    <ul class="sidebar-nav list-unstyled" id="sidebar-nav">
      <li class="nav-item">
        <a href="{{ route('dashboard') }}" class="nav-link">
          <i class="bi bi-grid"></i>
          <span>Painel</span>
        </a>
      </li>
      <hr>
      <li class="nav-item">
        <a href="{{route('orders.index')}}" class="nav-link">
          <i class="bi bi-coin"></i>
          <span>Vendas</span>
        </a>
      </li>
      <hr>
      <li class="nav-item">
        <a href="{{route('products.index')}}" class="nav-link">
          <i class="bi bi-box"></i>
          <span>Produtos</span>
        </a>
      </li>
      <hr>
    </ul>
  </aside>
