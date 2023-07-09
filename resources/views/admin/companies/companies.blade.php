@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Empresa - {{  $company->name }}</h1>
    <hr>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="false">Publicacoes</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="associate-tab" data-bs-toggle="tab" data-bs-target="#associate" type="button" role="tab" aria-controls="associate" aria-selected="true">Associar</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Outros</button>
        </li>
      </ul>
      <div class="tab-content" id="myTabContent">
        <!-- ALL PRODUCTS -->
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <br>
            <h3>Dados de Produção</h3>
            <hr>
            <table class="table table-bordered">
                <thead>
                    <tr scope="col"  class="table-secondary">
                        <th scope="col">Produto</th>
                        <th scope="col">Unidade</th>
                        <th scope="col">Total</th>
                        @foreach( $months as $month)   
                            <th>  
                                <div class="months">{{$month->month}}</div>
                            </th>
                        @endforeach
                    </tr>
                   
                </thead>
                <tbody>
                    @foreach($publications as $product)
                        <tr>                       
                            <td class="title">{{$product->name}}</td>   
                            <td>{{$product->unity}}</td>   
                            <td>{{$product->quantity}}</td>
                                @foreach( $product->publications as $pub)   
                                    <td class="values"> {{$pub->quantity}} </td>  
                                @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END ALL PRODUCTS -->


        <!-- ASSOCIATTE -->
        <div class="tab-pane fade" id="associate" role="tabpanel" aria-labelledby="associate-tab">
            <br>
            <h3>Associar Produto</h3>
            <hr>
            <form method="POST" action="{{ route('admin.associate.company.store', $company->id) }}" >
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
                                    <!--a type="submit" class="btn btn-danger btn-sm" href="{{ route('admin.associate.remove', [$company->id, $prod->id]) }}" >Remover <i class="fa fa-trash"></i></a-->
                                    <a type="submit" class="btn btn-danger btn-sm"  data-bs-toggle="modal" data-bs-target="#associationModal">Remover <i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach 
                    </tbody>
                </table>
            </div>     
        </div>
        <!-- END ASSOCIATTE -->
        @include('includes.modal-delete-association') 
    </div>   
</div>
@endsection