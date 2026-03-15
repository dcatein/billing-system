@php
    $currentSegment = explode('.', Route::currentRouteName())[0] ?? 'dashboard';

    $pageTitle = match($currentSegment) {
        'products'  => 'Produtos',
        'orders'    => 'Gestão de Vendas',
        'dashboard' => 'Painel',
        default     => ucfirst($currentSegment), // Fallback automático para novas páginas
    };
@endphp

<div class="page-title">
    <h1>{{ $pageTitle }}</h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Início</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ $pageTitle }}
            </li>
        </ol>
    </nav>
</div>
