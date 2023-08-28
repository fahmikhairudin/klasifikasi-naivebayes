@extends('layouts.main')

@section('css')

@endsection
@section('content')
<div class="content-wrapper">
   <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Uji</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Data</a></li>
              <li class="breadcrumb-item active">Uji</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Tambah Data Uji</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{url('/input/manual')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  @if($message=Session::get('error'))
                    <div class="alert alert-danger" role="alert">
                        <div class="alert-text">{{ucwords($message)}}</div>
                    </div>
                  @endif
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                       <label>Jenis</label>
                        <select class="form-control" name="jenis">
                          <option value="" disabled selected>Pilih Jenis</option>
                          <option value="seksual">Seksual</option>
                          <option value="pelecehan">Pelecehan</option>
                          <option value="kekerasan_anak">Kekerasan Anak</option>
                          <option value="kdrt">KDRT</option>
                          <option value="penipuan">Penipuan</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Kronologi</label>
                       <textarea class="form-control" name="kronologi" rows="5" cols="5" placeholder="Setelah ibu korban bercerai dengan suaminya kurang dari 3 bulan ibu korban menikah kembali dengan lelaki yang usia nya terpaut jauh..."></textarea>
                      </div>
                    </div>
                   <!--  <div class="col-sm-12">
                      <div class="form-group">
                        <label>Upload Data Set</label>
                        <input type="file" class="form-control" name="">
                      </div>
                      <p align=""><n style="color: red;">Note</n> : Upload Data Set <i class="fa fa-file-excel-o"></i> | <a style="color: black;" target="_blank" href="/assets/data_set_2.xlsx" class="btn btn-sm btn-info">Klik Disini <i class="fa fa-hand-o-up"></i></a> melihat template data set yang dapat dibaca</p>
                    </div> -->
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer" align="right">
                  <button type="reset" class="btn btn-default">Reset</button>
                  &nbsp;&nbsp;
                  <button type="submit" class="btn btn-primary">Uji Data <i class="fa fa-arrow-right"></i></button>
                </div>
              </form>
            </div>
            <!-- /.card -->

          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection
@section('script')
<script src="{{url('plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
@endsection