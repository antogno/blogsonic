<div class="mt-4">
    <form id="filter_blogs" method="get">
        <label class="form-label">
            <input type="number" class="form-control" name="limit" id="limit" value="<?= $limit; ?>" placeholder="<?= $this->lang->line('show'); ?>" min="1" max="<?= $max_limit; ?>"></input>
        </label>
        <label class="form-label">
            <select class="form-select" name="order" id="order">
                <option value="" selected disabled hidden><?= $this->lang->line('order_by'); ?></option>
                <option value="desc" <?php if ($order == 'desc') { echo 'selected'; } ?>><?= $this->lang->line('latest'); ?></option>
                <option value="asc" <?php if ($order == 'asc') { echo 'selected'; } ?>><?= $this->lang->line('oldest'); ?></option>
            </select>
        </label>
        <label class="form-label" for="date_range"><?= $this->lang->line('between'); ?>
            <span id="date_range">
                <label for="date_min" class="form-label">
                <input type="date" class="form-control" name="date_min" id="date_min" value="<?= $date_min ?? ''; ?>"></label>
                <label class="form-label"><?= $this->lang->line('between_and'); ?></label>
                <label for="date_max" class="form-label">
                <input type="date" class="form-control" name="date_max" id="date_max" value="<?= $date_max ?? ''; ?>"></label>
            </span>
        </label>
        <button type="submit" class="col-4 col-sm-2 btn btn-secondary" id="change_options"><?= $this->lang->line('apply'); ?></button>
    </form>
</div>