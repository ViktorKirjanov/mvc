<div class="container">
    <h1 class="page-header">List Dashboard - Guest</h1>
    <div class="table-responsive">

        <form action="/" id="filter" method="post">
            <table class="table borderless">
                <tbody>
                <tr>
                    <td colspan="2" style="width: 50%;">
                        <select name="payment_method_group"
                                id="payment_method_group"
                                class="selectpicker"
                                data-live-search="true"
                                data-title="Payment Method Group"
                                data-width="75%"
                                data-header="Payment Method Group">
                            <?php foreach ($this->paymentMethodGroups as $group) { ?>
                                <option <?php if ($group['id'] == $this->selectedPaymentMethodGroup) echo "selected" ?>
                                    value="<?php echo $group['id']; ?>"><?php echo $group['name']; ?></option>
                            <?php } ?>
                        </select>
                        <button class="btn btn-default" id="clear_payment_method_group">Clear</button>

                    </td>
                    <td colspan="2">
                        <select name="payment_method"
                                id="payment_method"
                                class="selectpicker"
                                data-live-search="true"
                                data-title="Payment Method"
                                data-header="Payment Method"
                                data-width="75%">
                            <?php foreach ($this->paymentMethods as $paymentMethod) { ?>
                                <option
                                    class="group_id-<?php echo $paymentMethod['group_id']; ?>"
                                    data-group_id="<?php echo $paymentMethod['group_id']; ?>" <?php if ($paymentMethod['id'] == $this->selectedPaymentMethod) echo "selected" ?>
                                    value="<?php echo $paymentMethod['id']; ?>"
                                    <?php if (isset($this->selectedPaymentMethodGroup) && $this->selectedPaymentMethodGroup != $paymentMethod['group_id']) { ?>
                                        hidden
                                    <?php } ?>
                                >
                                    <?php echo $paymentMethod['name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <button class="btn btn-default" id="clear_payment_method">Clear</button>
                    </td>
                </tr>

                <tr>
                    <td>
                        <select name="type" id="type" class="selectpicker" data-width="100%">
                            <?php foreach ($this->offerTypes as $offerType) { ?>
                                <option <?php if ($offerType['id'] == $this->selectedType) echo "selected" ?>
                                    value="<?php echo $offerType['id']; ?>"><?php echo $offerType['type']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td style="width: 25%" ;>
                        <input type="number"
                               name="amount"
                               id="amount"
                               class="form-control"
                               step="1"
                               placeholder="Amount"
                               value="<?php echo $this->selectedAmount; ?>">
                    </td>
                    <td>
                        <select name="currency"
                                id="currency"
                                class="selectpicker"
                                data-title="Currency"
                                data-live-search="true"
                                data-width="100%">
                            <?php foreach ($this->currencies as $currency) { ?>
                                <option <?php if ($currency['id'] == $this->selectedCurrency) echo "selected" ?>
                                    value="<?php echo $currency['id']; ?>"><?php echo $currency['fiat'] . " - " . $currency['currency']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-primary btn-block" type="submit" name="submit">Search</button>
                    </td>
                </tr>


                </tbody>
            </table>
        </form>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Type</th>
                <th>Seller/Buyer</th>
                <th>Pay with</th>
                <th>Min—Max amount</th>
                <th>Rate per bitcoin</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($this->offersList as $key => $offer) { ?>
                <tr>
                    <td>
                        <?php echo $offer['id'] ?> |
                        <?php echo $offer['type'] ?>
                    </td>
                    <td>
                        <?php echo $offer['full_name']; ?>
                    </td>
                    <td>
                        <?php echo $offer['payment_method_group'] . " - " . $offer['payment_method']; ?>
                    </td>
                    <td>
                        <?php echo $offer['min'] . " - " . $offer['max'] . " " . $offer['fiat']; ?></td>
                    <td>
                        <?php echo $offer['margin'] * BC_PRICE; ?><?php echo " " . $offer['fiat']; ?>
                    </td>

                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

