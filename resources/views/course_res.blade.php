@extends('layouts.dash')

@section('content')
    <div id="app">


        @include('sidebar')

        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <h3>Resurse pentru <strong class="text-danger">{{$course_name->name}}</strong></h3>
            </div>
            <div class="page-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <form action="{{url('addResourceToCourse')}}" method="post">
                                @csrf
                                <input type="hidden" value="{{$course_id}}" name="course_id">
                                <div class="row p-4">
                                    <div class="col-md-4 ">
                                        <label for="name">Nume (Asa apare in lista de resurse)</label>
                                        <input type="text" class="form-control" name="name">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="video_id">Link (se copiaza din bunny CDN)</label>
                                        <input type="text" class="form-control" name="link">
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <button class="btn btn-success btn-xs" value="submit">Adauga Resursa</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="card">
                            @if(Session::has('message') )
                                <div class="alert alert-light-success color-success"><i class="bi bi-check-circle"></i>
                                    {{Session::get('message')}}
                                </div>
                            @endif
                            <div class="card-body">
                                <table class="table table-striped" id="table1">
                                    <thead>
                                    <tr>
                                        <th>Nume Resursa</th>
                                        <th>Link Bunny</th>
                                        <th>Actiuni</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $u)
                                        <tr>
                                            <td>{{$u->name}}</td>
                                            <td>{{$u->link}}</td>
                                            <td>
                                                <a href="{{url('deleteResource') . "/" . $u->id}}" class="btn btn-danger btn-xs">Sterge</a>
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

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2021 &copy; Mazer</p>
                    </div>
                    <div class="float-end">
                        <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                                href="http://ahmadsaugi.com">A. Saugi</a></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="{{asset('vendors/simple-datatables/simple-datatables.js')}}"></script>
    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>

@endsection
