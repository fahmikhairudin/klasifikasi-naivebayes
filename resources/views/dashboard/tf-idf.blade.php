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
            <h1>Data Tf Idf</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Data Tf Idf</a></li>
              <li class="breadcrumb-item active">TF IDF</li>
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
                <h3 class="card-title">Hasl Data Tf Idf</h3>
              </div>
               <div class="card-header" align="center" style="background-color: white;">
                <a class="btn btn-warning" href="{{url('pre/'.$id)}}">
                     <i class="fa fa-arrow-left"></i> Lihat Ke Preprocessing 
                </a>
                &nbsp;
                 <a class="btn btn-info" href="{{url('nvb/'.$id)}}">
                      Hasil Klasifikasi Data Upload <i class="fa fa-arrow-right"></i>
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
                      <th>Kata</th>
                      <th>D1 Seksual</th>
                      <th>D2 Pelcehan</th>
                      <th>D3 Kekerasan Anak</th>
                      <th>D4 KDRT</th>
                      <th>D5 Penipuan</th>
                      <th>DF</th>
                      <th>D/DF</th>
                      <th>IDF(LOG(D/DF))</th>
                      <th>Probabilitas</th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach($data as $key => $item)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$item->kata}}</td>
                            <td>{{$item->seksual}}</td>
                            <td>{{$item->pelecehan}}</td>
                            <td>{{$item->kekerasan_anak}}</td>
                            <td>{{$item->kdrt}}</td>
                            <td>{{$item->penipuan}}</td>
                            <td>{{$item->df}}</td>
                            <td>{{$item->d_df}}</td>
                            <td>{{$item->idf}}</td>
                            <td>
                              <ul>
                                <li>
                                  P({{$item->kata}}|Seksual) : <b>{{$item->prob_seksual}}</b>
                                </li>
                                <li>
                                  P({{$item->kata}}|Pelecehan) : <b>{{$item->prob_pelecehan}}</b>
                                </li>
                                <li>
                                  P({{$item->kata}}|Kekerasan Anak) : <b>{{$item->prob_kekerasan_anak}}</b>
                                </li>
                                <li>
                                  P({{$item->kata}}|KDRT) : <b>{{$item->prob_kdrt}}</b>
                                </li>
                                <li>
                                  P({{$item->kata}}|penipuan) : <b>{{$item->prob_penipuan}}</b>
                                </li>
                              </ul>
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