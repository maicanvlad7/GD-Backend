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
                <h3>Teacher payouts</h3>
            </div>
            <div class="page-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <form action="{{url('addPayout')}}" method="post">
                                @csrf
                                <div class="row p-4">
                                    <div class="col-md-4 ">
                                        <label for="name">Nume Teacher</label>
                                        <select name="user_id" id="user_id" class="form-control">
                                            @foreach ($teachers as $t)
                                                <option value="{{$t->id}}">{{$t->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="amount">Suma (lei)</label>
                                        <input type="number" class="form-control" name="amount">
                                    </div><br>

                                    <div class="col-md-12 mt-2">
                                        <button class="btn btn-success btn-xs" value="submit">Adauga Payout</button>
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
                                        <th>Nume Teacher</th>
                                        <th>Suma</th>
                                        <th>Solicitat</th>
                                        <th>Actiuni</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($payouts as $u)
                                        <tr>
                                            <td>{{$u->name}}</td>
                                            <td>{{$u->amount}}</td>
                                            <td>{{$u->requested == 1 ? 'Da' : 'Nu'}}</td>
                                            <td>
                                                <a href="{{url('editPayout') . "/" . $u->id}}" class="btn btn-info btn-xs">Edit</a>
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

    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#editor',
            skin: 'bootstrap',
            plugins: 'lists, link, image, media',
            toolbar: 'h1 h2 bold italic strikethrough blockquote bullist numlist backcolor | link image media | removeformat help',
            menubar: false,
        });
    </script>

@endsection
