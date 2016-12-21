<?php

class DashboardController extends Controller
{
    public function __construct()
    {

        parent::__construct();
        if (!Session::get("loggedIn") && !Session::get("user_id")) {
            header("Location: /");
        } else {
            $this->user_id = Session::get("user_id");
            $this->offers = new OffersModel();

            $wallet = new WalletModel($this->user_id);
            $this->wallet = $wallet->getBtc();
            $this->view->wallet = $this->wallet;
        }
    }

    public function index()
    {
        $statuses = array(0, 1); //disabled + enabled
        $userId = Session::get("user_id");
        $offers = new OffersModel();

        $sellerTradeList = $offers->getTradesBySellerId($userId);
        $buyerTradeList = $offers->getTradesByBuyerId($userId);

        $userOffersList = $offers->getOffersByUserId($userId, $statuses);

        $this->view->offersList = $userOffersList;
        $this->view->sellerTradeList = $sellerTradeList;
        $this->view->buyerTradeList = $buyerTradeList;
        $this->view->render('offers/dashboard');
    }


}