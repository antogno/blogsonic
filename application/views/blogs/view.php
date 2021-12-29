<div>
    <p>
        <?= form_open(); ?>
        <div class="form-group">
            <div class="card" id="card">
            <h3 class="card-header"><?= $view_title; ?></h3>
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted"><strong><?= $user; ?></strong>:&nbsp;<?= $view_user; ?></h6>
                    <p class="card-text"><?= $view_body; ?></p>
                    <?php
                        if (strtolower($view_user) == strtolower($this->encryption->decrypt($this->session->userdata('username')))) {
                    ?>
                    <button onclick="return confirmation()" type="submit" class="col-5 col-sm-2 btn btn-danger" id="delete"><?= $delete; ?></button>
                    <?php
                        }
                    ?>
                    <?php
                        if (strtolower($view_user) === strtolower($this->encryption->decrypt($this->session->userdata('username')))) {
                    ?>
                    <a class="col-5 col-sm-2 btn btn-light" href="<?= base_url($this->encryption->decrypt($this->session->userdata('language')) . 'blogs/edit/' . $id); ?>" id="edit"><?= $edit; ?></a>
                    <?php
                        }
                    ?>
                </div>
                <div class="card-footer text-muted">
                    <?= $view_created_at; ?>
                </div>
            </div>
            <input type="hidden" name="id" value="<?= $id; ?>">
        </div>
        <?= form_close(); ?>
    </p>
    <a class="btn btn-link" onclick="history.go(-1);">&laquo; <?= $this->lang->line('back');?></a>
</div>