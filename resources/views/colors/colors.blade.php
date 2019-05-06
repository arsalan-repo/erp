@extends('layouts.admin')
@section('content')
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12">
                <!-- ============================================================== -->
                <!-- pageheader  -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header" id="top">
                            <h2 class="pageheader-title">All Colors</h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">Colors</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="section-block" id="basicform">
                            <h3 class="section-title">All Colors</h3>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <table id="colors" class="display" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>S#</th>
                                        <th>Color Name</th>
                                        <th>Color Code</th>
                                        <th>Color Image</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i = 0;
                                    if(!empty($colors)) {
                                    ?>
                                    @foreach($colors as $color)
                                        <?php $i++ ?>
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $color->name }}</td>
                                            <td>{{ $color->code }}</td>
                                            <td>
                                                <img src="/erp/public/images/{{ $color->image }}" class="img-responsive" width="100" height="100"/>
                                            </td>
                                            <td>
                                                <ul class="actions">
                                                    <li><a href="{{ route('color.edit', ['id' => $color->id]) }}"><span><i class="fa fa-edit"></i></span></a></li>
                                                    <li>
                                                        <form id="delete-category" method="post" action="{{ route('color.delete', ['id' => $color->id]) }}">
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
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection