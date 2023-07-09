@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gestão do Sistema</h1>
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Empresas</button>
          <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Gerir Anos</button>
        </div>
      </nav>
      <div class="tab-content" id="nav-tabContent">
        <!-- ALL COMPANIES -->
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <br>
            <h3>Todas Empresas</h3>
            <hr>
            @auth
                <a class="btn btn-primary btn-sm" href="{{ route('register') }}">Nova Empresa</a>
            @endauth
            <hr>
        
            <div  class="col-8">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th class="text-center" colspan="3" style="width:15%">Acções</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $company)
                            <tr>
                                <td>EMP{{$company->id}}</td>
                                <td>{{$company->name}}</td>
                                <td>{{$company->email}}</td>
                                <td>
                                    <a type="submit" class="btn btn-primary btn-sm" href="{{ route('admin.companie.show', $company->id)}}" ><i class="fa fa-eye"></i></a>
                                </td>
                                <td>  
                                    <button class="btn btn-danger btn-sm" type="button" data-toggle="modal" data-target="#modalTarget{{$company->id}}">  
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach 
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END ALL COMPANIES -->

        <!-- ALL YEARS -->
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <br>
            <h3>Abrir novo ano</h3>
            <hr>
            <form method="POST" action="{{ route('admin.year.store') }}" >
                {!! csrf_field()!!}
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="inputProduct">Ano<span class="required_field">*</span></label>
                        <input type="number" name="year" class="form-control" id="inputYear" placeholder="Introduza o ano a adicionar">
                    </div>
                    <div class="form-group col-md-4">
                        <button style="margin-top: 22px;" type="submit" class="btn btn-success" >Adicionar</button>
                    </div>
                </div>
            </form>
            <h3>Anos anteriores</h3>
            <div class="col-8">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Ano</th>
                            <th class="text-center" colspan="3" style="width:15%">Acções</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($years as $year)
                            <tr>
                                <td>{{$year->id}}</td>
                                <td>
                                    {{$year->year}}
                                </td>
                                <td  class="text-center">
                                    <a type="submit" class="btn btn-success btn-sm" href="#" ><i class="fa fa-eye"></i></a>
                                </td>
                                <td class="text-center">
                                    <a type="submit" class="btn btn-danger btn-sm"  data-bs-toggle="modal" data-bs-target="#yearModal"><i class="fa fa-trash"></i></a>
                                </td>@include('includes.modal-delete-year')
                            </tr>
                        @endforeach 
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END ALL YEARS -->

        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div>
      </div>

    
   
</div>
@endsection