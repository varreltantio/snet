<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>


  <div class="row">
    <div class="col-lg-6">
      <?php if (validation_errors()) : ?>
        <div class="alert alert-danger" role="alert"><?= validation_errors(); ?></div>
      <?php endif; ?>

      <?= $this->session->flashdata('message'); ?>
      <form action="" method="post">
        <input type="hidden" name="id" value="<?= $sbm['id'] ?>">
        <div class="form-group">
          <input type="text" class="form-control" id="title" name="title" placeholder="SubMenu Title" value="<?= $sbm['title'] ?>">
        </div>
        <div class="form-group">
          <select class="form-control" id="menu_id" name="menu_id">
            <?php foreach ($sbMenus as $sb) : ?>
              <option value="<?= $sb['id'] ?>"><?= $sb['menu']; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <input type="text" class="form-control" id="url" name="url" placeholder="SubMenu URL" value="<?= $sbm['url'] ?>">
        </div>
        <div class="form-group">
          <input type="text" class="form-control" id="icon" name="icon" placeholder="SubMenu Icon" value="<?= $sbm['icon'] ?>">
        </div>
        <div class="form-group">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="<?= $sbm['is_active'] ?>" id="is_active" name="is_active">
            <label class="form-check-label" for="is_active">
              Active
            </label>
          </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Edit SubMenu</button>
      </form>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->