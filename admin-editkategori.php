<?php
require_once 'core/init.php';
$kategori = new Kategori();

if(isset($_GET['id']) && preg_match("/[\W]+/", $_GET['id'])){
  Redirect::to('views/404');
}

if(!$user->is_login('role',1)){
  Session::flash('tidak_login', '<script>alert("Anda Harus Login")</script>');
  Redirect::to('loginAdmin');
}

$id=Input::get('id');
$detail = $kategori->detail_kategori('kategori','id',$id);

$errors = array();
if( isset($_POST['submit']) ){
  $validation = new Validation();

  $validation = $validation->check(array(
    'nama_kategori' => array(
                'required' => true,
              ),
  ));

  if( $validation->passed() ){

    $kategori->edit_kategori(array(
      'id' => Input::get('id'),
      'nama_kategori' => Input::get('nama_kategori'),
    ));
    Session::flash('kategoriedit_berhasil', '<script>alert("Kategori Berhasil Di Update")</script>');
    Redirect::to('admin-listkategori');
  }else {
    $errors = $validation->errors();
  }
}

?>
<?php require_once 'views/adminpanel/template/header.php';?>
<!-- ============================================================== -->
<!-- Page Content -->
<!-- ============================================================== -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Gallery</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="admin-dashboard.php">Dashboard</a></li>
                    <li class="active">Gallery</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                  <form class="" action="admin-editkategori.php" method="post" enctype="multipart/form-data">

                    <!-- alert pesan error -->
                    <?php if(!empty($errors)){ ?>
                        <div class="error">
                          <?php foreach ($errors as $error) { ?>
                            <!-- sweetalert -->
                            <body onload='swal({title: "Login Gagal Ada Kesalahan !",
                                                    text: "<b><?php echo $error;?></b>",
                                                    timer: 3000,
                                                    type: "error",
                                                    html: true,
                                                    showConfirmButton: false });'>
                        <?php  } ?>
                        </div>
                    <?php } ?>
                    <!-- end alert pesan error -->

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="judul">Nama Kategori</label>
                          <input type="text" class="form-control" name="nama_kategori" value="<?=$detail['nama_kategori']?>" >
                        </div>
                        <input type="hidden" class="form-control" name="id" value="<?=$detail['id']?>" >
                        <div class="col-md-9">
                          <div class="form-group">
                            <button type="button" name="back" class="col-md-2 btn btn-info" onclick="history.back(-1)"><i class="fa fa-long-arrow-left"></i> Kembali</button>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <button type="submit" name="submit" class="col-md-7 btn btn-success"><i class="fa fa-paper-plane"></i> Kirim</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                  </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
    <footer class="footer text-center"> <?=date('Y') ?> &copy; Development By Yosep alfatah </footer>
</div>

<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->

<?php require_once 'views/adminpanel/template/footer.php'; ?>
