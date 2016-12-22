<?php

class OffersModel extends Model
{

    /**
     * @param $userId
     * @return bool
     */
    public function create($userId, $paymentMethod, $type, $maxAmount, $minAmount, $currency, $margin)
    {
        $sql = "INSERT INTO offers (
                    user_id,
                    type,
                    payment_method_id,
                    currency_id,
                    min,
                    max,
                    margin) 
                VALUES (
                    :userId, 
                    :type, 
                    :payment_method_id,
                    :currency_id,
                    :min, 
                    :max,
                    :margin)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':type', $type, PDO::PARAM_INT);
        $stmt->bindParam(':payment_method_id', $paymentMethod, PDO::PARAM_INT);
        $stmt->bindParam(':max', $maxAmount, PDO::PARAM_INT);
        $stmt->bindParam(':min', $minAmount, PDO::PARAM_INT);
        $stmt->bindParam(':currency_id', $currency, PDO::PARAM_INT);
        $stmt->bindParam(':margin', $margin, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * @param $id
     * @param $offer
     * @return bool
     */
    public function edit($id, $offer)
    {
        $sql = "UPDATE offers SET type= :type, status = :status, payment_method_id= :payment_method, currency_id= :currency, min= :min_amount, max= :max_amount, margin= :margin WHERE id= :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':type', $offer['type'], PDO::PARAM_INT);
        $stmt->bindParam(':status', $offer['status'], PDO::PARAM_INT);
        $stmt->bindParam(':payment_method', $offer['payment_method'], PDO::PARAM_INT);
        $stmt->bindParam(':currency', $offer['currency'], PDO::PARAM_INT);
        $stmt->bindParam(':min_amount', $offer['min_amount'], PDO::PARAM_INT);
        $stmt->bindParam(':max_amount', $offer['max_amount'], PDO::PARAM_INT);
        $stmt->bindParam(':margin', $offer['margin'], PDO::PARAM_INT);
        return $stmt->execute();
    }


    /**
     * @param $payment_method_group
     * @param $payment_method
     * @param $type
     * @param $amount
     * @param $currency
     * @return array
     */

    public function getAllOffers($payment_method_group, $payment_method, $type, $amount, $currency)
    {

        $sql = "SELECT offers.id, offers.min, offers.max, offers.margin,offers.user_id, users.full_name, currencies.fiat, currencies.rate,invert_offer_types_t.type AS type, payment_method_groups.name AS payment_method_group, payment_methods.name AS payment_method
            FROM offers inner join payment_methods 
            ON offers.payment_method_id = payment_methods.id 
            INNER JOIN offer_types 
            ON offers.type = offer_types.id
            INNER JOIN payment_method_groups 
            ON payment_methods.group_id = payment_method_groups.id 
            INNER JOIN users 
            ON offers.user_id = users.user_id   
            INNER JOIN currencies 
            ON offers.currency_id = currencies.id 
            INNER JOIN offer_types invert_offer_types_t
            ON offer_types.id = invert_offer_types_t.invert_offer_type_id
            WHERE offers.status = 1 ";

        if ($payment_method_group) {
            $sql .= "AND payment_method_groups.id = :payment_method_group ";
        }
        if ($payment_method) {
            $sql .= "AND payment_methods.id = :payment_method ";
        }

        if ($type) {
            $sql .= "AND invert_offer_types_t.invert_offer_type_id = :type ";
        }

        if ($amount) {
            $sql .= "AND (offers.min <= :amount AND offers.max >= :amount) ";
        }

        if ($currency) {
            $sql .= "AND currencies.id = :currency ";
        }

        $stmt = $this->db->prepare($sql);

        if ($payment_method_group)
            $stmt->bindParam(':payment_method_group', $payment_method_group, PDO::PARAM_INT);

        if ($payment_method)
            $stmt->bindParam(':payment_method', $payment_method, PDO::PARAM_INT);

        if ($amount)
            $stmt->bindParam(':amount', $amount, PDO::PARAM_INT);

        $stmt->bindParam(':type', $type, PDO::PARAM_INT);

        if ($currency)
            $stmt->bindParam(':currency', $currency, PDO::PARAM_INT);

        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }

    /**
     * @param $id
     * @return mixed
     */
//    public function getOfferById($id)
//    {
//        $sql = "SELECT offers.id, offers.min, offers.max, offers.margin,users.user_id, users.full_name, currencies.fiat, currencies.rate,offers.type as type_id, offer_types.type AS type, payment_method_groups.name AS payment_method_group, payment_methods.name AS payment_method
//                FROM offers inner join payment_methods
//                ON offers.payment_method_id = payment_methods.id
//                INNER JOIN offer_types
//                ON offers.type = offer_types.id
//                INNER JOIN payment_method_groups
//                ON payment_methods.group_id = payment_method_groups.id
//                INNER JOIN users
//                ON offers.user_id = users.user_id
//                INNER JOIN currencies
//                ON offers.currency_id = currencies.id
//                WHERE offers.status = 1 AND offers.id = :id";
//        $stmt = $this->db->prepare($sql);
//        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
//        $stmt->execute();
//        $stmt->setFetchMode(PDO::FETCH_ASSOC);
//        return $stmt->fetch();
//    }

    public function getOfferById($id)
    {
        $sql = "SELECT offers.id, offers.min, offers.max, offers.margin,users.user_id, users.full_name, currencies.fiat, currencies.rate,invert_offer_types_t.id as type_id, invert_offer_types_t.type AS type, payment_method_groups.name AS payment_method_group, payment_methods.name AS payment_method
                FROM offers inner join payment_methods
                ON offers.payment_method_id = payment_methods.id
                INNER JOIN offer_types
                ON offers.type = offer_types.id
                INNER JOIN payment_method_groups
                ON payment_methods.group_id = payment_method_groups.id
                INNER JOIN users
                ON offers.user_id = users.user_id
                INNER JOIN currencies
                ON offers.currency_id = currencies.id
                INNER JOIN offer_types as invert_offer_types_t
                ON offer_types.id = invert_offer_types_t.invert_offer_type_id
                WHERE offers.status = 1 AND offers.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetch();
    }


    /**
     * @param $id
     * @return mixed
     */
    public function getOfferByIdToEdit($id)
    {
        $sql = "SELECT offers.*,payment_method_groups.id as payment_method_group_id   
                FROM offers 
                INNER JOIN payment_methods 
                ON offers.payment_method_id = payment_methods.id 
                INNER JOIN payment_method_groups 
                ON payment_methods.group_id = payment_method_groups.id 
                INNER JOIN users 
                WHERE offers.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetch();
    }

    /**
     * @param $id
     * @return array
     */

    //    status:
//    0 - disabled
//    1 - enabled
//    3 - deleted
//    4 - finised
    public function getOffersByUserId($id, $statusArray)
    {
        $sql = "SELECT offers.id, offers.status, offers.min, offers.max, offers.margin, offers.date, offer_types.type, users.full_name, currencies.fiat, currencies.rate,payment_method_groups.name AS payment_method_group, payment_methods.name AS payment_method
            FROM offers inner join payment_methods 
            ON offers.payment_method_id = payment_methods.id 
            INNER JOIN offer_types 
            ON offers.type = offer_types.id
            INNER JOIN payment_method_groups 
            ON payment_methods.group_id = payment_method_groups.id 
            INNER JOIN users 
            ON offers.user_id = users.user_id   
            INNER JOIN currencies 
            ON offers.currency_id = currencies.id 
            WHERE users.user_id = :user_id AND FIND_IN_SET(offers.status, :array)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $id, PDO::PARAM_INT);
//        $stmt->bindParam(':status', $status, PDO::PARAM_INT)
        $ids_string = implode(',', $statusArray);
        $stmt->bindParam('array', $ids_string);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }

    /**
     * @param $id
     * @return array
     */
    public function getTradesBySellerId($id)
    {
        $sql = "SELECT offers.id, offers.margin, offers.date, offer_types.type,status.id as status_id, trade_statuses.id as trade_status_id, trade_statuses.status as trade_status, currencies.fiat, currencies.rate,payment_method_groups.name AS payment_method_group, payment_methods.name AS payment_method,trades.id as trade_id, trades.amount, trades.btc_amount ,trades.status as trade_statuse_id,  offers.date as starded_date, partners.full_name as trade_partner
            FROM offers inner join payment_methods 
            ON offers.payment_method_id = payment_methods.id 
            INNER JOIN offer_types 
            ON offers.type = offer_types.id
            INNER JOIN payment_method_groups 
            ON payment_methods.group_id = payment_method_groups.id 
            INNER JOIN users 
            ON offers.user_id = users.user_id   
            INNER JOIN currencies 
            ON offers.currency_id = currencies.id 
            INNER JOIN trades
            ON offers.id = trades.offer_id
			INNER JOIN users as partners
			ON partners.user_id = trades.user_id
			INNER JOIN status
			ON offers.status = status.id
			INNER JOIN trade_statuses
			ON trades.status = trade_statuses.id
            WHERE offers.user_id = :user_id 
            ORDER BY offers.id";

//            WHERE users.user_id = :user_id AND offers.status = 4";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }

    /**
     * @param $id
     * @return array
     */
    public function getTradesByBuyerId($id)
    {
        $sql = "SELECT offers.id, offers.margin, offers.date, invert_offer_types_t.type as type,status.id as status_id, trade_statuses.id as trade_status_id, trade_statuses.status as trade_status, currencies.fiat, currencies.rate,payment_method_groups.name AS payment_method_group, payment_methods.name AS payment_method,trades.id as trade_id, trades.amount, trades.btc_amount , offers.date as starded_date, users.full_name as trade_partner
            FROM offers inner join payment_methods 
            ON offers.payment_method_id = payment_methods.id 
            INNER JOIN offer_types 
            ON offers.type = offer_types.id
            INNER JOIN payment_method_groups 
            ON payment_methods.group_id = payment_method_groups.id 
            INNER JOIN users 
            ON offers.user_id = users.user_id   
            INNER JOIN currencies 
            ON offers.currency_id = currencies.id 
            INNER JOIN trades
            ON offers.id = trades.offer_id
			INNER JOIN users as partners
			ON partners.user_id = trades.user_id
			INNER JOIN status
			ON offers.status = status.id
			INNER JOIN trade_statuses
			ON trades.status = trade_statuses.id
			INNER JOIN offer_types as invert_offer_types_t
            ON offer_types.id = invert_offer_types_t.invert_offer_type_id
            WHERE trades.user_id = :user_id 
            ORDER BY offers.id";

//            WHERE users.user_id = :user_id AND offers.status = 4";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }


    /**
     * @return array
     */
    public function getCurrencies()
    {
        $sql = "SELECT * FROM currencies";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }

    public function getCurrencyRateById($id)
    {
        $sql = "SELECT currencies.rate FROM currencies WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetch();
        return $result["rate"];
    }

    /**
     * @return array
     */
    public function getOfferTypes()
    {
        $sql = "SELECT id,type FROM offer_types";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }

    public function getInvertedOfferTypes()
    {
        $sql = "SELECT invert_offer_type_id as id,type FROM offer_types";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }

    /**
     * @return array
     */
    public function getPaymentMethods()
    {
        $sql = "SELECT payment_methods.*, payment_method_groups.id as group_id, payment_method_groups.name as group_name
                FROM payment_methods
                INNER JOIN payment_method_groups
                ON payment_methods.group_id = payment_method_groups.id
                ORDER BY payment_method_groups.name,payment_methods.name ASC ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }

    /**
     * @return array
     */
    public function getPaymentMethodGroups()
    {
        $sql = "SELECT * FROM payment_method_groups";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }

    public function changeStatus($userId, $id, $status)
    {
        $sql = "UPDATE offers SET status = :status WHERE id= :id AND user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }


    /**
     * @param $userId
     * @param $tradeId
     * @param $offerStatus
     * @param $tradeStatus
     * @return bool
     */
    public function changeTradeStatus($userId, $tradeId, $offerStatus, $tradeStatus)
    {
        $sql = "UPDATE offers
                INNER JOIN trades 
                ON offers.id = trades.offer_id
                SET offers.status = :offer_status, trades.status = :trade_status
                WHERE  trades.id = :trade_id AND offers.user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':trade_id', $tradeId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':offer_status', $offerStatus, PDO::PARAM_INT);
        $stmt->bindParam(':trade_status', $tradeStatus, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * @param $userId
     * @param $offerId
     * @return mixed
     */
    public function checkOffer($userId, $offerId)
    {
        $sql = "SELECT * FROM offers where user_id =:user_id AND id = :offer_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':offer_id', $offerId, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetch();
    }


    /**
     * @param $userId
     * @param $offerId
     * @param $amount
     * @return bool
     */
    public function createTrade($userId, $offerId, $amount)
    {


        $this->db->beginTransaction();
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            $sql = "SELECT * FROM offers 
                    INNER JOIN currencies
                    ON offers.currency_id = currencies.id
                    WHERE offers.id = :offer_id
                    AND offers.status = 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':offer_id', $offerId, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $offer = $stmt->fetch();

            if ($offer) {
                $offerStatus = 3;
                $sql2 = "UPDATE offers SET status = :status WHERE id= :id";
                $stmt2 = $this->db->prepare($sql2);
                $stmt2->bindParam(':id', $offerId, PDO::PARAM_INT);
                $stmt2->bindParam(':status', $offerStatus, PDO::PARAM_INT);
                $stmt2->execute();

                $currencyId = $offer['currency_id'];
                $rate = $offer['rate'];
                $margin = $offer['margin'];
                $btc_amount = $amount / (BC_PRICE * $margin * $rate);
                $tradeStatus = 1;

                $sql3 = "INSERT INTO trades(offer_id, user_id, amount, btc_amount, status) VALUES (:offer_id,:user_id, :amount, :btc_amount, :status)";
                $stmt3 = $this->db->prepare($sql3);
                $stmt3->bindParam(':offer_id', $offerId, PDO::PARAM_INT);
                $stmt3->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $stmt3->bindParam(':amount', $amount, PDO::PARAM_INT);
                $stmt3->bindParam(':btc_amount', $btc_amount, PDO::PARAM_INT);
                $stmt3->bindParam(':status', $tradeStatus, PDO::PARAM_INT);
                $stmt3->execute();
                $this->db->commit();
                return true;
            }
        } catch (Exception $e) {
//            echo $e->getMessage();
            $this->db->rollBack();
            return false;
        }
    }

    /**
     * @param $userId
     * @param $tradeId
     * @return bool
     */
    public function confirmTrade($userId, $tradeId)
    {
        $sql = "SELECT offers.id, offers.type as type_id, trades.btc_amount, offers.user_id as seller, trades.user_id as buyer  FROM offers 
                    INNER JOIN currencies
                    ON offers.currency_id = currencies.id
                    INNER JOIN trades
                    ON offers.id = trades.offer_id
                    WHERE trades.id = :trade_id 
                    AND offers.user_id = :user_id
                    AND offers.status = 3
                    AND trades.status = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':trade_id', $tradeId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $offer = $stmt->fetch();

        $commit = true;

        if ($offer) {
            $this->db->beginTransaction();
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            try {
                $offerId = $offer['id'];
                $btc = $offer['btc_amount'];
                $seller = $offer['seller'];
                $buyer = $offer['buyer'];
                $typeId = $offer['type_id'];

                switch ($typeId) {
                    case 1:
                        $sql2 = "UPDATE users SET btc= btc - :btc WHERE user_id = :seller";
                        $sql3 = "UPDATE users SET btc= btc + :btc WHERE user_id = :buyer";
                        break;
                    case 2:
                        $sql2 = "UPDATE users SET btc= btc + :btc WHERE user_id = :seller";
                        $sql3 = "UPDATE users SET btc= btc - :btc WHERE user_id = :buyer";
                        break;
                }

                // add/subtract btc from/to seller
                $stmt2 = $this->db->prepare($sql2);
                $stmt2->bindParam(':btc', $btc, PDO::PARAM_INT);
                $stmt2->bindParam(':seller', $seller, PDO::PARAM_INT);
                if (!$stmt2->execute())
                    $commit = false;

                // add/subtract btc from/to buyer
                $stmt3 = $this->db->prepare($sql3);
                $stmt3->bindParam(':btc', $btc, PDO::PARAM_INT);
                $stmt3->bindParam(':buyer', $buyer, PDO::PARAM_INT);
                if (!$stmt3->execute())
                    $commit = false;

                // update offer and trade statuses
                $sql4 = "UPDATE offers
                INNER JOIN trades 
                ON offers.id = trades.offer_id
                SET offers.status = 4, trades.status = 2
                WHERE  trades.id = :trade_id 
                AND trades.user_id = :buyer
                AND offers.user_id = :seller 
                AND offers.status = 3 
                AND trades.status = 1";
                $stmt4 = $this->db->prepare($sql4);
                $stmt4->bindParam(':trade_id', $tradeId, PDO::PARAM_INT);
                $stmt4->bindParam(':seller', $seller, PDO::PARAM_INT);
                $stmt4->bindParam(':buyer', $buyer, PDO::PARAM_INT);
                if (!$stmt4->execute())
                    $commit = false;

                $this->db->commit();

            } catch (Exception $e) {
//                echo $e->getMessage();
                $this->db->rollBack();
                return false;
            }

            if ($commit) {
                return true;
            }

        } else {
            //destroy session
            //echo "Something is  wrong !!!<br>";
            return false;
        }

    }

    /**
     * @param $fields
     * @return array
     */
    public function validateFields($fields)
    {
        $errors = array();
        foreach ($fields as $field => $value) {
            if (empty($_POST[$field]) || !isset($_POST[$field])) {
                $errors[] = $value . " is required";
            }
        }
        return $errors;
    }


    /**
     * @param $fields
     * @return array
     */
    public function validateNumeric($fields)
    {
        $errors = array();
        foreach ($fields as $field => $value) {
            if (!is_numeric($_POST[$field])) {
                $errors[] = $value . " should be a number";
            }
        }
        return $errors;
    }

    /**
     * @param $fields
     * @return array
     */
    public function validatePositiveNumeric($fields)
    {
        $errors = array();
        foreach ($fields as $field => $value) {
            if (((float)$_POST[$field]) < 0) {
                $errors[] = $value . " should be a positive number";
            }
        }
        return $errors;
    }

    /**
     * @param $min
     * @param $max
     * @return bool
     */
    public function validateMinMax($min, $max)
    {

        if ($max >= $min)
            return true;
        return false;

    }


    /**
     * @param $userId
     * @param $id
     * @param $amount
     * @return array
     */
    public function validateOffer($userId, $id, $amount)
    {
        $errors = array();
        $wallet = new WalletModel($userId);
        $userBtc = $wallet->getBtc();
        $offer = $this->getOfferById($id);

        $userBtcOffer = $offer['max'] / (BC_PRICE * $offer['margin'] * $offer['rate']);

        if($amount<$offer['min'] || $amount > $offer['max']) {
            $errors[] = WRONG_MIN_MAX;
        }
        if($userBtcOffer > $userBtc){
            $errors[] = NOT_ENOUGH_OF_BTC_2;
        }

        return $errors;


    }

    public  function getTotalBtc($userId){
        $sql = "SELECT sum(offers.max / (:btc * offers.margin * currencies.rate)) AS sum_btc
                FROM offers
                INNER JOIN currencies
                ON offers.currency_id = currencies.id
                WHERE user_id = :user_id AND offers.status =1";
        $stmt = $this->db->prepare($sql);
        $btc = BC_PRICE;
        $stmt->bindParam(':btc', $btc, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result =  $stmt->fetch();
        return $result['sum_btc'];
    }


}