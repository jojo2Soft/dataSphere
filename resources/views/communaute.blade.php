@extends('layouts.base')
@section('content')
      
    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Nous formons une communauté, passionnée de l'IA </h2>
          
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials">
      <div class="container">

        <div class="row">

         @foreach ($users as $user)
         <div class="col-lg-6 my-3">
          <div class="testimonial-item">
            <img src="assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">
            <h3>{{ $user->name }}</h3>
            <h4>Ceo &amp; Founder</h4>
            
          </div>
        </div>
         @endforeach
         <div class="d-flex justify-content-center">
          {{ $users->links('pagination::bootstrap-4') }}
      </div>

          {{-- <div class="col-lg-6">
            <div class="testimonial-item mt-4 mt-lg-0">
              <img src="assets/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="">
              <h3>Sara Wilsson</h3>
              <h4>Designer</h4>
              <p>
                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid cillum eram malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.
                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
              </p>
            </div>
          </div> --}}

     

        </div>

      </div>
    </section><!-- End Testimonials Section -->
@endsection