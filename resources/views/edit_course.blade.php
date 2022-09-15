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
                <h3>Editezi cursul <span class="text-primary">{{$data['name']}}</span></h3>
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
                        <p class="text-danger text-sm font-bold">Datele cu privire la cursuri sunt foarte importante, verifica de doua ori inainte sa salvezi!</p>
                        <form action="{{url('course/' . $data['id'])}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nume</label>
                                <input type="text" id="name" class="form-control" name="name" placeholder="Nume" value="{{$data['name']}}">
                            </div>
                            <div class="form-group mt-1">
                                <label for="subtitle">Subtitlu</label>
                                <input type="text" id="subtitle" class="form-control" name="subtitle" placeholder="Subtitlu" value="{{$data['subtitle']}}">
                            </div>
                            <div class="form-group mt-1">
                                <label for="description">Descriere</label>
                                <textarea type="text" id="description" rows="5" class="form-control" name="description" placeholder="Descriere">
                                    {{$data['description']}}
                                </textarea>
                            </div>
{{--                            <div class="form-group mt-1">--}}
{{--                                <label for="subtitle">Scor (ajuta la ordonare)</label>--}}
{{--                                <input type="text" id="score" class="form-control" name="score" placeholder="Scor" value="{{$data['score']}}">--}}
{{--                            </div>--}}
                            <div class="form-group mt-1">
                                <label for="subtitle">Cover</label>
                                <input type="text" id="image" class="form-control" name="image" placeholder="Imagine Cover" value="{{$data['image']}}">
                            </div>
                            <div class="form-group mt-1">
                                <label for="views">Vizualizari</label>
                                <input type="text" id="views" class="form-control" name="views" placeholder="Vizualizari" value="{{$data['views']}}">
                            </div>
                            <div class="form-group mt-1">
                                <label for="cktag">Tag Convert Kit</label>
                                <input type="number" id="cktag" class="form-control" name="cktag" placeholder="Tag Convert Kit" value="{{$data['cktag']}}">
                            </div>
                            <div class="form-group mt-1">
                                <label for="views">Scor (ajuta la ordonarea in categorie)</label>
                                <input type="text" id="score" class="form-control" name="score" placeholder="Scor" value="{{$data['score']}}">
                            </div>
                            <div class="form-group mt-1">
                                <label for="length">Durata</label>
                                <input type="text" id="length" class="form-control" name="length" placeholder="Customer ID" value="{{$data['length']}}">
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="coming_soon" id="flexCheckDefault" {{$data['coming_soon'] == 1 ? 'checked' : ''}}>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Coming Soon
                                </label>
                            </div>
                            <button class="btn btn-primary btn-xs mt-4">Salvează</button>
                        </form>
                    </div>
                </div>

                {{--                modal--}}
                <div class="modal fade text-left modal-borderless" id="border-less" tabindex="-1" aria-labelledby="myModalLabel1" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Cateva lucruri despre editarea unui curs</h5>
                                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                                    <i data-feather="x"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                              <ul>
                                  <li>Imaginea cursului va fi incarcata pe bunny CDN si de acolo linkul va fi copiat aici</li>
                                  <li>Verifica formatul pentru durata unui curs inainte sa il editezi (sa mentinem informatia la fel in platforma)</li>
                                  <li>Nu exagera cu numarul de vizualizari</li>
                              </ul>
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
