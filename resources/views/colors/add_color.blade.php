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
                            <h2 class="pageheader-title">Add Color</h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">All Colors</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">Add Color</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="section-block" id="basicform">
                            <h3 class="section-title">Add Color</h3>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <ul style="margin: 0">
                                            @foreach($errors->all() as $err)
                                                <li>{{ $err }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form action="{{ route('color.create') }}" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Color Name</label>
                                                <input type="text" class="form-control" name="name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Color Code</label>
                                                <input type="text" class="form-control" name="code">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Color Image</label>
                                                <input type="file" class="form-control" name="image">
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary" value="Create Color">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection