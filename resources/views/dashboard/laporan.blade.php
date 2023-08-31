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
              <div class="card-header row">
                <div class="col-sm-6 pt-2">
                  <h3 class="card-title">Hasil Klasfikasi</h3>
                </div>
                <div class="col-sm-6" align="right">
                <a href="{{url('input')}}" class="btn btn-success">
                  <i class="fa fa-arrow-left"></i> Kembali Ke Data Input
                </a>
                </div>
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
                       <p>{{$data->nama}}</p>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group">
                       <label>Alamat</label>
                       <p>{{$data->alamat}}</p>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group">
                       <label>Kronologi</label>
                       <p>{{$data->kronologi}}</p>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group">
                       <label>Label</label>
                       <p style="color:red;">{{str_replace('_',' ',$data->hasil_nbc)}}</p>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer" align="right">
                  
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