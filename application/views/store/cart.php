<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

  <div class="row">
    <div class="col-lg-4">
      <?php if (validation_errors()) : ?>
        <div class="alert alert-danger" role="alert"><?= validation_errors(); ?></div>
      <?php endif; ?>
      <?= $this->session->flashdata('message'); ?>
    </div>
  </div>

  <div class="row">
    <?php foreach ($user_product as $up) : ?>
      <div class="col-md-4 mb-5">
        <div class="card">
          <img src="<?= base_url('assets/img/item/' . $up['image']); ?>" class="card-img-top img-fluid img-responsive" style="height: 180px">
          <div class="card-body">
            <h5 class="card-title"><?= $up['name'] ?></h5>
            <p class="card-text">Rp. <?= $up['price'] ?></p>
            <a href="<?= base_url('store/edit/') . $up['id'] ?>" class="btn btn-success">Edit</a>
            <a href="<?= base_url('store/delete/') . $up['id'] ?>" class="btn btn-danger delete-item">Delete</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
    <div class="col-md-4 mb-5">
      <div class="card">
        <a href="" data-toggle="modal" data-target="#addModal"><img src="<?= base_url('assets/img/item/default.png') ?>" class="card-img-top img-fluid img-responsive" style="height: 240px"></a>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->


</div>
<!-- End of Main Content -->

<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="itemModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="itemModal">Add New Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <?= form_open_multipart('store/cart') ?>

      <div class="modal-body">
        <div class="form-group">
          <input type="text" class="form-control" id="name" name="name" placeholder="Enter Item Name...">
        </div>

        <div class="form-group">
          <input type="text" class="form-control" id="price" name="price" placeholder="Enter Item Price...">
        </div>

        <div class="custom-file">
          <input type="file" class="custom-file-input" id="image" name="image">
          <label class="custom-file-label" for="image">Choose Image</label>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add Item</button>
      </div>
      </form>

    </div>
  </div>
</div>