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
                <h3>Social Links Teacheri GD</h3>
            </div>
            <div class="page-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <form action="{{url('addSocial')}}" method="post">
                                @csrf
                                <div class="row p-4">
                                    <div class="col-md-6 ">
                                        <label for="name">Nume Teacher</label>
                                        <select name="host_id" class="form-control">
                                            @foreach($hosts as $host)
                                                <option value="{{$host->id}}">{{$host->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="instagram">Instagram</label>
                                        <input type="text" class="form-control" name="instagram">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="facebook">Facebook</label>
                                        <input type="text" class="form-control" name="facebook">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="website">Website</label>
                                        <input type="text" class="form-control" name="website">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="telegram">Telegram</label>
                                        <input type="text" class="form-control" name="telegram">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="linkedin">Linkedin</label>
                                        <input type="text" class="form-control" name="linkedin">
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <button class="btn btn-success btn-xs" value="submit">Adauga Socials</button>
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
                                Simple Datatable
                            </div>
                            <div class="card-body">
                                <table class="table table-striped" id="table1">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nume Teacher</th>
                                        <th>IG</th>
                                        <th>LinkedIn</th>
                                        <th>Website</th>
                                        <th>Facebook</th>
                                        <th>Telegram</th>
                                        <th>Actiuni</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($socials as $u)
                                        <tr>
                                            <td>{{$u->id}}</td>
                                            <td>{{$u->host->name}}</td>
                                            <td>{{$u->instagram}}</td>
                                            <td>{{$u->linkedin}}</td>
                                            <td>{{$u->website}}</td>
                                            <td>{{$u->facebook}}</td>
                                            <td>{{$u->telegram}}</td>
                                            <td>
                                                <a href="{{url('editSocials') . "/" . $u->id}}" class="btn btn-info btn-xs">Editare</a>
                                                <a href="{{url('deleteSocials') . "/" . $u->id}}" class="btn btn-outline-danger btn-xs">Sterge</a>
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
