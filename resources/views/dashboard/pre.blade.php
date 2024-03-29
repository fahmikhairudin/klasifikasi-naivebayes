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
            <h1>Data </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Data </a></li>
              <li class="breadcrumb-item active">Preprocessing</li>
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
                <h3 class="card-title">Hasil Data  Preprocessing</h3>
                
              </div>
               <div class="card-header" align="center" style="background-color: white;">
                 <a class="btn btn-warning" href="{{url('input')}}">
                     <i class="fa fa-arrow-left"></i> Kembali Ke Data Input 
                </a>
                &nbsp;
                 <a class="btn btn-info" href="{{url('tf-idf/'.$id)}}">
                      Lihat TF-IDF <i class="fa fa-arrow-right"></i>
                </a>
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
                      <th>Label</th>
                      <th>Kronologi</th>
                      <th>Preprocessing</th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach($data as $key => $item)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$item->label}}</td>
                            <td>{{$item->kronologi}}</td>
                            <td>{{$item->preprocessing}}</td>
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