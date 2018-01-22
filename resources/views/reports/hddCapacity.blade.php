@extends('layouts.master')

@section('content')
<div class="container">
    <h1>HDD CAPACITY<small>(кол-во дисков всего: {{App\Drives::count()}})</small></h1>

    <table class="table table-bordered"> 
        <thead> 
            <tr> 
                <th width="10px">hid</th>  
                <th class="filter-select filter-exact" data-placeholder="Выбрать группу">Подразделение</th>
                <th data-sortinitialorder="asc" width="50px">HDD CAPACITY (Gb)</th>  
            </tr> 
        </thead> 
       <tbody> 
            <?php $i=1; ?>
            @foreach ($objects as $obj)
            <tr>    
                <td scope="row">{{$obj->HARDWARE_ID}}</td> 
                <td>{{$obj->TAG}}</td>

               <td>
                   <p>{{round($obj->Occupate_space_Gb,0)}} </p>
               </td>

            </tr> 
            @endforeach
        </tbody> 
    </table>
</div>


@endsection


