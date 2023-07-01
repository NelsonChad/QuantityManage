@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Todos Produtos</h1>
    {{$productsCompanies}}
    @foreach ($productsCompanies as $product )
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>{{$product->name}} {{$product->id}}</th>
                    <th>Produção {{$product->created_at}}</th>
                    <th>Produção {{$product->created_at}}</th>
                    <!--th class="text-center" colspan="3" style="width:15%">Acções</th-->
                </tr>
            </thead>
            <tbody>
                @foreach($product->users as $companies)
                    <tr>
                        <td>{{$companies->name }} {{$companies->id}}</td>
                        <td>null</td>
                        @foreach($companies->publications as $pubs)
                            <td>{{$pubs}}</td>
                        @endforeach
                        
                    </tr>
                @endforeach 
                <tr>
                    <td><b>Total</b></td>
                </tr>
            </tbody>
        </table>
    @endforeach
    <div>

    </div>
</div>
@endsection
