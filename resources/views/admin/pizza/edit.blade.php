@extends('admin.layout.app')

@section('content')

<div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row mt-4">
          <div class="col-9 offset-2 mt-5">
            <div class="col-md-9">

                <a href="{{ route('admin#pizza')}}" class="text-decoration-none text-black">
                    <div class="mb-4"><i class="fas fa-arrow-circle-left"></i> Back</div>
                </a>

              <div class="card">
                <div class="card-header p-2">
                  <legend class="text-center">ADD PIZZA</legend>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{ asset('uploadsImage/'.$pizza->image ) }}" class="img-thumbnail my-3 " width="250px " height="100px">
                    </div>
                  <div class="tab-content">
                    <div class="active tab-pane" id="activity">

                      <form class="form-horizontal" method="POST" action="{{ route('admin#updatePizza' , $pizza->pizza_id )}}" enctype="multipart/form-data">
                          @csrf

                        <div class="form-group row">
                          <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="Enter Pizza Name..." name="name" value="{{ old('name', $pizza->pizza_name ) }} ">

                            @if ($errors->has('name'))

                            <p class="text-danger"> {{ $errors->first('name')}} </p>

                            @endif
                          </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Image</label>
                            <div class="col-sm-10">
                              <input type="file" class="form-control" placeholder="Enter Image..." name="image">

                              @if ($errors->has('image'))

                              <p class="text-danger"> {{ $errors->first('image')}} </p>

                              @endif
                            </div>
                          </div>


                          <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Price</label>
                            <div class="col-sm-10">
                              <input type="number" class="form-control" placeholder="Enter Price..." name="price" value="{{ old('price' , $pizza->price ) }}">

                              @if ($errors->has('price'))

                              <p class="text-danger"> {{ $errors->first('price')}} </p>

                              @endif
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Publish Status</label>
                            <div class="col-sm-10">
                             <select name="publish" id="" class="form-control">
                                 <option value="">Choose Option...</option>
                                 @if ( $pizza->publish_status == 0)
                                 <option value="1">Publish</option>
                                 <option value="0" selected></option>Unpublish</option>

                                 @else
                                 <option value="1" selected>Publish</option>
                                 <option value="0">Unpublish</option>

                                 @endif
                             </select>

                              @if ($errors->has('publish'))

                              <p class="text-danger"> {{ $errors->first('publish')}} </p>

                              @endif
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Category</label>
                            <div class="col-sm-10">
                                <select name="category" id="" class="form-control">
                                    <option value="{{ $pizza->category_id }}">{{ $pizza->category_name  }}</option>

                                    @foreach ($category as $item )
                                    @if ($item->category_id != $pizza->category_id)
                                    <option value="{{ $item->category_id }}"> {{ $item->category_name }}</option>
                                    @endif
                                    @endforeach

                                </select>
                              @if ($errors->has('category'))

                              <p class="text-danger"> {{ $errors->first('category')}} </p>

                              @endif
                            </div>
                          </div>


                          <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Discount</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" placeholder="Enter Discount Price ..." value="{{ old('discount', $pizza->discount_price ) }} "  name="discount">

                              @if ($errors->has('discount'))

                              <p class="text-danger"> {{ $errors->first('discount')}} </p>

                              @endif
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Buy 1 Get 1</label>
                            <div class="col-sm-10 mt-2">

                                @if ( $pizza->buy_one_get_one_status == 1)
                                <input type="radio" name="buyOnegetOne" value="1" class="form-input-check" checked >Yes
                                @else
                                <input type="radio" name="buyOnegetOne" value="0" class="form-input-check" > Yes
                                @endif

                                @if ( $pizza->buy_one_get_one_status == 0)
                                <input type="radio" name="buyOnegetOne" value="1" class="form-input-check" checked  >No
                                @else
                                <input type="radio" name="buyOnegetOne" value="0" class="form-input-check"> No
                                @endif

                              @if ($errors->has('buyOnegetOne'))

                              <p class="text-danger"> {{ $errors->first('buyOnegetOne')}} </p>

                              @endif
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Waiting Time</label>
                            <div class="col-sm-10">
                              <input type="number" class="form-control" placeholder="Enter Waiting Time..." name="waitingTime" value="{{ old('waitingTime',$pizza->waiting_time) }}">

                              @if ($errors->has('waitingTime'))

                              <p class="text-danger"> {{ $errors->first('waitijngTime')}} </p>

                              @endif
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Discription</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="description" rows="3" placeholder="Enter Description ..." > {{ old('description' , $pizza->description ) }} </textarea>


                              @if ($errors->has('descrtption'))

                              <p class="text-danger"> {{ $errors->first('descrtption')}} </p>

                              @endif
                            </div>
                          </div>



                        <div class="form-group row text-center">
                          <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn bg-dark text-white">Update</button>
                          </div>
                        </div>

                      </form>

                    </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

@endsection

