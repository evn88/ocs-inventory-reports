@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Выгрузка для РАЦ</h1>
    <p>Сгенерировано {{$date}}</p>
    <p>Анкеты расположены по пути "Z:\ocs\storage\app\exports\out"</p>

    <hr>
    @foreach($softCount as $sCount)
    <p>{{$sCount['name']. " - " . $sCount['count'] . " - " . $sCount['apc']}}</p>
    @endforeach
    
</div>


@endsection