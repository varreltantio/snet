<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

  <div class="row">
    <?php foreach ($user_checkreport as $usr) : ?>
      <div class="col-lg-4 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <img src="<?= base_url('assets/img/item/' . $usr['image']); ?>" class="card-img-top img-fluid img-responsive product-image">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 mt-3">Product : <?= $usr['name']; ?></div>
                <div class="h6 mb-1 font-weight-bold text-gray-800">Harga : Rp <?= $usr['price']; ?></div>
                <div class="h6 mb-1 font-weight-bold text-gray-800">Deskripsi : <?= $usr['report_list']; ?></div>
                <div class="h6 mb-1 font-weight-bold text-gray-800">Email Penjual : <?= $usr['email']; ?></div>
                <div class="h6 mb-1 font-weight-bold text-gray-800">Email Pereport : <?= $usr['email_report']; ?></div>
              </div>
            </div>
          </div>
          <a href="<?= base_url('admin/deleteitem/') . $usr['id'] ?>" class="btn btn-danger delete-item">Delete Item</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->