@extends('layouts.app')

@section('content')

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>


    <div class="modal fade" id="preprocessingModal" tabindex="-1" role="dialog" aria-labelledby="preprocessingModal"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pre Processing Output</h5>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        id="preprocessingModalClose">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tfIdfModal" tabindex="-1" role="dialog" aria-labelledby="tfIdfModal"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">TF-IDF Output</h5>
                </div>
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        id="tfIdfModalClose">Close</button>
                </div>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="col-md-12" align="center">
           <div class="car">
              <div class="card-body">
                  <div class="row ">

                    <div class="col-md-6">
                        <p align="center">Masukkan Kronologi Kejadian <i class="fa fa-edit"></i> Atau</p>
                        <div class="d-flex align-items-center justify-content-center w-100">
                            <textarea placeholder="Contoh : Setelah ibu korban bercerai dengan suaminya kurang dari 3 bulan ibu..." name="kronologi" id="kronologi" cols="50" rows="17" class="w-100"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <p align="center">Upload Data Set <i class="fa fa-file-excel-o"></i> | <a style="color: black;" target="_blank" href="/assets/data_set_1.xlsx" class="btn btn-sm btn-info">Klik Disini <i class="fa fa-hand-o-up"></i></a> melihat template data set yang dapat dibaca</p>
                        <div class="row">
                            
                            <div class="col-12 m-2">
                                <div class="row">

                                    <div class="col w-100 m-2">
                                        <input onchange="uploadDataSet();" type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" id="data_set" style="display: none;" name="file">
                                        <label style="color: black;" type="button" for="data_set" name="hasil" class="btn btn-success w-100" >Upload <i class="fa fa-upload"></i></label>
                                    </div>
                                    <div class="col w-100 m-2">
                                        <a onclick="return confirm('Yakin untuk merefresh halaman?')" href="/" style="color: black;" type="button" class="btn btn-warning w-100" >REFRESH HALAMAN <i class="fa fa-refresh"></i></a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12 m-2">
                                <p align="center">Aksi Prosesing <i class="fa fa-angle-double-right"></i></p>
                                <div class="row">
                                    <div class="col w-100 m-2">
                                        <label>Pertama <i class="fa fa-circle-o-notch"></i></label>
                                        <button style="color: black;" type="button" name="preprocessing" class="btn btn-primary w-100"
                                            id="preprocessing">PRE-PROCESSING</button>
                                    </div>
                                    <div class="col w-100 m-2">
                                        <label>Ketiga <i class="fa fa-cog"></i></label>
                                        <button style="color: black;" type="button" name="naivebayes" class="btn btn-primary w-100" disabled=true
                                            id="naivebayes">NAIVE BAYES</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 m-2">
                                <div class="row">
                                    <div class="col w-50 m-2">
                                        <label>Kedua <i class="fa fa-spinner"></i></label>
                                        <button style="color: black;" type="button" name="tfidf" class="btn btn-primary w-100" disabled=true
                                            id="tfidf">TF-IDF</button>
                                    </div>
                                    <div class="col w-50 m-2">
                                        <label>Keempat <i class="fa fa-book"></i></label>
                                        <button style="color: black;" type="button" name="evaluasi" class="btn btn-primary w-100" disabled=true
                                            id="evaluasi">EVALUASI</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 m-2">
                                <div class="row">
                                    <div class="col w-50 m-2">
                                        <label>Keenam <i class="fa fa-file-text-o"></i></label>
                                        <button style="color: black;" type="button" name="hasil" class="btn btn-primary w-100" disabled=true
                                            id="hasil">HASIL</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div> 
           </div>
        </div>
    </div>
<br>

    <div class="container" id="hasilnya" style="display: none;">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                <p align="">Hasil Preprocessing</p>
                <div class="table-responsive">
                    <table class="table table-striped" id="table-preprocessing">
                        <thead>
                            <tr>
                                <th>
                                    key
                                </th>
                                <th>
                                    Sebelum
                                </th>
                                <th>
                                    Setelah
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <p align="">Hasil TF-IDF</p>
                <div class="table-responsive">
                    <table class="table table-striped" id="table-tfIdf">
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous">
    </script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.js"></script>
    <script src="{{ url('/assets/js/main.js') }}"></script>
    <script type="text/javascript">
        function uploadDataSet() 
        {
           var CSRF_TOKEN = "{{ csrf_token() }}";
           var formData = new FormData;
           formData.append('data_set',$('input[type=file]')[0].files[0]); 
           $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                }
           });
           $.ajax({
                url: "{{url('upload_data_set')}}",  
                type: 'POST',
                data: formData,
                success:function(data){
                    if(data.success)
                    {
                        alert(data.message);
                        $('#kronologi').val(data.data);
                        $('#preprocessing').trigger('click');
                    }else
                    {
                        alert(data.message);
                    }
                        
                },
                error: function(data){
                      console.log(data);
                      alert('Tejadi kesalahan sistem');
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
    </script>
</body>

</html>
@endsection
