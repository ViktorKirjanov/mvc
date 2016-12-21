<div class="container">
    <h2>View offer!</h2>
    <p>Minimum is <?php echo $this->offer['min']; ?> <?php echo $this->offer['fiat']; ?></p>
    <p>Maximum trade <?php echo $this->offer['max'] ?> <?php echo $this->offer['fiat']; ?></p>
    <p>Rate <?php echo BC_PRICE * $this->offer['rate']*$this->offer['margin'] ." ". $this->offer['fiat']; ?> per bitcoin (you can buy any fraction of bitcoin)</p>

    <p>
    <?php if($this->offer['type_id']==1){?>
        For each dollar in bitcoin that you sell you get $<?php echo $this->offer['margin'];?>
    <?php } else{?>
        It costs you $<?php echo $this->offer['margin'];?> for each dollar
    <?php }?>
    </p>

    <p>
        <?php echo $this->offer['payment_method_group']; ?> - <?php echo $this->offer['payment_method']; ?>
    </p>
    <div>
        <?php if ($this->offer['user_id'] == Session::get("user_id")){?>
            <div class="alert alert-danger" role="alert">You can't  trade with yourself</div>
        <?php }else{?>
        <form method="post" id="start_trade" action="/offers/trade">
            <input name="offer_type" type="hidden" value="<?php echo $this->offer['type_id']; ?>">
            <input name="offer_id" type="hidden" value="<?php echo $this->offer['id']; ?>">
            <input data-min="<?php echo $this->offer['min']; ?>" data-max="<?php echo $this->offer['max']; ?>" class="form-control input-lg" id="amount_fiat" placeholder="ex: 50" step="1" name="amount_fiat" type="number" value="<?php echo $this->offer['min']; ?>">
            <input class="form-control input-lg" id="amount_btc" placeholder="0" step="0.01" max="21000000" name="amount_btc" type="number">
            <button id="start-trade-btn" type="submit" name="submit" class="btn btn-primary btn-lg btn-block">
                <?php echo $this->offer['type_id'];?>
            </button>

        </form>
        <?php }?>
    <div>
        <pre><?php print_r($this->offer) ?></pre>
</div>

