@extends('admin.layout.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


    </style>



    <div class="card">
        <div class="card-header bg-light d-flex justify-content-between">
            <h3>All Category</h3>
          <div>
            <a href="{{route('category.create')}}" class="btn btn-primary">Create</a>
            <a href="" class="btn btn-success">Back</a>
          </div>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    
           
             @foreach ($cats as $cat)
             <tr>
              <td>{{$cat->id}}</td>
              <td>{{$cat->name}}</td>
              <td>
                @if ($cat->status == '1')
                    <span class="badge badge-success">Active</span>
                @else
                <span class="badge badge-danger">Inactive</span>
                @endif
              </td>
              <td>
                <a href="{{route('category.edit', $cat->id)}}" class="btn btn-info">Edit</a>
                <form method="POST" action="{{route('category.destroy', $cat->id)}}" style="display: inline">
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
              {{$cats->links()}}
            </div>
        </div>
    </div>


   

    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

@endsection
