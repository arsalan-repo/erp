@extends('layouts.admin')
@section('content')
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header" id="top">
                            <h2 class="pageheader-title">All Item Types</h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">Item Types</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="section-block" id="basicform">
                            <h3 class="section-title">All Item Types</h3>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <table id="types" class="display" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>S#</th>
                                        <th>Item Type</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i = 0;
                                    if(!empty($all_types)){
                                    ?>
                                    @foreach($all_types as $type)
                                        <?php $i++ ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td>{{ $type->name }}</td>
                                            <td>
                                                <ul class="actions">
                                                    <li><a href="{{ route('item.edit', ['id' => $type->id]) }}"><span><i class="fa fa-edit"></i></span></a></li>
                                                    <li>
                                                        <form id="delete-category" method="post" action="{{ route('item.delete', ['id' => $type->id]) }}">
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <button type="submit"><span><i class="fa fa-trash"></i></span></button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection