@extends('admin.layout.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


    </style>



    <div class="card">
        <div class="card-header bg-light d-flex justify-content-between">
            <h3>All Suppliers</h3>
          <div>
            <a href="{{route('supplier.create')}}" class="btn btn-primary">Create</a>
            <a href="" class="btn btn-success">Back</a>
          </div>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Company Name</th>
                        <th scope="col">Supplier Name</th>
                        <th scope="col">Email Address</th>
                        <th scope="col">Contact</th>
                        <th scope="col">Address</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    
           
                @foreach ($sups as $sup)
                <tr>
                  <td>{{$sup->id}}
                    <!--+$loop->index + $sups->firstItem()-->
                  </td>
                  <td>{{$sup->name}}</td>
                  <td>{{$sup->sname}}</td>
                  <td>{{$sup->email}}</td>
                  <td>{{$sup->phone}}</td>
                  <td>{{$sup->address}}</td>
                  <td>
                   @if ($sup->status == '1')
                       <span class="badge badge-success">Active</span>
                   @else
                       <span class="badge badge-danger">Inactive</span>
                   @endif
                  </td>
                  <td>
                    <a href="{{route('supplier.edit', $sup->id)}}" class="btn btn-info">Edit</a>
                    <form action="{{route('supplier.destroy', $sup->id)}}" method="POST" style="display: inline">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-danger">Delete</button>
                    </form>
                  </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <div class="card-footer">
              {{$sups->links()}}
            </div>

         

        </div>
    </div>


   

    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

@endsection
