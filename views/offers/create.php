<div class="container" id="create_form">

    <form action="/offers/create" id="create_offer" method="post" class="form-horizontal" autocomplete="off">
        <h2>Add new offer!</h2>

        <?php  if (isset($this->errors)) {
            foreach ($this->errors as $error) { ?>
                <div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
            <?php } ?>
        <?php } ?>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="type"> Type</label>
            <div class="col-sm-10">
                <select class="form-control" name="type" id="type">
                    <?php foreach ($this->offerTypes as $offerType) { ?>
                        <option <?php if ($offerType['id'] == $_POST['type']) echo "selected" ?>
                            value="<?php echo $offerType['id']; ?>"><?php echo $offerType['type']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>


        <div class="form-group min_amount-group">
            <label class="col-sm-2 control-label" for="min_amount">Min amount</label>
            <div class="col-sm-10">
                <input name="min_amount" type="number" step="1" class="form-control" id="min_amount" placeholder="Min amount"
                       value="<?php if (isset($_POST['min_amount'])) echo $_POST['min_amount'] ?>">
            </div>
        </div>

        <div class="form-group max_amount_group">
            <label class="col-sm-2 control-label" for="max_amount">Max amount</label>
            <div class="col-sm-10">
                <input name="max_amount" type="number" step="1" class="form-control" id="max_amount" placeholder="Max amount"
                       value="<?php if (isset($_POST['max_amount'])) echo $_POST['max_amount'] ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="margin">Margin</label>
            <div class="col-sm-10">
                <input name="margin" type="number" step="1" class="form-control" id="margin" placeholder="Margin"
                       value="<?php if (isset($_POST['margin'])) echo $_POST['margin'] ?>">
                <p class="help-block">0 BTC</p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="payment_method_group">Payment Method Group</label>
            <div class="col-sm-10">
                <select class="form-control selectpicker" name="payment_method_group" id="payment_method_group" data-live-search="true" data-title="Payment Method Group" data-header="Payment Method Group">
                    <?php foreach ($this->paymentMethodGroups as $group) { ?>
                        <option <?php if ($group['id'] == $_POST['payment_method_group']) echo "selected" ?>
                            value="<?php echo $group['id']; ?>"><?php echo $group['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="payment_method">Payment Method</label>
            <div class="col-sm-10">
                <select class="form-control selectpicker" name="payment_method" id="payment_method" data-live-search="true" data-title="Payment Method" data-header="Payment Method">
                    <?php foreach ($this->paymentMethods as $paymentMethod) { ?>
                        <option
                            class="group_id-<?php echo $paymentMethod['group_id']; ?>"
                            data-group_id="<?php echo $paymentMethod['group_id']; ?>"
                            <?php if ($paymentMethod['id'] == $_POST['payment_method']) echo "selected" ?>
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
                        <option
                            <?php if ($currency['id'] == $_POST['currency']) echo "selected" ?>
                            data-rate="<?php echo $currency['rate'];?>"
                            value="<?php echo $currency['id']; ?>"><?php echo $currency['fiat'] . " - " . $currency['currency']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"></label>
            <div class="col-sm-10">
                <a href="/dashboard" class="btn btn-danger">Cancel</a>
                <button name="submit" type="submit" class="btn btn-success">Create new offer</button>
            </div>
        </div>

    </form>
</div>

