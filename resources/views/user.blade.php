@extends('layouts.app')

@section('title', 'User')

@section('styles')
<link rel="stylesheet" type="text/css" href="/assets/vendor/sweetalert/sweetalert.css"/>
@endsection

@section('content')
<!-- Table -->
<div class="row">
  <div class="col">
    <div class="card shadow">
      <div class="card-header border-0">
        <div class="row align-items-center">
          <div class="col-8">
            <h3 class="mb-0">Daftar User</h3>
          </div>
          <div class="col-4 text-right">
            <button id="addUserBtn" class="btn btn-sm btn-primary">Tambah User</button>
          </div>
        </div>
      </div>
      <div class="table-responsive py-4">
        @if (session()->has('message'))
        <div class="alert alert-{{ session('type') }} mx-4" user="alert">
            {!! session('message') !!}
        </div>
        @endif
        <table class="table align-items-center table-flush" id="table">
          <thead class="thead-light">
            <tr>
              <th scope="col" class="text-center">#</th>
              <th scope="col" class="text-center">Nama</th>
              <th scope="col" class="text-center">Umur</th>
              <th scope="col" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- Dark table -->

<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form id="addUserForm">
        <input type="hidden" id="deactivate_id" name="id" />
        <div class="modal-header">
          <h5 class="modal-title" id="createModalLabel">Tambah User</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label" for="nama">Nama</label>
                <input type="text" name="nama" id="nama" class="form-control form-control-alternative" required="">
              </div>
            </div>
            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label" for="umur">Umur</label>
                <input type="number" name="umur" id="umur" class="form-control form-control-alternative" required="">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" id="submitCreateBtn" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form id="editUserForm">
        <input type="hidden" id="id" name="id" />
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Ubah User</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <input type="hidden" name="id" value="">
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label" for="editnama">Nama</label>
                <input type="text" name="nama" id="editnama" class="form-control form-control-alternative" required="">
              </div>
            </div>
            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label" for="editumur">Umur</label>
                <input type="number" name="umur" id="editumur" class="form-control form-control-alternative" required="">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" id="submitEditBtn" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript" src="/assets/vendor/sweetalert/sweetalert.min.js"></script>

<script type="text/javascript">
  $(function() {
    function getUsers() {
      var tbody = $('#table tbody');
      tbody.html('');

      $.ajax({
        url: '/api/users',
        type: 'GET'
      }).done(function(data, textStatus, jqxhr) {
        $.each(data.data, function(i, d) {
          tbody.append('<tr>'+
            '<td scope="col" class="text-center">'+d.id+'</td>'+
            '<td scope="col" class="text-center">'+d.nama+'</td>'+
            '<td scope="col" class="text-center">'+d.umur+'</td>'+
            '<td scope="col" class="text-center"><button class="btn btn-sm btn-warning editBtn" data-id="'+d.id+'"><i class="fas fa-edit"></i></button> <button class="btn btn-sm btn-danger deleteBtn" data-id="'+d.id+'"><i class="fas fa-trash"></i></button></td>'+
          '</tr>');
        });
      }).fail(function(jqXhr, textStatus, error) {
        swal("Perhatian", jqXhr.responseJSON.message, "error");
      });
    }

    function getUser(id) {
      $.ajax({
        url: '/api/users/'+id,
        type: 'GET'
      }).done(function(data, textStatus, jqxhr) {
        $('#editModal').modal('show');
        $('#editnama').val(data.data.nama);
        $('#editumur').val(data.data.umur);
      }).fail(function(jqXhr, textStatus, error) {
        swal("Perhatian", jqXhr.responseJSON.message, "error");
      });
    }

    function storeUser(nama, umur) {
      $('#nama, #umur').removeClass('is-invalid');
      $('#addUserForm .invalid-feedback').remove();
      $.ajax({
        url: '/api/users',
        type: 'POST',
        data: {
          nama: nama,
          umur: umur
        }
      }).done(function(data, textStatus, jqxhr) {
        getUsers();
        $('#nama, #umur').val('');
        swal("Berhasil", data.message, "success");
        $('#createModal').modal('hide');
      }).fail(function(jqXhr, textStatus, error) {
        var data = jqXhr.responseJSON;
        if (jqXhr.status == 400) {
          swal("Perhatian", jqXhr.responseJSON.message, "error");
          $.each(data.data, function(i, d) {
            $("#"+i).addClass('is-invalid').after('<div class="invalid-feedback">'+d[0]+'</div>');
          });
        } else {
          swal("Perhatian", jqXhr.responseJSON.message, "error");
        }        
      });
    }

    function updateUser(id, nama, umur) {
      $('#editnama, #editnama').removeClass('is-invalid');
      $('#editUserForm .invalid-feedback').remove();
      $.ajax({
        url: '/api/users/'+id,
        type: 'POST',
        data: {
          _method: 'PATCH',
          id: id,
          nama: nama,
          umur: umur
        }
      }).done(function(data, textStatus, jqxhr) {
        getUsers();
        $('#id, #editnama, #editnama').val('');
        swal("Berhasil", data.message, "success");
        $('#editModal').modal('hide');
      }).fail(function(jqXhr, textStatus, error) {
        var data = jqXhr.responseJSON;
        if (jqXhr.status == 400) {
          swal("Perhatian", jqXhr.responseJSON.message, "error");
          $.each(data.data, function(i, d) {
            $("#edit"+i).addClass('is-invalid').after('<div class="invalid-feedback">'+d[0]+'</div>');
          });
        } else {
          swal("Perhatian", jqXhr.responseJSON.message, "error");
        }        
      });
    }

    function deleteUser(id) {
      $.ajax({
        url: '/api/users/'+id,
        type: 'POST',
        data: {
          _method: 'DELETE'
        }
      }).done(function(data, textStatus, jqxhr) {
        getUsers();
        swal("Berhasil", data.message, "success");
      }).fail(function(jqXhr, textStatus, error) {
        swal("Perhatian", jqXhr.responseJSON.message, "error");
      });
    }

    getUsers();

    $('#addUserBtn').click(function() {
      $('#createModal').modal('show');
    });

    $('body').on('click', '.editBtn', function() {
      $('#id').val($(this).data('id'));
      getUser($(this).data('id'));
    });

    $('#addUserForm').submit(function(e) {
      e.preventDefault();
      storeUser($('#nama').val(), $('#umur').val());
    });

    $('#editUserForm').submit(function(e) {
      e.preventDefault();
      updateUser($('#id').val(), $('#editnama').val(), $('#editumur').val());
    });

    $('body').on('click', '.deleteBtn', function() {
      var id = $(this).data('id');
        swal({
            title: "Apakah Anda yakin?",
            text: "User tersebut akan dihapus.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal",
            closeOnConfirm: false
        },
        function(){
            deleteUser(id);
        });
    });
  });
</script>
@endsection