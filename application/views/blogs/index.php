<div>
    <?php
        if ( ! $blogs) {
            echo '<div class="mt-4"><p>' . $this->lang->line('no_blogs');
            if ($this->session->userdata('logged_in')) {
                echo ' <a href="' . base_url($this->encryption->decrypt($this->session->userdata('language')) . 'blogs/newblog') . '">' . $this->lang->line('no_blogs_link') . '</a></p></div>';
            } else {
                echo ' <a href="' . base_url($this->encryption->decrypt($this->session->userdata('language')) . 'profiles/login') . '">' . $this->lang->line('login_now') . '</a> ' . $this->lang->line('or') . ' <a href="' . base_url($this->encryption->decrypt($this->session->userdata('language')) . 'profiles/register') . '">' . $this->lang->line('register') . '</a> ' . $this->lang->line('to_create_one') . '</p></div>';
            }
        } else {
    ?>
    <p>
        <div class="card" id="card">
            <div class="card-body">
                <h4 class="card-title"><?= $blog_title; ?></h4>
                <h6 class="card-subtitle mb-2 text-muted"><strong><?= $user; ?></strong>:&nbsp;<?= $blog_user; ?></h6>
                <a href="<?= base_url($this->encryption->decrypt($this->session->userdata('language')) . 'blogs/view?id=' . $blog_id); ?>" class="card-link"><?= $view; ?></a>
            </div>
            <div class="card-footer text-muted">
                <?= $blog_created_at; ?>
            </div>
        </div>
    </p>
    <?php
        }
    ?>
</div>