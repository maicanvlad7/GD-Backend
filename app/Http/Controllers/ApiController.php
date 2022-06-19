<?php

namespace App\Http\Controllers;

use App\Models\Activation;
use Illuminate\Support\Str;
use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;


class ApiController extends Controller
{
    public function __construct()
    {
        \Stripe\Stripe::setApiKey("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");
    }

    public function stripe(Request $request)
    {
        \Stripe\Stripe::setApiKey("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");
        header('Content-Type: application/json');



        $YOUR_DOMAIN = 'https://gandestediferit.ro/course/membership-levels';



        if(strtoupper($request->dc) == "GD50" || strtoupper($request->dc) == "GD20") {
            $checkout_session = \Stripe\Checkout\Session::create([
                'line_items' => [[
                    # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
                    'price' => $request->product_id,
                    'quantity' => 1,
                ]],
                'mode' => 'subscription',
                'discounts' => [[
                    'coupon' => strtoupper($request->dc),
                ]],
                'success_url' => $YOUR_DOMAIN . '?success=true&session_id={CHECKOUT_SESSION_ID}&kloiju=' . $request->level,
                'cancel_url' => $YOUR_DOMAIN . '?canceled=true',
            ]);
        }else {
            $checkout_session = \Stripe\Checkout\Session::create([
                'line_items' => [[
                    # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
                    'price' => $request->product_id,
                    'quantity' => 1,
                ]],
                'mode' => 'subscription',
                'success_url' => $YOUR_DOMAIN . '?success=true&session_id={CHECKOUT_SESSION_ID}&kloiju=' . $request->level,
                'cancel_url' => $YOUR_DOMAIN . '?canceled=true',
            ]);
        }


        header("HTTP/1.1 303 See Other");

        return response()->json([
            "url" => $checkout_session->url,
        ]);
    }

    public function updateCustomerId(Request $request)
    {
        $user = User::find($request->input('gd_id'));

        $user->stripe_id    = $request->input('stripe_id');
        $user->subscription = $request->input('sub_id');
        $user->level        = $request->input('level');

        if($user->save()) {
            //User created, return success response
            return response()->json([
                'success' => true,
                'message' => 'Customer ID updated',
                'data' => $user
            ], Response::HTTP_OK);
        };
    }


    public function get_stripe_customer_data(Request $request)
    {
        \Stripe\Stripe::setApiKey("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");

        $session = \Stripe\Checkout\Session::retrieve($request->input('session_id'));
        $customer = \Stripe\Customer::retrieve($session->customer);

        return response()->json([
            "customer" => $customer,
            "session" => $session,
        ], Response::HTTP_OK);
    }

    public function get_stripe_profile_data(Request $request)
    {

        $user = User::find($request->input('user_id'));

        if($user->subscription == "0" ) {
            return response()->json([
                "customer" => null,
                "product"  => null,
            ], Response::HTTP_OK);
        }

        $customer = \Stripe\Subscription::retrieve($user->subscription);

        $prodInt = $customer->plan->product;

        $prod = \Stripe\Product::retrieve($prodInt);


        return response()->json([
            "customer" => $customer,
            "product"  => $prod,
        ], Response::HTTP_OK);
    }

    public function cancel_active_sub(Request $request)
    {
        $user = User::find($request->input('user_id'));

        $customer = \Stripe\Subscription::update($user->subscription,
            [
                'cancel_at_period_end' => true,
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Customer Subscription canceled',
        ], Response::HTTP_OK);

    }

    public function generateResetCode(Request $request)
    {
        $user = User::where('email',$request->input('email'))->first();

        if(isset($user->id)) {

            $email = new \SendGrid\Mail\Mail();
            $email->setFrom("website@gandestediferit.ro", "Example User");
            $email->setSubject("Resetare Parola - GDRO");
            $email->addTo("maicanvlad1998@gmail.com", "Example User");
            $email->addContent("text/plain", "test 123");
            $sendgrid = new \SendGrid(env('SENDGRID_API_KEY'));
            try {
                $response = $sendgrid->send($email);
                print $response->statusCode() . "\n";
                print_r($response->headers());
                print $response->body() . "\n";
            } catch (Exception $e) {
                echo 'Caught exception: '. $e->getMessage() ."\n";
            }

            return response()->json([
                'success' => true,
                'message' => 'Linkul de resetare a fost trimis pe email. Te rugam sa verifici si folderul de spam!',
            ], Response::HTTP_OK);
            //returnam succes si mesaj pentru alerta
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Emailul nu este asociat cu un cont. Incearca din nou!',
            ], Response::HTTP_OK);
        }
    }

    public function getReferred(Request $request)
    {
        $refer = new \stdClass();

        $refer->referredCount = User::where('referred_by', $request->user_id)->count();
        $refer->subbedCount   = User::where('referred_by', $request->user_id)
                            ->where('subscription','!=','0')
                            ->count();

        return response()->json([
            'success' => true,
            'message' => 'Referral data fount',
            'data' => $refer
        ], Response::HTTP_OK);

    }


    public function register(Request $request)
    {
        //Validate data
        $data = $request->only('name', 'email', 'password', 'refCode');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $active = 0;
        $refBy = 0;

        if(isset($request->refCode) && !empty($request->refCode)) {
            $refBy = substr($request->refCode, 3);
        }

        if(isset($request->pid) && !empty($request->pid)) {
            $active = 1;
        }

        //Request is valid, create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'referred_by' => intval($refBy),
            'active'    => 1,
        ]);

        $new_time = date("Y-m-d H:i:s", strtotime('+5 hours'));

       if(!$active) {
           //user created, create activation code
           $activation = Activation::create([
               'user_id' => $user->id,
               'code'    => Str::random(30),
               'expires' => $new_time
           ]);


       }

        //User created, return success response
        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => $user
        ], Response::HTTP_OK);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is validated
        //Crean token
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Login credentials are invalid.',
                ], 400);
            }
        } catch (JWTException $e) {
            return $credentials;
            return response()->json([
                'success' => false,
                'message' => 'Could not create token.',
            ], 500);
        }

        //Token created, return with success response and jwt token
        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        //valid credential
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is validated, do logout
        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'success' => true,
                'message' => 'User has been logged out'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function get_user(Request $request)
    {
//        $this->validate($request, [
//            'token' => 'required'
//        ]);

        $user = JWTAuth::authenticate($request->bearerToken());

        return response()->json(['user' => $user]);
    }

    public function activateAccount(Request $request, $code)
    {
        $user = JWTAuth::authenticate($request->bearerToken());
        //get user with activation data
        $user = User::where('id', $user->id)->with('activation')->first();

        $now = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', \Carbon\Carbon::now());
        $expires = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $user->activation->expires);

        if($user->active) {
            return response()->json([
                'success' => false,
                'message' => 'Acest cont este deja activ.'
            ], 200);
        }else if($now->gt($expires)){
            echo($now);
            echo($expires);
            return response()->json([
                'success' => false,
                'message' => 'Codul de activare a expirat, va rugam sa solicitati unul nou.'
            ], 200);
        }else{
            if($code == $user->activation->code) {
                $user = User::where('id', $user->id)->update([
                    'active' => 1,
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Contul a fost activat cu succes! Veti fi redirectionat.'
                ], 200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Codul folosit este gresit sau nu exista. Va rugam sa solicitati unul nou.'
                ], 200);
            }


        }


    }
}
