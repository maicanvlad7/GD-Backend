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
                <h3>Teacheri GD</h3>
            </div>
            <div class="page-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <form action="{{url('add_teacher')}}" method="post">
                                @csrf
                                <div class="row p-4">
                                    <div class="col-md-6 ">
                                        <label for="name">Nume Teacher</label>
                                        <input type="text" class="form-control" name="name">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="image">Imagine bunny CDN</label>
                                        <input type="text" class="form-control" name="image">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="title">Titlu (la sfarsit de item din titlu se pune < br > (fara spatii)</label>
                                        <textarea type="text" class="form-control" name="title"></textarea>
                                    </div><br>
                                    <div class="col-md-12">
                                        <label for="description">Descriere SCURTA</label>
                                        <textarea type="text" class="form-control" name="description"></textarea>
                                    </div><br>
                                    <div class="col-md-12 mt-2">
                                        <button class="btn btn-success btn-xs" value="submit">Adauga Teacher</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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
                                        <th>Titlu</th>
                                        <th>Descriere</th>
                                        <th>Actiuni</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $u)
                                        <tr>
                                            <td>{{$u->name}}</td>
                                            <td>{{$u->title}}</td>
                                            <td>{{$u->description}}</td>
                                            <td>
                                                <a class="btn btn-primary btn-xs" href="{{url('/teacher/') . "/" . $u->id}}">Edit</a>
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
