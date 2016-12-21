<?php

class IndexController extends Controller
{
    /**
     * IndexController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        if (Session::get("loggedIn") && Session::get("user_id")) {
            $this->user_id = Session::get("user_id");
            $this->offers = new OffersModel();

            $wallet = new WalletModel($this->user_id);
            $this->wallet = $wallet->getBtc();
            $this->view->wallet = $this->wallet;
        }
    }
    
    public function index()
    {
        $paymentMethodGroup = null;
        $paymentMethod = null;
        $type = 1; // buy by default
        $amount = null;
        $currency = null;

        if (isset($_POST['submit'])) {
            if (isset($_POST['payment_method_group'])) {
                $paymentMethodGroup = $_POST['payment_method_group'];
            }
            if (isset($_POST['payment_method'])) {
                $paymentMethod = $_POST['payment_method'];
            }
            if (isset($_POST['type'])) {
                $type = $_POST['type'];
            }
            if (isset($_POST['amount'])) {
                $amount = $_POST['amount'];
            }
            if (isset($_POST['currency'])) {
                $currency = $_POST['currency'];
            }
        }

        $offers = new OffersModel();
//        $offerTypes = $offers->getOfferTypes();
        $offerTypes = $offers->getInvertedOfferTypes();
        $offersList = $offers->getAllOffers($paymentMethodGroup, $paymentMethod, $type, $amount, $currency);
        $currencies = $offers->getCurrencies();
        $paymentMethods = $offers->getPaymentMethods();
        $paymentMethodGroups = $offers->getPaymentMethodGroups();

        $this->view->offersList = $offersList;
        $this->view->offerTypes = $offerTypes;
        $this->view->currencies = $currencies;
        $this->view->paymentMethods = $paymentMethods;
        $this->view->paymentMethodGroups = $paymentMethodGroups;

        $this->view->selectedPaymentMethodGroup = $paymentMethodGroup;
        $this->view->selectedPaymentMethod = $paymentMethod;
        $this->view->selectedCurrency = $currency;
        $this->view->selectedAmount = $amount;
        $this->view->selectedType = $type;

        if (Session::get('loggedIn'))
            $this->view->render('offers/loggedin_list');
        else
            $this->view->render('offers/guest_list');
    }


}