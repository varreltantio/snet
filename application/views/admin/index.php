<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

  <div class="row">

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Account Registered</div>
              <?php $nomor = 0; ?>
              <?php foreach ($user_registered as $u) : ?>
                <?php $nomor++ ?>
              <?php endforeach; ?>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $nomor ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <a href="<?= base_url('admin/checkreport') ?>" class="reported">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Product List Report</div>
                <?php $nomor = 0; ?>
                <?php foreach ($user_report as $ur) : ?>
                  <?php $nomor++ ?>
                <?php endforeach; ?>
                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $nomor ?></div>
              </div>
              <div class="col-auto">
                <i class="fas fa-thumbs-down fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </a>
      </div>
    </div>

  </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->