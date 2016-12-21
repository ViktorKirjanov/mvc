<div id="edit_form" class="container">

<!--    <pre>-->
<!--        --><?php //print_r($this->offer); ?>
<!--    </pre>-->

    <form action="/offers/edit/<?php echo $this->offer['id']; ?>" id="edit_offer" method="post"
          class="form-horizontal" autocomplete="off">

        <h2>Edit the offer!</h2>

        <?php if (isset($this->errors)) {
            foreach ($this->errors as $error) { ?>
                <div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
            <?php } ?>
        <?php } ?>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="type"> Type</label>
            <div class="col-sm-10">
                <select class="form-control" name="type" id="type">
                    <?php foreach ($this->offerTypes as $offerType) { ?>
                        <option <?php if ($offerType['id'] == $this->offer['type']) echo "selected" ?>
                            value="<?php echo $offerType['id']; ?>"><?php echo $offerType['type']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="min_amount">Min amount</label>
            <div class="col-sm-10">
                <input type="number" step="1" name="min_amount" id="min_amount" class="form-control" id="min_amount"
                       placeholder="Min amount" value="<?php echo $this->offer['min_amount']; ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="max_amount">Max amount</label>
            <div class="col-sm-10">
                <input type="number" step="1" name="max_amount" id="max_amount" class="form-control" id="max_amount"
                       placeholder="Max amount" value="<?php echo $this->offer['max_amount']; ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="margin">Margin </label>
            <div class="col-sm-10">
                <input type="number" step="0.05" name="margin" id="margin" class="form-control" id="margin" placeholder="Margin"
                       value="<?php echo $this->offer['margin']; ?>">
                <p class="help-block">
                    <?php echo "Max: " . $this->btcMax . " BTC / Min: " . $this->btcMin . " BTC"; ?>
                </p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="payment_method_group">Payment Method Group</label>
            <div class="col-sm-10">
                <select class="form-control selectpicker" data-live-search="true" name="payment_method_group"
                        id="payment_method_group" data-title="Payment Method Group" data-header="Payment Method Group">
                    <?php foreach ($this->paymentMethodGroups as $group) { ?>
                        <option <?php if ($group['id'] == $this->offer['payment_method_group']) echo "selected" ?>
                            value="<?php echo $group['id']; ?>"><?php echo $group['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="payment_method">Payment Method</label>
            <div class="col-sm-10">
                <select class="form-control selectpicker" data-live-search="true" name="payment_method"
                        id="payment_method" data-title="Payment Method" data-header="Payment Method">
                    <?php foreach ($this->paymentMethods as $paymentMethod) { ?>
                        <option
                            class="group_id-<?php echo $paymentMethod['group_id']; ?>"
                            data-group_id="<?php echo $paymentMethod['group_id']; ?>"
                            <?php if ($paymentMethod['id'] == $this->offer['payment_method']) echo "selected" ?>
                            value="<?php echo $paymentMethod['id']; ?>">
                            <?php echo $paymentMethod['name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="currency">Currency</label>
            <div class="col-sm-10">
                <select class="form-control selectpicker" data-live-search="true" name="currency" id="currency">
                    <?php foreach ($this->currencies as $currency) { ?>
                        <option <?php if ($currency['id'] == $this->offer['currency']) echo "selected" ?>
                            data-rate="<?php echo $currency['rate']; ?>"
                            value="<?php echo $currency['id']; ?>"><?php echo $currency['fiat'] . " - " . $currency['currency']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status">Status</label>
            <div class="col-sm-10">
                <select name="status" id="input-status" class="form-control">
                    <option value="1" <?php if ($this->offer['status'] == 1) echo "selected" ?>>Enabled</option>
                    <option value="0" <?php if ($this->offer['status'] == 0) echo "selected" ?>>Disabled</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"></label>
            <div class="col-sm-10">
                <a href="/dashboard" class="btn btn-danger">Cancel</a>
                <button name="submit" type="submit" class="btn btn-success">Edit</button>
            </div>
        </div>


    </form>


</div>

