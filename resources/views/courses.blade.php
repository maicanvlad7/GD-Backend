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
                <h3>Cursuri GD</h3>
                <a href="{{url('add_course')}}" class="btn btn-success">Curs Nou</a>
            </div>
            <div class="page-content">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="card">
                            @if(Session::has('message') )
                                <div class="alert alert-light-success color-success"><i class="bi bi-check-circle"></i>
                                    {{Session::get('message')}}
                                </div>
                            @endif
                            <div class="card-header">
                                Simple Datatable
                            </div>
                            <div class="card-body">
                                <table class="table table-striped" id="table1">
                                    <thead>
                                    <tr>
                                        <th>Nume</th>
                                        <th>Durata</th>
                                        <th>Scor</th>
                                        <th>Imagine (link bunny)</th>
                                        <th>Vizualizari</th>
                                        <th>Actiuni</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $u)
                                        <tr>
                                            <td>{{$u->name}}</td>
                                            <td>{{$u->length}}</td>
                                            <td>{{$u->score}}</td>
                                            <td>{{$u->image}}</td>
                                            <td>{{$u->views}}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-primary dropdown-toggle me-1" type="button" id="dropdownMenuButtonIcon" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="bi bi-error-circle me-50"></i> Actiuni
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonIcon" style="">
                                                        <a class="dropdown-item"  href="{{url('/course/') . "/" . $u->id}}">
                                                            <i class="bi bi-bar-chart-alt-2 me-50"></i>Edit Curs
                                                        </a>
                                                        <a class="dropdown-item" href="{{url('/clessons' . "/" . $u->id )}}">
                                                            <i class="bi bi-bell me-50"></i> Lectii
                                                        </a>
                                                        <a class="dropdown-item" href="{{url('/cres' . "/" . $u->id )}}">
                                                            <i class="bi bi-archive me-50"></i> Resurse
                                                        </a>
                                                    </div>
                                                </div>
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
