<div class="mt-4">
    <label class="form-label">
        <select class="form-select" id="change_limit">
            <option value="" selected disabled hidden><?= $this->lang->line('show'); ?></option>
            <option value="5"><?= $this->lang->line('5_blogs'); ?></option>
            <option value="10"><?= $this->lang->line('10_blogs'); ?></option>
            <option value="20"><?= $this->lang->line('20_blogs'); ?></option>
        </select>
    </label>
    <label class="form-label">
        <select class="form-select" id="change_order">
            <option value="" selected disabled hidden><?= $this->lang->line('order_by'); ?></option>
            <option value="desc"><?= $this->lang->line('latest'); ?></option>
            <option value="asc"><?= $this->lang->line('oldest'); ?></option>
        </select>
    </label>
    <label class="form-label" for="date_range"><?= $this->lang->line('between'); ?>
        <span id="date_range">
            <label for="date_min" class="form-label">
            <input type="date" class="form-control" id="date_min"></label>
            <label class="form-label"><?= $this->lang->line('between_and'); ?></label>
            <label for="date_max" class="form-label">
            <input type="date" class="form-control" id="date_max"></label>
        </span>
    </label>
    <button type="submit" class="col-4 col-sm-2 btn btn-secondary" id="change_options"><?= $this->lang->line('apply'); ?></button>
    <button type="reset" class="col-4 col-sm-2 btn btn-warning" id="reset"><?= $this->lang->line('reset'); ?></button>
</div>