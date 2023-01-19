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
                <h3>Adauga un curs nou</h3>
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
                        <form action="{{url('add_course')}}" method="post">
                            @csrf
                            <div class="form-group mt-1">
                                <label for="category_id">Categorie</label>
                                <select class="form-select" id="basicSelect" name="category_id" required>
                                    <option value="1">Dezvoltare personală</option>
                                    <option value="2">Business</option>
                                    <option value="4">Relații</option>
                                    <option value="5">Mindfulness & Lifestyle</option>
                                    <option value="6">Marketing & Vânzări</option>
                                    <option value="8">Educație Financiară</option>
                                    <option value="9">Parenting</option>
                                </select>
                            </div>
                            <div class="form-group mt-1">
                                <label for="host">Trainer</label>
                                <select class="form-select" id="basicSelect" name="host" required>
                                    @foreach($data as $ho)
                                        <option value="{{$ho->id}}">{{$ho->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">Nume</label>
                                <input type="text" id="name" class="form-control" name="name" placeholder="Nume" required>
                            </div>
                            <div class="form-group mt-1">
                                <label for="subtitle">Subtitlu</label>
                                <input type="text" id="subtitle" class="form-control" name="subtitle" placeholder="Subtitlu" required>
                            </div>
                            <div class="form-group mt-1">
                                <label for="description">Descriere</label>
                                <textarea type="text" id="description" rows="5" class="form-control" name="description" placeholder="Descriere" required>

                                </textarea>
                            </div>
                            <div class="form-group mt-1">
                                <label for="views">Vizualizari</label>
                                <input type="text" id="views" class="form-control" name="views" placeholder="Vizualizari" required>
                            </div>
                            <div class="form-group mt-1">
                                <label for="image">Imagine (link bunny)</label>
                                <input type="text" id="image" class="form-control" name="image" placeholder="Imagine" required>
                            </div>
                            <div class="form-group mt-1">
                                <label for="image">Acces Abonament</label>
                                <p class="text-info text-sm">abonamentul minim de care un user are nevoie pentru a accesa cursul</p>
                                <select class="form-select" id="basicSelect" name="plan" required>
                                    <option value="0">Basic</option>
                                    <option value="2">Pro</option>
                                    <option value="3">Full</option>
                                </select>
                            </div>
                            <div class="form-group mt-1">
                                <label for="length">Durata</label>
                                <p class="text-info text-sm">02:20 h | 56:32min </p>
                                <input type="text" id="length" class="form-control" name="length" placeholder="Durata" required>
                            </div>
                            <div class="form-group mt-2">
                                <div class="form-check">
                                    <div class="checkbox">
                                        <input type="checkbox" name="coming_soon" id="checkbox1" class="form-check-input" >
                                        <label for="checkbox1">Coming Soon</label>
                                    </div>
                                </div>
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
