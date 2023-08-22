<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css" />
    <style>
        html,
        body {
            height: 100%
        }
    </style>
</head>

<body>


    <div class="modal fade" id="preprocessingModal" tabindex="-1" role="dialog" aria-labelledby="preprocessingModal"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pre Processing Output</h5>
                </div>
                <div class="modal-body">
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        id="preprocessingModalClose">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tfIdfModal" tabindex="-1" role="dialog" aria-labelledby="tfIdfModal"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">TF-IDF Output</h5>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-tfIdf">
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        id="tfIdfModalClose">Close</button>
                </div>
            </div>
        </div>
    </div>



    <div class="h-100 d-flex align-items-center justify-content-center">
        <div class="border p-2  w-25">
            <div class="row align-items-start">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-center w-100">
                        <textarea name="kronologi" id="kronologi" cols="30" rows="10" class="w-100"></textarea>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 m-2">
                            <div class="row">
                                <div class="col w-100 m-2">
                                    <button type="button" name="preprocessing" class="btn btn-primary w-100"
                                        id="preprocessing">PRE-PROCESSING</button>
                                </div>
                                <div class="col w-100 m-2">
                                    <button type="button" name="naivebayes" class="btn btn-primary w-100" disabled=true
                                        id="naivebayes">NAIVE BAYES</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 m-2">
                            <div class="row">
                                <div class="col w-50 m-2">
                                    <button type="button" name="tfidf" class="btn btn-primary w-100" disabled=true
                                        id="tfidf">TF-IDF</button>
                                </div>
                                <div class="col w-50 m-2">
                                    <button type="button" name="evaluasi" class="btn btn-primary w-100" disabled=true
                                        id="evaluasi">EVALUASI</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 m-2">
                            <div class="row">
                                <div class="col w-50 m-2">
                                    <button type="button" name="hasil" class="btn btn-primary w-100" disabled=true
                                        id="hasil">HASIL</button>
                                </div>
                            </div>
                        </div>
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
</body>

</html>
