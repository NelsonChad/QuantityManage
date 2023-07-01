@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Associate</h1>
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
    <div>
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
                    </tr>
                @endforeach 
            </tbody>
        </table>
    </div>
</div>
@endsection
