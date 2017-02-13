@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <h1>Все компьютеры <small>(кол-во: {{App\Hardwares::count()}})</small></h1>

    <table class="table table-bordered"> 
        <thead> 
            <tr> 
                <!--<th>#</th>-->
                <th>hid</th>  
                <th>Дата ввода</th>
                <th>Дата опроса</th>
                <th class="filter-select filter-exact" data-placeholder="Выбрать группу">Подразделение</th>
                <th>Пользователь/проф.</th>
                <th>Компьютер</th>
                <th class="filter-select filter-exact" data-placeholder="Выбрать группу">ОС</th>
                <th class="filter-select filter-exact" data-placeholder="Выбрать группу">CPU</th> 
                <th class="filter-select filter-exact" data-placeholder="Выбрать группу">RAM</th> 
                <th class="filter-select filter-exact" data-placeholder="Выбрать группу">HDD</th> 
                <th class="filter-select filter-exact" data-placeholder="Выбрать группу">Мониторы</th>
            </tr> 
        </thead> 
       <tbody> 
            <?php $i=1; ?>
            @foreach ($objects as $obj)
            <tr>    
                <!--<td><?= $i++; ?></td>-->
                <td scope="row">{{$obj->ID}}</td> 
                <td>{{$obj->accountinfo['fields_9']}}</td>
                <td>{{$obj->LASTDATE}}</td>
                <td>{{$obj->accountinfo['TAG']}}</td>
                <td>{{$obj->accountinfo['fields_5']}}<p><small class="text-lowercase text-muted">{{$obj->accountinfo['fields_6']}}</small></p></td>
                <td>
                    <p>{{$obj->NAME}}</p>
                    <p><small class="text-lowercase text-muted">{{$obj->IPADDR}}</small></p>
                    
                </td>    
               <td>{{$obj->OSNAME}}<p><small class="text-lowercase text-muted">{{$obj->USERAGENT}}</small></p></td>
                <td>{{$obj->PROCESSORT}} <small class="text-muted">{{$obj->PROCESSORS}} GHz</small></td> 
               <td>{{$obj->MEMORY}}</td> 
               <td>
                   @foreach ($obj->storages as $hdd)
                   <p>{{$hdd->NAME}} <small class="text-lowercase text-muted">{{$hdd->DISKSIZE}} Гб</small></p>
                   @endforeach
               </td>
               <td>
                   @foreach ($obj->monitors as $mon)
                   <p>{{$mon->MANUFACTURER}} <br><small class="text-lowercase text-muted">{{$mon->CAPTION}}</small></p>
                   @endforeach
               </td>
            </tr> 
            @endforeach
        </tbody> 
        <!--<tfoot>
            <tr>
                <th colspan="8" class="ts-pager form-horizontal">
                    <button type="button" class="btn first"><i class="icon-step-backward glyphicon glyphicon-step-backward"></i></button>
                    <button type="button" class="btn prev"><i class="icon-arrow-left glyphicon glyphicon-backward"></i></button>
                    <span class="pagedisplay"></span> 
                    <button type="button" class="btn next"><i class="icon-arrow-right glyphicon glyphicon-forward"></i></button>
                    <button type="button" class="btn last"><i class="icon-step-forward glyphicon glyphicon-step-forward"></i></button>
                    <select class="pagesize input-mini" title="Строк на странице">
                        <option selected="selected" value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="40">40</option>
                    </select>
                    <select class="pagenum input-mini" title="Выбрать страницу"></select>
                </th>
            </tr>
        </tfoot>
        -->
    </table>
</div>


@endsection


