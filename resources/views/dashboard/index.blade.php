@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
       <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header" style="text-align: center;">
                <p align="center" class="pt-2" style="margin-bottom: 0;">
                    Selamat Datang Di Sistem Klasfikasi Kekerasan Perempuan NVb 
                </p>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fa fa-minus"></i>
                  </button>

                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">

                  <div class="col-md-12">
                   <h1 align="center">KELASIFIKASI KASUS KEKERASAN PADA PEREMPUAN MENGGUNAKAN METODE NAIVE BAYES CLASSIFER</h1>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>


      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection


@section('script')

@endsection
