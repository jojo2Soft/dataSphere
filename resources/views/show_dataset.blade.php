@extends('layouts.base')
@section('content')
      
    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Détail du Dataset</h2>
          <ol>
            <li><a href="index.html">Acceuil</a></li>
            <li>Détail du Dataset</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Blog Section ======= -->
    <section id="blog" class="blog">
      <div class="container" data-aos="fade-up">

        <div class="row">

          <div class="col-lg-8 entries">

            <article class="entry">

              {{-- <div class="entry-img">
                <img src="{{ asset('assets/img/blog/blog-1.jpg') }}" alt="" class="img-fluid">
              </div> --}}

              <h2 class="entry-title">
                <a href="blog-single.html">{{ $dataset->name }}</a>
              </h2>

              <div class="entry-meta">
                <ul>
                  <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a href="blog-single.html">{{ $dataset->user->name }} </a></li>
                  <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a href="blog-single.html"><time datetime="2020-01-01">{{  $dataset->created_at }}</time></a></li>
                  <li class="d-flex align-items-center"><i class="bi bi-chat-dots"></i> <a href="blog-single.html">{{ $dataset->analyses->count() }} Comments</a></li>
                </ul>
              </div>

              <div class="entry-content">
                <p>
                  {{ $dataset->description }}
                </p>
                <div class="read-more">
                  <a href="{{ route('datasets.download', $dataset->id) }}">Telecharger</a>
                </div>
              </div>

            </article><!-- End blog entry -->

            <article class="entry">


              <h2 class="entry-title">
                <a href="blog-single.html">Dataset Information</a>
                <h2>Descriptive Statistics</h2>
                <div class="row">
                  @foreach ($statistics as $column => $stats)

                  <div class="col-6">
                    <h3>{{ $column }}</h3>
                    <p>Mean: {{ number_format($stats['mean'], 2) }}</p>
                    <p>Median: {{ number_format($stats['median'], 2) }}</p>
                    <p>Standard Deviation: {{ number_format($stats['stdDev'], 2) }}</p>
                
                  </div>
                  @endforeach

                </div>
              </h2>
              <div class="entry-meta">
            
                <div class="entry-content">
                  @foreach ($dataset->analyses as $analyse)
                  <div class="card border-0 my-2">
                    <div class="card-body">
                      <h4 class="card-title">{{ $analyse->name }}</h4>
                      <p class="card-text">{{ $analyse->description }}</p>
                    </div>

                   </div>
                   <div class="read-more">
                    <a href="#"  data-bs-toggle="modal" data-bs-target="#comment_{{ $analyse->id }}">Ajouter un commentaire !</a>
                  </div>
                  @include('layouts.comment')

                  @endforeach
                  <h2 class="read-more">
                    <a href="#"  data-bs-toggle="modal" data-bs-target="#analyse">Donnez votre anaylse !</a>

                  </h2>
                </div>
              </div>

            </article><!-- End blog entry -->

            <article class="entry">


              <h2 class="entry-title">
                <a href="blog-single.html">Variables Table</a>
              </h2>

              <div class="entry-meta">
            

              <div class="entry-content">
                <p>
                 <div
                  class="table-responsive"
                 >
                  <table
                    class="table table-primary"
                  >
                    <thead>
                      <tr>
                        <th scope="col">N</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Type</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ( $dataset->columns as $column )
                    <tr class="">
                      <td scope="row">{{  $loop->index }}</td>
                      <td scope="row">{{  $column->name }}</td>
                      <td>{{ $column->type }}</td>
                    </tr>
                    @endforeach
                    
                    </tbody>
                  </table>
                 </div>
                 
                </p>
             
              </div>

            </article><!-- End blog entry -->

            <article class="entry">

            

              <h2 class="entry-title">
                  Listes des commentaires
              </h2>

              <div class="entry-content">
                <p>
                  @foreach ($dataset->analyses as $analysis)
                  <h4>Titre:  Ananyse: {{  $analysis->name }}</h4>
                  @foreach ($analysis->comments as $comment)
                      <div class="col-lg-6">
                          <div class="testimonial-item mt-2 mt-lg-0">
                              <h3>{{ $comment->user->name }}</h3>
                              <h4>{{ $comment->user->profession }}</h4>
                              <p>
                                  <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                  {{ $comment->content }}
                                  <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                              </p>
                          </div>
                      </div>
                  @endforeach
              @endforeach
              

                   

                </p>
                
              </div>

            </article><!-- End blog entry -->

            {{-- <div class="blog-pagination">
              <ul class="justify-content-center">
                <li><a href="#">1</a></li>
                <li class="active"><a href="#">2</a></li>
                <li><a href="#">3</a></li>
              </ul>
            </div> --}}

          </div><!-- End blog entries list -->

          <div class="col-lg-4">

            <div class="sidebar">

              <a href="{{ route('datasets.download', $dataset->id) }}" class="btn btn-success my-4">Télécharger</a> <br>

              <div class="sidebar-item recent-posts">

              
              <!-- Button trigger modal -->
              
              <a href="{{ route('datasets.import') }}" class="btn btn-danger my-4">
                Import DataSet
              </a>
              

              <div class="sidebar-item recent-posts">

                <button type="button" class="btn btn-secondary my-4" data-bs-toggle="modal" data-bs-target="#comment">
                 Ajouter un commentaire
                </button>
             


              <h3 class="sidebar-title">Createur</h3>
              <p><i class="bi bi-person"></i> {{ $dataset->user->name }}</p>
             

            </div><!-- End sidebar -->

          </div><!-- End blog sidebar -->

        </div>
        @include('layouts.analyse')
      </div>
    </section><!-- End Blog Section -->
@endsection