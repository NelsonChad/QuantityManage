@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Associar Produto</h1>
    <form method="POST" action="{{ route('admin.associate.store') }}" >
        {!! csrf_field()!!}
        <div class="row">
            <div class="form-group col-md-3">
                <label for="inputProduct">Produto<span class="required_field">*</span></label>
                <select class="form-control js-example-basic-single" name="product" id="inputProduct">
                    @foreach($products as $product)
                    <option value="{{$product->id}}">
                        {{$product->name}}
                    </option>
                    @endforeach
                </select>
                @if ($errors->has('product'))
                <span class="help-block">
                    <strong>{{ $errors->first('product') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group col-md-4">
                <button style="margin-top: 22px;" type="submit" class="btn btn-success" >Associar</button>
            </div>
        </div>
    </form>
    <hr>
    <h3>Produtos associados a esta Empresa</h3>
    <div  class="col-8">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Produto</th>
                    <th class="text-center" colspan="3" style="width:15%">Acções</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productsAss as $prod)
                    <tr>
                        <td>PROD{{$prod->id}}</td>
                        <td>
                            {{$prod->name}}
                        </td>
                        <td>
                            <a type="submit" class="btn btn-danger btn-sm" href="{{ route('admin.associate.self.remove', $prod->id) }}" >Remover <i class="fa fa-trash"></i></a>
                          
                            <button class="btn btn-danger btn-sm" type="button" data-toggle="modal" data-target="#modal">  
                                <i class="fa fa-trash"></i>ss
                            </button>
                        </td>

                        
                        @include('includes.msg-delete-association') 
                    </tr>
                @endforeach 
            </tbody>
        </table>
    </div>

    <br>
    <h1>Abrir novo ano</h1>
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
                            <a type="submit" class="btn btn-danger btn-sm" href="{{ route('admin.year.delete', $year->id) }}" ><i class="fa fa-trash"></i></a>
                        </td>@include('includes.msg-delete-association') 
                    </tr>
                @endforeach 
            </tbody>
        </table>
    </div>
</div>
@endsection
