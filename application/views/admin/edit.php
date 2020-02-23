<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>


  <div class="row">
    <div class="col-lg-6">
      <?= form_error('role', '<div class="alert alert-danger" role="alert">', '</div>') ?>
      <?= $this->session->flashdata('message'); ?>
      <form action="" method="post">
        <input type="hidden" name="id" value="<?= $roles['id'] ?>">
        <input type="text" class="form-control" id="role" name="role" placeholder="Role Name" value="<?= $roles['role'] ?>">
        <button type="submit" class="btn btn-primary mt-3">Edit Role</button>
      </form>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->