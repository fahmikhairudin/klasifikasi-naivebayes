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
            <h1>History Upload</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">History</a></li>
              <li class="breadcrumb-item active">Upload</li>
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

              <div class="card-header row">
                <div class="col-sm-6 pt-2">
                  <h3 class="card-title">History Upload</h3>
                </div>
                <div class="col-sm-6" align="right">
                <a href="{{url('input')}}" class="btn btn-success">
                  <i class="fa fa-arrow-left"></i> Kembali Ke Data Input
                </a>
                </div>
              </div>
              <div class="card-body">
                @if($message=Session::get('success_hapus'))
                    <div class="alert alert-success" role="alert">
                        <div class="alert-text">{{ucwords($message)}}</div>
                    </div>
                  @endif
                <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>File Yang Di Upload</th>
                      <th>Tanggal Upload</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach($data as $key => $item)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>
                              <a class="btn btn-sm btn-warning" href="{{url('assets/data_set/'.$item->file)}}">
                                Lihat File <i class="fa fa-file-excel-o"></i>
                              </a>
                            </td>
                            <td>
                              {{Carbon\Carbon::parse($item->created_at)->format('d F Y H:i:s')}}
                            </td>
                            <td>
                              <a href="{{url('nvb/'.$item->id)}}" class="btn btn-sm btn-success">
                                Lihat Hasil <i class="fa fa-eye"></i>
                              </a>
                            </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
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