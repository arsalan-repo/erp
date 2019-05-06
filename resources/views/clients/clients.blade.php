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
                            <h2 class="pageheader-title">All Clients</h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">Clients</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="section-block" id="basicform">
                            <h3 class="section-title">All Clients</h3>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <table id="clients" class="display" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>S#</th>
                                        <th>Name</th>
                                        <th>Distributor</th>
                                        <th>Phone</th>
                                        <th>Whatsapp Number</th>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>Region</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i = 0;
                                    ?>
                                    @foreach($clients as $client)
                                        <?php $i++ ?>
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $client->name }}</td>
                                            <td>{{ $client->distributor->name }}</td>
                                            <td>{{ $client->phone }}</td>
                                            <td>{{ $client->whatsapp_number }}</td>
                                            <td>{{ $client->address }}</td>
                                            <td>{{ $client->city }}</td>
                                            <td style="text-transform: capitalize">{{ $client->region }}</td>
                                            <td>
                                                <ul class="actions">
                                                    <li><a href="{{ route('client.edit', ['id' => $client->id]) }}"><span><i class="fa fa-edit"></i></span></a></li>
                                                    <li>
                                                        <form id="delete-category" method="post" action="{{ route('client.delete', ['id' => $client->id]) }}">
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <button type="submit"><span><i class="fa fa-trash"></i></span></button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
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