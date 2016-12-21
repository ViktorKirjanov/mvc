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
    
  


}