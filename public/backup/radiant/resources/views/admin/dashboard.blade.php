@extends('admin.layouts.main')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">

                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success text-center">
                        <div class="inner">
                            <h3>{{ $admincount }}</h3>

                            <p> All Subadmin</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ url('admin/subadmin') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-secondary text-center">
                        <div class="inner">
                            <h3>{{ $testimonialcount }}</h3>

                            <p> All Testimonials</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ url('admin/testimonials') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-primary text-center">
                        <div class="inner">
                            <h3>{{ $generalInquirycount }}</h3>

                            <p> All General Inquires</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ url('admin/general_inquires') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning text-center">
                        <div class="inner">
                            <h3></h3>

                            <p> All Product Inquires</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                

                

         



            </div>


        </div>
    </section>
@endsection
