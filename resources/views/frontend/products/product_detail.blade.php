@extends('frontend.index')
@section('content')
<section>
		<div class="container">
			<div class="row">
				
				<form action="{{ route('order.add')}}" method="POST">
					@csrf
				<div class="col-sm-12 padding-right">
					<div class="product-details"><!--product-details-->
						<div class="col-sm-5">
							<div class="view-product">
								<img src="{{ asset('storage/'.$product->image) }}" alt="" />
								<h3>ZOOM</h3>
							</div>
							

						</div>
						<div class="col-sm-7">
							<div class="product-information"><!--/product-information-->
								{{-- <img src="{{ asset('storage/'.$product->image) }}" class="newarrival" alt="" /> --}}
								<h2>{{$product->name}}</h2>
								{{-- <p>Web ID: 1089772</p> --}}
								{{-- <img src="images/product-details/rating.png" alt="" /> --}}
								{{-- <span> --}}
									<div class="row" style="margin-bottom: 10px;">
										<div class="col-md-3">
										<label>Categories:</label>
									</div>
									<div class="col-md-9">
										<p> 
											@foreach($product->categories as $key => $value)
										  {{ $value->category_name }},
										 @endforeach
										</p>
									</div>	
									
									</div>
								<div class="row" style="margin-bottom: 10px;">
									<div class="col-md-3">
										<label>Sub-Categories:</label>
									</div>
									<div class="col-md-9">
										<p> @foreach($product->types as $key => $value)
										  {{ $value->type_name }},
										 @endforeach
										</p>
									</div>	
								</div>
								
								<div class="row" style="margin-bottom: 10px;">
								@if($product->qty > 0)
								<div class="col-md-3">
									<label>Availability:</label>
								</div>
								<div class="col-md-3">
									<p> In Stock</p>
								</div>	
								@else
								<div class="col-md-3">
									<label>Availability:</label>
								</div>
								<div class="col-md-3">
									<p> Out Of Stock</p>
								</div>								
								@endif
								</div>
								<div class="row" style="margin-bottom: 10px;">
									<div class="col-md-3">
										<label>Unit:</label> 
									</div>
									<div class="col-md-9">
										{{$product->unit}}
									</div>
								</div>
								
								<div class="row" style="margin-bottom: 10px;">
									<div class="col-md-3">
										<label>color:</label> 
									</div>
									<div class="col-md-3">
								<select name='color'>
								    <option val="">Please choose</option>
								    @foreach($product->colors as $key => $value)
								    <option val="{{$value->color_id}}">{{$value->color_name}}</option>
								    @endforeach
									</select>
								</div>
							</div>
							<div class="row">
								{{-- </p> --}}
								<div class="col-md-3">
									<label>Quantity:</label>
								</div>
								<div class="col-md-3">
									<input type="text" value="3" name="qty" style="width: 100%" />
								</div>
								<div class="col-md-3">
									<input type="hidden" name="product_id" value="{{$product->id}}">
									<button type="submit" class="btn btn-fefault cart">
										<i class="fa fa-shopping-cart"></i>
										Add to cart
									</button>
								</div>
								</div>
							</div>

								{{-- </span> --}}
								
								
								{{-- <p><b>Brand:</b> E-SHOPPER</p> --}}
							
							</div><!--/product-information-->
						</div>
					</div><!--/product-details-->
				</form>
			</div>

					
					<div class="category-tab shop-details-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#details" data-toggle="tab">Details</a></li>
							</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane active" id="details" >
								<p>
									{{$product->description}}
								</p>
							</div>												
						</div>																					
					</div><!--/category-tab-->
					
					
					
				</div>
			</div>
		</div>
	</section>
	@endsection