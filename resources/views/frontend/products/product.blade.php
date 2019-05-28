@extends('frontend.index')
@section('content')
<section>
		<div class="container">
			<div class="row">
				
				
				<div class="col-sm-12 padding-right">
					<div class="features_ites"><!--features_items-->
						<h2 class="title text-center">Shop</h2>
						 {{--{{--}}
						{{--dd(count($products))--}}
						{{--}}--}}
						@if(count($products) > 0)
						@foreach($products as $product)

						<div class="col-sm-4">
							<div class="product-image-wrapper">
								<div class="single-products">
									<div class="productinfo text-center">
										<img src="{{ asset('storage/'.$product->image) }}" alt="" />
										<h2>{{$product->name }}</h2>
										
										<a href="{{ route('productdetails',$product->id) }}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
									</div>
									<div class="product-overlay">
										<div class="overlay-content">
											<h2>{{$product->name }}</h2>
											
											<a href="{{ route('productdetails',$product->id) }}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
										</div>
									</div>
								</div>
								{{-- <div class="choose">
									<ul class="nav nav-pills nav-justified">
										<li><a href=""><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
										<li><a href=""><i class="fa fa-plus-square"></i>Add to compare</a></li>
									</ul>
								</div> --}}
							</div>
						</div>
						@endforeach
						@else
							<div class="col-sm-12" style="margin-bottom: 10px">
								<h4>No Product Available</h4>
							</div>
						@endif
						
						
						{{-- <ul class="pagination">
							<li class="active"><a href="">1</a></li>
							<li><a href="">2</a></li>
							<li><a href="">3</a></li>
							<li><a href="">&raquo;</a></li>
						</ul> --}}
					</div><!--features_items-->
				</div>
			</div>
		</div>
	</section>
@endsection