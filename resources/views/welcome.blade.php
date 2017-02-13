@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Отчет</h1>

    <table class="table table-bordered"> 
        <thead> 
            <tr> 
                <th>hid</th> 
                <th>имя компьютера</th> 
                <th>ip адрес</th> 
                <th>CPU</th> 
                <th>Memory</th> 
                <th>HDD</th>
                <th></th>
                <th></th>
            </tr> 
        </thead> 
       
    </table>
</div>


@endsection

