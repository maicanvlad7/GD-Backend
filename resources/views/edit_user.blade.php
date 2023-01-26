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
                <h3>Editezi utilizatorul <span class="text-primary">{{$user['name']}}</span></h3>
                <button type="button" class="btn btn-warning block" data-bs-toggle="modal" data-bs-target="#border-less">
                    Instructiuni importante
                </button>
            </div>
            <div class="page-content">
                <div class="row">
                    <div class="col-md-6 col-12 card rounded shadow p-3">
                        @if(Session::has('message') )
                            <div class="alert alert-light-success color-success"><i class="bi bi-check-circle"></i>
                                {{Session::get('message')}}
                            </div>
                        @endif
                        <p class="text-danger text-sm font-bold">Datele cu privire la utilizatori sunt foarte importante, verifica de doua ori inainte sa salvezi!</p>
                        <form action="{{url('user/' . $user['id'])}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nume</label>
                                <input type="text" id="name" class="form-control" name="name" placeholder="Nume" value="{{$user['name']}}">
                            </div>
                            <div class="form-group mt-1">
                                <label for="email">Email</label>
                                <input type="email" id="email" class="form-control" name="email" placeholder="Email" value="{{$user['email']}}">
                            </div>
                            <div class="form-group mt-1">
                                <label for="subscription">Subscription ID (Stripe)</label>
                                <input type="text" id="subscription" class="form-control" name="subscription" placeholder="Subscription ID" value="{{$user['subscription']}}">
                            </div>
                            <div class="form-group mt-1">
                                <label for="stripe_id">Customer ID (Stripe)</label>
                                <input type="text" id="stripe_id" class="form-control" name="stripe_id" placeholder="Customer ID" value="{{$user['stripe_id']}}">
                            </div>
                            <div class="form-group mt-1">
                                <label for="level">Level</label>
                                <select name="level" class="form-control" id="level">
                                    <option value="1" {{ $user['level'] == 1 ? "selected" : "" }}>1 - Basic</option>
                                    <option value="2" {{ $user['level'] == 2 ? "selected" : "" }}>2 - Pro</option>
                                    <option value="3" {{ $user['level'] == 3 ? "selected" : "" }}>3 - Premium</option>
                                </select>
                            </div>
                            <button class="btn btn-primary btn-xs mt-2">Salvează</button>
                        </form>
                    </div>
                </div>

{{--                modal--}}
                <div class="modal fade text-left modal-borderless" id="border-less" tabindex="-1" aria-labelledby="myModalLabel1" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Unde gasesc informatii despre abonament in Stripe ?</h5>
                                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                                    <i data-feather="x"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <ol>
                                    <li>Copiem emailul utilizatorului</li>
                                    <li>Paste in bara de search din Stripe</li>
                                    <li>Selectam intrarea cu iconita de user in stanga din lista de rezultate</li>
                                    <li>In stanga vedem segmentul <strong>Details</strong>, de acolo luam <strong>Customer ID</strong>, mereu incepe cu "cus_"</li>
                                    <li>In partea dreapta la <strong>Subscription</strong> vedem numele abonamentului, apasam pe el</li>
                                    <li>La <strong>Subscription Details</strong> putem vedea ID_ul abonamentului, incepe mereu cu "sub_". Il copiem in campul subscription ID al userului.</li>
                                </ol>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Close</span>
                                </button>
                                <button type="button" class="btn btn-primary ml-1" data-bs-dismiss="modal">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Ok</span>
                                </button>
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

@endsection
