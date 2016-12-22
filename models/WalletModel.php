<?php

class WalletModel extends Model
{

    private $btc;
    private $userId;

    /**
     * WalletModel constructor.
     */
    public function __construct($userId)
    {
        parent::__construct();
        $this->userId = $userId;
    }

    /**
     * @return bool
     */
    public function getBtc()
    {
        $sql = "SELECT btc FROM users where user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $this->userId, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetch();
        if ($result)
            return $result["btc"];
        else
            return false;
    }

    /**
     * @param $amount
     * @return bool
     */
    public function add($amount)
    {
        $sql = "UPDATE users SET btc = :btc WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $this->userId, PDO::PARAM_INT);
        $stmt->bindParam(':btc', $amount, PDO::PARAM_INT);
        return $stmt->execute();

    }

    /**
     * @param $amount
     * @return bool
     */
    public function substract($amount)
    {
        if ($this->btc >= $amount) {
            $this->btc -= $amount;
            return true;
        }
        return false;
    }


    public function getTotalBtc($userId)
    {
        $sql = "SELECT sum(offers.max / (:btc * offers.margin * currencies.rate)) AS sum_btc
                FROM offers
                INNER JOIN currencies
                ON offers.currency_id = currencies.id
                WHERE user_id = :user_id 
                AND offers.status IN (0,1,3) 
                AND offers.type = 1";
        $stmt = $this->db->prepare($sql);
        $btc = BC_PRICE;
        $stmt->bindParam(':btc', $btc, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetch();
        return $result['sum_btc'];
    }


}