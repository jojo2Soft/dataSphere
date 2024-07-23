@extends('layouts.base')
@section('content')
       <!-- ======= Breadcrumbs ======= -->
       <section id="breadcrumbs" class="breadcrumbs ">
        <div class="container-fluid">
  
          <div class="d-flex justify-content-between align-items-center my-4">
            <h2>Bienvenue sur DataSphere</h2>
            <ol>
              <li><a href="index.html">Acceuil</a></li>
              <li>Jeux de Données</li>
            </ol>
          </div>
  
        </div>
      </section><!-- End Breadcrumbs -->
  
      <!-- ======= Services Section ======= -->
      <section id="services" class="services">
        <div class="container-fluid">
          <div class="row">
            <div class="col-6">
              <h2>Dataset Les plus populaire</h2>
              <div class="row">
                @foreach ($datasets as $dataset )
                  <div class="col-md-6">
                    <div class="icon-box">
                      <i class="bi bi-briefcase"></i>
                      <h4><a href="{{ route('showdataset', $dataset->id) }}">{{ $dataset->name }}</a></h4>
                      <p>{{ \Illuminate\Support\Str::limit($dataset->description, 112, '...') }}</p>
                    </div>
                  </div>
                @endforeach
                <div class="d-flex justify-content-center">
                  {{ $datasets->links('pagination::bootstrap-4') }}
              </div>
              </div>
              <button class="btn">Voir plus de Dataset Populaire</button>
            </div>
            <div class="col-6">
              <h2 class="justify-content-end">Dasaset Nouvellement importé</h2>
              <div class="row">
                @foreach ($newdatasets as $newdataset )
                  <div class="col-md-6">
                    <div class="icon-box">
                      <i class="bi bi-briefcase"></i>
                      <h4><a href="{{ route('showdataset', $newdataset->id) }}">{{ $newdataset->name }}</a></h4>
                      <p>{{ \Illuminate\Support\Str::limit($newdataset->description, 112, '...') }}</p>
                    </div>
                  </div>
                @endforeach
                <div class="d-flex justify-content-center">
                  {{-- {{ $newdatasets->links('pagination::bootstrap-4') }} --}}
              </div>
              </div>
              <button class="btn">Voir plus de Dataset Populaire</button>
  
            </div>
  
          </div>
  
  
        </div>
      </section><!-- End Services Section -->
  
      <!-- ======= Features Section ======= -->
      <section id="features" class="features">
        <div class="container">
  
          <div class="section-title">
            <p>DATASPHERE</p>
          </div>
  
          <div class="row">
            <div class="col-lg-3">
              <ul class="nav nav-tabs flex-column">
                <li class="nav-item">
                  <a class="nav-link active show" data-bs-toggle="tab" href="#tab-1">Pourquoi DATASPHERE ? </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="tab" href="#tab-2">Nous fesons la promotion de l'IA !</a>
                </li>
                
              </ul>
            </div>
            <div class="col-lg-9 mt-4 mt-lg-0">
              <div class="tab-content">
                <div class="tab-pane active show" id="tab-1">
                  <div class="row">
                    <div class="col-lg-8 details order-2 order-lg-1">
                      <h3>Pourquoi DATASPHERE ?</h3>
                      <p class="fst-italic">Dans l'ère numérique actuelle, les entreprises et les organisations collectent des 
                        volumes  massifs de données provenant  de  diverses sources  pour  entraîner les 
                        modèles d’IA. 
                      </p>
                      <p > La gestion efficace de ces données, leur annotation précise et leur 
                        analyse  approfondie  sont  essentielles  pour  obtenir  des  résultats  optimaux. 
                        Cependant, de nombreuses organisations manquent d'outils intuitifs et robustes 
                        permettant d'accomplir ces tâches de manière rapide et efficace, notamment via 
                        des API sécurisées et flexibles pour la consommation des données. 
                      </p>
                    </div>
                    <div class="col-lg-4 text-center order-1 order-lg-2">
                      <img src="assets/img/features-5.png" alt="" class="img-fluid">
                    </div>
                  </div>
                </div>
                <div class="tab-pane" id="tab-2">
                  <div class="row">
                    <div class="col-lg-8 details order-2 order-lg-1">
                      <h3>La promotion de l'IA</h3>
                      <p class="fst-italic">Nous feons la promotion de l'IA en mettant à la disposition de la Communauté des jeux de Données
                        pour l'entrainement de leurs modèles</p>
                    </div>
                    <div class="col-lg-4 text-center order-1 order-lg-2">
                      <img src="assets/img/features-2.png" alt="" class="img-fluid">
                    </div>
                  </div>
                </div>
               
              </div>
            </div>
          </div>
  
        </div>
      </section><!-- End Features Section -->
@endsection