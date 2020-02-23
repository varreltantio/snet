<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

  <div class="row">
    <div class="col-lg-8">
      <?= $this->session->flashdata('message'); ?>
    </div>
  </div>

  <div class="row">
    <?php foreach ($product as $p) : ?>
      <div class="col-md-4 mb-5">
        <div class="card">
          <img src="<?= base_url('assets/img/item/' . $p['image']); ?>" class="card-img-top img-fluid img-responsive product-image">
          <div class="card-body">
            <h5 class="card-title"><?= $p['name'] ?></h5>
            <p class="card-text">Rp. <?= $p['price'] ?></p>
            <a href="#" class="btn btn-primary">Buy</a>
            <a href="<?= base_url('store/report/') . $p['id'] ?>" class="btn btn-warning"><i class="fas fa-exclamation-triangle"></i> Report</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

</div>
<!-- /.container-fluid -->


</div>
<!-- End of Main Content -->