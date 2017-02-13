@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Система отчетов OCS inventory</h1>
    <p>Для просмотра выберите необходимый отчет в меню</p>
    <hr>
    <p>Всего устройств зарегистрировано: {{App\Hardwares::count()}}</p>
</div>


@endsection

