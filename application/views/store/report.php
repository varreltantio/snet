<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

  <div class="row">
    <div class="col-lg-8">
      <?= form_error('report_list[]', '<div class="alert alert-danger" role="alert">', '</div>') ?>
      <form action="" method="post">
        <input type="hidden" class="form-control" name="id" value="<?= $user_productid['id'] ?>">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <div class="input-group-text">
              <input type="checkbox" name="report_list[]" value="Gambar tidak sesuai dengan barang">
            </div>
          </div>
          <input type="text" class="form-control" value="Gambar tidak sesuai dengan barang" readonly>
        </div>

        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <div class="input-group-text">
              <input type="checkbox" name="report_list[]" value="Barang tidak asli/ada kecacatan pada barang">
            </div>
          </div>
          <input type="text" class="form-control" value="Barang tidak asli/ada kecacatan pada barang" readonly>
        </div>

        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <div class="input-group-text">
              <input type="checkbox" name="report_list[]" value="Nama dan harga item tidak sesuai">
            </div>
          </div>
          <input type="text" class="form-control" value="Nama dan harga item tidak sesuai" readonly>
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary">Report</button>
        </div>
      </form>
    </div>
  </div>

</div>
<!-- /.container-fluid -->


</div>
<!-- End of Main Content -->