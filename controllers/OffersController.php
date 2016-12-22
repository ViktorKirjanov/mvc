<?php

class OffersController extends Controller
{
    private $userId;
    private $required = array(
        'type' => 'Type',
        'min_amount' => 'Min',
        'max_amount' => 'Max',
        'margin' => 'Margin',
        'payment_method_group' => 'Payment method group',
        'payment_method' => 'Payment method',
        'currency' => 'Currency',
    );

    private $numeric = array(
        'min_amount' => 'Min',
        'max_amount' => 'Max',
        'margin' => 'Margin',
    );

    private $offers;
    private $wallet;

    public function __construct()
    {
        parent::__construct();
        if (!Session::get("loggedIn") && !Session::get("user_id")) {
            header("Location: /");
        } else {
            $this->userId = Session::get("user_id");
            $this->offers = new OffersModel();
            $this->wallet = new WalletModel($this->userId);
            $this->view->wallet = $this->wallet->getBtc();
        }

    }

    public function index()
    {
        header("Location: /dashboard");
    }

    public function create()
    {
        $offers = new OffersModel();
        $paymentMethodGroup = null;
        $paymentMethod = null;
        $type = null;
        $maxAmount = null;
        $minAmount = null;
        $currency = null;
        $margin = null;
        $error = false;
        $errors = array();
        $newMaxOfferBtcAmount = 0;
        $newMinOfferBtcAmount = 0;

        if (isset($_POST['submit'])) {
//            print_r($_POST);
            $errors = $offers->validateFields($this->required);
            if (!$errors) {
                $errors = array_merge($errors, $offers->validateNumeric($this->numeric));
                $errors = array_merge($errors, $offers->validatePositiveNumeric($this->numeric));

                if (!empty($errors))
                    $error = true;

                if ($_POST['min_amount'] != "" && $_POST['max_amount'] != "") {
                    if (!$offers->validateMinMax((float)$_POST['min_amount'], (float)$_POST['max_amount'])) {
                        $errors[] = MAX_MIN_ERROR;
                        $error = true;
                    }
                }
            } else {
                $error = true;
            }
        }

        if (!$error && isset($_POST['submit'])) {
            if (isset($_POST['payment_method_group'])) {
                $paymentMethodGroup = $_POST['payment_method_group'];
            }
            if (isset($_POST['payment_method'])) {
                $paymentMethod = $_POST['payment_method'];
            }
            if (isset($_POST['type'])) {
                $type = $_POST['type'];
            }
            if (isset($_POST['max_amount'])) {
                $maxAmount = $_POST['max_amount'];
            }
            if (isset($_POST['min_amount'])) {
                $minAmount = $_POST['min_amount'];
            }
            if (isset($_POST['currency'])) {
                $currency = $_POST['currency'];
            }
            if (isset($_POST['margin'])) {
                $margin = $_POST['margin'];
            }

            $wallet = new WalletModel($this->userId);
            $userBtc = $wallet->getBtc();
            $rate = $offers->getCurrencyRateById($currency);
            $totalOffersBtc = $offers->getTotalBtc($this->userId);
            $newMaxOfferBtcAmount = $maxAmount / (BC_PRICE * $margin * $rate);
            $newMinOfferBtcAmount = $minAmount / (BC_PRICE * $margin * $rate);
            $newMaxOfferBtcAmount = (float)number_format((float)$newMaxOfferBtcAmount, 8, '.', '');
            $newMinOfferBtcAmount = (float)number_format((float)$newMinOfferBtcAmount, 8, '.', '');
            $totalOffersBtc = (float)number_format((float)$totalOffersBtc, 8, '.', '');

            if ($type == 1 && $newMaxOfferBtcAmount > $userBtc) {
                $errors[] = NOT_ENOUGH_OF_BTC;
            } elseif ($type == 1 && (($newMaxOfferBtcAmount + $totalOffersBtc) > $userBtc)) {
                $errors[] = NOT_ENOUGH_OF_BTC . " " . TOTAL_AMOUNT_ERROR . $totalOffersBtc . " BTC";
            } else {
                $result = $offers->create($this->userId, $paymentMethod, $type, $maxAmount, $minAmount, $currency, $margin);
                if ($result) {
                    header("Location: /dashboard");
                }
            }

        }

        $offerTypes = $offers->getOfferTypes();
        $currencies = $offers->getCurrencies();
        $paymentMethods = $offers->getPaymentMethods();
        $paymentMethodGroups = $offers->getPaymentMethodGroups();

        $this->view->errors = $errors;
        $this->view->newMinOfferBtcAmount = $newMinOfferBtcAmount;
        $this->view->newMaxOfferBtcAmount = $newMaxOfferBtcAmount;
        $this->view->offerTypes = $offerTypes;
        $this->view->currencies = $currencies;
        $this->view->paymentMethods = $paymentMethods;
        $this->view->paymentMethodGroups = $paymentMethodGroups;

        $this->view->render('offers/create');
    }

    /**
     * @param $id
     */
    public function edit($id)
    {
        $offers = new OffersModel();
        $offer = $offers->getOfferByIdToEdit($id);
        $error = false;
        $errors = array();
        $btcMax = 0;
        $btcMin = 0;

        if ($offer) {
            $offerData = array
            (
                "id" => $id,
                "type" => $offer['type'],
                "status" => $offer['status'],
                "payment_method_group" => $offer['payment_method_group_id'],
                "payment_method" => $offer['payment_method_id'],
                "currency" => $offer['currency_id'],
                "min_amount" => $offer['min'],
                "max_amount" => $offer['max'],
                "margin" => $offer['margin']
            );

            if (isset($_POST['submit'])) {
                $offerData['type'] = $_POST['type'];
                $offerData['status'] = $_POST['status'];
                $offerData['payment_method_group'] = $_POST['payment_method_group'];
                $offerData['payment_method'] = $_POST['payment_method'];
                $offerData['currency'] = $_POST['currency'];
                $offerData['min_amount'] = $_POST['min_amount'];
                $offerData['max_amount'] = $_POST['max_amount'];
                $offerData['margin'] = $_POST['margin'];

                $errors = $offers->validateFields($this->required);
                if (!$errors) {
                    $errors = array_merge($errors, $offers->validateNumeric($this->numeric));
                    $errors = array_merge($errors, $offers->validatePositiveNumeric($this->numeric));

                    if (!empty($errors))
                        $error = true;

                    if ($_POST['min_amount'] != "" && $_POST['max_amount'] != "") {
                        if (!$offers->validateMinMax((float)$_POST['min_amount'], (float)$_POST['max_amount'])) {
                            $errors[] = MAX_MIN_ERROR;
                            $error = true;
                        }
                    }
                } else {
                    $error = true;
                }
            } else {
                $currencyRate = $offers->getCurrencyRateById($offer['currency_id']);
                $btcMax = $offer['max'] / (BC_PRICE * $offer['margin'] * $currencyRate);
                $btcMin = $offer['min'] / (BC_PRICE * $offer['margin'] * $currencyRate);
                $btcMin = (float)number_format((float)$btcMin, 8, '.', '');
                $btcMax = (float)number_format((float)$btcMax, 8, '.', '');
            }

            if (!$error && isset($_POST['submit'])) {

                $wallet = new WalletModel($this->userId);
                $userBtc = $wallet->getBtc();
                $rate = $offers->getCurrencyRateById($offerData['currency']);
                $editOfferBtcAmount = $offerData['max_amount'] / (BC_PRICE * $offerData['margin'] * $rate);

                $totalOffersBtc = $offers->getTotalBtc($this->userId);
                $btcMax = $offerData['max_amount'] / (BC_PRICE * $offerData['margin'] * $rate);
                $btcMin = $offerData['min_amount'] / (BC_PRICE * $offerData['margin'] * $rate);
                $btcMax = (float)number_format((float)$btcMax, 8, '.', '');
                $btcMin = (float)number_format((float)$btcMin, 8, '.', '');
                $totalOffersBtc = (float)number_format((float)$totalOffersBtc, 8, '.', '');

                if ($offerData['type'] == 1 && $editOfferBtcAmount > $userBtc) {
                    $errors[] = NOT_ENOUGH_OF_BTC;
                } elseif ($offerData['type'] == 1 && (($btcMax + $totalOffersBtc) > $userBtc)) {
                    $errors[] = NOT_ENOUGH_OF_BTC . " " . TOTAL_AMOUNT_ERROR . $totalOffersBtc . " BTC";
                } else {
                    $result = $offers->edit($id, $offerData);
                    if ($result) {
                        header("Location: /dashboard");
                    }
                }
            }

            $offerTypes = $offers->getOfferTypes();
            $currencies = $offers->getCurrencies();
            $paymentMethods = $offers->getPaymentMethods();
            $paymentMethodGroups = $offers->getPaymentMethodGroups();
            $this->view->btcMax = $btcMax;
            $this->view->btcMin = $btcMin;
            $this->view->errors = $errors;
            $this->view->offer = $offerData;
            $this->view->offerTypes = $offerTypes;
            $this->view->currencies = $currencies;
            $this->view->paymentMethods = $paymentMethods;
            $this->view->paymentMethodGroups = $paymentMethodGroups;

            $this->view->render('offers/edit');
        } else {
            Session::destroy();
            header("Location: /");
        }
    }

    public function delete($offerId)
    {
        $offers = new OffersModel();
        $result = $offers->checkOffer($this->userId, $offerId);
        if ($result) {
            $offers->changeStatus($this->userId, $offerId, 2);
            header("Location: /dashboard");
        } else {
            Session::destroy();
            header("Location: /");
        }
    }


    public function cancel($tradeId)
    {
        $offers = new OffersModel();
        $result = $offers->changeTradeStatus($this->userId, $tradeId, 1, 0);
        if (!$result) {
            Session::destroy();
            header("Location: /");
        }
        header("Location: /dashboard");
    }

    public function release($tradeId)
    {
        $offers = new OffersModel();
        $result = $offers->confirmTrade($this->userId, $tradeId);
        if (!$result) {
            Session::destroy();
            header("Location: /");
        }
        header("Location: /dashboard");
    }

    /**
     * change status(enable/disable) of the  the offer
     * @param $id
     */
    public function enable($id)
    {
        $this->offers->changeStatus($this->userId, $id, 1);
        $data = array('status' => 'true', 'error' => false, 'url' => '/offers/disable/' . $id);
        header('Content-type: application/json');
        echo json_encode($data);
    }

    /**
     * change status(enable/disable) of the  the offer
     * @param $id
     */
    public function disable($id)
    {
        $this->offers->changeStatus($this->userId, $id, 0);
        $data = array('status' => 'true', 'error' => false, 'url' => '/offers/enable/' . $id);
        header('Content-type: application/json');
        echo json_encode($data);

    }


    /**
     * @param $id
     */
    public function view($id)
    {
        $offers = new OffersModel();
        $offer = $offers->getOfferById($id);
        if ($offer) {
            $this->view->offer = $offer;
            $this->view->render('offers/view');
        } else {
            $controller = new ErrorController();
            $controller->index();
            return false;
        }

    }

    public function trade()
    {
        $offers = new OffersModel();
        $offerId = null;
        $amountFiat = null;
        $errors = array();

        if (isset($_POST['submit'])) {
            if (isset($_POST['id']) && (isset($_POST['amount_fiat']))) {
                $offerId = $_POST['id'];
                $amount = $_POST['amount_fiat'];

                $errors = $offers->validateOffer($this->userId, $offerId, $amount);
                if (empty($errors)) {
                    $result = $offers->createTrade($this->userId, $offerId, $amountFiat);
                    if (!$result) {
                        Session::destroy();
                        header("Location: /");
                    }
                } else {
                    $this->view->errors = $errors;
                    $this->view->render('/offers/trade');
                }
            }
        }
//        header("Location: /dashboard");


    }
}