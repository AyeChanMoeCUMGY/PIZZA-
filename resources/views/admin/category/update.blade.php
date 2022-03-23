@extends('admin.layout.app')

@section('content')

<div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row mt-4">
          <div class="col-8 offset-3 mt-5">
            <div class="col-md-9">

                <a href="{{ route('admin#category')}}" class="text-decoration-none text-black">
                    <div class="mb-4"><i class="fas fa-arrow-circle-left"></i> Back</div>
                </a>

              <div class="card">
                <div class="card-header p-2">
                  <legend class="text-center">Edit Category</legend>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane" id="activity">

                      <form class="form-horizontal" method="post" action="{{ route('admin#updateCategory') }}">
                          @csrf

                        <div class="form-group row">
                          <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                          <div class="col-sm-10">
                              <input type="hidden" name="id"  value="{{ $category->category_id}}">
                            <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name' , $category->category_name) }}">

                            @if ($errors->has('name'))

                            <p class="text-danger"> {{ $errors->first('name')}} </p>

                            @endif
                          </div>
                        </div>


                        <div class="form-group row">
                          <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn bg-primary text-white">Update</button>
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

