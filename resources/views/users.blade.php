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
                <h3>Utilizatori GD</h3>
            </div>
            <div class="page-content">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                Simple Datatable
                            </div>
                            <div class="card-body">
                                <table class="table table-striped" id="table1">
                                    <thead>
                                    <tr>
                                        <th>Nume</th>
                                        <th>Email</th>
                                        <th>Telefon</th>
                                        <th>SubID</th>
                                        <th>CustomerID</th>
                                        <th>Abonament</th>
                                        <th>Actiuni</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $u)
                                        <tr>
                                            <td>{{$u->name}}</td>
                                            <td>{{$u->email}}</td>
                                            <td>{{$u->phone}}</td>
                                            <td>{{$u->subscription}}</td>
                                            <td>{{$u->stripe_id}}</td>
                                            <td>
                                                @if($u->level == '1')
                                                    basic
                                                @elseif($u->level == '2')
                                                    pro
                                                @elseif($u->level == '3')
                                                    full
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <a class="btn btn-primary btn-xs" href="{{url('/user/') . "/" . $u->id}}">Edit</a>
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
        let dataTable = new simpleDatatables.DataTable(table1, {
            order: [[0, 'desc']]
        });
    </script>

@endsection
