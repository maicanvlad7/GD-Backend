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
                <h3>Comentarii Gandeste Diferit</h3>
                <p>Aici se pot adauga doar comentarii legate de useri(boti) creati de noi</p>
            </div>
            <div class="page-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <form action="{{url('addFakeUser')}}" method="post">
                                @csrf
                                <div class="row p-4">
                                    <div class="col-md-12">
                                        <h3>Adaugare utilizator fake</h3>
                                    </div>
                                    <div class="col-md-6 ">
                                        <label for="name">Nume Utilizator</label>
                                        <input type="text" class="form-control" name="name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="length">Email</label>
                                        <input type="text" class="form-control" name="email">
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <label for="level">Abonament</label>
                                        <select name="level" class="form-control">
                                            <option value="1">Basic</option>
                                            <option value="2">PRO</option>
                                            <option value="3">Premium</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <button class="btn btn-success btn-xs" value="submit">Adauga Utilizator Fake</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card">
                            <form action="{{url('addFakeComment')}}" method="post">
                                @csrf
                                <div class="row p-4">
                                    <div class="col-md-12">
                                        <h3>Adaugare comentariu fake</h3>
                                    </div>
                                    <div class="col-md-6 ">
                                        <label for="name">Utilizator</label>
                                        <select name="user_id" id="user_id" class="form-control">
                                            @foreach($users as $us)
                                                <option value="{{$us->id}}">{{$us->name}} - {{$us->level}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="length">Curs</label>
                                        <select name="course_id" id="course_id" class="form-control">
                                            @foreach($courses as $c)
                                                <option value="{{$c->id}}">{{$c->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="content">Comentariu</label>
                                        <textarea id="content" name="con" class="form-control"></textarea>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <button class="btn btn-success btn-xs" value="submit">Adauga Comentariu Fake</button>
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
                            <div class="card-header">
                                <h4>Comentarii GD</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped" id="table1">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Utilizator</th>
                                        <th>Curs</th>
                                        <th>Comentariu</th>
                                        <th>Actiuni</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $u)
                                        <tr>
                                            <td>{{$u->id}}</td>
                                            <td>{{$u->uname}} - {{$u->ulevel}}</td>
                                            <td>{{$u->cname}}</td>
                                            <td>{{$u->content}}</td>
                                            <td>
                                                <a href="{{url('deleteReview') . "/" . $u->id}}" class="btn btn-danger btn-xs">Sterge Comentariu</a>
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
