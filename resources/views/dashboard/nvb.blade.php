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
            <h1>Hasil Klasifikasi</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Data Upload</a></li>
              <li class="breadcrumb-item active">Naive Bayes</li>
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
                <h3 class="card-title">Hasil Data Klasifikasi Naive Bayes</h3>
                
              </div>
               <div class="card-header" align="center" style="background-color: white;">
                 <a class="btn btn-warning" href="{{url('tf-idf/'.$id)}}">
                     <i class="fa fa-arrow-left"></i> Lihat Ke TF IDF
                </a>
                &nbsp;
                 <a class="btn btn-info" style="cursor: pointer;" class="btn btn-info" data-toggle="modal" 
                    data-target="#matrix">
                      Confusion Matrix &nbsp; <i class="fa fa-table"></i>&nbsp; &  Accuracy &nbsp; <i class="fa fa-bullseye"></i>
                </a>
              
               </div>
              <div class="card-body">
                @if($message=Session::get('success'))
                    <div class="alert alert-success" role="alert">
                        <div class="alert-text">{{ucwords($message)}}</div>
                    </div>
                  @endif
               
                <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>Kronologi</th>
                      <th>Kata</th>
                      <th>Aktual</th>
                      <th>NBC</th>
                      <th>Tanggal</th>
                     <!--  <th>Probabilitas</th> -->
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach($data as $key => $item)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$item->kronologi}}</td>
                            <td>{{$item->preprocessing}}</td>
                            <td>{{$item->label}}</td>
                            <td>{{$item->hasil_nbc}}</td>
                            <td>
                              {{Carbon\Carbon::parse($item->created_at)->format('d F Y H:i:s')}}
                            </td>
                            <!-- <td>
                              <ul>
                                <li>
                                  P|(Seksual) : <b>{{$item->seksual}}</b>
                                </li>
                                <li>
                                  P|(Pelecehan) : <b>{{$item->pelecehan}}</b>
                                </li>
                                <li>
                                  P|(Kekerasan Anak) : <b>{{$item->kekerasan_anak}}</b>
                                </li>
                                <li>
                                  P|(KDRT) : <b>{{$item->kdrt}}</b>
                                </li>
                                <li>
                                  P|(penipuan) : <b>{{$item->penipuan}}</b>
                                </li>
                              </ul>
                            </td> -->
                            <td>
                                <a class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Yakin hapus data uji?')" 
                                   href="{{url('nvb_delete/'.$item->id)}}">
                                  Hapus <i class="fa fa-trash"></i>
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

  <!-- The Modal -->
<div class="modal" id="matrix">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Confusion Matrik & Acuuracy</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body table-responsive">
       <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <td rowspan="7" style="text-align: center;padding-top: 16%;">Hasil Aktual</td>
            <td colspan="6" style="text-align:center;">Hasil Prediksi</td>
          </tr>
          <tr>
            <td></td>
            <td>SEKSUAL</td>
            <td>PELECEHAN</td>
            <td>KEKERASAN ANAK</td>
            <td>KDRT</td>
            <td>PENIPUAN</td>
          </tr>
          <tr>
            <td>SEKSUAL</td>
            <td>{{$prediksi['seksual_seksual']}}</td>
            <td>{{$prediksi['seksual_pelecehan']}}</td>
            <td>{{$prediksi['seksual_kekerasan_anak']}}</td>
            <td>{{$prediksi['seksual_kdrt']}}</td>
            <td>{{$prediksi['seksual_penipuan']}}</td>
          </tr>
          <tr>
            <td>PELECEHAN</td>
            <td>{{$prediksi['pelecehan_seksual']}}</td>
            <td>{{$prediksi['pelecehan_pelecehan']}}</td>
            <td>{{$prediksi['pelecehan_kekerasan_anak']}}</td>
            <td>{{$prediksi['pelecehan_kdrt']}}</td>
            <td>{{$prediksi['pelecehan_penipuan']}}</td>
          </tr>
          <tr>
            <td>KEKERASAN ANAK</td>
            <td>{{$prediksi['kekerasan_anak_seksual']}}</td>
            <td>{{$prediksi['kekerasan_anak_pelecehan']}}</td>
            <td>{{$prediksi['kekerasan_anak_kekerasan_anak']}}</td>
            <td>{{$prediksi['kekerasan_anak_kdrt']}}</td>
            <td>{{$prediksi['kekerasan_anak_penipuan']}}</td>
          </tr>
          <tr>
            <td>KDRT</td>
            <td>{{$prediksi['kdrt_seksual']}}</td>
            <td>{{$prediksi['kdrt_pelecehan']}}</td>
            <td>{{$prediksi['kdrt_kekerasan_anak']}}</td>
            <td>{{$prediksi['kdrt_kdrt']}}</td>
            <td>{{$prediksi['kdrt_penipuan']}}</td>
          </tr>
          <tr>
            <td>PENIPUAN</td>
            <td>{{$prediksi['penipuan_seksual']}}</td>
            <td>{{$prediksi['penipuan_pelecehan']}}</td>
            <td>{{$prediksi['penipuan_kekerasan_anak']}}</td>
            <td>{{$prediksi['penipuan_kdrt']}}</td>
            <td>{{$prediksi['penipuan_penipuan']}}</td>
          </tr>
        </thead>

       </table>

       <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>TP (SEKSUAL) = {{$prediksi['seksual_seksual']}}</th>
            <th>TP (PELECEHAN) = {{$prediksi['pelecehan_pelecehan']}}</th>
            <th>TP (KEKERASAN ANAK) = {{$prediksi['kekerasan_anak_kekerasan_anak']}}</th>
            <th>TP (KDRT) = {{$prediksi['kdrt_kdrt']}}</th>
            <th colspan="3">TP (PENIPUAN) = {{$prediksi['penipuan_penipuan']}}</th>
          </tr>
        </thead>
        @php 
          $fnSeksual = $prediksi['seksual_pelecehan'] + $prediksi['seksual_kekerasan_anak'] + $prediksi['seksual_kdrt'] + $prediksi['seksual_penipuan'];
          $fpSeksual = $prediksi['pelecehan_seksual'] + $prediksi['kekerasan_anak_seksual'] + $prediksi['kdrt_seksual'] + $prediksi['penipuan_seksual'];

          $fnPelecehan = $prediksi['pelecehan_seksual'] + $prediksi['pelecehan_kekerasan_anak'] + $prediksi['pelecehan_kdrt'] + $prediksi['pelecehan_penipuan'];
          $fpPelecehan = $prediksi['seksual_pelecehan'] + $prediksi['kekerasan_anak_pelecehan'] + $prediksi['kdrt_pelecehan'] + $prediksi['penipuan_pelecehan'];

          $fnKa = $prediksi['kekerasan_anak_seksual'] + $prediksi['kekerasan_anak_pelecehan'] + $prediksi['kekerasan_anak_kdrt'] + $prediksi['kekerasan_anak_penipuan'];
          $fpKa = $prediksi['seksual_kekerasan_anak'] + $prediksi['pelecehan_kekerasan_anak'] + $prediksi['kdrt_kekerasan_anak'] + $prediksi['penipuan_kekerasan_anak'];

          $fnKkdrt = $prediksi['kdrt_seksual'] + $prediksi['kdrt_kekerasan_anak'] + $prediksi['kdrt_pelecehan'] + $prediksi['kdrt_penipuan'];
          $fpKdrt = $prediksi['seksual_kdrt'] + $prediksi['pelecehan_kdrt'] + $prediksi['kekerasan_anak_kdrt'] + $prediksi['penipuan_kdrt'];

          $fnPenipuan = $prediksi['penipuan_seksual'] + $prediksi['penipuan_kekerasan_anak'] + $prediksi['penipuan_kdrt'] + $prediksi['penipuan_pelecehan'];
          $fpPenipuan = $prediksi['seksual_penipuan'] + $prediksi['pelecehan_penipuan'] + $prediksi['kekerasan_anak_penipuan'] + $prediksi['kdrt_penipuan'];

          $tp = $prediksi['seksual_seksual'] + $prediksi['pelecehan_pelecehan'] + $prediksi['kekerasan_anak_kekerasan_anak'] + $prediksi['kdrt_kdrt'] + $prediksi['penipuan_penipuan'];
        @endphp
        <tbody>
          <tr>
            <td>FN (SEKSUAL) = {{$fnSeksual}}</td>
            <td>FN (PELECEHAN) = {{$fnPelecehan}}</td>
            <td>FN (KEKERASAN ANAK) = {{$fnKa}}</td>
            <td>FN (KDRT) = {{$fnKkdrt}}</td>
            <td colspan="3">FN (PENIPUAN) = {{$fnPenipuan}}</td>
          </tr>
          <tr>
            <td colspan="7">Nilai Accuracy = TP/Total Data Set = {{$tp}}/{{$dataset}} ={{$tp/$dataset}}</td>
          </tr>

          <tr>
            <td colspan="7">
              Nilai Precision (SEKSUAL)  = TP/(TP+FP) = {{$prediksi['seksual_seksual']}}/({{$prediksi['seksual_seksual']}}+{{$fpSeksual}}) = 
              @if($prediksi['seksual_seksual'] > 0)
                {{ $prediksi['seksual_seksual'] / ($prediksi['seksual_seksual'] + $fpSeksual) }}
              @else
                0
              @endif
            </td>
          </tr>
          <tr>
            <td colspan="7">Nilai Precision (PELECEHAN) = TP/(TP+FP)  = {{$prediksi['pelecehan_pelecehan']}}/({{$prediksi['pelecehan_pelecehan']}}+{{$fpPelecehan}}) = 
             @if($prediksi['pelecehan_pelecehan'] > 0)
              {{ $prediksi['pelecehan_pelecehan'] / ($prediksi['pelecehan_pelecehan'] + $fpPelecehan) }}
             @else
                0
             @endif
            </td>
          </tr>
          <tr>
            <td colspan="7">Nilai Precision (KDRT) = TP/(TP+FP)  = {{$prediksi['kdrt_kdrt']}}/({{$prediksi['kdrt_kdrt']}}+{{$fpKdrt}}) = 
              @if($prediksi['kdrt_kdrt'] > 0)
                {{ $prediksi['kdrt_kdrt'] / ($prediksi['kdrt_kdrt'] + $fpKdrt) }}
              @else
                0
              @endif
            </td>
          </tr>
          <tr>
            <td colspan="7">Nilai Precision (KEKERASAN ANAK) = TP/(TP+FP)  = {{$prediksi['kekerasan_anak_kekerasan_anak']}}/({{$prediksi['kekerasan_anak_kekerasan_anak']}}+{{$fpKa}}) =
              @if($prediksi['kekerasan_anak_kekerasan_anak'] > 0)
                {{ $prediksi['kekerasan_anak_kekerasan_anak'] / ($prediksi['kekerasan_anak_kekerasan_anak'] + $fpKa) }}
              @else
                0
              @endif
            </td>
          </tr>
          <tr>
            <td colspan="7">Nilai Precision (PENIPUAN) = TP/(TP+FP) = {{$prediksi['penipuan_penipuan']}}/({{$prediksi['penipuan_penipuan']}}+{{$fpPenipuan}}) =
              @if($prediksi['penipuan_penipuan'] > 0)
                {{ $prediksi['penipuan_penipuan'] / ($prediksi['penipuan_penipuan'] + $fpPenipuan) }}
              @else
                0
              @endif
            </td>
          </tr>

          @php
            $psek = 0;
            $ppel = 0;
            $pka = 0;
            $pkdrt = 0;
            $pnip = 0;
          @endphp
          <tr>
            <td colspan="7">Total Nilai Precision 
              P(SEK)+P(PEL)+P(KA)+P(KDRT)+P(PEN)) / Jumlah Kelas = 

              @if($prediksi['seksual_seksual'] > 0)
                @php
                  $psek = $prediksi['seksual_seksual'] / ($prediksi['seksual_seksual'] + $fpSeksual)
                @endphp
                {{$prediksi['seksual_seksual'] / ($prediksi['seksual_seksual'] + $fpSeksual)}}
              @else
                0
              @endif
              +
              @if($prediksi['pelecehan_pelecehan'] > 0)
                @php
                  $ppel = $prediksi['pelecehan_pelecehan'] / ($prediksi['pelecehan_pelecehan'] + $fpPelecehan)
                @endphp
                {{$prediksi['pelecehan_pelecehan'] / ($prediksi['pelecehan_pelecehan'] + $fpPelecehan)}}
              @else
                0
              @endif
              +
              @if($prediksi['kdrt_kdrt'] > 0)
                @php
                  $pkdrt = $prediksi['kdrt_kdrt'] / ($prediksi['kdrt_kdrt'] + $fpKdrt)
                @endphp
                {{$prediksi['kdrt_kdrt'] / ($prediksi['kdrt_kdrt'] + $fpKdrt)}}
              @else
                0
              @endif
              +
              @if($prediksi['kekerasan_anak_kekerasan_anak'] > 0)
                @php
                  $pka = $prediksi['kekerasan_anak_kekerasan_anak'] / ($prediksi['kekerasan_anak_kekerasan_anak'] + $fpKa)
                @endphp
                {{$prediksi['kekerasan_anak_kekerasan_anak'] / ($prediksi['kekerasan_anak_kekerasan_anak'] + $fpKa)}}
              @else
                0
              @endif
              +
              @if($prediksi['penipuan_penipuan'] > 0)
                @php
                  $pnip = $prediksi['penipuan_penipuan'] / ($prediksi['penipuan_penipuan'] + $fpPenipuan)
                @endphp
                {{$prediksi['penipuan_penipuan'] / ($prediksi['penipuan_penipuan'] + $fpPenipuan)}}
              @else
                0
              @endif
              / 5

              @php 
                $hasil = $psek + $ppel + $pkdrt + $pka + $pnip;
              @endphp
              =
                {{$hasil}} / 5
              =
              
              @if($hasil > 0)
                {{ $hasil / 5}}
              @else
                0
              @endif

            </td>
          </tr>

          <tr>
            <td colspan="7">
              Nilai Recall (SEKSUAL)  = TP/(TP+FN) = {{$prediksi['seksual_seksual']}}/({{$prediksi['seksual_seksual']}}+{{$fnSeksual}}) = 
              @if($prediksi['seksual_seksual'] > 0)
                {{ $prediksi['seksual_seksual'] / ($prediksi['seksual_seksual'] + $fnSeksual) }}
              @else
                0
              @endif
            </td>
          </tr>
          <tr>
            <td colspan="7">Nilai Recall (PELECEHAN) = TP/(TP+FN)  = {{$prediksi['pelecehan_pelecehan']}}/({{$prediksi['pelecehan_pelecehan']}}+{{$fnPelecehan}}) = 
             @if($prediksi['pelecehan_pelecehan'] > 0)
              {{ $prediksi['pelecehan_pelecehan'] / ($prediksi['pelecehan_pelecehan'] + $fnPelecehan) }}
             @else
                0
             @endif
            </td>
          </tr>
          <tr>
            <td colspan="7">Nilai Recall (KDRT) = TP/(TP+FN)  = {{$prediksi['kdrt_kdrt']}}/({{$prediksi['kdrt_kdrt']}}+{{$fnKkdrt}}) = 
              @if($prediksi['kdrt_kdrt'] > 0)
                {{ $prediksi['kdrt_kdrt'] / ($prediksi['kdrt_kdrt'] + $fnKkdrt) }}
              @else
                0
              @endif
            </td>
          </tr>
          <tr>
            <td colspan="7">Nilai Recall (KEKERASAN ANAK) = TP/(TP+FN)  = {{$prediksi['kekerasan_anak_kekerasan_anak']}}/({{$prediksi['kekerasan_anak_kekerasan_anak']}}+{{$fnKa}}) =
              @if($prediksi['kekerasan_anak_kekerasan_anak'] > 0)
                {{ $prediksi['kekerasan_anak_kekerasan_anak'] / ($prediksi['kekerasan_anak_kekerasan_anak'] + $fnKa) }}
              @else
                0
              @endif
            </td>
          </tr>
          <tr>
            <td colspan="7">Nilai Recall (PENIPUAN) = TP/(TP+FN) = {{$prediksi['penipuan_penipuan']}}/({{$prediksi['penipuan_penipuan']}}+{{$fnPenipuan}}) =
              @if($prediksi['penipuan_penipuan'] > 0)
                {{ $prediksi['penipuan_penipuan'] / ($prediksi['penipuan_penipuan'] + $fnPenipuan) }}
              @else
                0
              @endif
            </td>
          </tr>

          @php
            $psek = 0;
            $ppel = 0;
            $pka = 0;
            $pkdrt = 0;
            $pnip = 0;
          @endphp
          <tr>
            <td colspan="7">Total Nilai Recall 
              R(SEK)+R(PEL)+R(KA)+R(KDRT)+R(PEN)) / Jumlah Kelas = 

              @if($prediksi['seksual_seksual'] > 0)
                @php
                  $psek = $prediksi['seksual_seksual'] / ($prediksi['seksual_seksual'] + $fnSeksual)
                @endphp
                {{$prediksi['seksual_seksual'] / ($prediksi['seksual_seksual'] + $fnSeksual)}}
              @else
                0
              @endif
              +
              @if($prediksi['pelecehan_pelecehan'] > 0)
                @php
                  $ppel = $prediksi['pelecehan_pelecehan'] / ($prediksi['pelecehan_pelecehan'] + $fnPelecehan)
                @endphp
                {{$prediksi['pelecehan_pelecehan'] / ($prediksi['pelecehan_pelecehan'] + $fnPelecehan)}}
              @else
                0
              @endif
              +
              @if($prediksi['kdrt_kdrt'] > 0)
                @php
                  $pkdrt = $prediksi['kdrt_kdrt'] / ($prediksi['kdrt_kdrt'] + $fnKkdrt)
                @endphp
                {{$prediksi['kdrt_kdrt'] / ($prediksi['kdrt_kdrt'] + $fnKkdrt)}}
              @else
                0
              @endif
              +
              @if($prediksi['kekerasan_anak_kekerasan_anak'] > 0)
                @php
                  $pka = $prediksi['kekerasan_anak_kekerasan_anak'] / ($prediksi['kekerasan_anak_kekerasan_anak'] + $fnKa)
                @endphp
                {{$prediksi['kekerasan_anak_kekerasan_anak'] / ($prediksi['kekerasan_anak_kekerasan_anak'] + $fnKa)}}
              @else
                0
              @endif
              +
              @if($prediksi['penipuan_penipuan'] > 0)
                @php
                  $pnip = $prediksi['penipuan_penipuan'] / ($prediksi['penipuan_penipuan'] + $fnPenipuan)
                @endphp
                {{$prediksi['penipuan_penipuan'] / ($prediksi['penipuan_penipuan'] + $fnPenipuan)}}
              @else
                0
              @endif
              / 5

              @php 
                $hasilR = $psek + $ppel + $pkdrt + $pka + $pnip;
              @endphp
              =
                {{$hasilR}} / 5
              =
              
              @if($hasilR > 0)
                {{ $hasilR / 5}}
              @else
                0
              @endif

            </td>
          </tr>
          <tr>
            <td colspan="7">
              <em>F-Mensure</em> = 2(recall×precision)) / (recall+precision) = 
              @if($hasilR > 0 && $hasil > 0)
              2( {{$hasilR/5}} x {{$hasil/5}} ) / ( {{$hasilR/5}} + {{$hasil/5}} ) 

              = {{ ( ($hasilR/5) * ($hasil/5) * 2) }} / {{ ($hasilR/5) + ($hasilR/5) }}

              = {{ ( ($hasilR/5) * ($hasil/5) * 2) / ( ($hasilR/5) + ($hasilR/5) ) }}
              @else
              -
              @endif
            </td>
          </tr>
        </tbody>
       </table>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
      </div>

    </div>
  </div>
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