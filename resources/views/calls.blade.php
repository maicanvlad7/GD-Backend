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
                <h3>Lista Apeluri Sales GD</h3>
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
                                        <th>Id Utilizator</th>
                                        <th>Nume</th>
                                        <th>Email</th>
                                        <th>Telefon</th>
                                        <th>Sunat De</th>
                                        <th>Status</th>
                                        <th>Notite</th>
                                        <th>Data Apel</th>
                                        <th>Data Update</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $u)
                                        <tr>
                                            <td>{{$u->user_id}}</td>
                                            <td>{{$u->name}}</td>
                                            <td>{{$u->email}}</td>
                                            <td>{{$u->phone}}</td>
                                            <td>{{$u->called_by}}</td>
                                            <td>{{$u->status}}</td>
                                            <td>{{$u->notes}}</td>
                                            <td>{{$u->created_at}}</td>
                                            <td>{{$u->updated_at}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">
                                Adaugati un apel pentru  <span id="userCallContainer"></span>
                            </h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="POST" id="callAdderForm">
                                @csrf
                                <div class="form-group">
                                    <label for="called_by">Sunat de</label>
                                    <select name="called_by" class="form-control" id="called_by">
                                        <option value="Florin">Florin</option>
                                        <option value="Miruna">Miruna</option>
                                        <option value="Vlad">Vlad</option>
                                        <option value="Alex">Alex</option>
                                        <option value="Marius">Marius</option>
                                        <option value="Radu">Radu</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="Revenim pe email cu ab normal">Revenim pe email cu ab normal</option>
                                        <option value="Nu a raspuns apel">Nu a raspuns</option>
                                        <option value="Revenim pe email cu 7 zile">Revenim pe email cu 7 zile</option>
                                        <option value="Nu este interesat">Nu este interesat</option>
                                        <option value="Nu are bani, revenim">Nu are bani, revenim</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <textarea name="notes" id="notes" cols="30" rows="10" class="form-control" placeholder="daca exista ceva de adaugat"></textarea>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-success" type="submit">Adauga Apel</button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Inchidere</span>
                            </button>
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

    <script>

        const nameContainer = document.getElementById('userCallContainer');
        const addCallAction = document.getElementById('addCallToDb');
        const finalUrl = 'http://127.0.0.1:8000/muac/';
        const form     = document.getElementById('callAdderForm');

        let userName = '';
        let userId   = '';
        let called_by  = '';
        let status = '';
        let notes = '';


        function test(that) {
            userName = that.dataset.username;
            userId   = that.dataset.userid;

            nameContainer.innerText = userName;

            form.action = finalUrl + userId;
        }









    </script>

@endsection
