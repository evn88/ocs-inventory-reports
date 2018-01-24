@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Выгрузка для РАЦ</h1>
    <p>Сгенерировано {{$date}}</p>
    <p><a href="/exports/out/exportForRac.docx">Загрузить анкеты</a></p>
</div>


@endsection