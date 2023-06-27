@extends('layouts.app')

@section('content')
<div class="pagetitle">
  <h1>Products</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item active">Products</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<div class="card">
    <div class="card-header">
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-import">
        Import
      </button>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-addedit">
        Add
      </button>
    </div>
    <div class="card-body">

        <!-- Table with hoverable rows -->
        <table class="table table-hover">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Brand</th>
            <th scope="col">Model</th>
            <th scope="col">Capacity</th>
            <th scope="col">Quantity</th>
            </tr>
        </thead>
        <tbody id="tbody">
            <tr>
            <th scope="row">1</th>
            <td>Brandon Jacob</td>
            <td>Designer</td>
            <td>28</td>
            <td>2016-05-25</td>
            </tr>
        </tbody>
        </table>
        <!-- End Table with hoverable rows -->

    </div>
    <div class="modal fade" id="modal-import" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <form id="form_import" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Import</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <a href="{{ route('api.product.import.template.download') }}" target="_blank">Download Template</a>
              </div>
                  <div class="row">
                      <label for="inputNumber" class="col-sm-2 col-form-label">File Upload</label>
                      <div class="col-sm-10">
                      <input class="form-control" type="file" id="file-upload" name="file">
                      <div class="invalid-feedback file-error" style="display: none;">Please select file!</div>
                      </div>
                  </div>                  
              </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Import</button>
            </div>
          </div>
        </form>
      </div>
    </div>
</div>

@endsection

@push('js')
<script>
    $(function() {
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
        if(Cookies.get('token') == '') {
            window.location = "{{ route('login') }}";
        } else {
            $.ajax({
                type: "GET",
                url: "{{ route('products.index') }}",
                headers: {
                    'Authorization': "Bearer "+ Cookies.get('token')
                },
            }).done(function (res) {
                // console.log(data);
                let arr = '';
                res.data.forEach(element => {
                    arr += '<tr id="row'+ element.id +'">'+
                            '<td>'+ element.id + '</td>' +
                            '<td>'+ element.brand + '</td>' +
                            '<td>'+ element.model + '</td>' +
                            '<td>'+ element.capacity + '</td>' +
                            '<td>'+ element.quantity + '</td>' +
                            '</tr>';
                });
                $('#tbody').html(arr);
                
            });
        }
  
        $("#form_import").on('submit', (function (e) {
          e.preventDefault();
          var files = $('#file-upload')[0].files;
          if(files.length > 0){
            let formData = new FormData();
            formData.append('file',files[0]);
            formData.append('_token',CSRF_TOKEN);
            $.ajax({
              url: "{{ route('api.product.import.store') }}",
              type: "POST",
              data: formData,
              async: true,
              contentType: false, // The content type used when sending data to the server.
              cache: false, // To unable request pages to be cached
              processData: false,
              beforeSend: function(xhr){
                $('.file-error').css('display','none');
              }
            }).done(function (res) {
                  let arr = '';
                  res.data.forEach(element => {
                      arr += '<tr id="row'+ element.id +'">'+
                              '<td>'+ element.id + '</td>' +
                              '<td>'+ element.brand + '</td>' +
                              '<td>'+ element.model + '</td>' +
                              '<td>'+ element.capacity + '</td>' +
                              '<td>'+ element.quantity + '</td>' +
                              '</tr>';
                  });
                  $('#tbody').html(arr);
                  $('#modal-import').modal('hide');
                  $(':input').val('');
            });
          } else{
            $('.file-error').css('display','block');
          }
        }));

        function add() {
          $('#login-form').submit(function() {
              let data = $('#login-form').serialize();
              console.log('data', data)
              $.ajax({
                  type: "POST",
                  url: "{{ route('api.login') }}",
                  data: data,
                  dataType: "json",
              }).done(function (res) {
                  console.log(data);
                  Cookies.set('token', data.token);
                  window.location = "{{ route('front.products.index') }}";
              });
          });
        }

        function edit() {

        }
    })
</script>
@endpush