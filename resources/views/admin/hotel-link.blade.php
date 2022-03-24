@extends('admin.master')

@section('body')
<div class="container mt-4">
<div class="page-content-wrapper">
    <div class="page-content">
        <a href="{{route('resize-and-download')}}" class="btn btn-success mb-3">Resize & Download</a>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">Image Link</th>
            <th scope="col">Hotel Name</th>
            <th scope="col">Resize Link</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($links as $link)
            <tr>
                <td><img height="100" width="200" src="{{$link->image_link}}" alt="{{$link->hotel_name}}"></td>
                <td>{{$link->hotel_name}}</td>
                <td><img width="200" height="100" src="{{asset($link->resize_link)}}" alt="{{$link->hotel_name}}"></td>
              </tr> 
            @endforeach
          
          
        </tbody>
      </table>
    </div>
</div>
</div>
@endsection