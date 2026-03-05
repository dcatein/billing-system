@extends('layouts.app')

@section('page-title','Dashboard')

@section('content')
 
 <section class="section dashboard">
      <div class="row">
        <div class="col-lg-8">
          <div class="row">
            <!-- ****** Card de vendas ****** -->
            <div class="col-xxl-4 col-md-6">
              <div class="card shadow-lg info-card sales-card">
                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-three-dots">
                    </i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow shadow-lg"
                    style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 30px);"
                    data-popper-placement="bottom-end">
                    <li class="dropdown-header text-start">
                      <h5>Filtro</h5>
                    </li>
                    <hr>
                    <li>
                      <a href="#" class="dropdown-item">Dia</a>
                    </li>
                    <hr>
                    <li>
                      <a href="#" class="dropdown-item">Mês</a>
                    </li>
                    <hr>
                    <li>
                      <a href="#" class="dropdown-item">Ano</a>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                  <h5 class="card-title">Vendas
                    <span>| Dia</span>
                  </h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart fs-1"></i>
                    </div>
                    <div class="ps-3">
                      <h6>200 <span class="text-secondary"> Peças</span></h6>
                      <span class="text-sucess small pt-1 fw-bold">20%</span>
                      <i class="bi bi-caret-up-fill text-success"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- ****** Fim do card de vendas ****** -->
            <!-- ****** Card de receita ****** -->
            <div class="cal-xxl-4 col-md-6">
              <div class="card shadow-lg revenue-card info-card sales-card">
                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-three-dots">
                    </i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow shadow-lg"
                    style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 30px);"
                    data-popper-placement="bottom-end">
                    <li class="dropdown-header text-start">
                      <h5>Filtro</h5>
                    </li>
                    <hr>
                    <li>
                      <a href="#" class="dropdown-item">Dia</a>
                    </li>
                    <hr>
                    <li>
                      <a href="#" class="dropdown-item">Mês</a>
                    </li>
                    <hr>
                    <li>
                      <a href="#" class="dropdown-item">Ano</a>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                  <h5 class="card-title">Receita
                    <span>| Mês</span>
                  </h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-currency-dollar fs-1"></i>
                    </div>
                    <div class="ps-3">
                      <h6><span class="text-secondary bi bi-currency-dollar"></span>5,985 </h6>
                      <span class="small pt-1 fw-bold">50%</span>
                      <i class="bi bi-caret-down-fill text-danger"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- ****** Fim do card de receita ****** -->
            <!-- ****** Card de vendas recentes ****** -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto shadow-lg">
                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-three-dots">
                    </i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow shadow-lg"
                    style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 30px);"
                    data-popper-placement="bottom-end">
                    <li class="dropdown-header text-start">
                      <h5>Filtro</h5>
                    </li>
                    <hr>
                    <li>
                      <a href="#" class="dropdown-item">Dia</a>
                    </li>
                    <hr>
                    <li>
                      <a href="#" class="dropdown-item">Mês</a>
                    </li>
                    <hr>
                    <li>
                      <a href="#" class="dropdown-item">Ano</a>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                  <h5 class="card-title">
                    Vendas recentes
                    <span>| Dia</span>
                  </h5>
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
                      <table class="table table-hover datatable datatable-table">
                        <thead>
                          <tr>
                            <th data-sortable="true" style="width: 5%;">
                              <button class="datatable-sorter">
                                #
                              </button>
                            </th>
                            <th data-sortable="true" style="width: 15%;">
                              <button class="datatable-sorter">
                                Cliente
                              </button>
                            </th>
                            <th data-sortable="true" style="width: 30%;">
                              <button class="datatable-sorter">
                                Produto
                              </button>
                            </th>
                            <th data-sortable="true" style="width: 15%;">
                              <button class="datatable-sorter">
                                Preço
                              </button>
                            </th>
                            <th data-sortable="true" style="width: 5%;">
                              <button class="datatable-sorter">
                                Un
                              </button>
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr data-index="0">
                            <td>
                              <a href="#">#0000</a>
                            </td>
                            <td>Marcos</td>
                            <td>
                              <a href="#">Suporte Radiador Corsa 02/ Montana 04/ Le</a>
                            </td>
                            <td>R$ 129,90</td>
                            <td>1 Un</td>
                          </tr>
                          <tr data-index="0">
                            <td>
                              <a href="#">#0000</a>
                            </td>
                            <td>Carlos</td>
                            <td>
                              <a href="#">Acabamento Paralama Onix 20/23 Esquerdo</a>
                            </td>
                            <td>R$ 79,90</td>
                            <td>1 Un</td>
                          </tr>
                          <tr data-index="0">
                            <td>
                              <a href="#">#0000</a>
                            </td>
                            <td>Flávio</td>
                            <td>
                              <a href="#">Capo 500 08/15</a>
                            </td>
                            <td>R$ 945,90</td>
                            <td>1 Un</td>
                          </tr>
                          <tr data-index="0">
                            <td>
                              <a href="#">#0000</a>
                            </td>
                            <td>Marllon</td>
                            <td>
                              <a href="#">Paralama Sprinter 03/12 Direito</a>
                            </td>
                            <td>R$ 1379,90</td>
                            <td>1 Un</td>
                          </tr>
                          <tr data-index="0">
                            <td>
                              <a href="#">#0000</a>
                            </td>
                            <td>Davidson</td>
                            <td>
                              <a href="#">Porta Duster Dianteira 2010 A 2020 Lado Direito - Passageiro</a>
                            </td>
                            <td>R$ 600,90</td>
                            <td>1 Un</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="datatable-info">Exibindo itens de 1 a 5</div>
                    <nav class="datatale-pagination">
                      <ul class="datatable-pagination-list"></ul>
                    </nav>
                  </div>
                </div>
              </div>
            </div>
            <!-- ****** Fim card de vendas recentes ****** -->
          </div>
        </div>
        <!-- ****** Card top vendas ****** -->
        <div class="col-lg-4">
          <div class="card top-selling overflow-auto shadow-lg">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown">
                <i class="bi bi-three-dots">
                </i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow shadow-lg"
                style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 30px);"
                data-popper-placement="bottom-end">
                <li class="dropdown-header text-start">
                  <h5>Filtro</h5>
                </li>
                <hr>
                <li>
                  <a href="#" class="dropdown-item">Dia</a>
                </li>
                <hr>
                <li>
                  <a href="#" class="dropdown-item">Mês</a>
                </li>
                <hr>
                <li>
                  <a href="#" class="dropdown-item">Ano</a>
                </li>
              </ul>
            </div>
            <div class="card-body pb-0">
              <h5 class="card-title">
                Top vendas
                <span>| Dia</span>
              </h5>
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th style="width: 40%;" scope="col">Produto</th>
                    <th scope="col">Preço</th>
                    <th scope="col">Un</th>
                    <th scope="col">Receita</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th>
                      <a href="#">Paralama Sprinter 03/12 Direito</a>
                    </th>
                    <td>R$ 129,90</td>
                    <td class="fw-bold">7</td>
                    <td>R$ 9659,30</td>
                  </tr>
                  <tr>
                    <th>
                      <a href="#">Capo 500 08/15</a>
                    </th>
                    <td>R$ 945,90</td>
                    <td class="fw-bold">5</td>
                    <td>R$ 4729,50</td>
                  </tr>
                  <tr>
                    <th>
                      <a href="#">Pneu - Aro 16 - Marca</a>
                    </th>
                    <td>R$ 150,00</td>
                    <td class="fw-bold">26</td>
                    <td>R$ 3900,00</td>
                  </tr>
                  <tr>
                    <th>
                      <a href="#">Porta Duster Dianteira 2010 A 2020 Lado Direito - Passageiro</a>
                    </th>
                    <td>R$ 600,90</td>
                    <td class="fw-bold">2</td>
                    <td>R$ 1201,08</td>
                  </tr>
                  <tr>
                    <th>
                      <a href="#">Acabamento Paralama Onix 20/23 Esquerdo</a>
                    </th>
                    <td>R$ 79,90</td>
                    <td class="fw-bold">3</td>
                    <td>R$ 239,70</td>
                  </tr>
                  <tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- ****** Fim card top vendas ****** -->
      </div>
    </section>


@endsection