@extends('layouts.main')

@section('css')
  <link rel="stylesheet" href="{{url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection
@section('content')
<div class="content-wrapper">
   <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Latih</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Data Latih</a></li>
              <li class="breadcrumb-item active">Tambah</li>
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
                <h3 class="card-title">Tambah Data Latih</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{url('/data_latih/input')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  @if($message=Session::get('error'))
                    <div class="alert alert-danger" role="alert">
                        <div class="alert-text">{{ucwords($message)}}</div>
                    </div>
                  @endif
                  @if($message=Session::get('success'))
                    <div class="alert alert-success" role="alert">
                        <div class="alert-text">{{ucwords($message)}}</div>
                    </div>
                  @endif
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                       <label>Jenis</label>
                        <select class="form-control" name="label" required> 
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
                       <textarea class="form-control" required name="kronologi" rows="5" cols="5" placeholder="Setelah ibu korban bercerai dengan suaminya kurang dari 3 bulan ibu korban menikah kembali dengan lelaki yang usia nya terpaut jauh..."></textarea>
                      </div>
                    </div>
                    <div class="col-sm-12" align="center">
                      <a class="btn btn-success" href="{{url('data_latih/train')}}" 
                         onclick="return confirm('yakin untuk melatih data?')">
                        Latih Data <i class="fa fa-refresh"></i>
                      </a>
                      &nbsp;&nbsp;
                      <a class="btn btn-info" href="{{url('pre')}}">
                        Lihat Preprocessing <i class="fa fa-arrow-right"></i>
                      </a>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer" align="right">
                  <button type="reset" class="btn btn-default">Reset</button>
                  &nbsp;&nbsp;
                  <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data Latih</button>
                </div>
              </form>
            </div>
            <!-- /.card -->

          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->

       <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Daftar Data Latih</h3>
              </div>
              <div class="card-body">
                @if($message=Session::get('success_hapus'))
                    <div class="alert alert-success" role="alert">
                        <div class="alert-text">{{ucwords($message)}}</div>
                    </div>
                  @endif
                <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Label</th>
                  <th>Kronologi</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($data as $key => $item)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$item->label}}</td>
                        <td>{{$item->kronologi}}</td>
                        <td>
                          <a class="btn btn-sm btn-danger" 
                             onclick="return confirm('Yakin hapus data latih?')" 
                             href="{{url('data_latih_delete/'.$item->id)}}">
                            Hapus <i class="fa fa-trash"></i>
                          </a>
                        </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              </div>
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
<script src="{{url('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{url('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{url('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{url('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script type="text/javascript">
    $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
</script>
@endsection