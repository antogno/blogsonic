    <div class="mt-4">
        <p><?= $this->lang->line('home_1'); ?></p>
        <p><strong><?= $this->lang->line('home_2'); ?></strong></p>
        <p><?= $this->lang->line('home_3'); ?></p>
        <p><strong><?= $this->lang->line('home_4'); ?></strong></p>
        <p><?= $this->lang->line('home_5'); ?> <a href="<?=  base_url($this->session->userdata('language').'pages/view/about'); ?>"><?= $this->lang->line('home_6'); ?></a>.</p>
    </div>