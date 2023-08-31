@extends('layouts.main')

@section('css')

@endsection
@section('content')
<div class="content-wrapper">
   <section class="content-header">

    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Data Input</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{url('/test_input')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  @if($message=Session::get('error'))
                    <div class="alert alert-danger" role="alert">
                        <div class="alert-text">{{ucwords($message)}}</div>
                    </div>
                  @endif
                  <div class="row">
                   <div class="col-sm-12">
                      <div class="form-group">
                       <label>Nama</label>
                       <input type="text" class="form-control"  placeholder="Contoh : Wanita asal medan tidak kuat lagi menjalani rumah tangga dengan sang suami.." name="nama">
                       <input type="hidden" value="manual" name="tipe">
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group">
                       <label>Alamat</label>
                       <input type="text" class="form-control"  placeholder="Contoh : Jalan ikan lumba-lumba No 15. Medan Kota" name="alamat">
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label>Kronologi</label>
                       <textarea class="form-control"  required name="kronologi" rows="5" cols="5" placeholder="Setelah ibu korban bercerai dengan suaminya kurang dari 3 bulan ibu korban menikah kembali dengan lelaki yang usia nya terpaut jauh..."></textarea>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer" align="right">
                  <a href="{{url('history_input')}}" class="btn btn-warning"> <i class="fa fa-history"></i> 
                    Lihat History Input Data
                  </a>
                  &nbsp;
                  <button type="reset" class="btn btn-default">Reset</button>
                  &nbsp;&nbsp;
                  <button type="submit" class="btn btn-primary">Submit Input <i class="fa fa-arrow-right"></i></button>
                </div>
              </form>
              <br>
              <div class="card-header">
                <h3 class="card-title">Data Upload</h3>
              </div>
              <form role="form" action="{{url('/test_input')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  @if($message=Session::get('error_upload'))
                    <div class="alert alert-danger" role="alert">
                        <div class="alert-text">{{ucwords($message)}}</div>
                    </div>
                  @endif
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label>Upload Data Set</label>
                        <input type="file" class="form-control" name="file">
                        <input type="hidden" value="upload" name="tipe">
                      </div>
                      <p align=""><n style="color: red;">Note</n> : Upload Data Set <i class="fa fa-file-excel-o"></i> | <a style="color: black;" target="_blank" href="/assets/data_set_template_1.xlsx" class="btn btn-sm btn-info">Klik Disini <i class="fa fa-hand-o-up"></i></a> melihat template data set yang dapat dibaca</p>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer" align="right">
                  <a href="{{url('history_upload')}}" class="btn btn-warning"> <i class="fa fa-history"></i> 
                    Lihat History Upload Data
                  </a>
                  &nbsp;
                  <button type="submit" class="btn btn-primary">Upload Data <i class="fa fa-upload"></i></button>
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