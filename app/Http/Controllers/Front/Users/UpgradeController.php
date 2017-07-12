<?php

namespace App\Http\Controllers\Front\Users;

use GuzzleHttp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpgradeController extends Controller
{
    private $options = [];

    public function __construct()
    {
        $this->options = [
            'IDM' => '37589026',
            'IDW' => '29037740',
            'TID' => '99032854',
            'IDO' => '25365232',
            'TTP' => 0,
            'SPR' => '',
            'SDS' => '',
        ];
    }

    public function upgrade()
    {
        return view('front.registered.profile.upgrade');
    }

    public function process(Request $request)
    {
        $options = [
            'LAN' => 'EN', // client interface language
            'CHU' => 'USD', // currency
            'AMT' => $request->amount,
            'CIP' => $request->getClientIp(),
            'CCHN' => $request->cchn,
            'CCHM' => $request->cchm,
            'PAR1' => '',
            'PAR2' => '',
            'PAR3' => '',
            'ATP' => 'JSON',
            'CCNR' => $request->ccnr,
            'CCEM' => $request->ccem,
            'CCEY' => $request->ccey,
            'CCV2' => $request->ccv2
        ];

        $opts = array_merge($this->options, $options);

        $apw = '@gtgd56t!fg';

        /* test credentials */

        /*$opts = [
            'IDM' => '37589026', // 'Your Merchant ID
            'IDW' => '29037740', // website id
            'TID' => '99032854', // terminal id
            'IDO' => '25365232', // merchant order id
            'TTP' => 0, // Transaction type 0=normal 1=subscription
            'SPR' => '',
            'SDS' => '',
            'LAN' => 'EN', // client interface language
            'CHU' => 'USD', // currency
            'AMT' => 2500,
            'CIP' => '77.111.23.69',
            'CCHN' => 'Joe Smith',
            'CCHM' => 'joesmith@domain.com',
            'PAR1' => '',
            'PAR2' => '',
            'PAR3' => '',
            'ATP' => 'JSON',
            'CCNR' => '4111111111111111',
            'CCEM' => '08',
            'CCEY' => 17,
            'CCV2' => 369
        ];

        $apw = '@gtgd56t!fg';*/

        /* end test creds */

        $mdstring = http_build_query($opts);
        $url = 'https://gateway.firstpay.biz/api/pay.asp?' . $mdstring;
        $mdgest = '&MDGEST=' . md5( $apw . $mdstring);


        $purchase_url = $url . $mdgest;

        $client = new GuzzleHttp\Client();

        $res = $client->request('POST', $purchase_url);

        $body = (string) $res->getBody();

        $result = json_decode($body, true );


        // if transaction failed or something is not right
        if( $result['TRANSRES'] != 1 )
        {
            return response()->json([
                'success' => false,
                'message' => $result['TRANSRESDESC']
            ]);
        }

        // if transaction success
        return response()->json([
            'success' => true,
            'message' => $result['TRANSRESDESC']
        ]);

    }

    public function payment()
    {
        if( request()->method() === 'POST' )
        {
            $data = request()->all();

            return view('front.registered.payments.credit_card', compact('data'));
        }
    }
}
