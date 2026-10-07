<style>
    .profile-image-container {
        position: relative;
        width: 150px;
        height: 150px;
        cursor: pointer;
    }

    .profile-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .file-input {
        display: none;
    }
</style>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h5><i class="nav-icon far fa-circle text-warning"></i> Hi, Welcome To <?=  $siteDetails[0]->company_name; ?> !</h5>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="post" action="<?= base_url('#'); ?>" autocomplete="off" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="profile-image-container">
                                        <img id="profileImage" src="<?= base_url('uploads/admin/profile/'); ?><?= $profileData[0]->user_image; ?>" alt="Profile Image" class="profile-image">
                                        <input type="file" id="fileInput" class="file-input" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <input type="hidden" name="id" id="Edit_id" value="<?= (isset($profileData)) ? base64_encode(urlencode($profileData[0]->id)) : ''; ?>" />

                                    <div class="form-group">
                                        <label for="user_name"><span class="text-danger">* </span>Email Id</label>
                                        <input type="text" class="form-control" id="user_name" name="user_name" value="<?= (isset($profileData)) ? $profileData[0]->user_name : ''; ?>" placeholder="Enter Your Email Id" autocomplete="off">
                                        <span class="text-danger text-sm">
                                            <?= isset($validation) ? display_form_errors($validation, 'user_name') : ''; ?>
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label for="password"><span class="text-danger">* </span>New Password</label>
                                        <input type="password" class="form-control" id="password" name="password"  placeholder="Enter Your New Password If you want to change" autocomplete="off">
                                        <span class="text-danger text-sm">
                                            <?= isset($validation) ? display_form_errors($validation, 'password') : ''; ?>
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label for="display_name"><span class="text-danger">* </span>Display Name</label>
                                        <input type="text" class="form-control" id="display_name" name="display_name" value="<?= (isset($profileData)) ? $profileData[0]->display_name : ''; ?>" placeholder="Enter Your Email Id" autocomplete="off">
                                        <span class="text-danger text-sm">
                                            <?= isset($validation) ? display_form_errors($validation, 'display_name') : ''; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" name="addPackage" id="<?= (isset($profileData)) ? 'UpdateProfile' : '' ?>" class="btn btn-success"><i class="fa fa-plus"></i> <?= (isset($profileData)) ? 'Update Profile' : 'Save Your Profile' ?> </button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->

            </div>
            <!--/.col (left) -->
            <!-- right column -->

        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>

<script>
    const profileImage = document.getElementById('profileImage');
    const fileInput = document.getElementById('fileInput');

    profileImage.addEventListener('click', () => {
        fileInput.click();
    });

    fileInput.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                profileImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>