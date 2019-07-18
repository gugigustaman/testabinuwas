@extends('layouts.app')

@section('title', 'Buku')

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
            <h3 class="mb-0">Daftar Buku</h3>
          </div>
          <div class="col-4 text-right">
            <button id="addBukuBtn" class="btn btn-sm btn-primary">Tambah Buku</button>
          </div>
        </div>
      </div>
      <div class="table-responsive py-4">
        @if (session()->has('message'))
        <div class="alert alert-{{ session('type') }} mx-4" role="alert">
            {!! session('message') !!}
        </div>
        @endif
        <table class="table align-items-center table-flush" id="table">
          <thead class="thead-light">
            <tr>
              <th scope="col" class="text-center">#</th>
              <th scope="col" class="text-center">Judul</th>
              <th scope="col" class="text-center">Jumlah Halaman</th>
              <th scope="col" class="text-center">Penerbit</th>
              <th scope="col" class="text-center">Pemilik</th>
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
      <form id="addBukuForm">
        <input type="hidden" id="deactivate_id" name="id" />
        <div class="modal-header">
          <h5 class="modal-title" id="createModalLabel">Tambah Buku</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label" for="judul">Judul</label>
                <input type="text" name="judul" id="judul" class="form-control form-control-alternative" required="">
              </div>
            </div>
            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label" for="jumlah_halaman">Jumlah Halaman</label>
                <input type="number" name="jumlah_halaman" id="jumlah_halaman" class="form-control form-control-alternative" required="">
              </div>
            </div>
            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label" for="penerbit">Penerbit</label>
                <input type="text" name="penerbit" id="penerbit" class="form-control form-control-alternative" required="">
              </div>
            </div>
            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label" for="pemilik">Pemilik</label>
                <select class="form-control form-control-alternative pemilik" name="pemilik" id="pemilik">
                </select>
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
      <form id="editBukuForm">
        <input type="hidden" id="deactivate_id" name="id" />
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Ubah Buku</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <input type="hidden" name="id" id="id">
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label" for="editjudul">Judul</label>
                <input type="text" name="judul" id="editjudul" class="form-control form-control-alternative" required="">
              </div>
            </div>
            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label" for="editjumlah_halaman">Jumlah Halaman</label>
                <input type="number" name="jumlah_halaman" id="editjumlah_halaman" class="form-control form-control-alternative" required="">
              </div>
            </div>
            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label" for="editpenerbit">Penerbit</label>
                <input type="text" name="penerbit" id="editpenerbit" class="form-control form-control-alternative" required="">
              </div>
            </div>
            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label" for="editpemilik">Pemilik</label>
                <select class="form-control form-control-alternative pemilik" name="pemilik" id="editpemilik">
                </select>
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

@endsection

@section('scripts')
<script type="text/javascript" src="/assets/vendor/sweetalert/sweetalert.min.js"></script>

<script type="text/javascript">
  $(function() {
    function getBooks() {
      var tbody = $('#table tbody');
      tbody.html('');

      $.ajax({
        url: '/api/books',
        type: 'GET'
      }).done(function(data, textStatus, jqxhr) {
        $.each(data.data, function(i, d) {
          tbody.append('<tr>'+
            '<td scope="col" class="text-center">'+d.id+'</td>'+
            '<td scope="col" class="text-center">'+d.judul+'</td>'+
            '<td scope="col" class="text-center">'+d.jumlah_halaman+'</td>'+
            '<td scope="col" class="text-center">'+d.penerbit+'</td>'+
            '<td scope="col" class="text-center">'+d.user.nama+'</td>'+
            '<td scope="col" class="text-center"><button class="btn btn-sm btn-warning editBtn" data-id="'+d.id+'"><i class="fas fa-edit"></i></button> <button class="btn btn-sm btn-danger deleteBtn" data-id="'+d.id+'"><i class="fas fa-trash"></i></button></td>'+
          '</tr>');
        });
      }).fail(function(jqXhr, textStatus, error) {
        swal("Perhatian", jqXhr.responseJSON.message, "error");
      });
    }

    function getUsers() {
      var pemilik = $('.pemilik');
      pemilik.html('<option value="">-- Pilih Pemilik --</option>');

      $.ajax({
        url: '/api/users',
        type: 'GET'
      }).done(function(data, textStatus, jqxhr) {
        $.each(data.data, function(i, d) {
          pemilik.append('<option value="'+d.id+'">'+d.nama+'</option>');
        });
      }).fail(function(jqXhr, textStatus, error) {
        swal("Perhatian", jqXhr.responseJSON.message, "error");
      });
    }

    function getBook(id) {
      $.ajax({
        url: '/api/books/'+id,
        type: 'GET'
      }).done(function(data, textStatus, jqxhr) {
        $('#editModal').modal('show');
        $('#editjudul').val(data.data.judul);
        $('#editjumlah_halaman').val(data.data.jumlah_halaman);
        $('#editpenerbit').val(data.data.penerbit);
        $('#editpemilik').val(data.data.user_id);
      }).fail(function(jqXhr, textStatus, error) {
        swal("Perhatian", jqXhr.responseJSON.message, "error");
      });
    }

    function storeBuku(judul, jumlah_halaman, penerbit, pemilik) {
      $('#addBukuForm input, #addBukuForm select').removeClass('is-invalid');
      $('#addBukuForm .invalid-feedback').remove();
      $.ajax({
        url: '/api/books',
        type: 'POST',
        data: {
          judul: judul,
          jumlah_halaman: jumlah_halaman,
          penerbit: penerbit,
          user_id: pemilik
        }
      }).done(function(data, textStatus, jqxhr) {
        getBooks();
        $('#addBukuForm input, #addBukuForm select').val('');
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

    function updateBuku(id, judul, jumlah_halaman, penerbit, pemilik) {
      $('#editBukuForm input, #editBukuForm select').removeClass('is-invalid');
      $('#editBukuForm .invalid-feedback').remove();
      $.ajax({
        url: '/api/books/'+id,
        type: 'POST',
        data: {
          _method: 'PATCH',
          id: id,
          judul: judul,
          jumlah_halaman: jumlah_halaman,
          penerbit: penerbit,
          user_id: pemilik
        }
      }).done(function(data, textStatus, jqxhr) {
        getBooks();
        $('#editBukuForm input, #editBukuForm select').val('');
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

    function deleteBuku(id) {
      $.ajax({
        url: '/api/books/'+id,
        type: 'POST',
        data: {
          _method: 'DELETE'
        }
      }).done(function(data, textStatus, jqxhr) {
        getBooks();
        swal("Berhasil", data.message, "success");
      }).fail(function(jqXhr, textStatus, error) {
        swal("Perhatian", jqXhr.responseJSON.message, "error");
      });
    }

    getBooks();

    $('#addBukuBtn').click(function() {
      getUsers();
      $('#createModal').modal('show');
    });

    $('body').on('click', '.editBtn', function() {
      getUsers();
      $('#id').val($(this).data('id'));
      getBook($(this).data('id'));
    });

    $('#addBukuForm').submit(function(e) {
      e.preventDefault();
      storeBuku($('#judul').val(), $('#jumlah_halaman').val(), $('#penerbit').val(), $('#pemilik').val());
    });

    $('#editBukuForm').submit(function(e) {
      e.preventDefault();
      updateBuku($('#id').val(), $('#editjudul').val(), $('#editjumlah_halaman').val(), $('#editpenerbit').val(), $('#editpemilik').val());
    });

    $('body').on('click', '.deleteBtn', function() {
      var id = $(this).data('id');
        swal({
            title: "Apakah Anda yakin?",
            text: "Buku tersebut akan dihapus.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal",
            closeOnConfirm: false
        },
        function(){
            deleteBuku(id);
        });
    });
  });
</script>
@endsection