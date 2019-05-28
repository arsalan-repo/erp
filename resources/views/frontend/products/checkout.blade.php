@extends('frontend.index')
@section('content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active">Check out</li>
                </ol>
            </div><!--/breadcrums-->


            <form action="{{route('order.create') }}" method="POST">
                @csrf
            {{--<div class="shopper-informations">--}}
                <div class="row">
                    <div class="col-sm-12 clearfix">
                        <div class="order-message">
                            <p>Billing Order</p>
                            <textarea name="billing"  placeholder="Billing Address" required="true"></textarea>

                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="order-message">
                            <p>Shipping Order</p>
                            <textarea name="shipping"  placeholder="Shipping Address" required="true"></textarea>

                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="order-message">
                            <p>Additional Information</p>
                            <textarea name="additional_notes"  placeholder="Additional Information" required="true"></textarea>

                        </div>
                    </div>
                </div>
            {{--</div>--}}
            {{--<div class="review-payment">--}}
                {{--<h2>Review & Payment</h2>--}}
            {{--</div>--}}

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
                            <h4><a href="">{{$product->name}}</a></h4>
                        </td>
                        <td class="cart_price">
                            <p><input name="color" value="{{$order->color}}"></p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <a class="cart_quantity_up" href=""> + </a>
                                <input class="cart_quantity_input" type="text" name="qty" value="{{$order->qty}}" autocomplete="off" size="2">
                                <a class="cart_quantity_down" href=""> - </a>
                            </div>
                        </td>




                    </tr>

                    </tbody>
                </table>
            </div>
                <div class="row" style="margin-bottom: 10px">
                    <div class="col-md-12">
                        <input type="hidden" name="product_id" value="{{$order->product_id}}">
                        <button type="submit" class="btn btn-primary" style="float: right" href="">Get Quotes</button>
                    </div>
                </div>
            {{--</div>--}}
            </form>
        </div>

    </section> <!--/#cart_items-->
    @endsection