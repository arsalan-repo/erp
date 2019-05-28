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
                            <h2 class="pageheader-title">View Order</h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Orders</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">View Orders</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="{{ route('order.edit',['id' => $order->id]) }}" method="POST">
                    @csrf
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="section-block" id="basicform">
                            <h3 class="section-title">View Order</h3>
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
                                {{--<form action="{{ route('category.update', ['id' => $category->id]) }}" method="POST">--}}
                                    <div class="form-group">
                                        <label class="col-form-label">Order Id</label>
                                        <p>{{$order->id}}</p>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Client Name</label>
                                        <p>{{$user->name}}</p>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Billing Address</label>
                                        <p>{{$billing->value}}</p>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Shipping Address</label>
                                        <p>{{$shipping->value}}</p>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Order Status</label>
                                        <select name="status">
                                            <option value="Processing" @if ($order->status == 'processing') selected @endif>Processing</option>
                                            <option value="Partial Approved" @if ($order->status == 'Partial Approved') selected @endif>Partial Approved</option>
                                            <option value="approved" @if ($order->status == 'approved') selected @endif>Approved</option>
                                            <option value="compeleted" @if ($order->status == 'compeleted') selected @endif>Completed</option>
                                            <option value="declined" @if ($order->status == 'declined') selected @endif>Declined</option>

                                        </select>
                                        <input type="hidden" name="order_id" value="{{$order->id}}">
                                    </div>

                                    <div class="table-responsive cart_info">
                                        <table class="table table-condensed">
                                            <thead>
                                            <tr class="cart_menu">
                                                <td class="image">Item</td>
                                                <td class="description">Name</td>
                                                <td class="price">Color</td>
                                                <td class="quantity">Quantity</td>
                                                {{--<td class="total">Total</td>--}}
                                                <td></td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="cart_product">
                                                    <a href=""><img src="{{ asset('storage/'.$product->image)}}" alt=""></a>
                                                </td>
                                                <td class="cart_description">
                                                    <h4>{{$product->name}}</h4>
                                                </td>
                                                <td class="cart_price">
                                                    <p>{{$color->value}}</p>
                                                </td>
                                                <td class="cart_quantity">
                                                    <div class="cart_quantity_button">
                                                        {{--<a class="cart_quantity_up" href=""> + </a>--}}
                                                        <p>{{$quantity->value}}</p>
                                                        {{--<a class="cart_quantity_down" href=""> - </a>--}}
                                                    </div>
                                                </td>




                                            </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                    <input type = "hidden" name = "_method" value = "PUT">
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary" value="Edit Status">
                                    </div>
                            </div>


                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection