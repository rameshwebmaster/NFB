<?php

namespace App\Http\Controllers;
use App\Subscription;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Log;

class SubscriptionCheckController extends Controller
{
    
        

    public function cronIOSValidator(){

        $now = new \DateTime();
        $current_datetime = $now->format('Y-m-d H:i:s');

        //'expiry_date','<=',$current_datetime
        $sub_id_db = Subscription::where('user_id','181')->get()->toArray();
        
        dd($sub_id_db);

            if(empty($sub_id_db)){
                    Log::info('NO user Found in Cron to Check subscription' );
            }
            else{ 

                     //to get refresh token from Google play 

                    $url ="https://accounts.google.com/o/oauth2/token";
                    $fields = array(
                       "client_id"=>"255681012265-42mdna8cdltqo6a01k47o16jf333bf0r.apps.googleusercontent.com",
                       "client_secret"=>"HJ8fYLJqD6EDpDqISxJip5tE",
                       "refresh_token"=>"1/vuQSCzXk5GZbagniavjMj_bq5BB66ikniuaQtUlFLeaCdaamc6i6ErMmv-bbm92R",
                       "grant_type"=>"refresh_token"
                    );

                    $ch = curl_init($url);

                    //set the url, number of POST vars, POST data
                    curl_setopt($ch, CURLOPT_POST,count($fields));
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    //execute post
                    $lResponse_json = curl_exec($ch);

                    //close connection
                    curl_close($ch);
                    $access_token_google_play = json_decode($lResponse_json, TRUE);
                    unset($ch);

                    //dd($decoded);
                    if(!empty($access_token_google_play['access_token'])){

                    $lAccessToken = $access_token_google_play['access_token'] ;    
                     Log::info('Access Token From Google Play : ' . $lAccessToken);
                    }else{
                     Log::info('Access Token Not Found From Google Play');
                    }   


                 foreach ($sub_id_db as $user => $uservalue){
                  
                   
                    $device_type = $uservalue['device_type'];

                    if($device_type == 'ios'){
                        //call to Ios fucntion
                        $this->getIosSubscription($uservalue);

                    }else{
                       //call to Android function
                         $this->getAndroidSubscription($uservalue,$lAccessToken); 

                    }

                }

         }
       

     }


     public static function getIosSubscription($uservalue){

                    $now = new \DateTime();
                    $current_datetime = $now->format('Y-m-d H:i:s');
   

                     ob_start(); //Turning ON Output Buffering

                     $PASSWORD = '997ec3808bd34f14890506f7008ddc93';
                    
                     $url = "https://sandbox.itunes.apple.com/verifyReceipt/";
                    //dd($sub_id_db);
                    // if ($sandbox_receipt) {
                    //     $url = "https://sandbox.itunes.apple.com/verifyReceipt/";
                    // }
                    // else{
                    //     $url = "https://buy.itunes.apple.com/verifyReceipt";
                    // }

                    $RECEIPT = $uservalue['receipt'];
                    
                    if(!empty($RECEIPT)){

                            $ch = curl_init($url);
                            $data_string = json_encode(array(
                                'receipt-data' => $RECEIPT,
                                'password'     => $PASSWORD,
                            ));
                            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                'Content-Type: application/json',
                                'Content-Length: ' . strlen($data_string))
                            );
                            $output   = curl_exec($ch);
                            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                            ob_flush();//Flush the data here  
                            curl_close($ch);
                            unset($ch);
                           

                            if (200 != $httpCode) {
                                Log::info("Apple Server Response Issue: Error validating App Store transaction receipt. Response HTTP code $httpCode");
                            }
                                
                            $decoded = json_decode($output, TRUE);
                   
                            //  dd($decoded);  
                            //receipt Status if 0 =>correct validated else not validated
                             $status_code = $decoded['status'];


                             /* error log
                            21000   The App Store could not read the JSON object you provided.
                            21002   The data in the receipt-data property was malformed.
                            21003   The receipt could not be authenticated.
                            21004   The shared secret you provided does not match the 
                                    shared secret on file for your account.
                            21005   The receipt server is not currently available.
                            21007   This receipt is a sandbox receipt, but it was sent to the production server.
                            21008   This receipt is a production receipt, but it was sent to the sandbox server. 
                                */

                        if($status_code != 0){
                              Log::info('IOS APP Purchase Error: ' . $output);
                        }else{
                        

                            $latest_receipt = $decoded['latest_receipt'];  

                        
                            //In recipt array,need last array for latest transactions,
                            //It will conintaine all info about transactions
                             $recipt_array = $decoded['latest_receipt_info'];

                            $reverse_Array = end($recipt_array); 
                           // dd($reverse_Array);
                            //Check for cancellation_date if user cancel's subscription
                            if(!empty($reverse_Array['cancellation_date'])){
                                 Log::info('IOS APP Subscription Cancel: ' . $reverse_Array['cancellation_date']);
                              $data['status'] =  'Inactive';

                            }
                            
                            $data['purchase_id']=$reverse_Array['transaction_id'];
                            $data['start_date'] = date("Y-m-d H:i:s",strtotime($reverse_Array['purchase_date']));
                            $data['expiry_date'] = date("Y-m-d H:i:s",strtotime($reverse_Array['expires_date']));
                           // $data['type']=$reverse_Array['product_id'];
                           // $data['device_type']='ios';
                            $data['receipt_status_code'] =  $status_code;
                            if($data['expiry_date'] <= $current_datetime){
                               Log::info('IOS APP Subscription Expired For User Id->'.$uservalue['user_id']);
                               $data['status'] =  'Inactive';

                            }   
                            $data['receipt'] =  $latest_receipt;
                           // dd($data);
                            $update = Subscription::where('id', $uservalue['id'])->update($data);
                                  if($update){
                                  Log::info('IOS APP Purchase Response success user_id: ' . $uservalue['user_id'].' Latest Receipt from Apple server'.json_encode($reverse_Array));
                                  }   

                        }           


                    }else{
                      Log::info('Empty Receipt user_id: ' . $uservalue['user_id']);
                    }   
        }

        public static function getAndroidSubscription($uservalue,$lAccessToken){

            ob_start(); //Turning ON Output Buffering

             $lPackageNameStr = "com.tds.app.nfbox";
            
             $pReceiptStr = $uservalue['receipt'];
                $productID = $uservalue['type'];

                $lURLStr="https://www.googleapis.com/androidpublisher/v2/applications/$lPackageNameStr/purchases/subscriptions/$productID/tokens/$pReceiptStr";
                
                $curl = curl_init($lURLStr);

                curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
                $curlheader[0] = "Authorization: Bearer " . $lAccessToken;
                curl_setopt($curl, CURLOPT_HTTPHEADER, $curlheader);
                ob_flush();//Flush the data here 
                $json_response = curl_exec($curl);
                curl_close($curl);
                unset($ch);
                
                $responseObj = json_decode($json_response,true);
                


            // dd($responseObj);
            if(!empty($responseObj['error'])){
            
            Log::info('Error From Google Play respons:Error Code->'.$responseObj['error']['code'].' Message->'.$responseObj['error']['message']);
            }
           
            Log::info('User success response from Google play for this user id=>'.$uservalue['user_id'].' #Response from Google->'.json_encode($responseObj));
           

            $data = array();  

            if(!empty($responseObj['startTimeMillis'])){
               //Time at which the subscription was granted, in milliseconds since the Epoch. 
                $data['start_date'] = date("Y-m-d H:i:s",$responseObj['startTimeMillis']/1000);
            }
            if(!empty($responseObj['expiryTimeMillis'])){
                //Time at which the subscription will expire, in milliseconds since the Epoch.
               $data['expiry_date'] = date("Y-m-d H:i:s",$responseObj['expiryTimeMillis']/1000);
            }
            
            //The reason why a subscription was cancelled or is not auto-renewing. Possible values are:
            // 0 => User cancelled the subscription
           // 1 => Subscription was cancelled by the system, for example because of a billing problem
        
            if(!empty($responseObj['cancelReason'])){
           
               $data['status'] = 'Inactive';
            }

            $update = Subscription::where('id', $uservalue['id'])->update($data);
             
            if($update){
             Log::info('Android APP Purchase Response success user_id: ' . $uservalue['user_id']);
            }

        }
}