@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('order/view') }}">Orders</a></li>
      <li class="breadcrumb-item active" aria-current="page">View</li>
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
          <div class="row">
            <div class="col-md-6">
              <h6 class="card-title">Order List</h6>
            </div>
          </div>
          <div class="table-responsive pt-3">
            <table id="dataTableExample" class="table table-hover">
              <thead>
                <tr>
                  <th>
                    #
                  </th>
                  <th>
                    User
                  </th>
                  <th>
                    Type
                  </th>
                  <th>
                    Creation Date
                  </th>
                  <th class="text-center">
                    Status
                  </th>
                  <th class="text-center" data-orderable="false">
                    Actions
                  </th>
                </tr>
              </thead>
              <tbody>
                @foreach($orders as $serial => $order)
                <tr @if ($order->notify_paid == '1' || $order->notify_complete == '1') style="background-color:#262F36;" @endif>
                  <td>{{ $serial + 1 }}</td>
                  <td>{{ $order->user->name }}</td>
                  <td>{{ $order->type }}</td>
                  <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</td>
                  <td class="text-center align-middle">
                  
                  <!-- Unconfirmed Status -->
                  @if($order->status == 'Unconfirmed')
                    <h5><span class="badge badge-danger">{{ $order->status }}</span></h5>

                  <!-- Confirmed Status -->
                  @elseif($order->status == 'Confirmed')
                  <h5><span class="badge badge-primary" data-toggle="modal" data-target="#paidModal{{$serial}}">{{ $order->status }}</span></h5>
                  <div class="modal fade text-left" id="paidModal{{$serial}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Upload Paid Invoice!</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                        <form method="POST" action="{{url('order/paid/'.encrypt($order->id))}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                          <div class="col-md-12">
                            <input required type="file" data-allowed-file-extensions="png jpg jpeg pdf doc docx zip" data-max-file-size="20M" name="file" id="myDropify" class="border"/>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button style="color: white;" type="submit" class="btn btn-primary">Upload</button>
                      </form>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                      </div>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Unpaid Status -->
                  @elseif($order->status == 'Unpaid')
                  <h5><span class="badge badge-warning">{{ $order->status }}</span></h5>                  
                  
                  <!-- Paid Status -->
                  @elseif($order->status == 'Paid')
                    <h5><span class="badge badge-secondary" data-toggle="modal" data-target="#startModal{{$serial}}">{{ $order->status }}</span></h5>
                    <div class="modal fade text-left" id="startModal{{$serial}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confirm your action!</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Mark this Order as Started?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                            <a href="{{ url('order/start/'.encrypt($order->id)) }}" type="button" class="btn btn-primary">Yes</a>
                          </div>
                        </div>
                      </div>
                    </div>

                  <!-- Started Status -->
                  @elseif($order->status == 'Started')
                    <h5><span class="badge badge-dark" data-toggle="modal" data-target="#InProgress{{$serial}}">{{ $order->status }}</span></h5>
                    <div class="modal fade text-left" id="InProgress{{$serial}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confirm your action!</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Mark this Order as In progress?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                            <a href="{{ url('order/in/progress/'.encrypt($order->id)) }}" type="button" class="btn btn-primary">Yes</a>
                          </div>
                        </div>
                      </div>
                    </div>  

                  <!-- In progress Status -->
                  @elseif($order->status == 'In progress')
                    <h5><span class="badge badge-info" data-toggle="modal" data-target="#completeModal{{$serial}}">{{ $order->status }}</span></h5>
                    <div class="modal fade text-left" id="completeModal{{$serial}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confirm your action!</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Mark this Order as Complete?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                            <a href="{{ url('order/complete/'.encrypt($order->id)) }}" type="button" class="btn btn-primary">Yes</a>
                          </div>
                        </div>
                      </div>
                    </div>  

                  <!-- Complete Status -->
                  @elseif($order->status == 'Complete')
                  <h5><span class="badge badge-success">{{ $order->status }}</span></h5>                  
                  @endif
                  </td>

                  <td class="text-center">
                      @can('Download Order Invoice')
                        @if ($order->items->count() > 0)
                          <a title="Download Invoice" target="_blank" href="{{ url('/order/invoice/'.encrypt($order->id)) }}">
                            <button type="button" class="btn btn-primary btn-icon">
                              <i data-feather="download"></i>
                            </button>
                          </a>
                        @endif
                      @endcan
                      @can('Edit Order Details')
                      @if ($order->status == 'Unconfirmed' || $order->status == 'Unpaid')
                      <a title="Edit Order Details" href="{{ url('/order/edit/items/'.encrypt($order->id)) }}">
                        <button type="button" class="btn btn-primary btn-icon">
                          <i data-feather="edit"></i>
                        </button>
                      </a>
                      @endif
                      @endcan
                      @can('Delete Order')
                        <a title="Delete" data-toggle="modal" data-target="#actionModal{{$serial}}">
                          <button type="button" class="btn btn-primary btn-icon">
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
                                Are you sure you want to delete this order?
                                <p>Note: This will also delete items in order.</p>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <a href="{{ url('order/destroy/'.encrypt($order->id)) }}" type="button" class="btn btn-primary">Yes</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      @endcan
                      @can('Acknowledge Order')
                      @if ($order->notify_paid == '1' || $order->notify_start == '1' || $order->notify_complete == '1' || $order->notify_in_progress == '1')
                        <a title="Acknowledge" href="{{ url('order/acknowledge/'.encrypt($order->id)) }}">
                          <button type="button" class="btn btn-primary btn-icon">
                            <i data-feather="eye-off"></i>
                          </button>
                        </a>
                      @endif
                      @endcan
                      @can('View Order Details')
                      @if ($order->status == 'Confirmed' || $order->status == 'Paid' || $order->status == 'Started' || $order->status == 'In progress' || $order->status == 'Complete')
                      <button type="button" class="btn btn-success"><a style="color:white;" href="{{ url('order/view/items/'.encrypt($order->id)) }}">View Details</a></button>
                      @endif 
                      @endcan
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
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/chartjs/Chart.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/jquery.flot/jquery.flot.js') }}"></script>
  <script src="{{ asset('assets/plugins/jquery.flot/jquery.flot.resize.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/progressbar-js/progressbar.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
  <script src="{{ asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/js/datepicker.js') }}"></script>
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
  <script src="{{ asset('assets/js/dropify.js') }}"></script>
@endpush