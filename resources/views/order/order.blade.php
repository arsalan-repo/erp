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
                            <h2 class="pageheader-title">All Categories</h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">Order</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="section-block" id="basicform">
                            <h3 class="section-title">All Categories</h3>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <table id="categories" class="display" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>S#</th>
                                        <th>Order id</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i = 0;

                                    ?>
                                    @foreach($orders as $order)
                                        <?php $i++ ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td>{{ $order->id }}</td>
                                            <td>
                                                <ul class="actions">
                                                    <li><a href="{{ route('order.detail', ['id' => $order->id]) }}"><span><i class="fa fa-eye"></i></span></a></li>

                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection