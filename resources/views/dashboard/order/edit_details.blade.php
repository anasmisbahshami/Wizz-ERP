@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('order/view') }}">Order</a></li>
      <li class="breadcrumb-item active" aria-current="page">Edit</li>
    </ol>
  </nav>

  @if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> {{ $message }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif

  @if ($message = Session::get('warning'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Warning!</strong> {{ $message }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif
  
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">Item Detail</h6>
           <form method="POST" action="{{ url('order-book/item/store') }}" class="forms-sample" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="form-group col-md-4">
                  <label for="name">Name<span style="color:red;"> *</span></label>
                  <input required type="text" class="form-control" id="name" name="name" placeholder="">
                </div>
                <div class="form-group col-md-4">
                  <label for="weight">Weight<span style="color:red;"> *</span></label>
                  <input required type="number" step="any" min="0.1" name="weight" id="weight" class="form-control" placeholder="2.3 kg">
                </div>
                <div class="form-group col-md-4">
                  <label for="quantity">Quantity<span style="color:red;"> *</span></label>
                  <input required type="number" min="1" value="1" name="quantity" id="quantity" class="form-control">
                </div>
            </div>
            <div class="row">
              <div class="form-group col-md-4">
                <label for="email">Vehicle<span style="color:red;"> *</span></label>
                <select required class="js-example-basic-single w-100" id="vehicle_id" name="vehicle_id">
                    <option selected value="">Select</option>
                    @foreach(\App\Models\Vehicle::all() as $vehicle)
                        <option value="{{ $vehicle->id }}">{{ $vehicle->name }}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group col-md-4">
                <label for="name">Route<span style="color:red;"> *</span></label>
                <select required class="js-example-basic-single w-100" onchange="getRate()" id="route_id" name="route_id">
                    <option selected value="">Select</option>
                    @foreach(\App\Models\Route::all() as $route)
                        <option value="{{ $route->id }}">{{ $route->name }}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group col-md-4">
                <label for="email">Price<span style="color:red;"> *</span></label>
                <input required readonly type="number" step="any" class="form-control" id="rate" name="rate" placeholder="Rs 10,000">
              </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                  <label for="email">Delivery Address<span style="color:red;"> *</span></label>
                  <textarea required class="form-control" name="delivery_address" id="delivery_address" cols="30" rows="4"></textarea>
                  <input type="hidden" name="order_id" value="{{ $order->id }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mr-2">Add</button>
            <a class="btn btn-light"  href="{{ url('/order/view') }}">Cancel</a>
          </form>
        </div>
      </div>
    </div>
  </div>


  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <h6 class="card-title">Order Items</h6>
            </div>
            <div class="col-md-6">
              <a href="{{ url('/order-book/complete/'.encrypt($order->id)) }}" type="button" class="btn btn-success" style="float:right;">Complete Order</a>
            </div>
          </div>

          <div class="table-responsive pt-3">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th class="text-center">Name</th>
                  <th class="text-center">Quantity</th>
                  <th class="text-center">Vehicle</th>
                  <th class="text-center">Route</th>
                  <th class="text-center">Price</th>
                  <th class="text-center">Weight</th>
                  <th class="text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($order->items as $serial => $item)
                <tr>
                  <td class="text-center">{{ $item->name }}</td>
                  <td class="text-center">{{ $item->quantity }}</td>
                  <td class="text-center">{{ \App\Models\Vehicle::find($item->vehicle_id)->name }}</td>
                  <td class="text-center">{{ \App\Models\Route::find($item->route_id)->name }}</td>
                  <td class="text-center">Rs {{ number_format($item->price, 2) }}</td>
                  <td class="text-center">{{ number_format($item->weight, 2) }} Kg</td>
                  <td class="text-center">
                        <a title="Edit" data-toggle="modal" data-target="#EditModal{{$serial}}">
                            <button type="button" class="btn btn-primary btn-icon">
                                <i data-feather="edit"></i>
                            </button>
                        </a>
                        <div class="modal fade text-left" id="EditModal{{$serial}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Item Details</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form method="POST" action="{{ url('/order-book/item/update/'.encrypt($item->id)) }}" class="forms-sample" enctype="multipart/form-data">
                                  @csrf
                                <div class="row">
                                  <div class="form-group col-md-4">
                                    <label for="name">Name<span style="color:red;"> *</span></label>
                                    <input required type="text" class="form-control" id="name" name="name" placeholder="" value="{{ $item->name }}">
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label for="weight">Weight<span style="color:red;"> *</span></label>
                                    <input required type="number" step="any" min="0.1" name="weight" id="weight" class="form-control" placeholder="2.3 kg" value="{{ $item->weight }}">
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label for="quantity">Quantity<span style="color:red;"> *</span></label>
                                    <input required type="number" min="1" value="1" name="quantity" id="quantity" class="form-control" value="{{ $item->quantity }}">
                                  </div>
                              </div>
                              <div class="row">
                                <div class="form-group col-md-6">
                                  <label for="email">Vehicle<span style="color:red;"> *</span></label>
                                  <select required id="vehicle" name="vehicle_id">
                                      <option selected value="">Select</option>
                                      @foreach(\App\Models\Vehicle::all() as $vehicle)
                                          <option @if ($item->vehicle_id == $vehicle->id) selected @endif value="{{ $vehicle->id }}">{{ $vehicle->name }}</option>
                                      @endforeach
                                  </select>
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="name">Route<span style="color:red;"> *</span></label>
                                  <select required onchange="getOrderRate()" id="route" name="route_id">
                                      <option selected value="">Select</option>
                                      @foreach(\App\Models\Route::all() as $route)
                                          <option @if ($item->route_id == $route->id) selected @endif value="{{ $route->id }}">{{ $route->name }}</option>
                                      @endforeach
                                  </select>
                                </div>
                              </div>
                              <div class="row">
                                <div class="form-group col-md-12">
                                  <label for="email">Price<span style="color:red;"> *</span></label>
                                  <input required readonly type="number" step="any" class="form-control" id="rateItem" name="rate" placeholder="Rs 10,000" value="{{ $item->price }}">
                                </div>
                              </div>
                              <div class="row">
                                  <div class="form-group col-md-12">
                                    <label for="email">Delivery Address<span style="color:red;"> *</span></label>
                                    <textarea required class="form-control" name="delivery_address" id="delivery_address" cols="30" rows="4">{{ $item->delivery_address }}</textarea>
                                  </div>
                              </div>
                              </div>
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Yes</a>
                                </form>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <a title="Delete" data-toggle="modal" data-target="#actionModal{{$serial}}">
                            <button type="button" class="btn btn-danger btn-icon">
                                <i data-feather="trash-2"></i>
                            </button>
                        </a>
                        <div class="modal fade text-left" id="actionModal{{$serial}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Confirm your action!</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                Are you sure you want to delete this order item?
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <a href="{{ url('/order-book/item/destroy/'.encrypt($item->id)) }}" type="button" class="btn btn-primary">Yes</a>
                              </div>
                            </div>
                          </div>
                        </div>
                  </td>
                </tr>                    
                @endforeach
                <tr>
                  <td colspan="3" style="border:none;"></td>
                  <td style="font-weight: bold;" class="text-center">Total</td>
                  <td class="text-center">Rs {{ number_format($order->items->sum('price'), 2) }}</td>
                  <td class="text-center">{{ number_format($order->items->sum('weight'), 2) }} Kg</td>
                </tr>
              </tbody>
            </table>
          </div>
          </div>
        </div>
      </div>
    </div>


@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/chartjs/Chart.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/jquery.flot/jquery.flot.js') }}"></script>
  <script src="{{ asset('assets/plugins/jquery.flot/jquery.flot.resize.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/progressbar-js/progressbar.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/js/datepicker.js') }}"></script>
  <script src="{{ asset('assets/js/select2.js') }}"></script>
  <script>
    function getRate(){
        var vehicle_id = $('#vehicle_id').val();
        var route_id = $('#route_id').val();

        $.post('{{ route('getRate') }}', {_token:'{{ csrf_token() }}', vehicle_id:vehicle_id, route_id:route_id}, function(data){
        if(data){        
            $('#rate').val(data);
        }
        });
    }

    function getOrderRate(){
        var vehicle_id = $('#vehicle').val();
        var route_id = $('#route').val();

        $.post('{{ route('getRate') }}', {_token:'{{ csrf_token() }}', vehicle_id:vehicle_id, route_id:route_id}, function(data){
        if(data){        
            $('#rateItem').val(data);
        }
        });
    } 
  </script>
@endpush