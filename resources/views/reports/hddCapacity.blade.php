@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <h1>HDD CAPACITY<small>(кол-во: {{App\Drives::count()}})</small></h1>

    <table class="table table-bordered"> 
        <thead> 
            <tr> 
                <th>hid</th>  
                <th class="filter-select filter-exact" data-placeholder="Выбрать группу">Подразделение</th>
                <th>HDD</th>
                <th>HDD CAPACITY</th>  
            </tr> 
        </thead> 
       <tbody> 
            <?php $i=1; ?>
            @foreach ($objects as $obj)
            <tr>    
                <td scope="row">{{$obj->ID}}</td> 
                <td>{{$obj->accountinfo['TAG']}}</td>

               <td>
                   @foreach ($obj->storages as $hdd)
                   <p>{{$hdd->NAME}} <small class="text-lowercase text-muted">{{$hdd->DISKSIZE}} Гб</small></p>
                   @endforeach
               </td>
               <td>
                   @foreach ($obj->drives as $drive)
                   <p>{{$drive->LETTER }}<small class="text-lowercase text-muted">{{$drive->TOTAL - $drive->FREE }} Гб</small></p>
                   @endforeach
               </td>
            </tr> 
            @endforeach
        </tbody> 
    </table>
</div>


@endsection


