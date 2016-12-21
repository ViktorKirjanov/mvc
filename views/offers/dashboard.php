<div class="container">
    <a href="/offers/create" class="create_offer btn btn-primary btn-lg">New offer</a>

    <h1 class="page-header">Trades</h1>
    <h3 class="page-header">Based on your offers:</h3>

    <div class="table-responsive">

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Trade id</th>
                <th>Type</th>
                <th>Trade partner</th>
                <th>Amount</th>
                <th>Amount in BTC</th>
                <th>Payment method</th>
                <th>Status</th>
                <th>Started (time)</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($this->sellerTradeList as $key => $offer) { ?>

                <tr>
                    <td>
                        <?php echo $offer['trade_id']; ?> | <?php echo $offer['id']; ?>
                    </td>
                    <td>
                        <?php echo $offer['type']; ?>
                    </td>
                    <td>
                        <?php echo $offer['trade_partner']; ?>
                    </td>
                    <td>
                        <?php echo $offer['amount'] . " " . $offer['fiat']; ?>
                    </td>
                    <td>
                        <?php echo (float)$offer['btc_amount']; ?> <span class="glyphicon glyphicon-btc"></span>
                    </td>
                    <td>
                        <?php echo $offer['payment_method_group'] . " - " . $offer['payment_method']; ?>
                    </td>
                    <td>
                        <strong class="
                        <?php
                        switch ($offer['trade_status_id']) {
                            case 0:
                                echo "status-canseled";
                                break;
                            case 1:
                                echo "status-inprogress";
                                break;
                            case 2:
                                echo "status-done";
                                break;
                        }
                        ?>
                        "><?php echo ucfirst($offer['trade_status']); ?></strong>
                    </td>
                    <td>
                        <?php echo $offer['starded_date']; ?>
                    </td>
                    <td>
                        <?php if ($offer['trade_statuse_id'] == 1) { ?>
                            <a href="/offers/cancel/<?php echo $offer['trade_id']; ?>" class=" btn btn-danger">Cancel</a>
                            <a href="/offers/release/<?php echo $offer['trade_id']; ?>" class=" btn btn-success">Release</a>
                        <?php } ?>
                    </td>


                </tr>
                <?php
            } ?>

            </tbody>
        </table>
        <?php if(!$this->sellerTradeList){?>
            <h3 class="text-center">No trades</h3>
        <?php }?>

    </div>
    <h3 class="page-header">Based on other clients offers:</h3>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Trade id</th>
            <th>Type</th>
            <th>Trade partner</th>
            <th>Amount</th>
            <th>Amount in BTC</th>
            <th>Payment method</th>
            <th>Status</th>
            <th>Started (time)</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($this->buyerTradeList as $key => $offer) { ?>

            <tr>
                <td>
                    <?php echo $offer['trade_id']; ?> | <?php echo $offer['id']; ?>
                </td>
                <td>
                    <?php echo $offer['type']; ?>
                </td>
                <td>
                    <?php echo $offer['trade_partner']; ?>
                </td>
                <td>
                    <?php echo $offer['amount'] . " " . $offer['fiat']; ?>
                </td>
                <td>
                    <?php echo (float)$offer['btc_amount']; ?> <span class="glyphicon glyphicon-btc"></span>
                </td>
                <td>
                    <?php echo $offer['payment_method_group'] . " - " . $offer['payment_method']; ?>
                </td>
                <td>
                    <strong class="
                        <?php
                    switch ($offer['trade_status_id']) {
                        case 0:
                            echo "status-canseled";
                            break;
                        case 1:
                            echo "status-inprogress";
                            break;
                        case 2:
                            echo "status-done";
                            break;
                    }
                    ?>
                    "><?php echo ucfirst($offer['trade_status']); ?></strong>
                </td>
                <td>
                    <?php echo $offer['starded_date']; ?>
                </td>


            </tr>
            <?php
        } ?>


        </tbody>
    </table>
    <?php if(!$this->buyerTradeList){?>
        <h3 class="text-center">No trades</h3>
    <?php }?>

    <h1 class="page-header">Your offers</h1>
    <div class="table-responsive">

        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <!--                <th>Seller/Buyer</th>-->
                <th>Pay with</th>
                <th>Min—Max amount</th>
                <th>Rate per bitcoin</th>
                <th>Started:</th>
                <th></th>

            </tr>
            </thead>
            <tbody>

            <?php
            foreach ($this->offersList as $key => $offer) {
                ?>

                <tr>
                    <td>
                        <?php echo $offer['id'] ?>
                    </td>
                    <td>
                        <?php echo $offer['type'] ?>
                    </td>
                    <!--                    <td>-->
                    <!--                        --><?php //echo $offer['full_name']; ?>
                    <!--                    </td>-->
                    <td>
                        <?php echo $offer['payment_method_group'] . " - " . $offer['payment_method']; ?>
                    </td>
                    <td>
                        <?php echo $offer['min'] . " - " . $offer['max'] . " " . $offer['fiat']; ?></td>
                    <td>
                        <?php echo $offer['margin'] * BC_PRICE; ?>
                    </td>
                    <td>
                        <?php echo $offer['date']; ?>
                    </td>

                    <td>
                        <?php if ($offer['status'] == 1) { ?>
                            <a data-status="<?php echo $offer['status']; ?>" data-id="<?php echo $offer['id']; ?>"
                               href="/offers/disable/<?php echo $offer['id']; ?>"
                               class="enable_offer btn btn-success">Enabled</a>
                        <?php } ?>

                        <?php if ($offer['status'] == 0) { ?>
                            <a data-status="<?php echo $offer['status']; ?>" data-id="<?php echo $offer['id']; ?>"
                               href="/offers/enable/<?php echo $offer['id']; ?>"
                               class="disable_offer btn btn-danger">Disabled</a>
                        <?php } ?>

                        <a href="/offers/edit/<?php echo $offer['id']; ?>" class=" btn btn-warning">Edit</a>
                        <a href="/offers/delete/<?php echo $offer['id']; ?>" class=" btn btn-danger">Delete</a>
                    </td>

                </tr>
                <?php
            } ?>


            </tbody>
        </table>
    </div>

</div>
<!--<pre>-->
<!--    --><?php //print_r($this->offersList); ?>
<!--</pre>-->


