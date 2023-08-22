let preprocessingDisable = false;
let tfidfDisable = true;
let naivebayesDisable = true;
let evaluasiDisable = true;
let hasilDisable = true;

let preprocessingData;

function setpreprocessingData(preprocessingDataset) {
  preprocessingData = preprocessingDataset
}


function initButton(preprocessingDisable = false, tfidfDisable = true, naivebayesDisable = true, evaluasiDisable =
  true, hasilDisable = true) {
  preprocessingDisable = preprocessingDisable
  tfidfDisable = tfidfDisable
  naivebayesDisable = naivebayesDisable
  evaluasiDisable = evaluasiDisable
  hasilDisable = hasilDisable
  if (preprocessingDisable) {
    $('#preprocessing').prop('disabled', true)
  } else {
    $('#preprocessing').prop('disabled', false)
  }

  if (tfidfDisable) {
    $('#tfidf').prop('disabled', true)
  } else {
    $('#tfidf').prop('disabled', false)
  }

  if (naivebayesDisable) {
    $('#naivebayes').prop('disabled', true)
  } else {
    $('#naivebayes').prop('disabled', false)
  }

  if (evaluasiDisable) {
    $('#evaluasi').prop('disabled', true)
  } else {
    $('#evaluasi').prop('disabled', false)
  }

  if (hasilDisable) {
    $('#hasil').prop('disabled', true)
  } else {
    $('#hasil').prop('disabled', false)
  }
}
(() => {
  initButton();
})()



$('#preprocessingModalClose').click(function () {
  $('#preprocessingModal').modal('hide');
  $('#table-preprocessing').DataTable().clear().destroy();
})

// $('#preprocessingModalClose').on('hidden.bs.modal', function (e) {
//   $('#table-preprocessing').DataTable().clear().destroy();
// })

$('#tfIdfModalClose').click(function () {
  $('#tfIdfModal').modal('hide');
  $('#table-tfIdf').DataTable().clear().destroy();
})

// $('#preprocessingModalClose').on('hidden.bs.modal', function (e) {
//   $('#table-preprocessing').DataTable().clear().destroy();
// })


$('#preprocessing').click(function () {
  var kronologi = $('textarea#kronologi').val();
  var splited = kronologi.split('\n');
  $.ajax({
    type: "POST",
    url: "https://klastering-api.invinic.site/preprocessing",
    data: {
      q: splited
    },
    headers: {
      'Access-Control-Allow-Origin': '*',
    },
    success: callbackFunc,
  });
});


$('#tfidf').click(function () {

  let wordList = [];
  Object.keys(preprocessingData.hasil).forEach(q => {
    Object.keys(preprocessingData.hasil[q]).forEach(word => {
      if (wordList.indexOf(word) <= -1) {
        wordList.push({ 'TERM': word })
      }
    })
  });

  wordList.map((value) => {
    Object.keys(preprocessingData.hasil).forEach(q => {
      value[q] = preprocessingData.hasil[q][value['TERM']] ?? 0
    })
    return value
  });
  wordList.map(value => {
    value['df'] = 0;
    for (let i = 0; i <= Object.keys(value).length - 1; i++) {
      value['df'] += value[`q${i}`] !== undefined ? parseInt(value[`q${i}`]) : 0;
    }
    value['D/df'] = 5 / value['df']
    value['IDF (log d/df)'] = Math.log(value['D/df']).toFixed(4)
    return value;
  })
  let columns = [];
  Object.keys(Object.values(wordList)[0]).forEach((element) => {
    columns.push({ 'title': element, 'data': element })
  })
  $('#tfIdfModal').modal('show')
  $('#table-tfIdf').DataTable({
    "autoWidth": false,
    "data": wordList,
    "iDisplayLength": 10,
    "paging": false,
    "searching": false,
    "ordering": false,
    "columns": columns
  });
});



function callbackFunctfidf(response) {
  console.log(response)
}

function callbackFunc(response) {

  initButton(true, false, true, true, true)
  setpreprocessingData(response.data)
  iKey = 1;
  iSetelah = 0;
  console.log(response['data']);
  $('#preprocessingModal').modal('show')
  $('#table-preprocessing').DataTable({
    "autoWidth": false,
    "data": response['data']['q'],
    "iDisplayLength": 10,
    "paging": false,
    "searching": false,
    "ordering": false,
    "columns": [{
      "data": "KEY",
      "render": function (value, type, row, meta) {
        return `q${iKey++}`;
      }
    },
    {
      "data": "SEBELUM",
      "render": function (value, type, row, meta) {
        return row;
      }
    },
    {
      "data": "SETELAH",
      "render": function (value, type, row, meta) {
        return Object.keys(response['data']['hasil'][`q${iSetelah++}`]).join(', ');
      }
    },
    ]
  });
}