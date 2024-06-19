<?php
require FCPATH . 'vendor/autoload.php';
require_once(FCPATH . 'application/libraries/stripe-php-master/init.php');

use Dompdf\Dompdf;
use Dompdf\Options;

class Users extends MY_Controller
{
    private $jsonvalue;
    public $currencySymbol = '';
    public $userData = array();
    public function __construct()
    {
        parent::__construct();
        /*if (!$this->authCheck()) {            
            $this->returnFailedResponse();
            exit();
        }  */
        //////////////////////////////////
        header('Content-type:application/json');
        /* if (isset($_FILES['upload_photos']) && !empty($_FILES['upload_photos'])) {
            $json_file = $_POST['data'];
        } else {
            $json_file = file_get_contents('php://input');
        } */

        if (isset($_FILES['towing_storage_image']) && !empty($_FILES['towing_storage_image'])) {
            $json_file = $_POST['data'];
        } else {
            $json_file = file_get_contents('php://input');
        }

        $this->jsonvalue = json_decode($json_file, true);
        $headers         = apache_request_headers();
        if (isset($headers['User'])) {
            $this->jsonvalue['user_id'] = $headers['User'];
            $this->userData = $this->db->get_where('ca_users', array('user_id' => $headers['User']))->row_array();
        }
        if (isset($headers['user'])) {
            $this->jsonvalue['user_id'] = $headers['user'];
            $this->userData = $this->db->get_where('ca_users', array('user_id' => $headers['user']))->row_array();
        }
        //////////////////////////////////
        $this->load->model('Muser');
        $this->load->helper('common');
        $this->load->library('pushnotification');
        $this->load->library('emailnotification');
    }

    /************************ Change Password Function  **********************/

    public function change_password()
    {
        $fields = array(
            'new_password',
            'old_password',
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);
        
        $userData['password'] = $this->jsonvalue['new_password'];
        $datavalue            = array(
            "password" => $userData['password']
        );
        $isActiveUser = $this->Muser->matchOldPassword($this->jsonvalue);
        if ($isActiveUser) {
            $returnStatus         = $this->Muser->update_password($datavalue, $this->jsonvalue['user_id']);
            if ($returnStatus) {
                $result = array(
                    'success' => true,
                    'msg' => $this->lang->line('password_update'),
                    'code' => 200
                );
            } else {
                $result = array(
                    'success' => false,
                    'msg' => $this->lang->line('password_not_update'),
                    'code' => 400
                );
            }
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line("password_not_match"),
                'code' => 400
            );
        }
        echo json_encode($result);
    }


    /************************ Logout Serviec  **********************/

    public function logout()
    {
        $fields = array(
            'user_id'
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            echo json_encode($response);
            exit();
        }
        $taskDetails = $this->Muser->logout($this->jsonvalue);
        if ($taskDetails) {
            $result = array(
                'success' => true,
                'msg' => $this->lang->line('logout_success'),
                'code' => 200
            );
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('oops_something_went_wrong'),
                'code' => 400
            );
        }
        echo json_encode($result);
    }

    /********************** Add Estimation ***********************/

    public function delete()
    {
        $fields = array(
            'user_id'
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            echo json_encode($response);
            exit();
        }

        $taskDetails = $this->Muser->delete_account($this->jsonvalue);
      
      if ($taskDetails) {
        $result = array(
            'success' => true,
            'msg' => $this->lang->line('delete_account_success'),
            'code' => 200
        );
    } else {
        $result = array(
            'success' => false,
            'msg' => $this->lang->line('oops_something_went_wrong'),
            'code' => 400
        );
    }
    echo json_encode($result);
    }



    public function randomStr($length = 8)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function create_estimate()
    {
        $fields = array(
            'user_id'
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['estimate_id']   = '';
            $response['code']   = 400;
            echo json_encode($response);
            exit();
        }
        $estId = $this->Muser->create_estimate($this->jsonvalue['user_id']);
        if ($estId) {
            $result = array(
                'success' => true,
                'msg' => $this->lang->line('data_found'),
                'estimate_id' => $estId,
                'code' => 200
            );
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('oops_something_went_wrong'),
                'estimate_id' => '',
                'code' => 400
            );
        }
        echo json_encode($result);
    }

    public function add_estimate_owner()
    {
        $fields = array(
            'user_id',
            'owner_identity'
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['estimate_id'] = 0;
            echo json_encode($response);
            exit();
        }
        if ($this->jsonvalue['estimate_id'] == '' || $this->jsonvalue['estimate_id'] == 0) {
            $this->jsonvalue['estimate_id'] = $this->Muser->create_estimate($this->jsonvalue['user_id']);
        }
        $this->currentLang($this->jsonvalue['user_id']);
        $datavalue  = array(
            "estimate_id" => $this->jsonvalue['estimate_id'],
            "insured_name" => $this->jsonvalue['insured_name'],
            "claimant_name" => $this->jsonvalue['claimant_name'],
            "owner_identity" => $this->jsonvalue['owner_identity'],
            "owner_address" => $this->jsonvalue['owner_address'],
            "city" => $this->jsonvalue['city'],
            "state" => $this->jsonvalue['state'],
            "zipcode" => $this->jsonvalue['zipcode'],
            "phone1" => $this->jsonvalue['phone1'],
            "phone2" => $this->jsonvalue['phone2'],
            "owner_email" => $this->jsonvalue['owner_email'],
            "added_on" => date('Y-m-d H:i:s'),
            "added_on_gmt" => $this->getUTC(),
        );
        if ($this->Muser->isExistEstimate($this->jsonvalue['estimate_id'], $this->jsonvalue['user_id'])) {
            $returnStatus = $this->Muser->add_estimate_owner($datavalue);
            if ($returnStatus) {
                $result = array(
                    'success' => true,
                    'msg' => $this->lang->line('data_saved'),
                    'code' => 200,
                    'estimate_id' => $this->jsonvalue['estimate_id']
                );
            } else {
                $result = array(
                    'success' => false,
                    'msg' => $this->lang->line('oops_something_went_wrong'),
                    'code' => 400,
                    'estimate_id' => 0
                );
            }
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('no_premission'),
                'code' => 400,
                'estimate_id' => 0
            );
        }
        echo json_encode($result);
    }

    public function add_estimate_insurance()
    {
        $fields = array(
            'estimate_id',
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);
        $datavalue  = array(
            "estimate_id" => $this->jsonvalue['estimate_id'],
            "insurance_company" => $this->jsonvalue['insurance_company'],
            "adjuster_name" => $this->jsonvalue['adjuster_name'],
            "adjuster_phone" => $this->jsonvalue['adjuster_phone'],
            "claim" => $this->jsonvalue['claim'],
            "policy" => $this->jsonvalue['policy'],
            "loss_type" => $this->jsonvalue['loss_type'],
            "deductible" => $this->jsonvalue['deductible'],
            "loss_date" => $this->jsonvalue['loss_date'],
            // "repair_days" => $this->jsonvalue['repair_days'],
            "loss_date_gmt" => $this->Muser->getUtcTimeZone($this->jsonvalue['loss_date'], DEFAULT_TIMEZONE),
            "added_on" => date('Y-m-d H:i:s'),
            "added_on_gmt" => $this->getUTC(),
        );
        if ($this->Muser->isExistEstimate($this->jsonvalue['estimate_id'], $this->jsonvalue['user_id'])) {
            $returnStatus = $this->Muser->add_estimate_insurance($datavalue);
            if ($returnStatus) {
                $result = array(
                    'success' => true,
                    'msg' => $this->lang->line('data_saved'),
                    'code' => 200
                );
            } else {
                $result = array(
                    'success' => false,
                    'msg' => $this->lang->line('oops_something_went_wrong'),
                    'code' => 400
                );
            }
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('no_premission'),
                'code' => 400
            );
        }
        echo json_encode($result);
    }

    public function add_estimate_inspect()
    {
        $fields = array(
            'estimate_id',
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            echo json_encode($response);
            exit();
        }
        $datavalue  = array(
            "estimate_id" => $this->jsonvalue['estimate_id'],
            "site_type" => $this->jsonvalue['site_type'],
            "name" => $this->jsonvalue['name'],
            "address" => $this->jsonvalue['address'],
            "city" => $this->jsonvalue['city'],
            "state" => $this->jsonvalue['state'],
            "phone" => $this->jsonvalue['phone'],
            "fax" => $this->jsonvalue['fax'],
            "zipcode" => $this->jsonvalue['zipcode'],
            "tax_id" => $this->jsonvalue['tax_id'],
            "added_on" => date('Y-m-d H:i:s'),
            "added_on_gmt" => $this->getUTC(),
        );

        $this->currentLang($this->jsonvalue['user_id']);
        if ($this->Muser->isExistEstimate($this->jsonvalue['estimate_id'], $this->jsonvalue['user_id'])) {
            $returnStatus = $this->Muser->add_estimate_inspect($datavalue);
            if ($returnStatus) {
                $result = array(
                    'success' => true,
                    'msg' => $this->lang->line('data_saved'),
                    'code' => 200
                );
            } else {
                $result = array(
                    'success' => false,
                    'msg' => $this->lang->line('oops_something_went_wrong'),
                    'code' => 400
                );
            }
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('no_premission'),
                'code' => 400
            );
        }
        echo json_encode($result);
    }


      public function user_currency($user_id)
    {   
      $currncy = $this->Muser->getLocalCurrncy($user_id);      
      $arr = json_decode($currncy);
      return $arr[0]->default_currency;
    }
    
    
      public function currency_convert()
    {
    $date = date('Y-m-d',strtotime("-1 days"));
    
   
    $user_id =  $this->jsonvalue['user_id'];  
    $base_currency = 'USD';
    $user_currency = $this->user_currency($user_id);
    $amount = 1;

    $url = "https://api.currencyapi.com/v3/convert?date=$date&base_currency=$base_currency&currencies=$user_currency&value=$amount";
    
    


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'apikey: GJsfsyBUPoQSthQGouZaFtMZAJZoDhMB5ZCx3nNI'
    ));
    $result = curl_exec($ch);
    //echo $result;
    curl_close($ch);
    $obj = json_decode($result, true);

   $rows = $obj['data'];
   //print_r($rows);
 
   foreach($rows as $key=>$row)
   {
    $coverted_amount = number_format((float)$row['value'], 2, '.', '');
    $coverted_currency = $row['code'];
   }
   
     $this->db->where(array('currency' => $coverted_currency));
     $this->db->update('ca_countries', ['usd_value'=>$coverted_amount]);

    return $coverted_amount;
    
    
   }
   

   public function lang_translate($text,$user_id)
   {

    $lanaguage = $this->Muser->getLocalLanguage($user_id);      
    $arr = json_decode($lanaguage);
    $lang = $arr[0]->default_language;
    if($lang == 'en')
    {
      return $text;
    } else {
    $text_content = $text;
    $url = "https://translation-api.translate.com/translate/v1/mt";
    ///////////////////////////////////
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, array("source_language" => "en", "translation_language" => $lang, "text" => $text_content));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: multipart/form-data',
      'x-api-key: 164acb8bd1f8d1'
    ));
    $result = curl_exec($ch);

    curl_close($ch);
    $obj = json_decode($result, true);

   return $obj['translation'] ?? $text;
     }
   
  }





  public function getLanguage($user_id)
  {
    $this->db->select('default_language');
    $this->db->where(array('user_id' => $user_id));
    $user = $this->db->get('ca_users')->result_array();
    $lang = $user[0]['default_language'];

    switch ($lang) {
      case "en":
        return 'english';
        break;
      case "es":
        return "spanish";
        break;
      case "fr":
        return "french";
        break;
      case "de":
        return "german";
        break;
      case "zh-TW":
        return "chinese";
        break;
      case "ur":
        return "urdu";
        break;
      case "pa":
        return "punjabi";
        break;
      case "te":
        return "telugu";
        break;
      case "ar":
        return "arabic";
        break;
      case "ru":
        return "russian";
        break;
      case "ja":
        return "japanese";
        break;
      case "it":
        return "italian";
        break;
      case "zh":
        return "mandarin_chinese";
        break;
      case "id":
        return "indonesian";
        break;
      case "ta":
        return "tamil";
        break;
      case "th":
        return "thai";
        break;

      case "pt":
        return "portuguese";
        break;
      case "hi":
        return "hindi";
        break;
      case "ko":
        return "korean";
        break;
      case "tr":
        return "turkish";
        break;
      case "vi":
        return "vietnamese";
        break;
      case "mr":
        return "marathi";
        break;
      case "pl":
        return "polish";
        break;
      default:
        ///echo "english";
    
  }

   
  }

    public function currentLang($user_id)
    {
      $user_id = $user_id;
      $lanaguage = $this->getLanguage($user_id);
      $this->lang->load('translations_lang', $lanaguage);
    }



    public function save_rate_taxs_05july()
    {
        $fields = array(
            'user_id'
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            echo json_encode($response);
            exit();
        }
        
        $currency_convert = $this->currency_convert();
        
        $datavalue  = array(
            "user_id" => $this->jsonvalue['user_id'],
            "body_labor" => $this->jsonvalue['body_labor']/$currency_convert,
            "refinish_labor" => $this->jsonvalue['refinish_labor']/$currency_convert,
            "machanical_labor" => $this->jsonvalue['machanical_labor']/$currency_convert,
            "frame_labor" => $this->jsonvalue['frame_labor']/$currency_convert,
            "structural_labor" => $this->jsonvalue['structural_labor']/$currency_convert,
            "glass_labor" => $this->jsonvalue['glass_labor']/$currency_convert,
            "paint_meterials" => $this->jsonvalue['paint_meterials']/$currency_convert,
            "sales_tax_percent" => $this->jsonvalue['sales_tax_percent']/$currency_convert,
            "appraisal_service" => $this->jsonvalue['appraisal_service']/$currency_convert,
            "appraisal_service_loss" => $this->jsonvalue['appraisal_service_loss']/$currency_convert,
            "reinspection_service" => $this->jsonvalue['reinspection_service']/$currency_convert,
            "reinspection_service_loss" => $this->jsonvalue['reinspection_service_loss']/$currency_convert,
            "speciality_vehicle_damage" => $this->jsonvalue['speciality_vehicle_damage']/$currency_convert,
            "add_tax_to_paint" => $this->jsonvalue['add_tax_to_paint'],
            "appraisal_sales_tax_percent" => $this->jsonvalue['appraisal_sales_tax_percent']/$currency_convert,
            "add_tax_to_appraisal" => $this->jsonvalue['add_tax_to_appraisal']/$currency_convert,
            "user_define_label_1" => $this->jsonvalue['user_define_label_1']/$currency_convert,
            "user_define_value_1" => $this->jsonvalue['user_define_value_1']/$currency_convert,
            "user_define_label_2" => $this->jsonvalue['user_define_label_2']/$currency_convert,
            "user_define_value_2" => $this->jsonvalue['user_define_value_2']/$currency_convert,
            "added_on" => date('Y-m-d H:i:s'),
            "added_on_gmt" => $this->getUTC(),
        );
        $returnStatus = $this->Muser->save_rate_taxs($datavalue);
        if ($returnStatus) {
            $result = array(
                'success' => true,
                'msg' => $this->lang->line('data_saved'),
                'code' => 200
            );
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('oops_something_went_wrong'),
                'code' => 400
            );
        }

        echo json_encode($result);
    }




    // new save rate tax 


    public function save_rate_taxs()
    {
        $fields = array(
            'user_id'
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            echo json_encode($response);
            exit();
        }

        $this->currentLang($this->jsonvalue['user_id']);
 $currency_convert = $this->currency_convert();


        $datavalue  = array(
            "user_id" => $this->jsonvalue['user_id'],
            "userdefined1_head" => $this->jsonvalue['userdefined1_head'],
            "userdefined1" => $this->jsonvalue['userdefined1']/$currency_convert,
            "user_defined1_salestax" => $this->jsonvalue['user_defined1_salestax'],
            "userdefined2" => $this->jsonvalue['userdefined2']/$currency_convert,
            "userdefined2_head" => $this->jsonvalue['userdefined2_head'],
            "user_defined2_salestax" => $this->jsonvalue['user_defined2_salestax'],
            "userdefined3" => $this->jsonvalue['userdefined3']/$currency_convert,
            "userdefined3_head" => $this->jsonvalue['userdefined3_head'],
            "user_defined3_salestax" => $this->jsonvalue['user_defined3_salestax'],
            "body_labor" => $this->jsonvalue['body_labor']/$currency_convert,
            "refinish_labor_salestax" => $this->jsonvalue['refinish_labor_salestax'],
            "refinish_labor" => $this->jsonvalue['refinish_labor']/$currency_convert,
            "machanical_labor" => $this->jsonvalue['machanical_labor']/$currency_convert,
            "machanical_labor_salestax" => $this->jsonvalue['machanical_labor_salestax'],
            "frame_labor" => $this->jsonvalue['frame_labor']/$currency_convert,
            "frame_labor_salestax" => $this->jsonvalue['frame_labor_salestax'],
            "structural_labor" => $this->jsonvalue['structural_labor']/$currency_convert,
            "structural_labor_salestax" => $this->jsonvalue['structural_labor_salestax'],
            "glass_labor" => $this->jsonvalue['glass_labor']/$currency_convert,
            "glass_labor_salestax" => $this->jsonvalue['glass_labor_salestax'],
            "paint_meterials" => $this->jsonvalue['paint_meterials']/$currency_convert,
            "paint_meterials_salestax" => $this->jsonvalue['paint_meterials_salestax'],
            "days_to_repair_value" => $this->jsonvalue['days_to_repair_value'],
            "body_labor_salestax" => $this->jsonvalue['body_labor_salestax'],
            "sales_tax_percent" => $this->jsonvalue['sales_tax_percent'],
            "add_tax_to_paint" => $this->jsonvalue['add_tax_to_paint'],
            "towing_storage_fee" => $this->jsonvalue['towing_storage_fee']/$currency_convert,
            "tear_down_fee" => $this->jsonvalue['tear_down_fee']/$currency_convert,
            "user_define_value_1" => $this->jsonvalue['user_define_value_1']/$currency_convert,
            "user_define_value_1_head" => $this->jsonvalue['user_define_value_1_head'],
            "user_define_value_2" => $this->jsonvalue['user_define_value_2']/$currency_convert,
            "user_define_value_2_head" => $this->jsonvalue['user_define_value_2_head'],
            "user_define_value_1_salestax" => $this->jsonvalue['user_define_value_1_salestax'],
            "user_define_value_2_salestax" => $this->jsonvalue['user_define_value_2_salestax'],
            "diagnostic_service_fee" => $this->jsonvalue['diagnostic_service_fee']/$currency_convert,
           
            ///"diagnostic_service_fee" => $this->jsonvalue['diagnostic_service_fee']/$currency_convert,

            "added_on" => date('Y-m-d H:i:s'),
            "added_on_gmt" => $this->getUTC(),
        );

        // upload image


        if (isset($_FILES['towing_storage_image']) && !empty($_FILES['towing_storage_image'])) {
            @set_time_limit(-1);
            $path   = './uploads/towingimage';
            if (!is_dir($path)) { //create the folder if it's not already exists
                mkdir($path, 0777, TRUE);
            }
            $profile_upload_path = getcwd() . '/uploads/towingimage';
            $files               = $_FILES['towing_storage_image'];


            if ($_FILES['towing_storage_image']['name'] != '') {
                $config['upload_path']               = $profile_upload_path;
                $config['allowed_types']             = '*';
                $config['encrypt_name']              = TRUE;
                $_FILES['uploadedimage']['name']     = $files['name'];
                $_FILES['uploadedimage']['type']     = $files['type'];
                $_FILES['uploadedimage']['tmp_name'] = $files['tmp_name'];
                $_FILES['uploadedimage']['error']    = $files['error'];
                $_FILES['uploadedimage']['size']     = $files['size'];
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('uploadedimage')) {
                    $img_data                = $this->upload->data();
                    $towing_storage_image = $img_data['file_name'];


                    $datavalue['towing_storage_image'] = trim(base_url() . 'uploads/towingimage/' . $towing_storage_image);
                } else {
                    $result = array(
                        'success' => false,
                        'code' => 400,
                        'msg' => strip_tags($this->upload->display_errors()),
                        'data' => array()
                    );
                    echo json_encode($result);
                    exit();
                }
            }

            //$returnStatus = $this->Muser->add_signimage($datavalue);

            /*
                      if ($returnStatus) {
                          $result = array(
                              'success' => true,
                              'msg' => $this->lang->line('image_uploaded'),
                              'code' => 200,
                              'data' => $returnStatus
                          );
                      } else {
                          $result = array(
                              'success' => false,
                              'msg' => $this->lang->line('oops_something_went_wrong'),
                              'code' => 400,
                              'data' => array()
                          );
                      }
                      
                      */
        }

        /*else{
                    $result = array(
                        'success' => false,
                        'msg' => $this->lang->line('no_image_found'),
                        'code' => 400,
                        'data' => array()
                    );
                } */
        // upload image ends

        // print_r($datavalue);die;

        $returnStatus = $this->Muser->save_rate_taxs($datavalue);
        $res = json_encode($returnStatus);
        if ($returnStatus) {
            $result = array(
                'success' => true,
                'msg' => $this->lang->line('data_saved'),
                'code' => 200,
                'res' => $res
            );
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('oops_something_went_wrong'),
                'code' => 400
            );
        }

        echo json_encode($result);
    }


    public function get_rate_taxs_05july_stopped()
    {
        $fields = array(
            'user_id'
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['data']   = (object)array();
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);
        $taxDetails = $this->Muser->get_rate_taxs($this->jsonvalue);
        if ($taxDetails) {
            unset($taxDetails['id'], $taxDetails['added_on'], $taxDetails['added_on_gmt'], $taxDetails['status']);
            $result = array(
                'success' => true,
                'msg' => $this->lang->line('data_found'),
                'code' => 200,
                'data' => $taxDetails,
            );
        } else {
            $datavalue  = array(
                "user_id" => $this->jsonvalue['user_id'],
                "body_labor" => '0',
                "refinish_labor" => '0',
                "machanical_labor" => '0',
                "frame_labor" => '0',
                "structural_labor" => '0',
                "glass_labor" => '0',
                "paint_meterials" => '0',
                "sales_tax_percent" => '0',
                "appraisal_service" => '0',
                "appraisal_service_loss" => '0',
                "reinspection_service" => '0',
                "reinspection_service_loss" => '0',
                "speciality_vehicle_damage" => '0',
                "add_tax_to_paint" => '0',
                "add_tax_to_appraisal" => '0',
            );
            $result = array(
                'success' => true,
                'msg' => $this->lang->line('data_found'),
                'code' => 200,
                'data' => $datavalue,
            );
        }
        echo json_encode($result);
    }

    //  new rate api

    public function get_rate_taxs()
    {
        $fields = array(
            'user_id'
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['data']   = (object)array();
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);
       

        $taxDetails = $this->Muser->get_rate_taxs($this->jsonvalue);
         $currency_convert = $this->currency_convert();
        if ($taxDetails) {
            unset($taxDetails['id'], $taxDetails['added_on'], $taxDetails['added_on_gmt'], $taxDetails['status']);
            
            $taxDetails['body_labor'] = number_format((float)$taxDetails['body_labor'] * $currency_convert, 2, '.', '');

            $taxDetails['userdefined1'] = number_format((float)$taxDetails['userdefined1'] * $currency_convert, 2, '.', '');

            $taxDetails['userdefined2'] = number_format((float)$taxDetails['userdefined2'] * $currency_convert, 2, '.', '');

            $taxDetails['userdefined3'] = number_format((float)$taxDetails['userdefined3'] * $currency_convert, 2, '.', '');


            $taxDetails['refinish_labor'] = number_format((float)$taxDetails['refinish_labor'] * $currency_convert, 2, '.', '');
            $taxDetails['machanical_labor'] = number_format((float)$taxDetails['machanical_labor'] * $currency_convert, 2, '.', '');

            $taxDetails['frame_labor'] = number_format((float)$taxDetails['frame_labor'] * $currency_convert, 2, '.', '');

            $taxDetails['structural_labor'] = number_format((float)$taxDetails['structural_labor'] * $currency_convert, 2, '.', '');

            $taxDetails['glass_labor'] = number_format((float)$taxDetails['glass_labor'] * $currency_convert, 2, '.', '');

            $taxDetails['paint_meterials'] = number_format((float)$taxDetails['paint_meterials'] * $currency_convert, 2, '.', '');

            $taxDetails['days_to_repair_value'] = number_format((float)$taxDetails['days_to_repair_value'] , 2, '.', '');
            $taxDetails['appraisal_service'] = number_format((float)$taxDetails['appraisal_service'] * $currency_convert, 2, '.', '');
            $taxDetails['towing_storage_fee'] = number_format((float)$taxDetails['towing_storage_fee'] * $currency_convert, 2, '.', '');
            $taxDetails['tear_down_fee'] = number_format((float)$taxDetails['tear_down_fee'] * $currency_convert, 2, '.', '');
            $taxDetails['diagnostic_service_fee'] = number_format((float)$taxDetails['diagnostic_service_fee'] * $currency_convert, 2, '.', '');
            $taxDetails['appraisal_service_loss'] = number_format((float)$taxDetails['appraisal_service_loss'] * $currency_convert, 2, '.', '');
            $taxDetails['reinspection_service'] = number_format((float)$taxDetails['reinspection_service'] * $currency_convert, 2, '.', '');
            $taxDetails['reinspection_service_loss'] = number_format((float)$taxDetails['reinspection_service_loss'] * $currency_convert, 2, '.', '');
            $taxDetails['speciality_vehicle_damage'] = number_format((float)$taxDetails['speciality_vehicle_damage'] * $currency_convert, 2, '.', '');
            $taxDetails['sales_tax_percent'] = number_format((float)$taxDetails['sales_tax_percent'], 2, '.', '');


            $taxDetails['diagnostic_service_fee'] = number_format((float)$taxDetails['diagnostic_service_fee'] * $currency_convert, 2, '.', '');
            $taxDetails['add_tax_to_appraisal'] = number_format((float)$taxDetails['add_tax_to_appraisal'] * $currency_convert, 2, '.', '');
            $taxDetails['user_define_value_1'] = number_format((float)$taxDetails['user_define_value_1'] * $currency_convert, 2, '.', '');

            $taxDetails['user_define_value_2'] = number_format((float)$taxDetails['user_define_value_2'] * $currency_convert, 2, '.', '');


           

            
            $result = array(
                'success' => true,
                'msg' => $this->lang->line('data_found'),
                'code' => 200,
                'data' => $taxDetails,
            );
        } else {
            $datavalue  = array(
                "user_id" => $this->jsonvalue['user_id'],
                "body_labor" => '0',
                "refinish_labor" => '0',
                "machanical_labor" => '0',
                "frame_labor" => '0',
                "structural_labor" => '0',
                "glass_labor" => '0',
                "paint_meterials" => '0',
                "sales_tax_percent" => '0',
                "appraisal_service" => '0',
                "appraisal_service_loss" => '0',
                "reinspection_service" => '0',
                "reinspection_service_loss" => '0',
                "speciality_vehicle_damage" => '0',
                "add_tax_to_paint" => '0',
                "add_tax_to_appraisal" => '0',
                "userdefined1" => '0',
                "userdefined1_head" => null,
                "userdefined2" => '0',
                "userdefined2_head" => null,
                "userdefined3" => '0',
                "userdefined3_head" => null,
                "user_define_value_1" => "0",
                "user_define_value_1_head" => null,
                "user_define_value_2" => "0",
                "user_define_value_2_head" => null,
            );
            $result = array(
                'success' => true,
                'msg' => $this->lang->line('data_found'),
                'code' => 200,
                'data' => $datavalue,
            );
        }
        echo json_encode($result);
    }


    public function add_vehicle_info()
    {
        $fields = array(
            'user_id',
            'estimate_id',
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);
        $datavalue  = array(
            "estimate_id" => $this->jsonvalue['estimate_id'],
            "vin_number" => $this->jsonvalue['vin_number'],
            "mileage" => $this->jsonvalue['mileage'],
            "vehicle_state" => $this->jsonvalue['vehicle_state'],
            "license_plate" => $this->jsonvalue['license_plate'],
            "production_plate" => $this->jsonvalue['production_plate'],
            "vehicle_color" => $this->jsonvalue['vehicle_color'],
            "point_of_impact" => $this->jsonvalue['point_of_impact'],
            "year" => trim($this->jsonvalue['year']),
            "make" => trim($this->jsonvalue['make']),
            "model" => trim($this->jsonvalue['model']),
        );
        if ($this->Muser->isExistEstimate($this->jsonvalue['estimate_id'], $this->jsonvalue['user_id'])) {
            $vehicleVinData = $this->getVehicleData($this->jsonvalue['vin_number']);
            if (isset($vehicleVinData['decode']['status']) && $vehicleVinData['decode']['status'] == 'SUCCESS') {
                $handlerArray = array();
                /*                  ($vehicleVinData['years'][0]->year)?array_push($handlerArray,$vehicleVinData['years'][0]->year):'';
                    ($vehicleVinData['make']->name)?array_push($handlerArray,$vehicleVinData['make']->name):'';
                    ($vehicleVinData['model']->name)?array_push($handlerArray,$vehicleVinData['model']->name):'';
                    $datavalue['year'] = $vehicleVinData['years'][0]->year;
                    $datavalue['make'] = $vehicleVinData['make']->name;
                    $datavalue['model'] = $vehicleVinData['model']->name;*/
                ($vehicleVinData['decode']['vehicle'][0]['year']) ? array_push($handlerArray, $vehicleVinData['decode']['vehicle'][0]['year']) : '';
                ($vehicleVinData['decode']['vehicle'][0]['make']) ? array_push($handlerArray, $vehicleVinData['decode']['vehicle'][0]['make']) : '';
                ($vehicleVinData['decode']['vehicle'][0]['model']) ? array_push($handlerArray, $vehicleVinData['decode']['vehicle'][0]['model']) : '';
                $datavalue['year'] = $vehicleVinData['decode']['vehicle'][0]['year'];
                $datavalue['make'] = $vehicleVinData['decode']['vehicle'][0]['make'];
                $datavalue['model'] = $vehicleVinData['decode']['vehicle'][0]['model'];
                $datavalue['vehicle_identity_name'] = implode(' ', $handlerArray);
                $datavalue['vin_row_data'] = serialize($vehicleVinData);
            } else {
                $datavalue['vehicle_identity_name'] = trim($this->jsonvalue['year']) . ' ' . trim($this->jsonvalue['make']) . ' ' . trim($this->jsonvalue['model']);
            }
            if (isset($datavalue['vehicle_identity_name']) && trim($datavalue['vehicle_identity_name']) != '') {
                $returnStatus = $this->Muser->add_vehicle_info($datavalue);
                if ($returnStatus) {
                    $result = array(
                        'success' => true,
                        'msg' => $this->lang->line('data_saved'),
                        'code' => 200
                    );
                } else {
                    $result = array(
                        'success' => false,
                        'msg' => $this->lang->line('oops_something_went_wrong'),
                        'code' => 400
                    );
                }
            } else {
                $result = array(
                    'success' => false,
                    'msg' => $this->lang->line('no_year_make_model_found'),
                    'code' => 400
                );
            }
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('no_premission'),
                'code' => 400
            );
        }
        echo json_encode($result);
    }

    /********************** Get Vip Number Data *************************/

    public function getVehicleData($vinNumber)
    {
        if ($vinNumber != '') {
            //$url = "https://api.edmunds.com/api/vehicle/v2/vins/".$vinNumber."?fmt=json&api_key=".VIN_API_KEY;
            $url = "https://www.decodethis.com/webservices/decodes/" . $vinNumber . "/bgCy87HV9YJPjvENbG6_/0.jsonp";
            //$json = file_get_contents($url);
            //$obj =  (array)json_decode($json);
            ///////////////////////////////////
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPGET, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Accept: application/json'
            ));
            $result = curl_exec($ch);
            curl_close($ch);
            $obj = json_decode($result, true);
            ///////////////////////////////////      
            if (isset($obj) && !empty($obj)) {
                return $obj;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /************************ Terms Conditions  **********************/

    public function get_help_faq()
    {
        $this->currentLang($this->jsonvalue['user_id']);

        $helpFAQ = $this->Muser->get_help_faq();
        
        $faq_data = [];
        foreach($helpFAQ as $faq)
        {
          $faq['question'] = $this->lang_translate($faq['question'], $this->jsonvalue['user_id']);
          $faq['answer'] = $this->lang_translate($faq['answer'], $this->jsonvalue['user_id']);
          $faq_data[] = $faq;
        }


        if (isset($helpFAQ) && !empty($helpFAQ)) {
            $result           = array(
                'success' => true,
                'msg' => $this->lang->line('help_faq'),
                'code' => 200,
                'data' => $faq_data
            );
        } else {
            $result           = array(
                'success' => false,
                'msg' => $this->lang->line('no_help_faq'),
                'code' => 400,
                'data' => array()
            );
        }

        echo json_encode($result);
    }


    public function get_photos()
    {
        $fields = array(
            'user_id',
            'estimate_id',
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['data']   = array();
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);
        if ($this->Muser->isExistEstimate($this->jsonvalue['estimate_id'], $this->jsonvalue['user_id'])) {
            $returnStatus = $this->Muser->get_photos($this->jsonvalue['estimate_id']);
            if ($returnStatus) {
                $result = array(
                    'success' => true,
                    'msg' => $this->lang->line('data_found'),
                    'code' => 200,
                    'data' => $returnStatus
                );
            } else {
                $result = array(
                    'success' => false,
                    'msg' => $this->lang->line('no_data_found'),
                    'code' => 400,
                    'data' => array()
                );
            }
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('no_premission'),
                'code' => 400,
                'data' => array()
            );
        }
        echo json_encode($result);
    }


    public function upload_photos()
    {


        $fields = array(
            'user_id',
            'estimate_id',
        );

        /*$errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['data']   = array();
            echo json_encode($response);
            exit();
        }  */



        if (isset($_FILES['upload_photos']) && !empty($_FILES['upload_photos'])) {
            $json_file = $_POST['data'];
        } else {

            $json_file = file_get_contents('php://input');
        }



        // $json_file = $_POST['data'];


        $jsonvalue = json_decode($json_file, true);


        /*
        print_r($_FILES);

print_r( $jsonvalue['user_id']);

        die; 

*/
        $numrow = $this->Muser->isExistEstimate($jsonvalue['estimate_id'], $jsonvalue['user_id']);
        $this->currentLang($this->jsonvalue['user_id']);


        //$numrow=1;

        if ($numrow >= 1) {
            ##############################################
            if (isset($_FILES['upload_photos']) && !empty($_FILES['upload_photos'])) {
                @set_time_limit(-1);
                // $path   = './uploads/EST_'.$this->jsonvalue['estimate_id'];
                $path   = './uploads/EST_' . $jsonvalue['estimate_id'];
                if (!is_dir($path)) { //create the folder if it's not already exists
                    mkdir($path, 0777, TRUE);
                }
                $profile_upload_path = getcwd() . '/uploads/EST_' . $jsonvalue['estimate_id'];


                $files               = $_FILES['upload_photos'];

                // print_r($_FILES['upload_photos']['tmp_name']);die;
                $countImage          = count($_FILES['upload_photos']['tmp_name']);
                for ($i = 0; $i < $countImage; $i++) {
                    if ($_FILES['upload_photos']['name'] != '') {


                        $config['upload_path']               = $profile_upload_path;
                        $config['allowed_types']             = 'gif|jpg|png|jpeg|webp';
                        $config['encrypt_name']              = TRUE;
                        $_FILES['uploadedimage']['name']     = $files['name'][$i];
                        $_FILES['uploadedimage']['type']     = $files['type'][$i];
                        $_FILES['uploadedimage']['tmp_name'] = $files['tmp_name'][$i];
                        $_FILES['uploadedimage']['error']    = $files['error'][$i];
                        $_FILES['uploadedimage']['size']     = $files['size'][$i];
                        $this->load->library('upload', $config);

                        // print_r(  $_FILES['uploadedimage']);die;
                        if ($this->upload->do_upload('uploadedimage')) {
                            $img_data[$i]                = $this->upload->data();
                            $saveDataValue[$i]['photo'] = $img_data[$i]['file_name'];
                            $saveDataValue[$i]['estimate_id'] = $jsonvalue['estimate_id'];
                        } else {
                            $result = array(
                                'success' => false,
                                'code' => 400,
                                'msg' => strip_tags($this->upload->display_errors()),
                                'data' => array()
                            );
                            echo json_encode($result);
                            exit();
                        }
                    }
                }



                $returnStatus = $this->Muser->add_photos($saveDataValue, $jsonvalue['estimate_id']);
                if ($returnStatus) {
                    $result = array(
                        'success' => true,
                        'msg' => $this->lang->line('photo_uploaded'),
                        'code' => 200,
                        'data' => $returnStatus
                    );
                } else {
                    $result = array(
                        'success' => false,
                        'msg' => $this->lang->line('oops_something_went_wrong'),
                        'code' => 400,
                        'data' => array()
                    );
                }
            } else {
                $result = array(
                    'success' => false,
                    'msg' => $this->lang->line('no_photo_found'),
                    'code' => 400,
                    'data' => array()
                );
            }
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('no_premission'),
                'code' => 400,
                'data' => array()
            );
        }
        echo json_encode($result);
    }

    public function upload_signimage()
    {
        $fields = array(
            'user_id',
            'estimate_id',
        );

        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['data']   = array();
            echo json_encode($response);
            exit();
        }


        if ($this->Muser->isExistEstimatesign($this->jsonvalue['estimate_id'], $this->jsonvalue['user_id'])) {
            ##############################################
            if (isset($_FILES['upload_photos']) && !empty($_FILES['upload_photos'])) {
                @set_time_limit(-1);
                $path   = './uploads/EST_SIGN' . $this->jsonvalue['estimate_id'];
                if (!is_dir($path)) { //create the folder if it's not already exists
                    mkdir($path, 0777, TRUE);
                }
                $profile_upload_path = getcwd() . '/uploads/EST_SIGN' . $this->jsonvalue['estimate_id'];
                $files               = $_FILES['upload_photos'];


                if ($_FILES['upload_photos']['name'] != '') {
                    $config['upload_path']               = $profile_upload_path;
                    $config['allowed_types']             = 'gif|jpg|png|jpeg|webp';
                    $config['encrypt_name']              = TRUE;
                    $_FILES['uploadedimage']['name']     = $files['name'];
                    $_FILES['uploadedimage']['type']     = $files['type'];
                    $_FILES['uploadedimage']['tmp_name'] = $files['tmp_name'];
                    $_FILES['uploadedimage']['error']    = $files['error'];
                    $_FILES['uploadedimage']['size']     = $files['size'];
                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('uploadedimage')) {
                        $img_data                = $this->upload->data();
                        $saveDataValue['photo'] = $img_data['file_name'];
                        $saveDataValue['estimate_id'] = $this->jsonvalue['estimate_id'];
                        $saveDataValue['user_id'] = $this->jsonvalue['user_id'];
                        $saveDataValue['upload_date'] = date('Y-m-d');
                    } else {
                        $result = array(
                            'success' => false,
                            'code' => 400,
                            'msg' => strip_tags($this->upload->display_errors()),
                            'data' => array()
                        );
                        echo json_encode($result);
                        exit();
                    }
                }

                $returnStatus = $this->Muser->add_signimage($saveDataValue);
                if ($returnStatus) {
                    $result = array(
                        'success' => true,
                        'msg' => $this->lang->line('image_uploaded'),
                        'code' => 200,
                        'data' => $returnStatus
                    );
                } else {
                    $result = array(
                        'success' => false,
                        'msg' => $this->lang->line('oops_something_went_wrong'),
                        'code' => 400,
                        'data' => array()
                    );
                }
            } else {
                $result = array(
                    'success' => false,
                    'msg' => $this->lang->line('no_photo_found'),
                    'code' => 400,
                    'data' => array()
                );
            }
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('no_premission'),
                'code' => 400,
                'data' => array()
            );
        }
        echo json_encode($result);
    }

    public function remove_photos()
    {
        $fields = array(
            'user_id',
            'estimate_id',
            'remove_photos'
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['data']   = array();
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);
        $returnStatus = $this->Muser->remove_photos($this->jsonvalue);
        $result = array(
            'success' => true,
            'msg' => $this->lang->line('photo_removed'),
            'code' => 200,
            'data' => $returnStatus
        );

        echo json_encode($result);
    }

    public function current_estimates()
    {
        $fields = array(
            'user_id',
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['data']   = array();
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);
        /*
        * Under Working Process 
        * Change When Work Done
        */
        //$currentEstimates = $this->Muser->get_current_estimates($this->jsonvalue);
        $currentEstimates = false;
        if ($currentEstimates) {
            $dummyArray[] = array('estimate_id' => '1', 'estimate_title' => '2015 Ford F-150', 'total_cost' => '2458', 'is_lock' => '1');
            $dummyArray[] = array('estimate_id' => '2', 'estimate_title' => '2015 Ford F-150', 'total_cost' => '2458', 'is_lock' => '1');
            $result = array(
                'success' => true,
                'msg' => $this->lang->line('data_found'),
                'code' => 200,
                'data' => $dummyArray
            );
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('no_current_estimates'),
                'code' => 400,
                'data' => array()
            );
        }
        echo json_encode($result);
    }

    public function save_vehicle_option()
    {
        $fields = array(
            'user_id',
            'estimate_id',
            'data'
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            echo json_encode($response);
            exit();
        }
        $insertBatch = array();
        foreach ($this->jsonvalue['data'] as $k => $val) {
            $partData = $this->db->get_where('ca_vehicle_parts', array('part_id' => $val))->row_array();
            $hData['estimate_id'] = $this->jsonvalue['estimate_id'];
            $hData['cat_id'] = $partData['cat_id'];
            $hData['part_id'] = $val;
            $insertBatch[] = $hData;
        }
        if ($this->Muser->isExistEstimate($this->jsonvalue['estimate_id'], $this->jsonvalue['user_id'])) {
            $returnStatus = $this->Muser->save_vehicle_option($insertBatch);
            if ($returnStatus) {
                $result = array(
                    'success' => true,
                    'msg' => $this->lang->line('data_saved'),
                    'code' => 200
                );
            } else {
                $result = array(
                    'success' => false,
                    'msg' => $this->lang->line('oops_something_went_wrong'),
                    'code' => 400
                );
            }
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('no_premission'),
                'code' => 400
            );
        }
        echo json_encode($result);
    }


    public function get_vehicle_option()
    {
        $fields = array(
            'user_id',
            'estimate_id',
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['vehicle_name']   = '';
            $response['data']   = array();
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);
        $vehicleOption = $this->Muser->get_vehicle_option($this->jsonvalue);
        if (isset($vehicleOption) && !empty($vehicleOption)) {
            $vehicleName = $this->Muser->getVehcileName($this->jsonvalue);
            $result         = array(
                'success' => true,
                'msg' => $this->lang->line('data_found'),
                'code' => 200,
                'vehicle_name' => ($vehicleName['vehicle_identity_name'] != NULL) ? $vehicleName['vehicle_identity_name'] : '',
                'data' => $vehicleOption
            );
        } else {
            $result         = array(
                'success' => false,
                'msg' => $this->lang->line('no_data_found'),
                'code' => 400,
                'vehicle_name' => '',
                'data' => array()
            );
        }

        echo json_encode($result);
    }

    /////////////////////////// Preliminary Estimate (Screen) //////////////////////////

    public function get_vehicle_parts()
    {
        $fields = array(
            'user_id',
            'estimate_id'
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['vehicle_name']   = '';
            $response['is_supplement']   = '0';
            $response['estimate_cost']   = '0.0';
            $response['data']   = array();
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);
        $currency_convert = $this->currency_convert();
        $vehicleParts = $this->Muser->get_vehicle_parts($this->jsonvalue);
        $estimateCost = $this->Muser->calculating_estimate_cost($this->jsonvalue);
        $returnStatus = $this->Muser->get_estimate_status($this->jsonvalue);


        $vehiclePartsLang  = $vehicleParts;

       
       $part = [];
        foreach($vehiclePartsLang as $key=>$vparts)
        {
            $part[] = $this->lang->line($vparts);
        }

        // print_r($part);
        // die;

        if (isset($vehicleParts) && !empty($vehicleParts)) {
            $vehicleName = $this->Muser->getVehcileName($this->jsonvalue);
            $result         = array(
                'success' => true,
                'msg' => $this->lang->line('data_found'),
                'code' => 200,
                'vehicle_name' => $vehicleName['vehicle_identity_name'],
                'estimate_cost' => number_format((float)$estimateCost*$currency_convert, 2, '.', ''),
                'is_supplement' => $returnStatus['is_supplement'],
                'data' => $vehicleParts,
                'data_lang' => $part
            );
        } else {
            $result         = array(
                'success' => false,
                'msg' => $this->lang->line('no_data_found'),
                'code' => 400,
                'vehicle_name' => '',
                'estimate_cost' => number_format((float)$estimateCost*$currency_convert, 2, '.', ''),
                'is_supplement' => $returnStatus['is_supplement'],
                'data' => array(),
                'data_lang' => array()
            );
        }
        echo json_encode($result);
    }

    public function get_part_details()
    {
        $fields = array(
            'user_id',
            'estimate_id',
            'part_name'
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['vehicle_name']   = '';
            $response['data']   = array();
            echo json_encode($response);
            exit();
        }
        $vehiclePartsDet = $this->Muser->get_part_details($this->jsonvalue);

        // print_r($vehiclePartsDet);
        // echo json_encode($vehiclePartsDet);

        $getnew_data = [];
        foreach ($vehiclePartsDet as $newdata) {
                if($newdata['part_name'] != null)
                {
                $newdata['part_name'] = $this->lang_translate($newdata['part_name'], $this->jsonvalue['user_id']);
                $getnew_data[] = $newdata;
             }
            
            }

            

        if (isset($vehiclePartsDet) && !empty($vehiclePartsDet)) {
            $vehicleName = $this->Muser->getVehcileName($this->jsonvalue);
            $result         = array(
                'success' => true,
                'msg' => $this->lang->line('data_found'),
                'code' => 200,
                'vehicle_name' => $vehicleName['vehicle_identity_name'],
                'data' => $getnew_data,
                'data_en' => $getnew_data
            );
        } else {
            $result         = array(
                'success' => false,
                'msg' => $this->lang->line('no_data_found'),
                'code' => 400,
                'vehicle_name' => '',
                'data' => array()
            );
        }
        echo json_encode($result);
    }

    public function get_estimate_owner()
    {
        $fields = array(
            'user_id',
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['data']   = (object)array();
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);
        $estData = $this->Muser->get_estimate_owner($this->jsonvalue);

        // update
        if (isset($this->jsonvalue['rating']) && $this->jsonvalue['rating'] != '') {
            $updata['rating'] = $this->jsonvalue['rating'];
            $this->Muser->update_all($this->jsonvalue['user_id'], $updata);
        }
        if (isset($this->jsonvalue['currentdate']) && $this->jsonvalue['currentdate'] != '') {
            $updata1['currentdate'] = $this->jsonvalue['currentdate'];
            $this->Muser->update_all($this->jsonvalue['user_id'], $updata1);
        }

        $alldata =   $this->Muser->get_alldata($this->jsonvalue['user_id']);



        $estData['currentdate'] =  $alldata[0]['currentdate'];
        $estData['rating'] =  $alldata[0]['rating'];
        $estData['intervall'] =  $alldata[0]['intervall'];


        /* $updatecountData = $this->Muser->update_count($this->jsonvalue); */

        //   $useriddata = $this->Muser->get_userid($this->jsonvalue);

        //--$fullData['user_id']=$useriddata[0]['user_id'];



        $countdata =     $this->Muser->get_countdata($this->jsonvalue['user_id']);



        $count = $countdata[0]['login_count'];



        $estData['logincount'] = $count;

        $alldata =   $this->Muser->get_alldata($this->jsonvalue['user_id']);

        $estData['currentdate'] =  $alldata[0]['currentdate'];
        $estData['rating'] =  $alldata[0]['rating'];

        if (isset($estData) && !empty($estData)) {
            $result         = array(
                'success' => true,
                'msg' => $this->lang->line('data_found'),
                'code' => 200,
                'data' => $estData
            );
        } else {
            $result         = array(
                'success' => true,
                'msg' => $this->lang->line('no_data_found'),
                'code' => 200,
                'data' => (object)array()
            );
        }
        echo json_encode($result);
    }

    public function set_rating_data()
    {
        $fields = array(
            'user_id',
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['data']   = (object)array();
            echo json_encode($response);
            exit();
        }
        //  $estData = $this->Muser->get_estimate_owner($this->jsonvalue);
        $this->currentLang($this->jsonvalue['user_id']);
        // update
        if (isset($this->jsonvalue['rating']) && $this->jsonvalue['rating'] != '') {
            $updata['rating'] = $this->jsonvalue['rating'];
            $this->Muser->update_all($this->jsonvalue['user_id'], $updata);
        }
        if (isset($this->jsonvalue['currentdate']) && $this->jsonvalue['currentdate'] != '') {
            $updata1['currentdate'] = $this->jsonvalue['currentdate'];
            $this->Muser->update_all($this->jsonvalue['user_id'], $updata1);
        }


        if (isset($this->jsonvalue['intervall']) && $this->jsonvalue['intervall'] != '') {
            $updata2['intervall'] = $this->jsonvalue['intervall'];
            $this->Muser->update_all($this->jsonvalue['user_id'], $updata2);
        }


        /* $updatecountData = $this->Muser->update_count($this->jsonvalue); */

        //   $useriddata = $this->Muser->get_userid($this->jsonvalue);

        //--$fullData['user_id']=$useriddata[0]['user_id'];



        $countdata =     $this->Muser->get_countdata($this->jsonvalue['user_id']);



        $count = $countdata[0]['login_count'];



        $estData['logincount'] = $count;

        $alldata =   $this->Muser->get_alldata($this->jsonvalue['user_id']);



        $estData['currentdate'] =  $alldata[0]['currentdate'];
        $estData['rating'] =  $alldata[0]['rating'];
        $estData['intervall'] =  $alldata[0]['intervall'];
        //

        if (isset($estData) && !empty($estData)) {
            $result         = array(
                'success' => true,
                'msg' => $this->lang->line('data_found'),
                'code' => 200,
                'data' => $estData
            );
        } else {
            $result         = array(
                'success' => true,
                'msg' => $this->lang->line('no_data_found'),
                'code' => 200,
                'data' => (object)array()
            );
        }
        echo json_encode($result);
    }


    public function get_estimate_insurance()
    {
        $fields = array(
            'user_id',
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['data']   = (object)array();
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);
        $estData = $this->Muser->get_estimate_insurance($this->jsonvalue);

        // $loginData =  $this->Muser->get_countdata($this->jsonvalue['user_id']) ; 
        // $estData['login_count'] = $loginData[0]['login_count'] ?? "0";
        // $estData['rating'] = $loginData[0]['rating'] ?? "0";
        // $estData['currentdate'] = $loginData[0]['currentdate'] ?? "0";
        // $estData['intervall'] = $loginData[0]['intervall'] ?? "0";

        $countdata =     $this->Muser->get_countdata($this->jsonvalue['user_id']);
        $count = $countdata[0]['login_count'];
        ///$estData['logincount'] = $count;

        $alldata =   $this->Muser->get_alldata($this->jsonvalue['user_id']);
        $estData['currentdate'] =  $alldata[0]['currentdate'];
        $estData['rating'] =  $alldata[0]['rating'];
        $estData['intervall'] =  $alldata[0]['intervall'];
        $estData['login_count'] = $count;

        if (isset($estData) && !empty($estData)) {
            $result         = array(
                'success' => true,
                'msg' => $this->lang->line('data_found'),
                'code' => 200,
                'data' => $estData
            );
        } else {
            $result         = array(
                'success' => true,
                'msg' => $this->lang->line('no_data_found'),
                'code' => 200,
                'data' => (object)array()
            );
        }
        echo json_encode($result);
    }

    public function get_estimate_inspect()
    {
        $fields = array(
            'user_id',
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['data']   = (object)array();
            echo json_encode($response);
            exit();
        }
        $estData = $this->Muser->get_estimate_inspect($this->jsonvalue);
        if (isset($estData) && !empty($estData)) {
            $result         = array(
                'success' => true,
                'msg' => $this->lang->line('data_found'),
                'code' => 200,
                'data' => $estData
            );
        } else {
            $result         = array(
                'success' => true,
                'msg' => $this->lang->line('no_data_found'),
                'code' => 200,
                'data' => (object)array()
            );
        }
        echo json_encode($result);
    }

    //////////////////////// Add Default Parts For Estimation///////////////////////

    public function add_default_parts()
    {
        $fields = array(
            'user_id',
            'estimate_id',
            'tab_name'
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);
        if ($this->Muser->isExistEstimate($this->jsonvalue['estimate_id'], $this->jsonvalue['user_id'])) {
            if (isset($this->jsonvalue['part_ids']) && !empty($this->jsonvalue['part_ids'])) {
                $insertBatch = array();
                foreach ($this->jsonvalue['part_ids'] as $k => $val) {
                    $partDetails = $this->Muser->get_default_parts($val, $this->jsonvalue['estimate_id']);
                    if (isset($partDetails) && !empty($partDetails)) {
                        if ($partDetails['labor'] == '') {
                            $partDetails['labor'] = NULL;
                        }
                        ///////////////////////////////////////////
                        $pos = strpos(strtoupper($partDetails['labor']), 'M');
                        $pos1 = strpos(strtoupper($partDetails['labor']), 'F');
                        $pos2 = strpos(strtoupper($partDetails['labor']), 'S');
                        $pos3 = strpos(strtoupper($partDetails['labor']), 'G');
                        $pos4 = strpos(strtoupper($partDetails['labor']), 'A');
                        $pos5 = strpos(strtoupper($partDetails['labor']), 'B');
                        $pos6 = strpos(strtoupper($partDetails['labor']), 'C');
                        if ($pos) {
                            $partDetails['mech'] = $partDetails['labor'];
                            $partDetails['labor'] = NULL;
                        } else if ($pos1) {
                            $partDetails['frame'] = $partDetails['labor'];
                            $partDetails['labor'] = NULL;
                        } else if ($pos2) {
                            $partDetails['structual'] = $partDetails['labor'];
                            $partDetails['labor'] = NULL;
                        } else if ($pos4) {
                            $partDetails['user_1'] = $partDetails['labor'];
                            $partDetails['labor'] = NULL;
                        } else if ($pos5) {
                            $partDetails['user_2'] = $partDetails['labor'];
                            $partDetails['labor'] = NULL;
                        } else if ($pos6) {
                            $partDetails['user_3'] = $partDetails['labor'];
                            $partDetails['labor'] = NULL;
                        } else if ($pos3) {
                            $partDetails['glass'] = $partDetails['labor'];
                            $partDetails['labor'] = NULL;
                        }
                        /////////////////////////////////////////////////
                        $insertBatch[$k] = $partDetails;
                        $insertBatch[$k]['estimate_id'] = $this->jsonvalue['estimate_id'];
                        $insertBatch[$k]['add_from'] = 1; // 1 For Default stored part data
                        $insertBatch[$k]['qty'] = 1;
                        $insertBatch[$k]['part_id'] = $val;
                        if ($partDetails['oper'] == 'Refn' || $partDetails['oper'] == 'Ref' || $partDetails['oper'] == 'Blnd' ||  $partDetails['oper'] == 'Subl') {
                            $insertBatch[$k]['incl_with'] = '';
                            $insertBatch[$k]['overlap_deduction'] = '';
                        }



                        $addeddata =  $this->Muser->getDatabyCondition("ca_estimate_select_parts", array("user_part_id" => $val,  "estimate_id" => $this->jsonvalue['estimate_id']));

                        if (empty($addeddata)) {
                            $this->Muser->insert_calisteddata("ca_estimate_select_parts_added", $insertBatch[$k]);
                        }



                        $adata =  $this->Muser->getDatabyCondition("ca_estimate_select_parts_all", array("user_part_id" => $val, "estimate_id" => $this->jsonvalue['estimate_id']));


                        if (empty($adata)) {
                            $this->Muser->insert_calisteddata("ca_estimate_select_parts_all", $insertBatch[$k]);
                        } else {
                            $where = array("user_part_id" => $val, "estimate_id" => $this->jsonvalue['estimate_id']);
                            $this->Muser->insertanddeletepartsdata($where, $insertBatch[$k], "ca_estimate_select_parts_all");
                        }


                        // 06 july for all data ends



                    }
                }

                // 11 july ends 

                $returnStatus = $this->Muser->save_estimate_parts($insertBatch, $this->jsonvalue['estimate_id'], 1);
            } else {
                $returnStatus = $this->Muser->remove_save_estimate_parts($this->jsonvalue['estimate_id'], 1, $this->jsonvalue['tab_name']); // add_from = 1 for default entiry
            }
            if ($returnStatus) {
                $result = array(
                    'success' => true,
                    'msg' => $this->lang->line('data_saved'),
                    'code' => 200
                );
            } else {
                $result = array(
                    'success' => false,
                    'msg' => $this->lang->line('oops_something_went_wrong'),
                    'code' => 400
                );
            }
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('no_premission'),
                'code' => 400
            );
        }
        echo json_encode($result);
    }

    ////////////////////////////////////////////////

    public function add_stored_parts()
    {
        $fields = array(
            'user_id',
            'estimate_id',
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);
        if ($this->Muser->isExistEstimate($this->jsonvalue['estimate_id'], $this->jsonvalue['user_id'])) {
            if (isset($this->jsonvalue['part_ids']) && !empty($this->jsonvalue['part_ids'])) {
                $insertBatch = array();
                foreach ($this->jsonvalue['part_ids'] as $k => $val) {
                    $partDetails = $this->Muser->get_stored_parts($val);
                    if (isset($partDetails[0]) && !empty($partDetails[0])) {
                        if ($partDetails[0]['labor'] == '') {
                            $partDetails[0]['labor'] = NULL;
                        }
                        $insertBatch[$k] = $partDetails[0];
                        $insertBatch[$k]['estimate_id'] = $this->jsonvalue['estimate_id'];
                        $insertBatch[$k]['add_from'] = 2; // 2 For User stored part data
                        $insertBatch[$k]['qty'] = 1; // 2 For User stored part data
                        $insertBatch[$k]['tab_name'] = 'ZZ'; // 2 For User stored part data
                        $insertBatch[$k]['user_part_id'] = $val; // 2 For User stored part data

                        //11 july

                        /*
                          $chngdata=  $this->Muser->getDatabyCondition("ca_estimate_select_parts_changed",array("user_part_id"=>$val,"estimate_id"=>$this->jsonvalue['estimate_id']));
                        if(empty($chngdata)){
                                          $this->Muser->insert_calisteddata("ca_estimate_select_parts_changed",$insertBatch[$k]);
                        }
                          */


                        // 06 july for all data 



                        $adata =  $this->Muser->getDatabyCondition("ca_estimate_select_parts_all", array("user_part_id" => $val, "estimate_id" => $this->jsonvalue['estimate_id']));


                        if (empty($adata)) {




                            $this->Muser->insert_calisteddata("ca_estimate_select_parts_all", $insertBatch[$k]);
                        } else {

                            $where = array("user_part_id" => $val, "estimate_id" => $this->jsonvalue['estimate_id']);
                            $this->Muser->insertanddeletepartsdata($where, $insertBatch[$k], "ca_estimate_select_parts_all");
                        }


                        // 06 july for all data ends


                    }
                }

                // 11 july ends 




                $returnStatus = $this->Muser->save_estimate_parts($insertBatch, $this->jsonvalue['estimate_id'], 2);
            } else {
                $returnStatus = $this->Muser->remove_save_estimate_parts($this->jsonvalue['estimate_id'], 2); // add_from = 2 for user stored entiry
            }
            if ($returnStatus) {
                $result = array(
                    'success' => true,
                    'msg' => $this->lang->line('data_saved'),
                    'code' => 200
                );
            } else {
                $result = array(
                    'success' => false,
                    'msg' => $this->lang->line('oops_something_went_wrong'),
                    'code' => 400
                );
            }
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('no_premission'),
                'code' => 400
            );
        }
        echo json_encode($result);
    }


    public function add_manual_parts()
    {
        $fields = array(
            'user_id',
            'estimate_id',
            'oper',
            'part_name',
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);
        $insertData['estimate_id'] = $this->jsonvalue['estimate_id'];
        $insertData['oper'] = $this->jsonvalue['oper'];
        $insertData['part_name'] = $this->jsonvalue['part_name'];
        $insertData['list_price'] = $this->jsonvalue['list_price'];
        $insertData['repairhour'] = $this->jsonvalue['repairhour'];
        $insertData['refinishhour'] = $this->jsonvalue['refinishhour'];

        ///////////////////// 4 NOV CHANGE ///////////////////////
        if ($this->jsonvalue['oper'] == 'Repl' && $this->jsonvalue['markup'] == 1 && $this->jsonvalue['list_price'] != '') {
            $get25Markup = ($this->jsonvalue['list_price'] * 25) / 100;
            $insertData['list_price'] = $this->jsonvalue['list_price'] + @round($get25Markup, 1);
        }
        //////////////////////////////////////////////////////////
        if ($this->jsonvalue['oper'] == 'Refn' || $this->jsonvalue['oper'] == 'Ref' || $this->jsonvalue['oper'] == 'Blnd') {
            if ($this->jsonvalue['oper'] == 'Refn') {
                $insertData['oper'] = 'Ref';
            }
            if ($this->jsonvalue['labor'] == '') {
                $this->jsonvalue['labor'] = NULL;
            }
            $insertData['labor'] = '';
            $insertData['mech'] = '';
            $insertData['frame'] = '';
            $insertData['structual'] = '';
            $insertData['glass'] = '';
            $insertData['user_1'] = '';
            $insertData['user_2'] = '';
            $insertData['user_3'] = '';
            $insertData['paint'] = $this->jsonvalue['labor'];
        } else {
            $pos = strpos(strtoupper($this->jsonvalue['labor']), 'M');
            $pos1 = strpos(strtoupper($this->jsonvalue['labor']), 'F');
            $pos2 = strpos(strtoupper($this->jsonvalue['labor']), 'S');
            $pos3 = strpos(strtoupper($this->jsonvalue['labor']), 'G');
            $pos4 = strpos(strtoupper($this->jsonvalue['labor']), 'A');
            $pos5 = strpos(strtoupper($this->jsonvalue['labor']), 'B');
            $pos6 = strpos(strtoupper($this->jsonvalue['labor']), 'C');
            if ($pos) {
                $insertData['mech'] = $this->jsonvalue['labor'];
            } else if ($pos1) {
                $insertData['frame'] = $this->jsonvalue['labor'];
            } else if ($pos2) {
                $insertData['structual'] = $this->jsonvalue['labor'];
            } else if ($pos3) {
                $insertData['glass'] = $this->jsonvalue['labor'];
            } else if ($pos4) {
                $insertData['user_1'] = $this->jsonvalue['labor'];
            } else if ($pos5) {
                $insertData['user_2'] = $this->jsonvalue['labor'];
            } else if ($pos6) {
                $insertData['user_3'] = $this->jsonvalue['labor'];
            } else {
                $insertData['labor'] = $this->jsonvalue['labor'];
            }
            $insertData['paint'] = $this->jsonvalue['paint'];
        }
        $insertData['markup'] = $this->jsonvalue['markup'];
        $insertData['note'] = $this->jsonvalue['note'];
        $insertData['add_from'] = 3; // Manual Entry
        $insertData['qty'] = 1; // Manual Entry
        $insertData['tab_name'] = 'ZZ'; // Manual Entry

        if ($this->Muser->isExistEstimate($this->jsonvalue['estimate_id'], $this->jsonvalue['user_id'])) {
            $returnStatus = $this->Muser->save_manual_estimate_parts($insertData);
            if ($returnStatus) {
                $result = array(
                    'success' => true,
                    'msg' => $this->lang->line('data_saved'),
                    'code' => 200
                );
            } else {
                $result = array(
                    'success' => false,
                    'msg' => $this->lang->line('oops_something_went_wrong'),
                    'code' => 400
                );
            }
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('no_premission'),
                'code' => 400
            );
        }
        echo json_encode($result);
    }

    public function get_user_define_parts()
    {
        $fields = array(
            'user_id',
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['data']   = array();
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);
        $returnData = $this->Muser->get_user_define_parts($this->jsonvalue);
        if ($returnData) {
            $result = array(
                'success' => true,
                'msg' => $this->lang->line('data_found'),
                'code' => 200,
                'data' => $returnData
            );
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('no_data_found'),
                'code' => 400,
                'data' => array()
            );
        }

        echo json_encode($result);
    }


    public function get_vehicle_info()
    {
        $fields = array(
            'user_id',
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['data']   = (object)array();
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);
        $returnData = $this->Muser->get_vehicle_info($this->jsonvalue['estimate_id']);
        if ($returnData) {
            $result = array(
                'success' => true,
                'msg' => $this->lang->line('data_found'),
                'code' => 200,
                'data' => $returnData[0]
            );
        } else {
            $result = array(
                'success' => true,
                'msg' => $this->lang->line('no_data_found'),
                'code' => 200,
                'data' => (object)array()
            );
        }

        echo json_encode($result);
    }


    public function latest_estimates()
    {
        $fields = array(
            'user_id',
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['data']   = (object)array();
            echo json_encode($response);
            exit();
        }

        $this->currentLang($this->jsonvalue['user_id']);
        $getestmt = array();
        ///$getEstimates = $this->db->limit(30)->order_by('estimate_id', 'DESC')->get_where('ca_estimates', ['user_id' => $this->jsonvalue['user_id']])->result_array();
        $getEstimates = $this->db->limit(30)->order_by('estimate_id', 'DESC')->get_where('ca_estimates', ['user_id' => $this->jsonvalue['user_id'], 'is_save' => 1])->result_array();
        ///print_r($getEstimates);

        
        foreach ($getEstimates as $key => $estmt) {
            $getestmt[] = $estmt;
            ////$getEstimates['test_id'] = 'demo 123';
            // $holderArray['user_id'] = $this->userData['user_id'];
            $getestmt[$key]['get_est_fullData'] = $this->Muser->get_est_fullData(['user_id' => $estmt['user_id'], 'estimate_id' => $estmt['estimate_id']]);
            $getestmt[$key]['modal_data'] = $this->Muser->get_estimate_data(['user_id' => $estmt['user_id'], 'estimate_id' => $estmt['estimate_id']]);
            $getestmt[$key]['owner'] = $this->Muser->get_estimate_owner(['user_id'=>$estmt['user_id'],'estimate_id'=>$estmt['estimate_id']]);
    
          }

        $returnData = $getestmt;
        
        if ($returnData) {
            $result = array(
                'success' => true,
                'msg' => $this->lang->line('data_found'),
                'code' => 200,
                'data' => $returnData
            );
        } else {
            $result = array(
                'success' => true,
                'msg' => $this->lang->line('no_data_found'),
                'code' => 200,
                'data' => array()
            );
        }

        echo json_encode($result);
    }


    public function save_user_define_parts()
    {
        $fields = array(
            'user_id',
            'oper',
            'part_name',
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['data']   = array();
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);
        $id = $this->jsonvalue['id'];
        $insertData['user_id'] = $this->jsonvalue['user_id'];
        $insertData['oper'] = $this->jsonvalue['oper'];
        $insertData['part_name'] = $this->jsonvalue['part_name'];
        $insertData['list_price'] = $this->jsonvalue['list_price'];
        $insertData['repairhour'] = $this->jsonvalue['repairhour'];
        $insertData['refinishhour'] = $this->jsonvalue['refinishhour'];
        if ($this->jsonvalue['oper'] == 'Refn' || $this->jsonvalue['oper'] == 'Ref' || $this->jsonvalue['oper'] == 'Blnd') {
            if ($this->jsonvalue['oper'] == 'Refn') {
                $insertData['oper'] = 'Ref';
            }
            $insertData['labor'] = '';
            $insertData['mech'] = '';
            $insertData['frame'] = '';
            $insertData['structual'] = '';
            $insertData['glass'] = '';
            $insertData['user_1'] = '';
            $insertData['user_2'] = '';
            $insertData['user_3'] = '';
            $insertData['paint'] = $this->jsonvalue['labor'];
        } else {
            $pos = strpos(strtoupper($this->jsonvalue['labor']), 'M');
            $pos1 = strpos(strtoupper($this->jsonvalue['labor']), 'F');
            $pos2 = strpos(strtoupper($this->jsonvalue['labor']), 'S');
            $pos3 = strpos(strtoupper($this->jsonvalue['labor']), 'G');
            $pos4 = strpos(strtoupper($this->jsonvalue['labor']), 'A');
            $pos5 = strpos(strtoupper($this->jsonvalue['labor']), 'B');
            $pos6 = strpos(strtoupper($this->jsonvalue['labor']), 'C');
            if ($pos) {
                $insertData['mech'] = $this->jsonvalue['labor'];
            } else if ($pos1) {
                $insertData['frame'] = $this->jsonvalue['labor'];
            } else if ($pos2) {
                $insertData['structual'] = $this->jsonvalue['labor'];
            } else if ($pos3) {
                $insertData['glass'] = $this->jsonvalue['labor'];
            } else if ($pos4) {
                $insertData['user_1'] = $this->jsonvalue['labor'];
            } else if ($pos5) {
                $insertData['user_2'] = $this->jsonvalue['labor'];
            } else if ($pos6) {
                $insertData['user_3'] = $this->jsonvalue['labor'];
            } else {
                $insertData['labor'] = $this->jsonvalue['labor'];
            }
            $insertData['paint'] = $this->jsonvalue['paint'];
        }
        $insertData['markup'] = $this->jsonvalue['markup'];
        $insertData['note'] = $this->jsonvalue['note'];

        if ($id) {
            $returnStatus = $this->Muser->update_entry($insertData, $id);
        } else {
            $returnStatus = $this->Muser->save_user_define_parts($insertData);
        }


        if ($returnStatus) {
            $savePdata = $this->Muser->get_user_define_parts($this->jsonvalue);
            $result = array(
                'success' => true,
                'msg' => $this->lang->line('data_saved'),
                'code' => 200,
                'data' => $savePdata
            );
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('oops_something_went_wrong'),
                'code' => 400,
                'data' => array()
            );
        }
        echo json_encode($result);
    }





    public function get_preliminary_est()
    {
        $fields = array(
            'user_id',
            'estimate_id'
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['vehicle_name'] = '';
            $response['data']   = (object)array();
            echo json_encode($response);
            exit();
        }

        $this->currentLang($this->jsonvalue['user_id']);
        $deleteditem = array();
        $changeditem = array();

        $addeditem = array();
        $initialdata = array();

        $returnData = array();

        $estimateStatus = $this->Muser->get_estimate_status(array('estimate_id' => $this->jsonvalue['estimate_id'], 'user_id' => $this->jsonvalue['user_id']));

        // echo $this->lang->line('data_saved');
        // die;

        if ($this->Muser->isExistEstimate($this->jsonvalue['estimate_id'], $this->jsonvalue['user_id'])) {
            $returnData = $this->Muser->get_preliminary_est($this->jsonvalue);

            // 22 june total days calculation
            $finalReportData = $this->Muser->get_initial_estimates_days($this->jsonvalue['estimate_id']);

            $totallaborhour =   $finalReportData["body_labor"] + $finalReportData["mechanical_labor"] + $finalReportData["frame_labor"] + $finalReportData["structual_labor"] + $finalReportData["glass_labor"] +  $finalReportData["paint_labor"] +  $finalReportData["user_1"] +  $finalReportData["user_2"] +  $finalReportData["user_3"];


            $days_to_repair_value =   $this->Muser->getData("ca_labor_taxs", $this->jsonvalue['user_id'], "user_id");


            $days_to_repair_valuedata = $days_to_repair_value[0]['days_to_repair_value'];

            if ($days_to_repair_valuedata > 0) {
                $totalcalculatedrepairdays = @$totallaborhour / @$days_to_repair_valuedata;

                $repair_days = round(@$totalcalculatedrepairdays);
            }

            // 22 june total days calculation ends
            $initialdata = array();

            $initialdata = $this->Muser->get_initial_estimates_report($this->jsonvalue['estimate_id']);

            // 11 july $initialdata=$this->Muser->dummydata();



            $addeditem = array();

            $estiddata = $this->Muser->getDatabyCondition("ca_estimate_select_parts", array("estimate_id" => $this->jsonvalue['estimate_id']));



            $addeditem = $estiddata;


            $changeditem = $this->Muser->deltedpartdata("ca_estimate_select_parts_changed", $this->jsonvalue['estimate_id']);


            $table = "ca_estimate_select_parts_deleted";
            $deleteditem = array();

            $deleteditem = $this->Muser->deltedpartdata($table, $this->jsonvalue['estimate_id']);


            // 09 june ends

            //--$data['deleteditem'] = $deleteditem; 
            //--$data['changeditem'] = $changeditem; 
            //-- $data['addeditem'] = $addeditem; 
            // $data['initialitem'] = $addeditem;


            $returnData['appraisal_report_data']['speculative_day_repair'] = $repair_days;
            $est_status =  $returnData['estimate_data']['status'];
            $est_status_lng = $this->lang_translate($est_status,$this->jsonvalue['user_id']);
            $returnData['estimate_data']['status'] = $est_status_lng;



            if (empty($deleteditem) || (!isset($deleteditem))) {

                $deleteditem = array();
            }

            if (empty($initialdata) || (!isset($initialdata))) {

                $initialdata = array();
            }


            if ($returnData) {
                $vehicleName = $this->Muser->getVehcileName($this->jsonvalue);

                //    $status = $returnData['estimate_data']->status;
                //    echo  $status;
                //    die;

                // echo json_encode($returnData['estimate_data']['status']);
                // die;

                $vehicle_options = $returnData['vehicle_option'];
                $new_options  = [];
                foreach($vehicle_options as $key=>$voptions)
                {
                   $new_options[$key]['title'] =  $this->lang->line($voptions['title']);
                   foreach($voptions['details'] as $details_data)
                   {
                    $new_options[$key]['details'][] =  $this->lang_translate($details_data, $this->jsonvalue['user_id']);
                   }
                   
                }

                $part_info_data = [];
                foreach($returnData['part_info'] as $new_data)
                {
                  $new_data['part_name_en'] = $new_data['part_name'];
                  $new_data['part_name'] = $this->lang_translate($new_data['part_name'], $this->jsonvalue['user_id']);
                  $new_data['list_price_usd'] = $new_data['list_price'];
                  $new_data['list_price'] = number_format($new_data['list_price'] * $this->currency_convert(),2, '.', '');
                  $part_info_data[] = $new_data;
                }
                $returnData['part_info'] = $part_info_data;

                 $returnData['vehicle_option'] = $new_options;
                  $result      = array(
                    'success' => true,
                    'msg' => $this->lang->line('data_saved'),
                    'code' => 200,
                    'vehicle_name' => $vehicleName['vehicle_identity_name'],
                    ///'data_en' => $returnData,
                    'data' => $returnData,
                    'deleteditem' => $deleteditem,
                    'initialdata' => $initialdata,
                    'changeditem' => $changeditem,
                    'addeditem' => $addeditem,
                    'repair_days'=> $repair_days,
                    'estimateStatus' => $estimateStatus,

                );
            } else {
                $result = array(
                    'success' => false,
                    'msg' => $this->lang->line('oops_something_went_wrong'),
                    'code' => 400,
                    'vehicle_name' => '',
                    'data' => object(array())
                );
            }
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('no_premission'),
                'code' => 400,
                'vehicle_name' => '',
                'data' => object(array())
            );
        }
        echo json_encode($result);
    }
    /////////////////////////////////////////////

    public function save_lock_est()
    {
        $fields = array(
            'user_id',
            'estimate_id',
            'action'
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);
        if ($this->Muser->isExistEstimate($this->jsonvalue['estimate_id'], $this->jsonvalue['user_id'])) {
            $returnData = $this->Muser->save_lock_est($this->jsonvalue);
            if ($returnData) {
                $msg = ($this->jsonvalue['action'] == 'lock') ? $this->lang->line('lock_est') : $this->lang->line('save_est');
                $result      = array(
                    'success' => true,
                    'msg' => $msg,
                    'code' => 200,
                );
            } else {
                $result = array(
                    'success' => false,
                    'msg' => $this->lang->line('no_part_is_selected'),
                    'code' => 400,
                );
            }
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('no_premission'),
                'code' => 400,
                'vehicle_name' => '',
            );
        }
        echo json_encode($result);
    }

    ///////////////////// Get User Registed Details /////////////////

    public function get_user_account_info()
    {
        $fields = array(
            'user_id',
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['data']   = array();
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);
        $returnData = $this->Muser->get_user_account_info($this->jsonvalue['user_id']);
        if ($returnData) {
            $result      = array(
                'success' => true,
                'msg' => $this->lang->line('data_found'),
                'code' => 200,
                'data' => $returnData
            );
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('oops_something_went_wrong'),
                'code' => 400,
                'data' => array()
            );
        }
        echo json_encode($result);
    }

    ///////////////////// Get User Registed Details /////////////////

    public function save_user_account_info()
    {
        $fields = array(
            'user_id',
            'appraisal_company_name',
            'appraiser_name',
            'phone_number',
        );
        $this->currentLang($this->jsonvalue['user_id']);
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['data']   = array();
            echo json_encode($response);
            exit();
        }
        $returnData = $this->Muser->update_user_account_info($this->jsonvalue);
        if ($returnData) {
            $result      = array(
                'success' => true,
                'msg' => $this->lang->line('data_update'),
                'code' => 200,
                'data' => $returnData
            );
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('oops_something_went_wrong'),
                'code' => 400,
                'data' => array()
            );
        }
        echo json_encode($result);
    }


    public function save_user_default_info()
    {
        $fields = array(
            'user_id',
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['data']   = array();
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);
        $returnData = $this->Muser->update_user_account_info($this->jsonvalue);
        if ($returnData) {
            $result      = array(
                'success' => true,
                'msg' => $this->lang->line('data_update'),
                'code' => 200,
                'data' => $returnData
            );
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('oops_something_went_wrong'),
                'code' => 400,
                'data' => array()
            );
        }
        echo json_encode($result);
    }


    //////////////////////// Getting invoice data ////////////////////////

    public function get_invoice_data()
    {
        $fields = array(
            'user_id',
            'estimate_id',
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['data']   = array();
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);
        if ($this->Muser->isExistEstimate($this->jsonvalue['estimate_id'], $this->jsonvalue['user_id'])) {
            $returnData = $this->Muser->get_invoice_data($this->jsonvalue);
            if ($returnData) {
                $result      = array(
                    'success' => true,
                    'msg' => $this->lang->line('data_found'),
                    'code' => 200,
                    'data' => $returnData
                );
            } else {
                $result = array(
                    'success' => false,
                    'msg' => $this->lang->line('oops_something_went_wrong'),
                    'code' => 400,
                    'data' => array()
                );
            }
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('no_premission'),
                'code' => 400,
            );
        }
        echo json_encode($result);
    }


    public function get_invoice_data1()
    {
        $fields = array(
            'user_id',
            'estimate_id',
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['data']   = array();
            echo json_encode($response);
            exit();
        }

        $currency_convert = $this->currency_convert();
        $this->currentLang($this->jsonvalue['user_id']);
        if ($this->Muser->isExistEstimate($this->jsonvalue['estimate_id'], $this->jsonvalue['user_id'])) {
            $returnData = $this->Muser->get_invoice_data1($this->jsonvalue);
            ///$returnData['invoice_data']['appraisal_service_type'][0]['value'] = (string) $returnData['invoice_data']['appraisal_service_type'][0]['value']*$currency_convert;
            //$returnData['invoice_data']['appraisal_service_type'][0]['tax'] = (string) $returnData['invoice_data']['appraisal_service_type'][0]['tax']*$currency_convert;
           
           $appraisal_service_types = $returnData['invoice_data']['appraisal_service_type'];
            foreach($appraisal_service_types as $key=>$appraisal_service_type)
            {
                $get_value = $appraisal_service_type['value']*$currency_convert;
                $get_tax = $appraisal_service_type['tax']*$currency_convert;

                $appraisal_service_type_data[] = array(
                    "slug" => $appraisal_service_type['slug'],
                    "label" => $appraisal_service_type['label'],
                    "value"=> (string) $get_value,
                    "is_selected" => $appraisal_service_type['is_selected'],
                    "tax" => (string) $get_tax
                );
                
            }

            $returnData['invoice_data']['appraisal_service_type'] = $appraisal_service_type_data;
 
             //$returnData['invoice_data']['appraisal_service_type'][0]['value'] = (string) $returnData['invoice_data']['appraisal_service_type'][0]['value']*$currency_convert;
             //$returnData['invoice_data']['appraisal_service_type'][0]['tax'] = (string) $returnData['invoice_data']['appraisal_service_type'][0]['tax']*$currency_convert;
 
  
             $additional_charges = $returnData['invoice_data']['invoice_total']*$currency_convert;
             $tax_total = $returnData['invoice_data']['tax_total']*$currency_convert;
             $invoice_total = $returnData['invoice_data']['invoice_total']*$currency_convert;
             $tax_rate = $returnData['invoice_data']['tax_rate']*$currency_convert;
             $sales_tax = $returnData['invoice_data']['sales_tax']*$currency_convert;
 
             $returnData['invoice_data']['additional_charges'] =  (string) $additional_charges;
             $returnData['invoice_data']['tax_total'] =  (string) $tax_total;
             $returnData['invoice_data']['invoice_total'] =  (string) $invoice_total;
             $returnData['invoice_data']['tax_rate'] = (string) $tax_rate;
             $returnData['invoice_data']['sales_tax'] =  (string) $sales_tax;
           
            if ($returnData) {
                $result      = array(
                    'success' => true,
                    'msg' => $this->lang->line('data_found'),
                    'code' => 200,
                    'data' => $returnData
                );
            } else {
                $result = array(
                    'success' => false,
                    'msg' => $this->lang->line('oops_something_went_wrong'),
                    'code' => 400,
                    'data' => array()
                );
            }
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('no_premission'),
                'code' => 400,
            );
        }
        echo json_encode($result);
    }

    /////////////////////////////////////////////////

    public function save_invoice_data()
    {
        $fields = array(
            'user_id',
            'estimate_id',
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);
        $returnData = $this->Muser->save_invoice_data($this->jsonvalue);
        if ($returnData) {
            $result      = array(
                'success' => true,
                'msg' => $this->lang->line('data_saved'),
                'code' => 200,
            );
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('oops_something_went_wrong'),
                'code' => 400,
            );
        }
        echo json_encode($result);
    }

    //////////////////////// Getting Appraisal Report data ////////////////////////

    public function get_appraisal_report()
    {
        $fields = array(
            'user_id',
            'estimate_id',
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['data']   = array();
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);
        if ($this->Muser->isExistEstimate($this->jsonvalue['estimate_id'], $this->jsonvalue['user_id'])) {
            $returnData = $this->Muser->get_appraisal_report(array('estimate_id' => $this->jsonvalue['estimate_id'], 'user_id' => $this->jsonvalue['user_id']));
            if ($returnData) {
                $returnData['appraisal_report_data']['remarks'] = [];
                $result      = array(
                    'success' => true,
                    'msg' => $this->lang->line('data_found'),
                    'code' => 200,
                    'data' => $returnData
                );
            } else {
                $result = array(
                    'success' => false,
                    'msg' => $this->lang->line('oops_something_went_wrong'),
                    'code' => 400,
                    'data' => array()
                );
            }
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('no_premission'),
                'code' => 400,
            );
        }
        echo json_encode($result);
    }

    ////////////////////////// Save Appraisal Report Data ///////////////////////

    public function save_appraisal_report()
    {
        $fields = array(
            'user_id',
            'estimate_id',
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);
        $returnData = $this->Muser->save_appraisal_report($this->jsonvalue);
        if ($returnData) {
            $result      = array(
                'success' => true,
                'msg' => $this->lang->line('data_saved'),
                'code' => 200,
            );
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('oops_something_went_wrong'),
                'code' => 400,
            );
        }
        echo json_encode($result);
    }



    ///////////////////// Generate Final Report ////////////////////

    public function generate_final_report()
    {
        $fields = array(
            'user_id',
            'estimate_id',
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['data']   = array();
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);
        if ($this->Muser->isExistEstimate($this->jsonvalue['estimate_id'], $this->jsonvalue['user_id'])) {
            $estData['photos'] = $this->Muser->get_photos($this->jsonvalue['estimate_id']);
            $estData['report'] = $this->Muser->get_est_report($this->jsonvalue['estimate_id']);
            $estData['invoice'] = $this->Muser->get_est_invoice($this->jsonvalue['estimate_id']);
            $estData['get_est_fullData'] = $this->Muser->get_est_fullData($this->jsonvalue);
            $userPhoneDate = (isset($this->jsonvalue['current_datetime'])) ? date('m/d/Y h:i:s A', strtotime($this->jsonvalue['current_datetime'])) : date('m/d/Y h:i:s A');
            $paymentDetails = $this->Muser->get_payment_details($this->jsonvalue);
            $companyData = $this->Muser->get_company_settings();
            $totalEstCost = 0;
            $generatePdfFileUrl = '';
            $deductibleAmnt = isset($estData['get_est_fullData']['estimate_data']['deductive_amount']) ? $estData['get_est_fullData']['estimate_data']['deductive_amount'] : 0;
            //$totalEstCost = $estData['get_est_fullData']['estimate_data']['estimate_cost'] - $deductibleAmnt;
            $totalEstCost = ($estData['get_est_fullData']['estimate_data']['estimate_cost'] != '') ? $estData['get_est_fullData']['estimate_data']['estimate_cost'] : 0;
            $generatePdfFileUrl = $this->create_pdf($this->jsonvalue['estimate_id'], $estData, $this->jsonvalue['user_id'], $companyData, $userPhoneDate);
            $responseData['vehicle_name'] = $estData['get_est_fullData']['vehicle_info']['vehicle_name'];
            $responseData['est_amount'] = @(string)number_format($totalEstCost, 2);
            $responseData['other_data']['is_complete'] = '1';
            $responseData['other_data']['report'] = (isset($estData['report']) && !empty($estData['report'])) ? '1' : '0';
            $responseData['other_data']['invoice'] = (isset($estData['invoice']) && !empty($estData['invoice'])) ? '1' : '0';
            $responseData['other_data']['photos'] = (isset($estData['photos']) && !empty($estData['photos'])) ? (string)count($estData['photos']) : '0';
            $responseData['sample_report'] = base_url() . 'assets/images/' . $companyData['sample_pdf'];
            $responseData['app_price'] = $this->Muser->get_app_settings();
            $alreadyPaidEst = $this->Muser->is_sold_estimate($this->jsonvalue);
            if ((isset($paymentDetails) && !empty($paymentDetails)) || $alreadyPaidEst) {
                /*
               *  Adding Estimate Which is pay amount fees.
               */
                if (!$alreadyPaidEst) {
                    $this->Muser->add_est_to_sold($this->jsonvalue, $paymentDetails);
                }
                $responseData['payment']['required'] = '0';
                $responseData['pdf_link'] = $generatePdfFileUrl;
            } else {



                $responseData['payment']['required'] = '1';
                $responseData['pdf_link'] = array('url' => '', 'filename' => '');
            }

            ###############################
            $newToken = $this->randomStr(32);
            $this->db->where('estimate_id', $this->jsonvalue['estimate_id']);
            // real changed below-- $this->db->update('ca_estimates',array('token'=>'','lock_token'=>'','payment_token'=>$newToken));  

            $this->db->update('ca_estimates', array('token' => '', 'lock_token' => '', 'payment_token' => $newToken));
            ##############################   


            $returnData = true;
            if ($returnData) {
                $result = array(
                    'success' => true,
                    'msg' => $this->lang->line('data_found'),
                    'code' => 200,
                    'data' => $responseData
                );
            } else {
                $result = array(
                    'success' => false,
                    'msg' => $this->lang->line('oops_something_went_wrong'),
                    'code' => 400,
                    'data' => array()
                );
            }
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('no_premission'),
                'code' => 400,
                'data' => array(),
            );
        }
        echo json_encode($result);
    }


    public function get_currency_data($type, $user_id)
    {
      $this->db->select('default_currency,currency_usd_value');
      $get_user_data = $this->db->get_where('ca_users', array('user_id' => $user_id))->row_array();
  
  
      $this->db->select('currency_symbol,currency');
      $country_data = $this->db->get_where('ca_countries', array('currency' => $get_user_data['default_currency']))->row_array();
      $get_user_data['default_currency_symbol'] = $country_data['currency_symbol'];
  
      // print_r($get_user_data);
      // die;
  
  
      return $get_user_data[$type];
    }

    /////////////////////////////// Create Pdf ////////////////////////////////

    public function create_pdf($estID, $estData, $userID, $companyData, $userPhoneDate)
    {
      $lanaguage = $this->getLanguage($userID);
      $this->lang->load('translations_lang', $lanaguage);
  
      $getUrlVal = $this->Muser->get_pdf_url($estID);
      $changeditem = $this->Muser->deltedpartdata("ca_estimate_select_parts_changed", $estID);
      $addeditem = $this->Muser->addeditem($estID);
  
      $deleteditem = $this->Muser->deleteditem($estID);
  
      $loginUser = $userID;
      $currency_val = $this->userData['currency_usd_value'];
  
      $days_to_repair_value =   $this->Muser->getData("ca_labor_taxs", $loginUser, "user_id");
  
      // 22 june total days calculation
      $totalcalculatedrepairdays = 0;
  
      $dayReportData = $this->Muser->get_initial_estimates_days($estID);
  
  
  
      $totallaborhour =   $dayReportData["body_labor"] + $dayReportData["paint_labor"] + $dayReportData["mechanical_labor"] + $dayReportData["frame_labor"] + $dayReportData["structual_labor"] + $dayReportData["glass_labor"] + $dayReportData["user_1"] + $dayReportData["user_2"] + $dayReportData["user_3"];
  
  
  
  
      $days_to_repair_valuedata = $days_to_repair_value[0]['days_to_repair_value'];
  
  
      if ($days_to_repair_valuedata > 0) {
        $totalcalculatedrepairdays = round(@$totallaborhour / @$days_to_repair_valuedata);
      }
  
  
      // $this->lang->line('Insured');
      // exit;
      // 22 june total days calculation ends  
  
  
      $imglink = $days_to_repair_value[0]['towing_storage_image'];
  
      // dd($imglink);
  
      if (isset($getUrlVal['pdf_url']) && $getUrlVal['pdf_url'] != '') {
        return array('url' => $getUrlVal['pdf_url'], 'filename' => $getUrlVal['pdf_name']);
      } else {
  
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $options->set('debugKeepTemp', TRUE);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        @set_time_limit(-1);
        $filePath = $_SERVER['DOCUMENT_ROOT'] . "/quicksheet/application/views/pdf/pdf-html.php";
  
  
        //$filePath = base_url()."application/views/pdf/pdf-html.php";
        $html = file_get_contents($filePath);
        $config = [
          //'mode' => 'en', // Example: zh-Hans, en, fr etc
          "autoScriptToLang" => true,
          "autoLangToFont" => true,
          "isRemoteEnabled" => true,
          "debugKeepTemp" => true,
          "isHtml5ParserEnabled" => true,
          "isPhpEnabled" => true,
        ];
        ///$dompdf = new Dompdf($options);
        $mpdf = new \Mpdf\Mpdf($config);
        $pdfSettings = $this->Muser->get_pdf_settings();
        $mpdf->AddPageByArray([
          'format' => 'A4',
          'margin-left' => 8,
          'margin-right' => 8,
          'margin-top' => 8,
          'margin-bottom' => 8,
        ]);
  
        // $html = str_replace('{CSS_PATH}', $cssPath, $html);
        $html = str_replace('{OWNER_NAME}', $estData['get_est_fullData']['estimate_data']['claimant'], $html);
        $html = str_replace('{PART_NAME}', $estData['get_est_fullData']['vehicle_info']['vehicle_name'], $html);
        /*if(isset($estData['get_est_fullData']['part_info']) && !empty($estData['get_est_fullData']['part_info'])){
                  $abbre = '<div class="row" style="font-size:14px;font-weight:500;page-break-before: always;">'.$pdfSettings['abbreviation'].'</div>';
                  $html = str_replace('{ABBREVIATION}',$abbre,$html);
              }else{
                  $html = str_replace('{ABBREVIATION}','',$html);
              }*/
  
        $companyName = $estData['get_est_fullData']['appraisal_data']['appraisal_company'];
        $companyEmailAddress = $estData['get_est_fullData']['appraisal_data']['email_id'];
        $companyAddress = $estData['get_est_fullData']['appraisal_data']['address'];
        $comPhone = $estData['get_est_fullData']['appraisal_data']['phone_number'];
        $comFax = $estData['get_est_fullData']['appraisal_data']['fax'];
        $written_by = $estData['get_est_fullData']['appraisal_data']['written_by'];
        $adjuster_name = $estData['get_est_fullData']['estimate_data']['adjuster_name'];
        $adjuster_phone = $estData['get_est_fullData']['estimate_data']['adjuster_phone'];
        $ownerNam = ($estData['get_est_fullData']['estimate_data']['owner_identity'] != 1) ? $estData['get_est_fullData']['estimate_data']['claimant'] : $estData['get_est_fullData']['estimate_data']['insured'];
        ///////////////////// Adding First Page Data ////////////////////////////
        $dateLoss = '';
        $REPAIRABLE = '';
        if (isset($estData['report']) && !empty($estData['report'])) {
          if ($estData['report'][0]['borderline_total_loss']) {
            $REPAIRABLE = 'BORDERLINE TOTAL LOSS';
          } elseif ($estData['report'][0]['total_loss']) {
            $REPAIRABLE = 'TOTAL LOSS';
          } elseif ($estData['report'][0]['supplement']) {
            $REPAIRABLE = 'SUPPLEMENT';
          } else {
            $REPAIRABLE = 'REPAIRABLE';
          }
          $finalReportData = $this->Muser->get_estimates_final_report($estID);
  
          //  print_r($finalReportData);
          //  die;
  
          $deductibleAmnt = $estData['get_est_fullData']['estimate_data']['deductive_amount'] ? $estData['get_est_fullData']['estimate_data']['deductive_amount'] : 0;
          $estimageCost = (isset($finalReportData["total_cost_repairs"]) && $finalReportData["total_cost_repairs"] != '') ? $finalReportData["total_cost_repairs"] : 0;
          $netEstimageCost = $estimageCost -  $deductibleAmnt;
          $calledVal = ($estData['report'][0]['called_in']) ? 'Yes' : 'No';
          $sinceVal = ($estData['report'][0]['since'] != '0000-00-00') ? date('m/d/Y', strtotime($estData['report'][0]['since'])) : '';
          $dateLoss = ($estData['get_est_fullData']['estimate_data']['loss_date'] != '0000-00-00 00:00:00') ? date('m/d/Y', strtotime($estData['get_est_fullData']['estimate_data']['loss_date'])) : '';
          $estReport = '';
          $collectionStorage = ($estData['report'][0]['collection_storage']) ? $estData['report'][0]['per_day'] : '';
          $repairFacility = '';
          if (isset($estData['get_est_fullData']['estimate_data']['site_type']) && trim($estData['get_est_fullData']['estimate_data']['site_type']) == 'Repair Facility') {
            $repairFacility = '' . $this->lang->line('Repair Facility') .': '. $estData['get_est_fullData']['estimate_data']['inspections_name'] . '<br>
                                      Address: ' . $estData['get_est_fullData']['estimate_data']['inspections_address'] . '<br>
                                      Tax ID #: ' . $estData['get_est_fullData']['estimate_data']['inspections_tax_id'] . '<br><br>';
          }
          $estReport .= '
          <div class="row">
  
          <div style="text-align:center;margin-top:-40px;font-family: TimesNewRoman, Times, Baskerville, Georgia, serif;">
           <h2 style="font-weight:bold;font-size:32px;margin-bottom:0px">' . $companyName . '</h2>
           <p style="font-weight:bold;font-size:13px;">' . $companyAddress . '<br>Ph: ' . preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $comPhone) . ' Fax: ' . preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $comFax) . '</p></p>
           <br><h2 class="s15" style="font-weight:bold;padding-bottom:5px;margin-top:0px;width:100%;border-bottom:4px solid #89a2b9;margin-bottom:10px">' . $this->lang->line('CLAIM SUMMARY REPORT') . '</h2>
  
           <table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:13px; line-height:25px;margin-left:10px;">
              <tbody>
              
                <tr>
                <td class="s3" style="padding-top: 4pt;text-indent: 0pt;text-align: left; width: 20%;">
              ' . $this->lang->line('COMPANY') . ':
                </td>
                <td style="margin-bottom:50px;display: inline;border:1px solid #000;padding-left:5px; width: 28%;">' . $estData['get_est_fullData']['estimate_data']['insurance_company'] . ' &nbsp;</td>
               
                <td class="s3" style="width: 20%; padding-left:10px;">
                  ' . $this->lang->line('INSURED') . ':
                </td>
                <td style="margin-bottom:5px;display: inline;border:1px solid #000;padding-left:5px; width: 28%;">' . $estData['get_est_fullData']['estimate_data']['insured'] . ' &nbsp;</td>
              </tr>
  
              <tr>
              <td colspan="4" style="padding-top:5px;"></td>
              </tr>
  
              <tr>
              <td class="s3" style="padding-top: 4pt;text-indent: 0pt;text-align: left;">
                ' . $this->lang->line('CLAIM NUMBER') . ':
              </td>
              <td style="margin-bottom:5px;display: inline;border:1px solid #000;padding-left:5px;">' . $estData['get_est_fullData']['estimate_data']['claim_number'] . ' &nbsp;</td>
           
              <td class="s3" style="padding-left:10px; font-family: helvetica !important;">
                ' . $this->lang->line('CLAIMANT') . ':
              </td>
              <td style="margin-bottom:5px;display: inline;border:1px solid #000;padding-left:5px;">' . $estData['get_est_fullData']['estimate_data']['claimant'] . ' &nbsp;</td>
            </tr>
  
            <tr>
            <td colspan="4" style="padding-top:5px;"></td>
            </tr>
  
            <tr>
            <td class="s3" style="padding-top: 4pt;text-indent: 0pt;text-align: left;">
              ' . $this->lang->line('ADJUSTER') . ':
            </td>
            <td style="margin-bottom:5px;display: inline;border:1px solid #000;padding-left:5px;">' . $estData['get_est_fullData']['estimate_data']['adjuster_name'] . ' &nbsp;</td>
          
            <td class="s3" style="padding-left:10px;">
              ' . $this->lang->line('DATE OF LOSS') . ':
            </td>
            <td style="margin-bottom:5px;display: inline;border:1px solid #000;padding-left:5px;">' . $dateLoss . ' &nbsp;</td>
          </tr>
  
          <tr>
          <td colspan="4" style="padding-top:5px;"></td>
         </tr>
  
         <tr>
         <td class="s3" style="padding-top: 4pt;text-indent: 0pt;text-align: left;">
          ' . $this->lang->line('INSPECTION DATE') . ':
         </td>
         <td style="margin-bottom:5px;display: inline;border:1px solid #000;padding-left:5px;">' . $estData['report'][0]['inspection_date'] . ' &nbsp;</td>
       
         <td class="s3" style="padding-left:10px;">
           ' . $this->lang->line('VEHICLE') . ':
         </td>
         <td style="margin-bottom:5px;display: inline;border:1px solid #000;padding-left:5px;">' . $estData['get_est_fullData']['vehicle_info']['vehicle_name'] . ' &nbsp;</td>
       </tr>
           
       <tr>
       <td colspan="4" style="padding-top:5px;"></td>
     </tr>
  
     <tr>
     <td colspan="2"  class="s3" style="padding-top: 4pt;text-indent: 0pt;text-align: left;">
       ' . $this->lang->line('INSPECTION SITE') . ': 
       <b>' . $estData['get_est_fullData']['estimate_data']['site_type'] . '</b>
     </td>
    
     <td colspan="2" width="100%" class="s3" style="padding-left:10px;">
       ' . $this->lang->line('WRITTEN BY') . ': 
       <b>' . $written_by . '</b>
     </td>
   </tr>
   <tr>
       <td colspan="4" style="padding-top:5px;"></td>
     </tr>
   ';
          if ($estData['report'][0]['drivable']) {
            $estReport .= '<tr><td colspan="2"  class="s3" style="padding-top: 4pt;text-indent: 0pt;text-align: left;">' . $this->lang->line('Drivable') . ': <b>Yes</b></td></tr>';
          } else {
            $estReport .= '<tr><td colspan="2"  class="s3" style="padding-top: 4pt;text-indent: 0pt;text-align: left;">' . $this->lang->line('Drivable') . ': <b>No</b></td></tr>';
          }
          $estReport .= '</tbody>
            </table>
            <h2 class="s15" style="font-weight:bold;padding-bottom:5px;margin-top:0px;width:100%;border-bottom:4px solid #89a2b9;margin-bottom:10px">' . $this->lang->line($REPAIRABLE) . '</h2>
           
            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:13px; line-height:25px;margin-left:10px;">
              <tbody>
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:13px; line-height:20px">
              <tbody>';
          if ($estData['get_est_fullData']['estimate_data']['is_supplement'] == 1) {
            $finalSupReportDataN = $this->Muser->get_supplement_summary($estID);
            $estReport .= '<tr>
                  
                  <td valign="middle" width="30%" style="line-height:17px;font-size:13px;">' . $this->lang->line('Supplement Total') . ': ' . $this->get_currency_data('default_currency_symbol', $userID) . @number_format($finalSupReportDataN['final_report_sup']["total_cost_repairs"] * $this->get_currency_data('currency_usd_value', $userID), 2) . ' </td>
                  <td valign="middle" style="line-height:17px;font-size:13px;">&nbsp;</td> 
                 
                </tr>';
          }
          $estReport .=  '<tr>
                 <td valign="middle" width="50%" style="line-height:17px;font-size:13px;">' . $this->lang->line('Gross Estimate Amount') . ': ' . $this->get_currency_data('default_currency_symbol', $userID) . @number_format($estimageCost * $this->get_currency_data('currency_usd_value', $userID), 2) . ' </td>
                 <td valign="middle" style="line-height:17px;font-size:13px;">' . $this->lang->line('Open Amount') . ': ' . $this->get_currency_data('default_currency_symbol', $userID) . $estData['report'][0]['open_amount'] . '</td> 
                </tr>    
                 <tr>
                  <td valign="middle" width="50%" style="line-height:17px;font-size:13px;">' . $this->lang->line('Speculative Days to Repair') . ': ' . $totalcalculatedrepairdays . '</td>
                  <td valign="middle" style="line-height:17px;font-size:13px;">' . $this->lang->line('Deductible') . ': ' . $this->get_currency_data('default_currency_symbol', $userID) . $estData['get_est_fullData']['estimate_data']['deductive_amount'] . '</td>
                </tr>';
          if ($estData['get_est_fullData']['estimate_data']['is_supplement'] == 1) {
            $finalSupReportDataN = $this->Muser->get_supplement_summary($estID);
            $estReport .= '<tr>
                  <td colspan="2" valign="middle" width="100%" style="line-height:0px;font-size:18px;margin:0px;padding:0"><h4><b>' . $this->lang->line('Net Supplement Total') . ': ' . $this->get_currency_data('default_currency_symbol', $userID) . @number_format($finalSupReportDataN['final_report_sup']["total_cost_repairs"] * $this->get_currency_data('currency_usd_value', $userID), 2) . '</b></h4> </td>
                </tr>';
          } else {
            $estReport .= ' <tr>
            <td colspan="2" style="padding-top:10px;"></td>
         </tr><tr>
                  <td colspan="2" valign="middle" width="100%" style="line-height:0px;font-size:18px;margin:0px;padding:0"><h4><b>' . $this->lang->line('Net Estimate Total') . ': ' . $this->get_currency_data('default_currency_symbol', $userID) . @number_format($netEstimageCost * $this->get_currency_data('currency_usd_value', $userID), 2) . '</b></h4> </td>
                </tr>';
          }
          $estReport .= '<tr>
          <td colspan="2" style="padding-top:10px;"></td>
       </tr><tr>
                  <td valign="middle" colspan="2" width="100%" style="line-height:17px;font-size:13px;">' . $this->lang->line('Inspection Location') . ': ' . $estData['get_est_fullData']['estimate_data']['inspections_name'] . ', ' . $estData['get_est_fullData']['estimate_data']['inspections_address'] . ' Ph: ' . preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $estData['get_est_fullData']['estimate_data']['inspections_phone']) . ' Fax: ' . preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $estData['get_est_fullData']['estimate_data']['inspections_fax']) . '</td>
                </tr> 
                <tr>
                  <td valign="middle" colspan="2" width="100%" style="line-height:17px;font-size:13px;">' . $this->lang->line('Open items for Possible Supplement') . ': ' . $estData['report'][0]['open_item_possible_supl'] . '.</td>
                </tr> 
                 <tr>
                  <td valign="middle" colspan="2" width="100%" style="line-height:17px;font-size:13px;">' . $this->lang->line('Advance Charges') . ': ' . $this->get_currency_data('default_currency_symbol', $userID) . $estData['report'][0]['advanced_charges'] . '</td>
                </tr> 
  
                <tr>
                 <td colspan="2" style="padding-top:10px;"></td>
                </tr>
  
                <tr>
                  <td valign="top" width="50%" style="line-height:17px">
                        <div style="font-size:13px;height:320px;padding-top:10px">
                        ' . $this->lang->line('Collecting Storage') . $this->get_currency_data('default_currency_symbol', $userID) . ' ' . $collectionStorage . $this->lang->line('day, Since') . ' :' . $sinceVal . '<br>
                            <b>' . $this->lang->line('Vehicle Base Retail Value') . $this->get_currency_data('default_currency_symbol', $userID) . ': ' . @number_format($estData['report'][0]['vehicle_retail_value'], 2) . '</b><br>
                            ' . $this->lang->line('Evaluation Method') . ': ' . $estData['report'][0]['evalucation_method'] . '<br>
                            ' . $this->lang->line('CALLED IN') . ': ' . $calledVal . '<br>
                            <b>' . $this->lang->line('Request') . ' #: ' . $estData['report'][0]['request_number'] . '</b><br>
                            ' . $this->lang->line('Evaluation Amount') . ': <b>' . @number_format($estData['report'][0]['evaulation_amount'], 2) . '</b><br>';
          $estReport .= $repairFacility;
          $estReport .= '<b>' . $this->lang->line('Alternative Part Searches') . ':</b><br>';
          $altPartSearch = json_decode($estData['report'][0]['alternative_part_searches']);
          if (isset($altPartSearch) && !empty($altPartSearch)) {
            foreach ($altPartSearch as $val) {
              $estReport .= $val . '<br>';
            }
          }
          $estReport .= '</div>
                        </td>
  
                        <td valign="top" style="line-height:17px;padding:0 10px;border:1px solid black;height:320px;">
                            <div>
                                <table width="100%" style="padding:0px;margin:0px" border="0" cellspacing="0" cellpadding="0">
                                  <tbody>
                                  <tr>
                                    <td style="font-size:13px; line-height:20px">
                                    <p><b>' . $this->lang->line('Remarks') . ':</b><br>';
          $remarksData = json_decode($estData['report'][0]['remarks'], TRUE);
          if (isset($remarksData) && !empty($remarksData)) {
            foreach ($remarksData as $val) {
              if ($val != '' && $val != ' ') {
                $val1 = str_replace("\n", '<br>', $val);
                $estReport .= $val1 . '<br>';
              }
            }
          }
          $estReport .= '</p>
                                    </td>
                                  </tr>                                 
                                  </tbody>
                                </table>
                            </div>
                        </td>
                        </tr>            
                      </tbody>
                    </table>
                    </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>';
          $breakPage = 'page-break-before: always;';
        } else {
          $estReport = '';
          $breakPage = '';
        }
  
        $Insured_lang = $this->lang->line('Insured');
        // echo $Insured_lang;
        // exit;
        $html = str_replace('{EST_REPORT}', $estReport, $html);
        $html = str_replace('{BREAK_PAGE}', $breakPage, $html);
  
        ///////////////////// Adding Second Page Data ////////////////////////////
         
        $secondPageHtml  = '<br><br><h1 style="margin:0;text-align:center; margin-top:-40px;font-size:28px;">' . strtoupper($companyName) . '</h1>';
        $secondPageHtml .= '<p style="margin:0;font-size:13px;text-align:center;">' . $companyEmailAddress . '</p>';
        $secondPageHtml .= '<p style="margin:0;font-size:13px;text-align:center;">' . strtoupper($companyAddress) . '</p>';
        $secondPageHtml .= '<p style="margin:0;font-size:13px;text-align:center;">' . $this->lang->line('Phone') . ': ' . preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $comPhone) . ', ' . $this->lang->line('Fax') . ': ' . preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $comFax) . '</p>';
        $secondPageHtml .= '<p style="margin:0;font-size:13px;text-align:center;">' . $this->lang->line('Written By') . ': ' . $written_by . '</p>';
        $secondPageHtml .= '<br><p style="padding:4px 0;margin:0;text-align:center;font-size:16px;border-top:4px solid #89a2b9;border-bottom:4px solid #89a2b9;"><b>' . $this->lang->line($estData['get_est_fullData']['estimate_data']['status']) . '</b></p>';
  
        $secondPageHtml .= '<br><table style="font-size:14px;margin-left:10px;line-height:22px;">
        <tr><td width="35%"><b>' . $this->lang->line('Insured') . ': </b>' . $estData['get_est_fullData']['estimate_data']['insured'] . '</td><td width="35%"> <b>' . $this->lang->line('insurance_company') . ': </b>' . $estData['get_est_fullData']['estimate_data']['insurance_company'] . '</td></tr>
        <tr><td width="35%"><b>' . $this->lang->line('Claimant') . ': </b>' . $estData['get_est_fullData']['estimate_data']['claimant'] . '</td><td width="35%"> <b>' . $this->lang->line('Adjuster') . ': </b>' . $adjuster_name . '</td></tr>
        <tr><td width="35%"><b>' . $this->lang->line('Type of Loss') . ': </b>' . $estData['get_est_fullData']['estimate_data']['loss_type'] . '</td><td width="35%">  <b>' . $this->lang->line('claim_number') . ': </b>' . $estData['get_est_fullData']['estimate_data']['claim_number'] . '</td></tr>
        <tr><td width="35%"><b>' . $this->lang->line('date_loss') . ': </b> ' . $dateLoss . '</td><td width="35%"><b>' . $this->lang->line('Policy') . ': </b>' . $estData['get_est_fullData']['estimate_data']['policy_number'] . '</td></tr>
        <tr><td width="35%"><b>' . $this->lang->line('Days to Repair') . ': </b>' . $totalcalculatedrepairdays . '</td><td  width="36%"><b>' . $this->lang->line('point_impact') . ': </b>' . $estData['get_est_fullData']['estimate_data']['point_of_impact'] . '</td></tr>
        </table>';
        $secondPageHtml .= '<table style="font-size:14px;margin-left:10px;">
        <tr>
        <td max-width="50%"><b>' . $this->lang->line('vehicle_owner') . ':</b></td>
        <td width="50%"><b>' . $this->lang->line('Inspection Location') . ':</b></td>
        </tr>
        <tr>
        <td>
          ' . $ownerNam . '<br>' . $estData['get_est_fullData']['estimate_data']['vehicle_owner'] . '<br>' . preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $estData['get_est_fullData']['estimate_data']['vehicle_owner_phone']) . '
          </td><td>
          ' . $estData['get_est_fullData']['estimate_data']['inspections_name'] . '<br>' . $estData['get_est_fullData']['estimate_data']['inspections_address'] . '<br>' . preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $estData['get_est_fullData']['estimate_data']['inspections_phone']) . '
          </td></tr></table> <br>';
        $secondPageHtml .= '<p style="text-align:center;font-size:16px;border-top:4px solid #89a2b9;border-bottom:4px solid #89a2b9;padding:3px 0 2px;margin:0"><b>' . $this->lang->line('vehicle_information') . '</b></p>';
        $secondPageHtml .= '<br><p style="font-size:14px;margin-left:10px;"><b>' . $estData['get_est_fullData']['vehicle_info']['vehicle_name'] . '</b></p> <br>';
        $secondPageHtml .= '<table style="font-size:12px;margin-left:10px;">
          <tr><td style="widht:30%;"><b>' . $this->lang->line('VIN') . ':</b> ' . $estData['get_est_fullData']['vehicle_info']['vin_number'] . '</td><td><b>' . $this->lang->line('PRODUCTION DATE') . ': </b> ' . $estData['get_est_fullData']['vehicle_info']['production_plate'] . '</td><td></td></tr>
          <tr><td style="widht:30%;"><b style="text-transform: uppercase;">' . $this->lang->line('License Plate') . ': </b>' . $estData['get_est_fullData']['vehicle_info']['license_plate'] . '</td><td><b>' . $this->lang->line('MILEAGE') . ': </b>' . $estData['get_est_fullData']['vehicle_info']['mileage'] . '</td><td><b>' . $this->lang->line('COLOR') . ': </b>' . $estData['get_est_fullData']['vehicle_info']['vehicle_color'] . '</td></tr>
          </table>';
        $secondPageHtml .= '';
        if (isset($estData['get_est_fullData']['vehicle_option']) && !empty($estData['get_est_fullData']['vehicle_option'])) {
          foreach ($estData['get_est_fullData']['vehicle_option'] as $vehicleOptionVal) {
  
            foreach ($vehicleOptionVal as $k => $v) {
              $flag = false;
              if (strstr($v, '<b>')) {
                $v = str_replace('<b>', '', $v);
                $v = str_replace('</b>', '', $v);
                $flag = true;
              }
              $ValueHandlerArray[] = $flag ? '<b style="padding:5px auto">' . $this->lang->line($v) . '</b>' : $this->lang->line($v);
            }
          }
  
          $loopCounter = ceil(count($ValueHandlerArray) / 4);
          $secondPageHtml .= '<p style="padding-bottom:2px;margin:0;margin-top:10px;text-align:center;font-size:16px;font-weight:900;border-bottom:4px solid #89a2b9;"></p>
          <br><table style="font-size:12px;padding-left:20px;"><tbody><tr>';
          
          for ($j = 0; $j <= 3; $j++) {
            $counter = $loopCounter * $j;
            $secondPageHtml .= '<td style="vertical-align:top;padding:5px auto;"><div>';
            for ($i = $counter; $i < ($loopCounter + $counter); $i++) {
              @$secondPageHtml .= '<table><tbody><tr><td style="padding-left:20px;">' . $ValueHandlerArray[$i] . '</td></tr> <tr>
              <td colspan="4" style="height: 5px"></td></tr></tbody></table>';
            }
            $secondPageHtml .= '</div></td>';
          }
          $secondPageHtml  .= '</tr></tbody></table>';
        }
  
  
        $html = str_replace('{SECOND_PAGE}', $secondPageHtml, $html);
  
        /////////////////////// Adding Estimate List ///////////////////
  
        $suplementNumber = '';
        $trDetails = '<div class="row" style="page-break-before: always;"><table class="table main-table" style="border-collapse: collapse;" cellpadding="0" cellspacing="0" width="100%;">
        <tr>
        <th style="padding: 5px 5px; text-align:left;float:left; font-weight: bold">' . $this->lang->line('Line') . '</th>
        <th style="padding: 5px 5px; text-align:left;float:left; font-weight: bold">' . $this->lang->line('Operation') . '</th>
        <th style="padding: 5px 5px; text-align:left;float:left; font-weight: bold"></th>
        <th style="padding: 5px 5px; text-align:left;float:left; font-weight: bold">' . $this->lang->line('Description') . '</th>
        <th style="padding: 5px 5px; text-align:left;float:left; font-weight: bold">' . $this->lang->line('Part Number') . '</th>
        <th style="padding: 5px 5px; text-align:left;float:left; font-weight: bold">' . $this->lang->line('Qty') . '</th>
        <th style="padding: 5px 5px; text-align:left;float:left; font-weight: bold">' . $this->lang->line('Price') . '</th>
        <th style="padding: 5px 5px; text-align:left;float:left; font-weight: bold">' . $this->lang->line('Labor') . '</th>
        <th style="padding: 5px 5px; text-align:left;float:left; font-weight: bold">' . $this->lang->line('Refinish') . '</th>
        <th style="padding: 5px 5px; text-align:left;float:left; font-weight: bold"></th>
        </tr>';
        $counterVal = 1;
        $holdTabName = array();
        $subletPartsListPrice = 0;
  
        // print_r($estData['get_est_fullData']);
        // exit;
  
        if (isset($estData['get_est_fullData']['part_info']) && !empty($estData['get_est_fullData']['part_info'])) {
          $underLineArray = $this->Muser->underline_keys($estID);
  
          $inclOverlapData = $this->Muser->get_incl_overlap_parts($estID);
          $refinishRuleData = $this->Muser->get_refinish_rule_data($estID);
          $refinishRuleAdjData = $this->Muser->get_refinish_adj_rule_data($estID);
  
          foreach ($estData['get_est_fullData']['part_info'] as $dData) {
            /*************************************/
            $suplementPassNext = '';
            $inclSublMessage = '';
            $refinishFormulaHtml = '';
            $refinishAdjFormulaHtml = '';
            if ((trim($dData['oper']) == 'Subl' || trim($dData['oper']) == 'Repl') && trim($dData['markup']) == 1) {
              $inclSublMessage = '<br><span class="font-size:8px;">+25%</span>';
            }
            if (isset($refinishRuleAdjData[$dData['id']])) {
              $roundRefinishRuleAdjData = ($refinishRuleAdjData[$dData['id']]['paint'] != 'INCL') ? round($refinishRuleAdjData[$dData['id']]['paint'], 1) : $refinishRuleAdjData[$dData['id']]['paint'];
              $refinishAdjFormulaHtml = '<tr><td></td><td></td><td></td>
              <td style="padding: 5px 5px; text-align:left;float:left;"><span>' . $this->lang_translate($refinishRuleAdjData[$dData['id']]['msg'], $userID) . '</span></td><td></td><td></td><td><span></span></td><td><span></span></td>
              <td style="padding: 5px 5px; text-align:left;float:left;"><span>' . $roundRefinishRuleAdjData . '</span></td></tr>';
            }
            if (isset($refinishRuleData[$dData['id']])) {
              $roundRefinishRuleData = ($refinishRuleData[$dData['id']]['paint'] != 'INCL') ? round($refinishRuleData[$dData['id']]['paint'], 1) : $refinishRuleData[$dData['id']]['paint'];
              $refinishFormulaHtml = '<tr><td></td><td></td><td></td>
              <td style="padding: 5px 5px; text-align:left;float:left;"><span>' . $this->lang_translate($refinishRuleData[$dData['id']]['msg'], $userID) . '</span></td><td></td><td></td><td><span></span></td><td><span></span></td>
              <td style="padding: 5px 5px; text-align:left;float:left;"><span>' . $roundRefinishRuleData . '</span></td></tr>';
            }
            /*************************************/
            $overlapDectionval = '';
            $inclMessage = '';
            $laborValNew = '';
            $extra = '';
            if (isset($dData['glass']) && $dData['glass'] != '' && $dData['glass'] != 0) {
              $laborValNew = $dData['glass'];
              $extra =  ' G';
            }
            if (isset($dData['structual']) && $dData['structual'] != '' && $dData['structual'] != 0) {
              $laborValNew = $dData['structual'];
              $extra =  ' S';
            }
            if (isset($dData['frame']) && $dData['frame'] != '' && $dData['frame'] != 0) {
              $laborValNew = $dData['frame'];
              $extra =  ' F';
            }
            if (isset($dData['user_1']) && $dData['user_1'] != '' && $dData['user_1'] != 0) {
              $laborValNew = $dData['user_1'];
              $extra =  ' A';
            }
            if (isset($dData['user_2']) && $dData['user_2'] != '' && $dData['user_2'] != 0) {
              $laborValNew = $dData['user_2'];
              $extra =  ' B';
            }
            if (isset($dData['user_3']) && $dData['user_3'] != '' && $dData['user_3'] != 0) {
              $laborValNew = $dData['user_3'];
              $extra =  ' C';
            }
            if (isset($dData['labor']) && $dData['labor'] != '' && $dData['labor'] != 0) {
              $laborValNew = $dData['labor'];
            }
            if (isset($dData['mech']) && $dData['mech'] != '' && $dData['mech'] != 0) {
              $laborValNew = $dData['mech'];
              $extra =  ' M';
            }
            if (isset($inclOverlapData['ids'])) {
              if (in_array($dData['id'], $inclOverlapData['ids'])) {
                if ($inclOverlapData['data'][$dData['id']]['mech'] != '') {
                  $overlapDectionval = '<br><span class="font-size:8px;"> -' . $inclOverlapData['data'][$dData['id']]['mech'] . ' M</span>';
                } else {
                  $laborValNew = 'INCL';
                }
                $inclMessage = '<br><span class="font-size:8px;">' . $this->lang_translate($inclOverlapData['data'][$dData['id']]['pdf_show_msg'], $userID) . '</span>';
              }
            }
            /*************************************/
            // $inclChecker = false;
  
            // if ($inclMessage) {
            //   if (str_contains($inclMessage, 'INCL')) {
            //     $inclArr = explode('INCL', $inclMessage);
            //     $restPart = implode(" ", $inclArr);
            //     $inclChecker = true;
            //     $inclMessage = '';
            //   } else {
            //     $inclMessage = '<br><span style="font-size:8px">' . $inclMessage . '</span>';
            //   }
            // }
  
            // commented on oct 6 2022 by shubham
            // if ($estData['get_est_fullData']['estimate_data']['is_supplement'] == 1 && $estData['get_est_fullData']['estimate_data']['estimate_id'] == $dData['estimate_id']) {
            //   $suplementPassNext = 'S' . $estData['get_est_fullData']['estimate_data']['supplement_number'];
            // } else
            if ($estData['get_est_fullData']['estimate_data']['is_supplement'] == 1) {
  
              $allSupplements = $this->db->order_by('estimate_id', 'DESC')->get_where('ca_estimates', array('parent_estimate_id' =>  $estData['get_est_fullData']['estimate_data']['parent_estimate_id'], 'is_supplement' => '1'))->result_array();
              // echo '<pre>';
              // print_r($allSupplements);
              // echo '<pre>';
              // die;
  
              foreach ($allSupplements as $all) {
                // echo $all['estimate_id'].' ';
                // die;
                $checkSup = $this->db->get_where('ca_estimate_select_parts_added', array('estimate_id' =>  $all['estimate_id'], 'part_id' => $dData['part_id']))->row_array();
                if (count($checkSup) > 0) {
                  $checkSup[0]['supplement_number'] = $all['supplement_number'];
                  break;
                }
                $checkSup = $this->db->get_where('ca_estimate_after_part_change', array('new_estimate_id' =>  $all['estimate_id'], 'part_id' => $dData['id']))->row_array();
                if (count($checkSup) > 0) {
                  $checkSup[0]['supplement_number'] = $all['supplement_number'];
                  break;
                }
              }
              // echo '<pre>';
              // print_r($checkSup);
              // echo '<pre>';
              // die;
  
              // die;
              if (count($checkSup) > 0) {
                $suplementPassNext = 'S' . $checkSup[0]['supplement_number'];
              }
  
  
              // die;
            }
            $suplementNumber = @$estData['get_est_fullData']['supplement_no'][$dData['estimate_id']];
            /*************************************/
            $laborLine = $nameLine = $priceLine = $paintLine = '';
            $showIcon = '';
            if (isset($underLineArray[$dData['id']]) && !empty($underLineArray[$dData['id']])) {
              $laborLine = (in_array('labor', $underLineArray[$dData['id']])) ? 'under-line' : '';
              $nameLine = (in_array('part_name', $underLineArray[$dData['id']])) ? 'under-line' : '';
              $priceLine = (in_array('list_price', $underLineArray[$dData['id']])) ? 'under-line' : '';
              $paintLine = (in_array('paint', $underLineArray[$dData['id']])) ? 'under-line' : '';
              $showIcon = '*';
            }
            /*************************************/
            $qty = '';
            if (trim($dData['oper']) == 'Repl' || trim($dData['oper']) == 'Subl') {
              $qty = $dData['qty'];
            }
  
            if (trim($dData['oper']) == 'Subl' && $dData['markup'] == 1) {
              $totalValPercent = ($dData['list_price'] * $dData['qty'] * 25) / 100; // Getting 25% for it
              $finalPartPrice = $dData['list_price'] * $dData['qty'] + $totalValPercent;
              $subletPartsListPrice += $finalPartPrice;
            } else {
              $finalPartPrice = $dData['list_price'] * $dData['qty'];
              if (trim($dData['oper']) == 'Subl') {
                $subletPartsListPrice += $finalPartPrice;
              }
            }
            $finalPartPrice = ($finalPartPrice != 0) ? $finalPartPrice : '';
            if (trim($dData['oper']) == 'Blnd') {
              $selectedPaintOption = $this->db->get_where('ca_estimate_vehicle_options', array('estimate_id' => $estID, 'cat_id' => 11))->result_array();
              $paintRefinishFormula = $selectedPaintOption[0]['part_id'];
              if ($paintRefinishFormula == 39 && $dData['paint'] != '' && $dData['paint'] != 0) {
                $finalPaintVal = ($dData['paint'] * 50) / 100;
              } elseif ($paintRefinishFormula == 102 && $dData['paint'] != '' && $dData['paint'] != 0) {
                $finalPaintVal = ($dData['paint'] * 70) / 100;
              } else {
                $finalPaintVal = ($dData['paint'] != 0) ? $dData['paint'] : '';
              }
            } else {
              $finalPaintVal = ($dData['paint'] != 0) ? $dData['paint'] : '';
            }
            /*************************************/
            // $dData['user_id'] = $userID;
            // $dData['part_name'] = $this->lang_translate($dData['part_name'], 915);
            // print_r($dData);
            // exit;
            if (!in_array($dData['tab_modify_name'], $holdTabName)) {
              array_push($holdTabName, $dData['tab_modify_name']);
              $TABNAME = ($dData['tab_modify_name'] != 'ZZ') ? $dData['tab_modify_name'] : '';
              $trDetails .= '<tr>
              <td style="padding: 5px 5px; text-align:left;float:left;" class="border-bttm"></td>
              <td class="border-bttm" style="padding: 5px 5px; text-align:left;float:left;"></td>
              <td class="border-bttm" style="padding: 5px 5px; text-align:left;float:left;"></td>
              <td class="border-bttm" style="padding: 5px 5px; text-align:left;float:left;"><b>' . $this->lang->line($TABNAME)  . '</b></td>
              <td class="border-bttm" style="padding: 5px 5px; text-align:left;float:left;"></td>
              <td class="border-bttm" style="padding: 5px 5px; text-align:left;float:left;"></td>
              <td class="border-bttm" style="padding: 5px 5px; text-align:left;float:left;"></td>
              <td class="border-bttm" style="padding: 5px 5px; text-align:left;float:left;"></td>
              <td class="border-bttm" style="padding: 5px 5px; text-align:left;float:left;"></td>
              <td class="border-bttm" style="padding: 5px 5px; text-align:left;float:left;"></td></tr>';
              $trDetails .= '<tr>
              <td style="padding: 5px 5px; text-align:left;float:left;">' . $counterVal . '</td>
              <td style="padding: 5px 5px; text-align:left;float:left;">' . $dData['oper'] . '</td>
              <td style="padding: 5px 5px; text-align:left;float:left;">' . $suplementPassNext . '</td>
              <td style="padding: 5px 5px; text-align:left;float:left;"><span class="' . $nameLine . '">' . $dData['note'] . ' ' . $this->lang_translate($dData['part_name'], $userID) . $this->lang_translate($inclSublMessage, $userID) . $this->lang_translate($inclMessage, $userID) . '</span></td>
              <td style="padding:5px 5px; text-align:left;float:left;">' . $dData['part_number'] . '</td>
              <td style="padding:5px 5px; text-align:left;float:left;">' . $qty . '</td>
              <td style="padding:5px 5px; text-align:left;float:left;"><span class="' . $priceLine . '">' . @number_format($finalPartPrice, 2) . '</span></td>
              <td style="padding:5px 5px; text-align:left;float:left;"><span class="' . $laborLine . '">' . ($laborValNew == "INCL" ? $laborValNew : @number_format($laborValNew, 1)) . $extra  . '</span></td>
              <td style="padding:5px 5px; text-align:left;float:left;"><span class="' . $paintLine . '">' . @number_format($finalPaintVal, 1) . '</span></td></tr>';
              // if ($inclChecker) {
              //   $trDetails .= '<tr><td></td><td></td><td></td><td><span class="font-size:8px;">' . $restPart . '</span></td><td></td><td></td><td></td><td>INCL</td><td></td></tr>';
              // }
            } else {
              $trDetails .= '<tr>
              <td style="padding: 5px 5px; text-align:left;float:left;">' . $counterVal . '</td>
              <td style="padding: 5px 5px; text-align:left;float:left;">' . $dData['oper'] . '</td>
              <td style="padding: 5px 5px; text-align:left;float:left;">' . $suplementPassNext . '</td>
              <td style="padding: 5px 5px; text-align:left;float:left;"><span class="' . $nameLine . '">' . $dData['note'] . ' ' . $this->lang_translate($dData['part_name'], $userID) . $this->lang_translate($inclSublMessage, $userID) . $this->lang_translate($inclMessage, $userID) . '</span></td>
              <td style="padding: 5px 5px; text-align:left;float:left;">' . $dData['part_number'] . '</td>
              <td style="padding: 5px 5px; text-align:left;float:left;">' . $qty . '</td>
              <td style="padding: 5px 5px; text-align:left;float:left;"><span class="' . $priceLine . '">' .  @number_format($finalPartPrice, 2) . '</span></td>
              <td style="padding: 5px 5px; text-align:left;float:left;"><span class="' . $laborLine . '">' . ($laborValNew == "INCL" ? $laborValNew : @number_format($laborValNew, 1)) . $extra  . '</span></td>
              <td style="padding: 5px 5px; text-align:left;float:left;"><span class="' . $paintLine . '">' . @number_format($finalPaintVal, 1) . '</span></td></tr>';
              // if ($inclChecker) {
              //   $trDetails .= '<tr><td></td><td></td><td></td><td><span class="font-size:8px;">' . $restPart . '</span></td><td></td><td></td><td></td><td>INCL</td><td></td></tr>';
              // }
            }
            $trDetails .= $refinishAdjFormulaHtml;
            $trDetails .= $refinishFormulaHtml;
            $counterVal++;
          }
          $trDetails .= '</table></div>';
          //$subTotalRow ='<tr><td class="end-table"></td><td class="end-table"></td><td class="end-table">SUBTOTALS</td><td class="end-table"></td><td class="end-table">'.$totalCost.'</td><td class="end-table">'.$totalLabor.'</td><td class="end-table">'.$totalPaint.'</td></tr>';
          $html = str_replace('{PART_LISTS}', $trDetails, $html);
          //$html = str_replace('{PART_SUBTOTALS}',$subTotalRow,$html);
        } else {
          $html = str_replace('{PART_LISTS}', '', $html);
          //$html = str_replace('{PART_SUBTOTALS}','',$html);
        }
  
  
  
        ////////////// Adding Final Calculation ////////////
        $netCostVal = 0;
        if (isset($estData['get_est_fullData']['part_info']) && !empty($estData['get_est_fullData']['part_info'])) {
          $finalReportData = $this->Muser->get_estimates_final_report($estID);
          $finalCal = '<div class="row" style="padding-bottom:5px;margin-bottom:40px;margin-top:20px;border-bottom:4px solid #89a2b9;clear:both;"></div><div style="margin-right:10px;margin-left:15px;margin-top:0px"><div class="new-break"><br><p style="color:#000;font-size:19px;margin-bottom:15px;font-family: "Arial", sans-serif;">' . $this->lang->line('ESTIMATE TOTALS') . ':  </p>';
          if (isset($finalReportData) && !empty($finalReportData)) {
  
            if ($estData['get_est_fullData']['estimate_data']['deductive_amount']) {
              $deductibleAmt =   $estData['get_est_fullData']['estimate_data']['deductive_amount'];
            } else {
              $deductibleAmt = 0;
            }
  
            $netCostVal = $finalReportData["total_cost_repairs"] - $deductibleAmt;
            $totalBLabor = $finalReportData["body_labor"] * $finalReportData["body_labor_rate"];
            $totalPLabor = $finalReportData["paint_labor"] * $finalReportData["paint_labor_rate"];
            $totalPSLabor = $finalReportData["paint_supplies"] * $finalReportData["paint_supplies_rate"];
            $totalMLabor = $finalReportData["mechanical_labor"] * $finalReportData["mechanical_labor_rate"];
            $totalFLabor = $finalReportData["frame_labor"] * $finalReportData["frame_labor_rate"];
            $totalSLabor = $finalReportData["structual_labor"] * $finalReportData["structual_labor_rate"];
            $totalGLabor = $finalReportData["glass_labor"] * $finalReportData["glass_labor_rate"];
            $totalU1Labor = $finalReportData["user_1"] * $finalReportData["user_1_rate"];
            $totalU2Labor = $finalReportData["user_2"] * $finalReportData["user_2_rate"];
            $totalU3Labor = $finalReportData["user_3"] * $finalReportData["user_3_rate"];
            $salesTaxCal = ($finalReportData["sales_tax"] * $finalReportData["sales_tax_percent"]) / 100;
            $finalCal .=   '<p style="padding:6px auto;font-family: "Arial", sans-serif;">' . $this->lang->line('body_labor') . ': ' . @number_format($finalReportData["body_labor"], 2) . ' hrs @ ' . $this->get_currency_data('default_currency_symbol', $userID) . @number_format($finalReportData["body_labor_rate"]*$currency_val , 2) . ' /hr: &nbsp;&nbsp;' .$this->get_currency_data('default_currency_symbol', $userID). @number_format($totalBLabor*$currency_val, 2) . '</p>
                         <p style="padding:6px auto; font-family: "Arial", sans-serif;">' . $this->lang->line('Paint Labor') . ': ' . @number_format($finalReportData["paint_labor"], 2) . ' hrs @ ' . $this->get_currency_data('default_currency_symbol', $userID) . @number_format($finalReportData["paint_labor_rate"]*$currency_val , 2) . ' /hr: &nbsp;&nbsp;' .$this->get_currency_data('default_currency_symbol', $userID). @number_format($totalPLabor*$currency_val, 2) . '</p>
                         <p style="padding:6px auto; font-family: "Arial", sans-serif;">' . $this->lang->line('Mechanical Labor') . ': ' . @number_format($finalReportData["mechanical_labor"], 2) . ' hrs @ ' . $this->get_currency_data('default_currency_symbol', $userID) . @number_format($finalReportData["mechanical_labor_rate"]*$currency_val , 2) . ' /hr: &nbsp;&nbsp;' .$this->get_currency_data('default_currency_symbol', $userID). @number_format($totalMLabor*$currency_val , 2) . '</p>
                         <p style="padding:6px auto; font-family: "Arial", sans-serif;">' . $this->lang->line('Frame Labor') . ': ' . @number_format($finalReportData["frame_labor"], 2) . ' hrs @ ' . $this->get_currency_data('default_currency_symbol', $userID) . @number_format($finalReportData["frame_labor_rate"]*$currency_val, 2) . ' /hr: &nbsp;&nbsp;' .$this->get_currency_data('default_currency_symbol', $userID). @number_format($totalFLabor*$currency_val, 2) . '</p>
                         <p style="padding:6px auto; font-family: "Arial", sans-serif;">' . $this->lang->line('Structual Labor') . ': ' . @number_format($finalReportData["structual_labor"], 2) . ' hrs @ ' . $this->get_currency_data('default_currency_symbol', $userID) . @number_format($finalReportData["structual_labor_rate"]*$currency_val, 2) . ' /hr: &nbsp;&nbsp;' .$this->get_currency_data('default_currency_symbol', $userID). @number_format($totalSLabor*$currency_val , 2) . '</p>
                         <p style="padding:6px auto; font-family: "Arial", sans-serif;">' . $this->lang->line('Glass Labor') . ': ' . @number_format($finalReportData["glass_labor"], 2) . ' hrs @ ' . $this->get_currency_data('default_currency_symbol', $userID) . @number_format($finalReportData["glass_labor_rate"]*$currency_val , 2) . ' /hr: &nbsp;&nbsp;' .$this->get_currency_data('default_currency_symbol', $userID). @number_format($totalGLabor*$currency_val , 2) . '</p>
  
                         <p style="padding:6px auto; font-family: "Arial", sans-serif;">' . ($days_to_repair_value[0]['userdefined1_head'] ? $days_to_repair_value[0]['userdefined1_head'] : $this->lang->line('user_defined') . ' A') . ': ' . @number_format($finalReportData["user_1"], 2) . ' hrs @ ' . $this->get_currency_data('default_currency_symbol', $userID) . @number_format($finalReportData["user_1_rate"]*$currency_val , 2) . ' /hr: &nbsp;&nbsp;' .$this->get_currency_data('default_currency_symbol', $userID). @number_format($totalU1Labor*$currency_val , 2) . '</p>
                         <p style="padding:6px auto; font-family: "Arial", sans-serif;">' . ($days_to_repair_value[0]['userdefined2_head'] ? $days_to_repair_value[0]['userdefined2_head'] : $this->lang->line('user_defined') . ' B') . ': ' . @number_format($finalReportData["user_2"], 2) . ' hrs @ ' . $this->get_currency_data('default_currency_symbol', $userID) . @number_format($finalReportData["user_2_rate"]*$currency_val , 2) . ' /hr: &nbsp;&nbsp;' .$this->get_currency_data('default_currency_symbol', $userID). @number_format($totalU2Labor*$currency_val , 2) . '</p>
                         <p style="padding:6px auto; font-family: "Arial", sans-serif;">' . ($days_to_repair_value[0]['userdefined3_head'] ? $days_to_repair_value[0]['userdefined3_head'] : $this->lang->line('user_defined') . ' C') . ': ' . @number_format($finalReportData["user_3"], 2) . ' hrs @ ' . $this->get_currency_data('default_currency_symbol', $userID) . @number_format($finalReportData["user_3_rate"]*$currency_val , 2) . ' /hr: &nbsp;&nbsp;' .$this->get_currency_data('default_currency_symbol', $userID). @number_format($totalU3Labor*$currency_val , 2) . '</p>
  
                         <p style="padding:6px auto; font-family: "Arial", sans-serif;">' . $this->lang->line('Paint Supplies') . ': ' . @number_format($finalReportData["paint_supplies"], 2) . ' hrs @ ' . $this->get_currency_data('default_currency_symbol', $userID) . @number_format($finalReportData["paint_supplies_rate"]*$currency_val, 2) . ' /hr: &nbsp;&nbsp;' .$this->get_currency_data('default_currency_symbol', $userID). @number_format($totalPSLabor*$currency_val, 2) . '</p>
                         <p style="padding:6px auto; font-family: "Arial", sans-serif;">' . $this->lang->line('Parts') . ': ' . $this->get_currency_data('default_currency_symbol', $userID) . @number_format(($finalReportData["parts"] - $subletPartsListPrice)*$currency_val , 2) . '</p>
                         <p style="padding:6px auto; font-family: "Arial", sans-serif;">' . $this->lang->line('Sublet') . ': ' . $this->get_currency_data('default_currency_symbol', $userID) . @number_format($subletPartsListPrice , 2)*$currency_val . '</p>
                         <p style="padding:6px auto; font-family: "Arial", sans-serif;">' . $this->lang->line('Subtotal') . ': ' . $this->get_currency_data('default_currency_symbol', $userID) . @number_format(($finalReportData["parts"] + $totalU3Labor + $totalU2Labor + $totalU1Labor + $totalBLabor + $totalPLabor + $totalMLabor + $totalFLabor + $totalSLabor + $totalGLabor + $totalPSLabor)*$currency_val, 2) . ' </p>
                         <p style="padding:6px auto; font-family: "Arial", sans-serif;">' . $this->lang->line('Sales Tax') . ': ' . $this->get_currency_data('default_currency_symbol', $userID) . @number_format($finalReportData["sales_tax"]*$currency_val, 2) . ' @' . @number_format($finalReportData["sales_tax_percent"],2) . '% &nbsp;&nbsp;' . $this->get_currency_data('default_currency_symbol', $userID) . @number_format($salesTaxCal*$currency_val , 2) . '</p>
                         <p style="padding:6px auto; font-family: "Arial", sans-serif;">' . $this->lang->line('Total Cost of Repairs') . ': ' . $this->get_currency_data('default_currency_symbol', $userID) . @number_format($finalReportData["total_cost_repairs"]*$currency_val , 2) . ' </p>
                         <p style="padding:6px auto; font-family: "Arial", sans-serif;">' . $this->lang->line('Deductible') . ': ' . $this->get_currency_data('default_currency_symbol', $userID) . @number_format($deductibleAmt , 2) . '</p>
                         <br><p style="color:#000;font-size:18px;margin-top:-4px">' . $this->lang->line('Net Cost of Repairs') . ': ' . $this->get_currency_data('default_currency_symbol', $userID) . @number_format($netCostVal*$currency_val , 2) . ' </p><br>';
            $finalCal .= '</div></div>';
          }
          $html = str_replace('{FINAL_CALCULATION}', $finalCal, $html);
        } else {
          $html = str_replace('{FINAL_CALCULATION}', '', $html);
        }
  
        /////////////////// Adding New Content In the Pdf /////////////////
  
  
        if (isset($estData['get_est_fullData']['part_info']) && !empty($estData['get_est_fullData']['part_info'])) {
          $newContent = '<div class="new-break-1" style="font-size:12px;font-family:helvetica;margin-top:60px;padding-right:15px;margin-left:15px;">
                          <br>
                          <p style="font-size:15px; font-family: "Arial", sans-serif;"><b>' . $this->lang->line('Terms & Abbreviations') . '</b></p> <br>
                         <p style="padding:5px auto font-family: "Arial", sans-serif;"><u><strong>' . $this->lang->line('Underlined') . '</strong></u> ' . $this->lang->line('items indicate item has been manually changed') . '.</p><br>
                          <p style="padding:5px auto font-family: "Arial", sans-serif;"><strong>OEM:</strong> ' . $this->lang->line('Indicates') . ' <strong></strong>' . $this->lang->line('Original') . ' <strong></strong>' . $this->lang->line('Equipment') . ' <strong></strong>' . $this->lang->line('Manufacturer') . '. ' . $this->lang->line('This is a brand new part from the dealership') . '.</p><br>
                          <p style="padding:5px auto font-family: "Arial", sans-serif;"><strong>A/M:</strong> ' . $this->lang->line('Indicates_an_aftermarket') . '.</p><br>
                          <p style="padding:5px auto font-family: "Arial", sans-serif;"><strong>LKQ:</strong> ' . $this->lang->line('Indicates') . ' <strong></strong>' . $this->lang->line('Like') . ' <strong></strong>' . $this->lang->line('Kind') . ' <strong></strong>' . $this->lang->line('Quality') . '. ' . $this->lang->line('Typically this is another term for a used/salvage OEM part') . '.</p><br>
                          <p style="padding:5px auto font-family: "Arial", sans-serif;"><strong>' . $this->lang->line('RECOND') . ':</strong> ' . $this->lang->line('Indicates_a_reconditioned') . '.</p><br>
                          <p style="padding:5px auto font-family: "Arial", sans-serif;"><strong>' . $this->lang->line('LABOR CODES') . ':</strong> ' . $this->lang->line('M_indicates_Mechanical') . '.</p><br>
                          <p style="padding:5px auto font-family: "Arial", sans-serif;"><strong>' . $this->lang->line('LABOR ABBREVIATIONS') . ':</strong> ' . $this->lang->line('RI_is_Remove') . '.</p><br>
                          <p style="padding:5px auto font-family: "Arial", sans-serif;">' . $this->lang->line('Quicksheet Mobile Collision Estimator is a product of') . ' EZ-DV,LLC.</p><br>
                          <p style="padding:5px auto font-family: "Arial", sans-serif;">© ' . date('Y') . ' EZ-DV, LLC. ' . $this->lang->line('All Rights Reserved') . '</p>
                          <br><br>
                         </div>';
  
          $newContent .= '<table style="font-size:12px; margin-left:50px; margin-right: 20px;"><tr>';
          $newContent .= '<td style="vertical-align:top;" colspan="2"><ul style="list-style-type: none;">';
          ///$newContent .=  "<br><br><br> <p><strong><span style='margin-bottom:5px'> '.$this->lang->line('Work Authorization').': </span><br>'.$this->lang->line('I hereby authorize').'<br> '.$this->lang->line('this written estimate').' <br>'.$this->lang->line('further inspection additional').' .<br/><br/> </strong></p>";
          ///$newContent .=  "<br><br><br> <p><strong><span style='margin-bottom:5px'> '.$this->lang->line('Work Authorization').' : </span><br> '.$this->lang->line('I hereby authorize').' <br> '.$this->lang->line('this written estimate').' <br> '.$this->lang->line('further inspection additional').' <br/><br/> </strong></p>";
          ///$newContent .=  "  <br><br><br> <p><strong><span style='margin-bottom:5px'> '. $this->lang->line('Work Authorization') .' : </span><br> '. $this->lang->line('I hereby authorize') .' <br> '. $this->lang->line('this written estimate').' <br>'. $this->lang->line('further inspection additional').' .<br/><br/> </strong></p>";
  
  
          $newContent .=  '<br><br><br> <p><strong><span style="margin-bottom:5px"> ' . $this->lang->line('Work Authorization') . ':</span><br>'.$this->lang->line('I hereby authorize this repair').'.<br/><br/> </strong></p>';
  
          $newContent .= '</ul></td></tr>';
  
          $newContent .=  '<tr><td colspan="5" style="padding-top:40px;"></td></tr><tr><td style="vertical-align:top;"><ul style="list-style-type: none;">     <b>X______________________________  </b>                </td> </ul><td style="vertical-align:top;"><ul style="list-style-type: none;">   <b>_________________________  </b>                 </td> </ul>    </tr>';
  
  
          $newContent .=  '<tr><td colspan="5" style="padding-top:40px;"></td></tr><tr><td style="vertical-align:top;"><ul style="list-style-type: none;"> <b>' . $this->lang->line('Signature of Vehicle Owner') . '</b></td> </ul><td style="vertical-align:top;"><ul style="list-style-type: none;"><b>' . $this->lang->line('Date') . '</b></td> </ul></tr>';
  
  
          $newContent  .= '</table><br><br>';
  
  
  
          $html = str_replace('{CONTENT_MSG}', $newContent, $html);
        } else {
          $html = str_replace('{CONTENT_MSG}', '', $html);
        }
  
        ////////////////// Adding Supplement Summary ///////////////////////
  
        if ($estData['get_est_fullData']['estimate_data']['is_supplement'] == 1) {
          $holdTabName = array();
          $finalSupReportData = $this->Muser->get_supplement_summary($estID);
          $finalCal = '';
          $supplementHtml = '';
          $subletPartsListPrice1 = 0;
          // if (isset($finalSupReportData['part_info_sup']) && !empty($finalSupReportData['part_info_sup'])) {
          $underLineArray1 = $this->Muser->underline_keys($estID);
          $refinishRuleData1 = $this->Muser->get_refinish_rule_data($estID);
          $refinishRuleAdjData1 = $this->Muser->get_refinish_adj_rule_data($estID);
          $inclOverlapData1 = $finalSupReportData['overlap_sup'];
          $suplementPassNext = $estData['get_est_fullData']['estimate_data']['supplement_number'];
          // if (isset($finalSupReportData['part_info_sup']) && !empty($finalSupReportData['part_info_sup'])) {
          //   $supplementHtml = '<br><br><p style="page-break-before: always;text-align:center;font-size:16px;"><b>SUPPLEMENT SUMMARY</b></p><table class="table" cellpadding="0" cellspacing="0" ><tr class="border_bottom">
          //     <th>Line</th><th>Operation</th><th></th><th>Description</th><th>Part Number</th><th>Qty</th><th>Price</th><th>Labor</th><th>Refinish</th></tr>';
          //   foreach ($finalSupReportData['part_info_sup'] as $dData) {
          //     $overlapDectionval = '';
          //     $inclMessage = '';
          //     $refinishFormulaHtml1 = '';
          //     $refinishAdjFormulaHtml1 = '';
          //     $inclSublMessage1 = '';
          //     $dPaintValu = ($dData['paint'] != 0) ? $dData['paint'] : '';
          //     $dListPriceValu = ($dData['list_price'] != 0) ? $dData['list_price'] : '';
          //     //$laborValNew = $dData['labor'];
          //     $laborValNew = '';
          //     if (isset($dData['glass']) && $dData['glass'] != '' && $dData['glass'] != 0) {
          //       $laborValNew = $dData['glass'];
          //     }
          //     if (isset($dData['structual']) && $dData['structual'] != '' && $dData['structual'] != 0) {
          //       $laborValNew = $dData['structual'];
          //     }
          //     if (isset($dData['frame']) && $dData['frame'] != '' && $dData['frame'] != 0) {
          //       $laborValNew = $dData['frame'];
          //     }
          //     if (isset($dData['labor']) && $dData['labor'] != '' && $dData['labor'] != 0) {
          //       $laborValNew = $dData['labor'];
          //     }
          //     if (isset($inclOverlapData1['ids'])) {
          //       if (in_array($dData['id'], $inclOverlapData1['ids'])) {
          //         if ($inclOverlapData1['data'][$dData['id']]['mech'] != '') {
          //           $overlapDectionval = '<br><span class="font-size:8px;"> -' . $inclOverlapData1['data'][$dData['id']]['mech'] . ' M</span>';
          //         } else {
          //           $laborValNew = 'INCL';
          //         }
          //         $inclMessage = '<br><span class="font-size:8px;">' . $inclOverlapData1['data'][$dData['id']]['pdf_show_msg'] . '</span>';
          //       }
          //     }
          //     if ((trim($dData['oper']) == 'Subl' || trim($dData['oper']) == 'Repl') && trim($dData['markup']) == 1) {
          //       $inclSublMessage1 = '<br><span class="font-size:8px;">+25%</span>';
          //     }
          //     if (isset($refinishRuleAdjData1[$dData['id']])) {
          //       $roundRefinishRuleAdjData1 = ($refinishRuleAdjData1[$dData['id']]['paint'] != 'INCL') ? round($refinishRuleAdjData1[$dData['id']]['paint'], 1) : $refinishRuleAdjData1[$dData['id']]['paint'];
          //       $refinishAdjFormulaHtml1 = '<tr><td></td><td></td><td></td><td><span>' . $refinishRuleAdjData1[$dData['id']]['msg'] . '</span></td><td></td><td></td><td></td><td><span></span></td><td><span>' . $roundRefinishRuleAdjData1 . '</span></td></tr>';
          //     }
          //     if (isset($refinishRuleData1[$dData['id']])) {
          //       $roundRefinishRuleData1 = ($refinishRuleData1[$dData['id']]['paint'] != 'INCL') ? round($refinishRuleData1[$dData['id']]['paint'], 1) : $refinishRuleData1[$dData['id']]['paint'];
          //       $refinishFormulaHtml1 = '<tr><td></td><td></td><td></td><td><span>' . $refinishRuleData1[$dData['id']]['msg'] . '</span></td><td></td><td></td><td></td><td><span></span></td><td><span>' . $roundRefinishRuleData1 . '</span></td></tr>';
          //     }
          //     $laborLine = $nameLine = $priceLine = $paintLine = '';
          //     $showIcon = '';
          //     if (isset($underLineArray1[$dData['id']]) && !empty($underLineArray1[$dData['id']])) {
          //       $laborLine = (in_array('labor', $underLineArray1[$dData['id']])) ? 'under-line' : '';
          //       $nameLine =  (in_array('part_name', $underLineArray1[$dData['id']])) ? 'under-line' : '';
          //       $priceLine = (in_array('list_price', $underLineArray1[$dData['id']])) ? 'under-line' : '';
          //       $paintLine = (in_array('paint', $underLineArray1[$dData['id']])) ? 'under-line' : '';
          //       $showIcon = '*';
          //     }
          //     /*************************************/
          //     $qty1 = '';
          //     if (trim($dData['oper']) == 'Repl' || trim($dData['oper']) == 'Subl') {
          //       $qty1 = $dData['qty'];
          //     }
          //     if (trim($dData['oper']) == 'Subl' && $dData['markup'] == 1) {
          //       $totalValPercent = ($dData['list_price'] * $dData['qty'] * 25) / 100; // Getting 25% for it
          //       $finalPartPrice1 = $dData['list_price'] * $dData['qty'] + $totalValPercent;
          //       $subletPartsListPrice1 += $finalPartPrice1;
          //     } else {
          //       $finalPartPrice1 = $dData['list_price'] * $dData['qty'];
          //       if (trim($dData['oper']) == 'Subl') {
          //         $subletPartsListPrice1 += $finalPartPrice1;
          //       }
          //     }
          //     $finalPartPrice1 = ($finalPartPrice1 != 0) ? $finalPartPrice1 : '';
          //     if (trim($dData['oper']) == 'Blnd') {
          //       $selectedPaintOption1 = $this->db->get_where('ca_estimate_vehicle_options', array('estimate_id' => $estID, 'cat_id' => 11))->result_array();
          //       $paintRefinishFormula1 = $selectedPaintOption1[0]['part_id'];
          //       if ($paintRefinishFormula1 == 39 && $dData['paint'] != '' && $dData['paint'] != 0) {
          //         $finalPaintVal1 = ($dData['paint'] * 50) / 100;
          //       } elseif ($paintRefinishFormula1 == 102 && $dData['paint'] != '' && $dData['paint'] != 0) {
          //         $finalPaintVal1 = ($dData['paint'] * 70) / 100;
          //       } else {
          //         $finalPaintVal1 = ($dData['paint'] != 0) ? $dData['paint'] : '';
          //       }
          //     } else {
          //       $finalPaintVal1 = ($dData['paint'] != 0) ? $dData['paint'] : '';
          //     }
          //     /*************************************/
          //     if (!in_array($dData['tab_modify_name'], $holdTabName)) {
          //       array_push($holdTabName, $dData['tab_modify_name']);
          //       $tabnameSup = ($dData['tab_modify_name'] != 'ZZ') ? $dData['tab_modify_name'] : '';
          //       $supplementHtml .= '<tr><td class="border-bttm"></td><td class="border-bttm"></td><td class="border-bttm"></td><td class="border-bttm"><b>' . $tabnameSup . '</b></td><td class="border-bttm"></td><td class="border-bttm"></td><td class="border-bttm"></td><td class="border-bttm"></td><td class="border-bttm"></td></tr>';
          //       $supplementHtml .= '<tr><td>' . $counterVal . '</td><td>' . $dData['oper'] . '</td><td>' . $suplementPassNext . '</td><td><span class="' . $nameLine . '">' . $dData['note'] . ' ' . $dData['part_name'] . $inclSublMessage1 . $inclMessage . '</span></td><td>' . $dData['part_number'] . '</td><td>' . $qty1 . '</td><td><span class="' . $priceLine . '">' . $finalPartPrice1 . '</span></td><td><span class="' . $laborLine . '">' . $laborValNew . $overlapDectionval . '</span></td><td><span class="' . $paintLine . '">' . $finalPaintVal1 . '</span></td></tr>';
          //     } else {
          //       $supplementHtml .= '<tr><td>' . $counterVal . '</td><td>' . $dData['oper'] . '</td><td>' . $suplementPassNext . '</td><td><span class="' . $nameLine . '">' . $dData['note'] . ' ' . $dData['part_name'] . $inclSublMessage1 . $inclMessage . '</span></td><td>' . $dData['part_number'] . '</td><td>' . $qty1 . '</td><td><span class="' . $priceLine . '">' . $finalPartPrice1 . '</span></td><td><span class="' . $laborLine . '">' . $laborValNew . $overlapDectionval . '</span></td><td><span class="' . $paintLine . '">' . $finalPaintVal1 . '</span></td></tr>';
          //     }
          //     $supplementHtml .= $refinishAdjFormulaHtml1;
          //     $supplementHtml .= $refinishFormulaHtml1;
          //     $counterVal++;
          //   }
          //   $supplementHtml .= '<table/>';
          // }
  
          //08 july deleted item
          // if (!isset($finalSupReportData['part_info_sup']) || empty($finalSupReportData['part_info_sup'])) {
          $supplementHtml = '<br><br><p style="page-break-before: always;text-align:center;font-size:16px;"><b>' . $this->lang->line('SUPPLEMENT SUMMARY') . '</b></p>';
          // }
          $cont = 1;
  
          if (isset($changeditem) && !empty($changeditem)) {
  
            $supplementHtml .= '<h4 style="margin-top:20px;margin-bottom:8px">' . $this->lang->line('Changed Items') . '</h4>';
            $supplementHtml .=   '     <table class="table" style="border-collapse: collapse;width:100%;" cellpadding="0" cellspacing="0">
              <tr style="font-size:12px;border-bottom:4px solid #89a2b9;border-top:4px solid #89a2b9;padding:5px 0">
              <th style="padding: 5px 5px; text-align:left;float:left; font-weight: bold">' . $this->lang->line('Line') . '</th>
              <th style="padding: 5px 5px; text-align:left;float:left; font-weight: bold">' . $this->lang->line('Operation') . '</th>
              <th style="padding: 5px 5px; text-align:left;float:left; font-weight: bold">' . $this->lang->line('Description') . '</th>
              <th style="padding: 5px 5px; text-align:left;float:left; font-weight: bold">' . $this->lang->line('Part Number') . '</th>
              <th style="padding: 5px 5px; text-align:left;float:left; font-weight: bold">' . $this->lang->line('Qty') . '</th>
              <th style="padding: 5px 5px; text-align:left;float:left; font-weight: bold">' . $this->lang->line('Price') . '</th>
              <th style="padding: 5px 5px; text-align:left;float:left; font-weight: bold">' . $this->lang->line('Labor') . '</th>
              <th style="padding: 5px 5px; text-align:left;float:left; font-weight: bold">' . $this->lang->line('Refinish') . '</th>
              </tr>';
  
  
  
            foreach ($changeditem as $pinfo) {
              if (isset($underLineArray[$pinfo['id']]) && !empty($underLineArray[$pinfo['id']])) {
                $laborLine = (in_array('labor', $underLineArray[$pinfo['id']])) ? 'under-line' : '';
                $nameLine = (in_array('part_name', $underLineArray[$pinfo['id']])) ? 'under-line' : '';
                $priceLine = (in_array('list_price', $underLineArray[$pinfo['id']])) ? 'under-line' : '';
                $paintLine = (in_array('paint', $underLineArray[$pinfo['id']])) ? 'under-line' : '';
                $showIcon = '*';
              }
              $extraStr = '';
              $laborValNew = null;
              $csuplementPassNext = '';
              $allSupplements = $this->db->order_by('estimate_id', 'DESC')->get_where('ca_estimates', array('parent_estimate_id' =>  $estData['get_est_fullData']['estimate_data']['parent_estimate_id'], 'is_supplement' => '1'))->result_array();
              // echo '<pre>';
              // print_r($allSupplements);
              // echo '<pre>';
              // die;
  
              foreach ($allSupplements as $all) {
                // echo $all['estimate_id'].' ';
                // die;
                // $checkSup = $this->db->get_where('ca_estimate_select_parts_added', array('estimate_id' =>  $all['estimate_id'], 'part_id' => $dData['part_id']))->row_array();
                // if (count($checkSup) > 0) {
                //   $checkSup[0]['supplement_number'] = $all['supplement_number'];
                //   break;
                // }
                $checkSup = $this->db->get_where('ca_estimate_after_part_change', array('new_estimate_id' =>  $all['estimate_id'], 'part_id' => $pinfo['id']))->row_array();
                if (count($checkSup) > 0) {
                  $checkSup[0]['supplement_number'] = $all['supplement_number'];
                  break;
                }
              }
  
              if (count($checkSup) > 0) {
                $csuplementPassNext = 'S' . $checkSup[0]['supplement_number'];
              }
  
              if (isset($pinfo['glass']) && $pinfo['glass'] != '' && $pinfo['glass'] != 0) {
                $extraStr = ' G';
                $laborValNew = $pinfo['glass'];
              }
              if (isset($pinfo['structual']) && $pinfo['structual'] != '' && $pinfo['structual'] != 0) {
                $laborValNew = $pinfo['structual'];
                $extraStr = ' S';
              }
              if (isset($pinfo['frame']) && $pinfo['frame'] != '' && $pinfo['frame'] != 0) {
                $extraStr = ' F';
                $laborValNew = $pinfo['frame'];
              }
              if (isset($pinfo['user_1']) && $pinfo['user_1'] != '' && $pinfo['user_1'] != 0) {
                $extraStr = ' A';
                $laborValNew = $pinfo['user_1'];
              }
              if (isset($pinfo['user_2']) && $pinfo['user_2'] != '' && $pinfo['user_2'] != 0) {
                $extraStr = ' B';
                $laborValNew = $pinfo['user_2'];
              }
              if (isset($pinfo['user_3']) && $pinfo['user_3'] != '' && $pinfo['user_3'] != 0) {
                $extraStr = ' C';
                $laborValNew = $pinfo['user_3'];
              }
              if (isset($pinfo['labor']) && $pinfo['labor'] != '' && $pinfo['labor'] != 0) {
                $laborValNew = $pinfo['labor'];
                $extraStr = '';
              }
  
              $supplementHtml .=   '<tr style="font-size:12px">';
              $supplementHtml .= '<td class="border-bttm" style="padding:5px 5px" scope="row">' . $cont . '</td>';
              $supplementHtml .= '<td class="border-bttm" style="padding:5px 5px">' . $pinfo['oper'] . '</td>';
              $supplementHtml .= '<td class="border-bttm" style="padding:5px 5px"><span class=' . $nameLine . '>' . ($csuplementPassNext ? $csuplementPassNext . ' ' : '') . $this->lang_translate($pinfo['part_name'], $userID) . '</span></td>';
              $supplementHtml .= '<td class="border-bttm" style="padding:5px 5px">' . $pinfo['part_number'] . '</td>';
              $supplementHtml .= '<td class="border-bttm" style="padding:5px 5px">';
              if (strtolower(trim($pinfo['oper'])) == 'repl' || strtolower(trim($pinfo['oper'])) == 'subl') {
                $supplementHtml .=  $pinfo['qty'];
              } else {
                $supplementHtml .= '<p class="pl-3">' . $pinfo['qty'] . '</p>';
              }
              $supplementHtml .= '</td>';
              if (($pinfo['oper'] == "Rpr" || $pinfo['oper'] == "Ref") && !$pinfo['list_price']) {
                $pinfo['list_price'] = null;
                $priceLine = '';
              } else {
                $pinfo['list_price'] = @number_format($pinfo['list_price'], 2);
              }
              if ($pinfo['oper'] == "Ref" && !$laborValNew) {
                $laborValNew = null;
                $laborLine = '';
              } else {
                $laborValNew = @number_format($laborValNew, 1);
              }
              $supplementHtml .= '<td class="border-bttm" style="padding:5px 5px"><span class=' . $priceLine . '>' . $pinfo['list_price'] . '</span></td>';
              $supplementHtml .= '<td class="border-bttm" style="padding:5px 5px"><span class=' . $laborLine . '>' . $laborValNew . $extraStr . '</span></td>';
              $supplementHtml .= '<td class="border-bttm" style="padding:5px 5px"><span class=' . $showIcon . '>' . @number_format($pinfo['paint'], 1) . '</span></td>';
              $supplementHtml .= '</tr>';
              $cont++;
            }
  
            $supplementHtml .=   '</table>';
          }
  
  
  
  
  
  
  
          if (isset($deleteditem) && !empty($deleteditem)) {
            $supplementHtml .= '<h4 style="margin-bottom:8px">Deleted Items</h4>';
            $supplementHtml .=   '<table class="table" style="border-collapse: collapse;width:100%;" cellpadding="0" cellspacing="0">
              <tr style="font-size:12px;border-bottom:4px solid #89a2b9;border-top:4px solid #89a2b9;padding:5px 0">
              <th style="padding: 5px 5px; text-align:left;float:left; font-weight: bold">' . $this->lang->line('Line') . '</th>
              <th style="padding: 5px 5px; text-align:left;float:left; font-weight: bold">' . $this->lang->line('Operation') . '</th>
              <th style="padding: 5px 5px; text-align:left;float:left; font-weight: bold">' . $this->lang->line('Description') . '</th>
              <th style="padding: 5px 5px; text-align:left;float:left; font-weight: bold">' . $this->lang->line('Part Number') . '</th>
              <th style="padding: 5px 5px; text-align:left;float:left; font-weight: bold">' . $this->lang->line('Qty') . '</th>
              <th style="padding: 5px 5px; text-align:left;float:left; font-weight: bold">' . $this->lang->line('Price') . '</th>
              <th style="padding: 5px 5px; text-align:left;float:left; font-weight: bold">' . $this->lang->line('Labor') . '</th>
              <th style="padding: 5px 5px; text-align:left;float:left; font-weight: bold">' . $this->lang->line('Refinish') . '</th>
              </tr>';
            foreach ($deleteditem as $pinfo) {
              if (isset($underLineArray[$pinfo['id']]) && !empty($underLineArray[$pinfo['id']])) {
                $laborLine = (in_array('labor', $underLineArray[$pinfo['id']])) ? 'under-line' : '';
                $nameLine = (in_array('part_name', $underLineArray[$pinfo['id']])) ? 'under-line' : '';
                $priceLine = (in_array('list_price', $underLineArray[$pinfo['id']])) ? 'under-line' : '';
                $paintLine = (in_array('paint', $underLineArray[$pinfo['id']])) ? 'under-line' : '';
                $showIcon = '*';
              }
              $csuplementPassNext = '';
              foreach ($allSupplements as $all) {
                // echo $all['estimate_id'].' ';
                // die;
                $checkSup = $this->db->get_where('ca_estimate_select_parts_deleted', array('estimate_id' =>  $all['estimate_id'], 'part_id' => $pinfo['part_id']))->row_array();
                if (count($checkSup) > 0) {
                  $checkSup[0]['supplement_number'] = $all['supplement_number'];
                  break;
                }
                // $checkSup = $this->db->get_where('ca_estimate_after_part_change', array('new_estimate_id' =>  $all['estimate_id'], 'part_id' => $pinfo['id']))->row_array();
                // if (count($checkSup) > 0) {
                //   $checkSup[0]['supplement_number'] = $all['supplement_number'];
                //   break;
                // }
              }
  
              if (count($checkSup) > 0) {
                $csuplementPassNext = 'S' . $checkSup[0]['supplement_number'];
              }
              $extraStr = '';
              $laborValNew = null;
              if (isset($pinfo['glass']) && $pinfo['glass'] != '' && $pinfo['glass'] != 0) {
                $extraStr = ' G';
                $laborValNew = $pinfo['glass'];
              }
              if (isset($pinfo['structual']) && $pinfo['structual'] != '' && $pinfo['structual'] != 0) {
                $laborValNew = $pinfo['structual'];
                $extraStr = ' S';
              }
              if (isset($pinfo['frame']) && $pinfo['frame'] != '' && $pinfo['frame'] != 0) {
                $extraStr = ' F';
                $laborValNew = $pinfo['frame'];
              }
              if (isset($pinfo['user_1']) && $pinfo['user_1'] != '' && $pinfo['user_1'] != 0) {
                $extraStr = ' A';
                $laborValNew = $pinfo['user_1'];
              }
              if (isset($pinfo['user_2']) && $pinfo['user_2'] != '' && $pinfo['user_2'] != 0) {
                $extraStr = ' B';
                $laborValNew = $pinfo['user_2'];
              }
              if (isset($pinfo['user_3']) && $pinfo['user_3'] != '' && $pinfo['user_3'] != 0) {
                $extraStr = ' C';
                $laborValNew = $pinfo['user_3'];
              }
              if (isset($pinfo['labor']) && $pinfo['labor'] != '' && $pinfo['labor'] != 0) {
                $laborValNew = $pinfo['labor'];
                $extraStr = '';
              }
  
              $supplementHtml .=   '<tr style="font-size:12px">';
              $supplementHtml .= '<td scope="row" class="border-bttm" style="padding:5px 5px">' . $cont . '</td>';
              $supplementHtml .= '<td class="border-bttm" style="padding:5px 5px">' . $pinfo['oper'] . '</td>';
              $supplementHtml .= '<td class="border-bttm" style="padding:5px 5px"><span class=' . $this->lang->line($nameLine) . '>' . ($csuplementPassNext ? $csuplementPassNext . ' ' : '') . $this->lang_translate($pinfo['part_name'], $userID) . '</span></td>';
              $supplementHtml .= '<td class="border-bttm" style="padding:5px 5px">' . $pinfo['part_number'] . '</td>';
              $supplementHtml .= '<td class="border-bttm" style="padding:5px 5px">';
              if (strtolower(trim($pinfo['oper'])) == 'repl' || strtolower(trim($pinfo['oper'])) == 'subl') {
                $supplementHtml .=  $pinfo['qty'];
              } else {
                $supplementHtml .= '<p class="pl-3">' . $pinfo['qty'] . '</p>';
              }
              $supplementHtml .= '</td>';
              if (($pinfo['oper'] == "Rpr" || $pinfo['oper'] == "Ref") && !$pinfo['list_price']) {
                $pinfo['list_price'] = null;
                $priceLine = '';
              } else {
                $pinfo['list_price'] = @number_format($pinfo['list_price'], 2);
              }
              if ($pinfo['oper'] == "Ref" && !$laborValNew) {
                $laborValNew = null;
                $laborLine = '';
              } else {
                $laborValNew = @number_format($laborValNew, 1);
              }
              $supplementHtml .= '<td class="border-bttm" style="padding:5px 5px"><span class=' . $priceLine . '>' . $pinfo['list_price'] . '</span></td>';
              $supplementHtml .= '<td class="border-bttm" style="padding:5px 5px"><span class=' . $laborLine . '>' . $laborValNew . $extraStr . '</span></td>';
              $supplementHtml .= '<td class="border-bttm" style="padding:5px 5px"><span class=' . $showIcon . '>' . @number_format($pinfo['paint'], 1) . '</span></td>';
              $supplementHtml .= '</tr>';
              $cont++;
            }
            $supplementHtml .= '</table>';
          }
  
  
  
  
  
  
  
  
          if (isset($addeditem) && !empty($addeditem)) {
            $supplementHtml .= '<h4 style="margin-bottom:8px">' . $this->lang->line('Added Items') . '</h4>';
            $supplementHtml .=   '<table class="table" style="border-collapse: collapse;width:100%;" cellpadding="0" cellspacing="0" >
              <tr style="font-size:12px;border-bottom:4px solid #89a2b9;border-top:4px solid #89a2b9;padding:5px 0">
              <th style="padding: 5px 5px; text-align:left;float:left; font-weight: bold">' . $this->lang->line('Line') . '</th>
              <th style="padding: 5px 5px; text-align:left;float:left; font-weight: bold">' . $this->lang->line('Operation') . '</th>
              <th style="padding: 5px 5px; text-align:left;float:left; font-weight: bold">' . $this->lang->line('Description') . '</th>
              <th style="padding: 5px 5px; text-align:left;float:left; font-weight: bold">' . $this->lang->line('Part Number') . '</th>
              <th style="padding: 5px 5px; text-align:left;float:left; font-weight: bold">' . $this->lang->line('Qty') . '</th>
              <th style="padding: 5px 5px; text-align:left;float:left; font-weight: bold">' . $this->lang->line('Price') . '</th>
              <th style="padding: 5px 5px; text-align:left;float:left; font-weight: bold">' . $this->lang->line('Labor') . '</th>
              <th style="padding: 5px 5px; text-align:left;float:left; font-weight: bold">' . $this->lang->line('Refinish') . '</th>
              </tr>';
  
  
            foreach ($addeditem as $pinfo) {
              if (isset($underLineArray[$pinfo['id']]) && !empty($underLineArray[$pinfo['id']])) {
                $laborLine = (in_array('labor', $underLineArray[$pinfo['id']])) ? 'under-line' : '';
                $nameLine = (in_array('part_name', $underLineArray[$pinfo['id']])) ? 'under-line' : '';
                $priceLine = (in_array('list_price', $underLineArray[$pinfo['id']])) ? 'under-line' : '';
                $paintLine = (in_array('paint', $underLineArray[$pinfo['id']])) ? 'under-line' : '';
                $showIcon = '*';
              }
              $csuplementPassNext = '';
  
              foreach ($allSupplements as $all) {
                // echo $all['estimate_id'].' ';
                // die;
                $checkSup = $this->db->get_where('ca_estimate_select_parts_added', array('estimate_id' =>  $all['estimate_id'], 'part_id' => $pinfo['part_id']))->row_array();
                if (count($checkSup) > 0) {
                  $checkSup[0]['supplement_number'] = $all['supplement_number'];
                  break;
                }
                // $checkSup = $this->db->get_where('ca_estimate_after_part_change', array('new_estimate_id' =>  $all['estimate_id'], 'part_id' => $dData['id']))->row_array();
                // if (count($checkSup) > 0) {
                //   $checkSup[0]['supplement_number'] = $all['supplement_number'];
                //   break;
                // }
              }
  
              if (count($checkSup) > 0) {
                $csuplementPassNext = 'S' . $checkSup[0]['supplement_number'];
              }
              $extraStr = '';
              $laborValNew = null;
              if (isset($pinfo['glass']) && $pinfo['glass'] != '' && $pinfo['glass'] != 0) {
                $extraStr = ' G';
                $laborValNew = $pinfo['glass'];
              }
              if (isset($pinfo['structual']) && $pinfo['structual'] != '' && $pinfo['structual'] != 0) {
                $laborValNew = $pinfo['structual'];
                $extraStr = ' S';
              }
              if (isset($pinfo['frame']) && $pinfo['frame'] != '' && $pinfo['frame'] != 0) {
                $extraStr = ' F';
                $laborValNew = $pinfo['frame'];
              }
              if (isset($pinfo['user_1']) && $pinfo['user_1'] != '' && $pinfo['user_1'] != 0) {
                $extraStr = ' A';
                $laborValNew = $pinfo['user_1'];
              }
              if (isset($pinfo['user_2']) && $pinfo['user_2'] != '' && $pinfo['user_2'] != 0) {
                $extraStr = ' B';
                $laborValNew = $pinfo['user_2'];
              }
              if (isset($pinfo['user_3']) && $pinfo['user_3'] != '' && $pinfo['user_3'] != 0) {
                $extraStr = ' C';
                $laborValNew = $pinfo['user_3'];
              }
              if (isset($pinfo['labor']) && $pinfo['labor'] != '' && $pinfo['labor'] != 0) {
                $laborValNew = $pinfo['labor'];
                $extraStr = '';
              }
  
              $supplementHtml .=   '<tr style="font-size:12px">';
              $supplementHtml .= '<td scope="row" style="padding:5px 5px">' . $cont . '</td>';
              $supplementHtml .= '<td style="padding:5px 5px">' . $pinfo['oper'] . '</td>';
              $supplementHtml .= '<td style="padding:5px 5px"><span class=' . $this->lang->line($nameLine) . '>' . ($csuplementPassNext ? $csuplementPassNext . ' ' : '') . $this->lang_translate($pinfo['part_name'], $userID) . '</span></td>';
              $supplementHtml .= '<td style="padding:5px 5px">' . $pinfo['part_number'] . '</td>';
              $supplementHtml .= '<td style="padding:5px 5px">';
              if (strtolower(trim($pinfo['oper'])) == 'repl' || strtolower(trim($pinfo['oper'])) == 'subl') {
                $supplementHtml .=  $pinfo['qty'];
              } else {
                $supplementHtml .= '<p class="pl-3">' . $pinfo['qty'] . '</p>';
              }
              $supplementHtml .= '</td>';
              if (($pinfo['oper'] == "Rpr" || $pinfo['oper'] == "Ref") && !$pinfo['list_price']) {
                $pinfo['list_price'] = null;
                $priceLine = '';
              } else {
                $pinfo['list_price'] = @number_format($pinfo['list_price'], 2);
              }
              if ($pinfo['oper'] == "Ref" && !$laborValNew) {
                $laborValNew = null;
                $laborLine = '';
              } else {
                $laborValNew = @number_format($laborValNew, 1);
              }
              $supplementHtml .= '<td style="padding:5px 5px"><span class=' . $priceLine . '>' . $pinfo['list_price'] . '</span></td>';
              $supplementHtml .= '<td style="padding:5px 5px"><span class=' . $laborLine . '>' . $laborValNew . $extraStr . '</span></td>';
              $supplementHtml .= '<td style="padding:5px 5px"><span class=' . $showIcon . '>' . @number_format($pinfo['paint'], 1) . '</span></td>';
              $supplementHtml .= '</tr>';
              $cont++;
            }
  
            $supplementHtml .= '</table>';
          }
  
          // 08 July deleted item ends 
  
          $supplementHtml .= '</table>';
          $supplementHtml .= '<div style="width:480px;font-size:14px;border:2px solid #2A2732;padding:10px;color:#2A2732;page-break-inside:avoid;display: inline-block;margin-left:15px;margin-top:15px" class="final-report-css">
            <p style="color:#000;font-size:19px;margin-bottom:15px;font-family: "Arial", sans-serif;">' . $this->lang->line('Supplement Totals Summary') . ':  </p>';
          $netCostVal1 = $finalSupReportData['final_report_sup']["total_cost_repairs"];
          $totalBLabor1 = $finalSupReportData['final_report_sup']["body_labor"] * $finalSupReportData['final_report_sup']["body_labor_rate"];
          $totalPLabor1 = $finalSupReportData['final_report_sup']["paint_labor"] * $finalSupReportData['final_report_sup']["paint_labor_rate"];
          $totalPSLabor1 = $finalSupReportData['final_report_sup']["paint_supplies"] * $finalSupReportData['final_report_sup']["paint_supplies_rate"];
          $totalMLabor1 = $finalSupReportData['final_report_sup']["mechanical_labor"] * $finalSupReportData['final_report_sup']["mechanical_labor_rate"];
          $totalFLabor1 = $finalSupReportData['final_report_sup']["frame_labor"] * $finalSupReportData['final_report_sup']["frame_labor_rate"];
          $totalSLabor1 = $finalSupReportData['final_report_sup']["structual_labor"] * $finalSupReportData['final_report_sup']["structual_labor_rate"];
          $totalGLabor1 = $finalSupReportData['final_report_sup']["glass_labor"] * $finalSupReportData['final_report_sup']["glass_labor_rate"];
          $totalU1Labor1 = $finalSupReportData['final_report_sup']["user_1"] * $finalSupReportData['final_report_sup']["user_1_rate"];
          $totalU2Labor1 = $finalSupReportData['final_report_sup']["user_2"] * $finalSupReportData['final_report_sup']["user_2_rate"];
          $totalU3Labor1 = $finalSupReportData['final_report_sup']["user_3"] * $finalSupReportData['final_report_sup']["user_3_rate"];
          $salesTaxCal1 = ($finalSupReportData['final_report_sup']["sales_tax"] * $finalSupReportData['final_report_sup']["sales_tax_percent"]) / 100;
          $supplementHtml  .=   '<p style="padding:6px auto;font-family: "Arial", sans-serif;">' . $this->lang->line('body_labor') . ': ' . @number_format($finalSupReportData['final_report_sup']["body_labor"], 2) . ' hrs @ '. $this->get_currency_data('default_currency_symbol', $userID) . @number_format($finalSupReportData['final_report_sup']["body_labor_rate"]*$currency_val, 2) . ' /hr: &nbsp;&nbsp;' .$this->get_currency_data('default_currency_symbol', $userID). @number_format($totalBLabor1*$currency_val, 2) . '</p>
   <p style="padding:6px auto;font-family: "Arial", sans-serif;">' . $this->lang->line('Paint Labor') . ': ' . @number_format($finalSupReportData['final_report_sup']["paint_labor"], 2) . ' hrs @ '. $this->get_currency_data('default_currency_symbol', $userID) . @number_format($finalSupReportData['final_report_sup']["paint_labor_rate"]*$currency_val*$currency_val, 2) . ' /hr: &nbsp;&nbsp;' .$this->get_currency_data('default_currency_symbol', $userID). @number_format($totalPLabor1*$currency_val, 2) . '</p>
   <p style="padding:6px auto;font-family: "Arial", sans-serif;">' . $this->lang->line('Mechanical Labor') . ': ' . @number_format($finalSupReportData['final_report_sup']["mechanical_labor"], 2) . ' hrs @ '. $this->get_currency_data('default_currency_symbol', $userID) . @number_format($finalSupReportData['final_report_sup']["mechanical_labor_rate"]*$currency_val, 2) . ' /hr: &nbsp;&nbsp;' .$this->get_currency_data('default_currency_symbol', $userID). @number_format($totalMLabor1*$currency_val, 2) . '</p>
   <p style="padding:6px auto;font-family: "Arial", sans-serif;">' . $this->lang->line('Frame Labor') . ': ' . @number_format($finalSupReportData['final_report_sup']["frame_labor"], 2) . ' hrs @ '. $this->get_currency_data('default_currency_symbol', $userID) . @number_format($finalSupReportData['final_report_sup']["frame_labor_rate"]*$currency_val, 2) . ' /hr: &nbsp;&nbsp;' .$this->get_currency_data('default_currency_symbol', $userID). @number_format($totalFLabor1*$currency_val, 2) . '</p>
   <p style="padding:6px auto;font-family: "Arial", sans-serif;">' . $this->lang->line('Structual Labor') . ': ' . @number_format($finalSupReportData['final_report_sup']["structual_labor"], 2) . ' hrs @ '. $this->get_currency_data('default_currency_symbol', $userID) . @number_format($finalSupReportData['final_report_sup']["structual_labor_rate"]*$currency_val, 2) . ' /hr: &nbsp;&nbsp;' .$this->get_currency_data('default_currency_symbol', $userID). @number_format($totalSLabor1*$currency_val, 2) . '</p>
   <p style="padding:6px auto;font-family: "Arial", sans-serif;">' . $this->lang->line('Glass Labor') . ': ' . @number_format($finalSupReportData['final_report_sup']["glass_labor"], 2) . ' hrs @ '. $this->get_currency_data('default_currency_symbol', $userID) . @number_format($finalSupReportData['final_report_sup']["glass_labor_rate"]*$currency_val, 2) . ' /hr: &nbsp;&nbsp;' .$this->get_currency_data('default_currency_symbol', $userID). @number_format($totalGLabor1*$currency_val, 2) . '</p>
   <p style="padding:6px auto;font-family: "Arial", sans-serif;">' . ($days_to_repair_value[0]['userdefined1_head'] ? $days_to_repair_value[0]['userdefined1_head'] : $this->lang->line('user_defined') . ' A') . ': ' . @number_format($finalSupReportData['final_report_sup']["user_1"], 2) . ' hrs @ '. $this->get_currency_data('default_currency_symbol', $userID) . @number_format($finalSupReportData['final_report_sup']["user_1_rate"]*$currency_val, 2) . ' /hr: &nbsp;&nbsp;' .$this->get_currency_data('default_currency_symbol', $userID). @number_format($totalU1Labor1*$currency_val, 2) . '</p>
   <p style="padding:6px auto;font-family: "Arial", sans-serif;">' . ($days_to_repair_value[0]['userdefined2_head'] ? $days_to_repair_value[0]['userdefined2_head'] : $this->lang->line('user_defined') . ' B') . ': ' . @number_format($finalSupReportData['final_report_sup']["user_2"], 2) . ' hrs @ '. $this->get_currency_data('default_currency_symbol', $userID) . @number_format($finalSupReportData['final_report_sup']["user_2_rate"]*$currency_val, 2) . ' /hr: &nbsp;&nbsp;' .$this->get_currency_data('default_currency_symbol', $userID). @number_format($totalU2Labor1*$currency_val, 2) . '</p>
   <p style="padding:6px auto;font-family: "Arial", sans-serif;">' . ($days_to_repair_value[0]['userdefined3_head'] ? $days_to_repair_value[0]['userdefined3_head'] : $this->lang->line('user_defined') . ' C') . ': ' . @number_format($finalSupReportData['final_report_sup']["user_3"], 2) . ' hrs @ '. $this->get_currency_data('default_currency_symbol', $userID) . @number_format($finalSupReportData['final_report_sup']["user_3_rate"]*$currency_val, 2) . ' /hr: &nbsp;&nbsp;' .$this->get_currency_data('default_currency_symbol', $userID). @number_format($totalU3Labor1*$currency_val, 2) . '</p>
   
   <p style="padding:6px auto;font-family: "Arial", sans-serif;">' . $this->lang->line('Paint Supplies') . ': ' . @number_format($finalSupReportData['final_report_sup']["paint_supplies"], 2) . ' hrs @ '. $this->get_currency_data('default_currency_symbol', $userID) . @number_format($finalSupReportData['final_report_sup']["paint_supplies_rate"]*$currency_val, 2) . ' /hr: &nbsp;&nbsp;' .$this->get_currency_data('default_currency_symbol', $userID). @number_format($totalPSLabor1*$currency_val, 2) . '</p>
   <p style="padding:6px auto;font-family: "Arial", sans-serif;">' . $this->lang->line('Parts') . ': '.$this->get_currency_data('default_currency_symbol', $userID) . @number_format(($finalSupReportData['final_report_sup']["parts"] - $subletPartsListPrice1)*$currency_val, 2) . '</p>
   <p style="padding:6px auto;font-family: "Arial", sans-serif;">' . $this->lang->line('Sublet') . ': ' . $this->get_currency_data('default_currency_symbol', $userID) . @number_format($subletPartsListPrice1*$currency_val, 2) . '</p>
   <p style="padding:6px auto;font-family: "Arial", sans-serif;">' . $this->lang->line('Subtotal') . ': ' .$this->get_currency_data('default_currency_symbol', $userID) . @number_format(($finalSupReportData['final_report_sup']["parts"] + $totalU1Labor1 + $totalU2Labor1 + $totalU3Labor1 + $totalBLabor1 + $totalPLabor1 + $totalMLabor1 + $totalFLabor1 + $totalSLabor1 + $totalGLabor1 + $totalPSLabor1)*$currency_val, 2) . ' </p>
   <p style="padding:6px auto;font-family: "Arial", sans-serif;">' . $this->lang->line('Sales Tax') . ': ' .$this->get_currency_data('default_currency_symbol', $userID) . @number_format($finalSupReportData['final_report_sup']["sales_tax"]*$currency_val, 2) . ' @' . $finalSupReportData['final_report_sup']["sales_tax_percent"] . '% &nbsp;&nbsp;'. $this->get_currency_data('default_currency_symbol', $userID) . @number_format($salesTaxCal1*$currency_val, 2) . '</p>
   <p style="padding:6px auto;font-family: "Arial", sans-serif;">' . $this->lang->line('Total Cost of Repairs') . ': '. $this->get_currency_data('default_currency_symbol', $userID) . @number_format($netCostVal*$currency_val, 2) . ' </p>
   <br><p style="color:#000;font-size:18px;margin-bottom:0;margin-top:-4px">' . $this->lang->line('Net Cost of Supplement') . ': '. $this->get_currency_data('default_currency_symbol', $userID) . @number_format($netCostVal1*$currency_val, 2) . ' </p>';
          $supplementHtml .= '</div>';
          // }
  
          $supplementDiffer = '<br><br><div style="text-align:center;page-break-inside:avoid"><p style="text-align:center;font-size:16px;"><b>' . $this->lang->line('ESTIMATE AND SUPPLEMENT(S) TOTAL') . '</b></p>';
          $supplementDiffer .= '<p style="padding-bottom:2px;margin:0;text-align:center;font-size:16px;font-weight:900;border-bottom:4px solid #89a2b9;"></p><br><table style="font-size:13px;">';
          $supplementDiffer .= '<tr><td width="25%"></td><td width="25%">' . $this->lang->line('Estimate Of Record') . '</td><td width="15%">'. $this->get_currency_data('default_currency_symbol', $userID) . @number_format(($netCostVal - $netCostVal1)*$currency_val, 2) . '</td><td width="20%">&nbsp;&nbsp;' . $written_by . '</td><td width="15%"></td></tr>';
          $supplementDiffer .= '<tr><td width="25%"></td><td width="25%">' . $this->lang->line('Supplement') . ' ' . $suplementPassNext . '</td><td width="15%" style="border-bottom:1px solid #000;">'. $this->get_currency_data('default_currency_symbol', $userID) . @number_format($netCostVal1*$currency_val, 2) . '</td><td width="20%">&nbsp;&nbsp;' . $written_by . '</td><td width="15%"></td></tr>';
          $supplementDiffer .= '<tr><td width="25%"></td><td width="25%"></td><td width="15%"></td><td width="20%"></td><td width="15%"></td></tr>';
          $supplementDiffer .= '<tr><td width="25%" height="40"></td><td width="25%" height="40"><b>' . $this->lang->line('Net Cost of Repairs') . ' :</b></td><td width="15%" height="40"><b>'. $this->get_currency_data('default_currency_symbol', $userID) . @number_format($netCostVal*$currency_val, 2) . '</b></td><td width="20%" height="40"></td><td width="15%" height="40"></td></tr>';
          $supplementDiffer .= '</table></div>';
          $html = str_replace('{SUPPLEMENT_SUMMARY}', $supplementHtml, $html);
          $html = str_replace('{SUPPLEMENT_EST_DIFF}', $supplementDiffer, $html);
        } else {
          $html = str_replace('{SUPPLEMENT_SUMMARY}', '', $html);
          $html = str_replace('{SUPPLEMENT_EST_DIFF}', '', $html);
        }
  
  
        ///////////////// Adding Photos In Pdf /////////////
        $groupUploadsImage = '';
        if (isset($estData['photos']) && !empty($estData['photos'])) {
          $counter = 1;
          foreach ($estData['photos'] as $pht) {
            if ($counter % 6 == 1 || $counter == 1) {
              $groupUploadsImage .= '<div class="row" style="page-break-before: always;margin:auto;text-align:center;margin-top:30px;padding:0px;">';
            }
            if ($counter % 2 == 1) {
              $groupUploadsImage .= '<div class="col-md-10" style="text-align:left;top:0px;margin:0px;padding:0px;">';
            }
            $groupUploadsImage .= '<img style="width:360px;height:260px;margin:0px;padding:0px;" src="' . $pht['photo'] . '">';
            //  $groupUploadsImage .= '<img style="width:360px;height:260px;margin:0px;padding:0px;" src="https://beebom-redkapmedia.netdna-ssl.com/wp-content/uploads/2016/01/Reverse-Image-Search-Engines-Apps-And-Its-Uses-2016.jpg">';
            if (($counter % 2) == 0) {
              $groupUploadsImage .= '</div>';
            }
            if (($counter % 6) == 0) {
              $groupUploadsImage .= '</div>';
            }
            $counter++;
          }
          if ($counter % 2 != 1) {
            $groupUploadsImage .= '&nbsp;</div>';
          }
          if ($counter % 6 != 1) {
            $groupUploadsImage .= '&nbsp;</div>';
          }
  
          //echo $groupUploadsImage; die;
  
          $html = str_replace('{UPLOAD_PHOTOS}', $groupUploadsImage, $html);
        } else {
          $html = str_replace('{UPLOAD_PHOTOS}', '', $html);
        }
  
        //ECHO $html; die;
  
        /////////////////////// Adding Appriasla Invoice ///////////////////////
  
        $estInvoice = '';
        /*if($estData['get_est_fullData']['estimate_data']['is_supplement'] == 1){
            $saleTaxInvoic = isset($finalSupReportData['final_report_sup']["sales_tax_percent"])?$finalSupReportData['final_report_sup']["sales_tax_percent"]:0;
          }else{
             $saleTaxInvoic = isset($finalReportData["sales_tax_percent"])?$finalReportData["sales_tax_percent"]:0;
          }*/
        $taxData = $this->db->get_where('ca_labor_taxs', array('user_id' => $userID))->row_array();
        $saleTaxInvoic = $taxData['sales_tax_percent'];
        if (isset($estData['invoice']) && !empty($estData['invoice'])) {
          $commentVal = (isset($estData['invoice'][0]['comment']) && $estData['invoice'][0]['comment'] != "") ? $estData['invoice'][0]['comment'] : '<p style="color:#B7B7B7;">' . $this->lang->line('Additional Comments') . ':</p>';
          $appraisalVal = (isset($estData['invoice'][0]['appraisal_service_type']) && $estData['invoice'][0]['appraisal_service_type'] != "") ? json_decode($estData['invoice'][0]['appraisal_service_type'], true) : array('slug' => '', 'label' => '', 'value' => 0);
          $additionalVal = (isset($estData['invoice'][0]['additional_charges']) && $estData['invoice'][0]['additional_charges'] != "") ? $estData['invoice'][0]['additional_charges'] : 0;
          $invoiceTotalVal = (isset($estData['invoice'][0]['invoice_total']) && $estData['invoice'][0]['invoice_total'] != "") ? $estData['invoice'][0]['invoice_total'] : 0;
          $taxVal = (isset($estData['invoice'][0]['tax_total']) && $estData['invoice'][0]['tax_total'] != "" && $estData['invoice'][0]['tax_total'] != "0.00" && $estData['invoice'][0]['tax_total'] != "0.0") ? $estData['invoice'][0]['tax_total'] : 0;
          $estInvoice = '<div class="row" style="page-break-before: always;font-family: TimesNewRoman, Times, Baskerville, Georgia, serif;">
                <div style="text-align:center;margin-top:-30px;">
                <h2 style="font-size:32px;margin-bottom:15px">' . $companyName . '</h2>
                 <p style="margin:0; font-size:13px;"><b>' . $companyAddress . '<br>Ph: ' . preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $comPhone) . ' Fax: ' . preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $comFax) . '<br>' . $companyEmailAddress . '</b></p>
                 
                 <h2 class="s15" style="font-weight:bold;padding-bottom:5px;margin-top:30px;width:100%;border-bottom:4px solid #89a2b9;">' . $this->lang->line('SERVICE INVOICE') . '</h2>
                 <table width="80%" border="0" cellspacing="0" cellpadding="0" style="margin-left:30px;font-size:16px; line-height:35px;">
                    <tbody>
                      <tr><td valign="middle" width="70%" style="font-family: TimesNewRoman, Times, Baskerville, Georgia, serif;  font-size: 18px;"><strong>' . $this->lang->line('Invoice Date') . ': </strong>' . date('m/d/Y') . '</td>
                        <td valign="middle" width="70%" style="font-family: TimesNewRoman, Times, Baskerville, Georgia, serif;  font-size: 18px;"><strong>' . $this->lang->line('Bill to') . ':</strong> ' . $estData['get_est_fullData']['estimate_data']['insurance_company'] . '</td></tr>
                        <tr><td valign="middle" width="70%" style="font-family: TimesNewRoman, Times, Baskerville, Georgia, serif;  font-size: 18px;"><strong>' . $this->lang->line('claim_number') . ':</strong> ' . $estData['get_est_fullData']['estimate_data']['claim_number'] . ' </td>
                        <td valign="middle" width="70%" style="font-family: TimesNewRoman, Times, Baskerville, Georgia, serif;  font-size: 18px;"><strong>' . $this->lang->line('Adjuster') . ':</strong> ' . $estData['get_est_fullData']['estimate_data']['adjuster_name'] . ' </td></tr>
                        <tr><td valign="middle" width="70%" style="font-family: TimesNewRoman, Times, Baskerville, Georgia, serif;  font-size: 18px;"><strong>' . $this->lang->line('vehicle_owner') . ':</strong> ' . $ownerNam . '</td>
                        <td valign="middle" width="70%" style="font-family: TimesNewRoman, Times, Baskerville, Georgia, serif;  font-size: 18px;"><strong>' . $this->lang->line('Vehicle') . ':</strong> ' . $estData['get_est_fullData']['vehicle_info']['vehicle_name'] . '</td>
                      </tr> 
                    </tbody>
                  </table> 
                 <h3 style="font-weight:650;padding-bottom:5px;margin-top:10px;width:100%;border-bottom:4px solid #89a2b9;"></h3>
                 <table width="80%" border="0" cellspacing="0" cellpadding="5" style="margin-left:30px;font-size:14px; line-height:25px;">
                    <tbody>
                      <tr><td valign="middle" width="70%" style="font-family: TimesNewRoman, Times, Baskerville, Georgia, serif;  font-size: 14px;"><strong>' . $appraisalVal['label'] . ': '.$this->get_currency_data('default_currency_symbol', $userID) . @number_format($appraisalVal['value'], 2) . '</strong></td></tr>
                        <tr><td valign="middle" width="70%" style="font-family: TimesNewRoman, Times, Baskerville, Georgia, serif;  font-size: 14px;"><strong>' . $this->lang->line('Additional Charges') . ': ' . $this->get_currency_data('default_currency_symbol', $userID) . @number_format($additionalVal, 2) . '</strong></td></tr>
                        <tr><td valign="middle" width="70%" style="font-family: TimesNewRoman, Times, Baskerville, Georgia, serif;  font-size: 14px;"><strong>' . $this->lang->line('Sales Tax') . ' @ ' . @number_format($saleTaxInvoic, 2) . '%: ' . $this->get_currency_data('default_currency_symbol', $userID) . @number_format($taxVal*$currency_val, 2) . ' </strong></td></tr>
                        <tr>
                        <td colspan="2" style="padding-top:21px;"></td>
                       </tr>
                        <tr><td valign="middle" width="70%"><h2 style="text-decoration:underline;font-family: TimesNewRoman, Times;font-weight:400;">' . $this->lang->line('Invoice total') . ': ' . $this->get_currency_data('default_currency_symbol', $userID) . @number_format(($invoiceTotalVal), 2) . '</h2></td></tr>
                      </tr> 
                    </tbody>
                  </table>
                  <br>
                  <div style="padding:5px 10px;width:90%;height:170px;border:1px solid #B7B7B7;margin:0 auto;text-align:left;">' . $commentVal . '</div>
                  <br>
                  <table width="80%" border="0" cellspacing="0" cellpadding="0" style="margin-left:30px;font-size:16px; line-height:0px;margin-top:20px">
                    <tbody><tr><td valign="middle" width="70%"><h3 margin-bottom:15px><b>' . $this->lang->line('Thank you for your business') . '!</b></h3></td></tr></tbody></table>
                  <h3 style="font-weight:700;margin-top:0px;padding-bottom:5px;width:100%;border-bottom:4px solid #89a2b9;"></h3> 
                </div>
              </div>';
        }
        // for image
        // if ($estData['parent'] == false) {
        //   $estInvoice .= '<table style="font-size:12px;margin-left:10px;font-family:roboto;"><tr><td style="widht:80%;"><img src="' . $imglink . '" ></td></tr></table>';
        // }
  
  
  
        // for image ends  
        $html = str_replace('{EST_INVOICE}', $estInvoice, $html);
  
  
  
  
  
  
        ////////////////////////////////////////////////////////////////////////
  
  
        // print_r($html);
        // die;
        ///$dompdf->loadHtml($html);
  
        $logoImage = base_url() . "assets/images/QUICKSHEET-LOGO-DARK-BG.png";
        $date = date('m/d/Y h:i:s A');
        $date = $userPhoneDate;
        $mpdf->SetHTMLFooter('
        <table><tr><td style="padding-top:25px;"></td></tr></table>
        <table width="100%">
        <tr style="margin-top:35px;">
        <td style="font-size:12px;">  ' . $date . ' </td>
        <td width="27%" style="font-size:12px;"><span>Powered By:</span> <img src="' . $logoImage . '" style=" width:80px; margin-bottom: -8px;"> </td>
        <td style="text-align: right; font-size:12px;">Page {PAGENO}</td>
     </tr>
  
    </table>', true);
  
        $css = '
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Arial">
        @import url("https://fonts.googleapis.com/css?family=Arial");
        @import url("https://fonts.googleapis.com/css?family=Times+New+Roman");
        
       
        body {
            margin: 0;
            font-family: helvetica;
            font-weight: normal;
            color: #000000;
        }
  
        table {
          border-collapse: collapse;
          width: 100%;
          font-size: 12px;
          color: #000000;
        }
  
        .table>tbody>tr>td,
        .table>tbody>tr>th,
        .table>tfoot>tr>td,
        .table>tfoot>tr>th,
        .table>thead>tr>td,
        .table>thead>tr>th {
          padding: 2px 4px;
          line-height: 1.42857143;
          vertical-align: top;
          border-top: 1px solid #fff;
        }
  
        th,
      td.end-table {
        border-top: 4px solid #89a2b9 !important;
        border-bottom: 4px solid #89a2b9 !important;
        border-right: none;
        text-align: left;
        padding: 0px;
        font-weight: 700;
      }
  
      td.border-bttm {
        border-top: 1px solid #ddd !important;
      }
  
      .top-margin-handler {
        margin-top: 30px !important;
      }
  
      .under-line {
        text-decoration: underline;
      }
  
      .vi_text {
        line-height:70px;
        margin-top: .5em;
      }
  
     
      .new-break {
        width: 525px;
        border: 2px solid #2A2732;
        padding: 0 10px;
        color: #2A2732;
        page-break-inside: avoid;
        display: inline-block;
      }
  
      .new-break-1 {
        page-break-inside: avoid;
      }
  
      .qtext {
        page-break-inside: avoid;
      }
  
        td.border-bttm {
          border-top: 1px solid #ddd !important;
          }
            h1 { color: black; font-family:"Times New Roman", serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 22.5pt; }
            .s1 { color: black; font-family:"Times New Roman", serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 10.5pt; }
            h2 { color: black; font-family:"Times New Roman", serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 18pt; }
            .s2 { color: black; font-family:"Times New Roman", serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 11pt; }
            .s3 { color: black; font-family:"Times New Roman", serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 10pt; }
            h3 { color: black; font-family:"Times New Roman", serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 13.5pt; }
            a { color: black; font-family:Arial, sans-serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 9pt; }
            .p, p { color: black; font-family:Arial, sans-serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 9pt; margin:0pt; }
            .s4 { color: black; font-family:Arial, sans-serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 12pt; }
            .s5 { color: black; font-family:Arial, sans-serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 10.5pt; }
            .s6 { color: black; font-family:Arial, sans-serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 10.5pt; }
            .s7 { color: black; font-family:Arial, sans-serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 9pt; }
            .s8 { color: black; font-family:Arial, sans-serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 9pt; }
            .s9 { color: black; font-family:Arial, sans-serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 9pt; }
            .s10 { color: black; font-family:Arial, sans-serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 13.5pt; }
            .s11 { color: #2A2731; font-family:Arial, sans-serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 10.5pt; }
            .s12 { color: black; font-family:Arial, sans-serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 11pt; }
            .s13 { color: black; font-family:"Times New Roman", serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 10.5pt; }
            h4 { color: black; font-family:"Times New Roman", serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 12pt; }
            .s14 { color: black; font-family:"Times New Roman", serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 12pt; }
            .s15 { color: black; font-family:"Times New Roman", serif; font-style: normal; font-weight: normal; font-size: 17pt; }
            .s16 { color: black; font-family:"Times New Roman", serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 10.5pt; }
             }';
        $html = preg_replace('/>\s+</', "><", $html);
        $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS); // Apply the CSS styles
        $mpdf->WriteHTML($html);
  
  
        if ($estData['get_est_fullData']['estimate_data']['owner_identity'] == 1) {
          $filename = $estData['get_est_fullData']['estimate_data']['insured'] . ' - ' . $estData['get_est_fullData']['estimate_data']['claim_number'];
        } else {
          $filename = $estData['get_est_fullData']['estimate_data']['claimant'] . ' - ' . $estData['get_est_fullData']['estimate_data']['claim_number'];
        }
        $filename = ($filename != ' ') ? $filename : 'Estimate PDf File';
        $filepdfUrlsVal = $this->seo_friendly_url(trim($filename));
        $createFolderName = $this->generateRandomString(25);
        @set_time_limit(-1);
        $path = FCPATH . "uploads/PDF/EST" . $estID . "-" . $userID . "-" . $createFolderName;
        if (!is_dir($path)) { //create the folder if it's not already exists
          mkdir($path, 0777, TRUE);
        }
        // $dompdf->setPaper("portrait");
        // $dompdf->render();
  
        // $logoImage = BASE_URL.'assets/images/'.$companyData['logo'];
        //$logoImage = BASE_URL.'assets/images/QUICKSHEET-LOGO-DARK-BG.png';
        //06 july  $logoImage = $_SERVER['DOCUMENT_ROOT'].'/quicksheet/assets/images/QUICKSHEET-LOGO-DARK-BG.png';
  
  
        //$mpdf->SetFooter($footer);
        ///$font = $dompdf->getFontMetrics()->get_font("helvetica", "normal");
        // $dompdf->getCanvas()->page_text(30, 760, $date, $font, 9, array(0, 0, 0));
        // $dompdf->getCanvas()->page_text(258, 760, "Powered By:", $font, 10, array(0, 0, 0));
        //$dompdf->getCanvas()->image($logoImage,315, 760, 80, 17);
        // $dompdf->getCanvas()->page_script('
        //         $pdf->image("' . $logoImage . '", 317, 760, 70, 15);
        //       ');
        // $dompdf->getCanvas()->page_text(522, 760, "Page {PAGE_NUM}", $font, 9, array(0, 0, 0));
        // $pdf = $dompdf->output();
  
  
  
  
        $file_location = $_SERVER['DOCUMENT_ROOT'] . "/quicksheet/uploads/PDF/EST" . $estID . "-" . $userID . "-" . $createFolderName . "/" . $filepdfUrlsVal . ".pdf";
        $pdf = $filepdfUrlsVal;
        //$mpdf->Output($filepdfUrlsVal.'.pdf', 'D');
        // $file_location = base_url()."/uploads/PDF/EST".$estID."-".$userID."-".$createFolderName."/".$filepdfUrlsVal.".pdf"; 
  
  
        if (file_put_contents($file_location, $pdf)) {
          $pdfUrlVal['url'] = base_url() . "uploads/PDF/EST" . $estID . "-" . $userID . "-" . $createFolderName . "/" . $filepdfUrlsVal . ".pdf";
          $pdfUrlVal['filename'] = trim($filename);
          $this->Muser->update_pdf_url($estID, $pdfUrlVal);
          $pdf =  $mpdf->Output($file_location, 'F');
          return $pdfUrlVal;
        } else {
          $pdfUrlVal['url'] = "";
          $pdfUrlVal['filename'] = "";
          return $pdfUrlVal;
        }
      }
    }
  


    public function old_create_pdf($estID, $estData, $userID, $companyData, $userPhoneDate)
    {

        $pdf_claim_number = "CLAIM NUMBER:";
        $getUrlVal = $this->Muser->get_pdf_url($estID);
        $changeditem = $this->Muser->deltedpartdata("ca_estimate_select_parts_changed", $estID);
        $addeditem = $this->Muser->addeditem($estID);

        $deleteditem = $this->Muser->deleteditem($estID);



        // $loginUser = $this->session->userdata('LOGGED_USER');

        $days_to_repair_value =   $this->Muser->getData("ca_labor_taxs", $userID, "user_id");

        // 22 june total days calculation
        $totalcalculatedrepairdays = 0;

        $dayReportData = $this->Muser->get_initial_estimates_days($estID);



        $totallaborhour =   $dayReportData["body_labor"] + $dayReportData["paint_labor"] + $dayReportData["mechanical_labor"] + $dayReportData["frame_labor"] + $dayReportData["structual_labor"] + $dayReportData["glass_labor"] + $dayReportData["user_1"] + $dayReportData["user_2"] + $dayReportData["user_3"];




        $days_to_repair_valuedata = $days_to_repair_value[0]['days_to_repair_value'];


        if ($days_to_repair_valuedata > 0) {
            $totalcalculatedrepairdays = round(@$totallaborhour / @$days_to_repair_valuedata);
        }

        if ($totalcalculatedrepairdays == 0) {
            $totalcalculatedrepairdays = 1;
        }

        // 22 june total days calculation ends  


        $imglink = $days_to_repair_value[0]['towing_storage_image'];

        // dd($imglink);

        if (isset($getUrlVal['pdf_url']) && $getUrlVal['pdf_url'] != '') {
            return array('url' => $getUrlVal['pdf_url'], 'filename' => $getUrlVal['pdf_name']);
        } else {

            $options = new Options();
            $options->set('isRemoteEnabled', TRUE);
            $options->set('debugKeepTemp', TRUE);
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isPhpEnabled', true);
            @set_time_limit(-1);
            $filePath = $_SERVER['DOCUMENT_ROOT'] . "/application/views/pdf/pdf-html.php";


            //$filePath = base_url()."application/views/pdf/pdf-html.php";
            $html = file_get_contents($filePath);
            $dompdf = new Dompdf($options);
            $pdfSettings = $this->Muser->get_pdf_settings();


            // $html = str_replace('{CSS_PATH}', $cssPath, $html);
            $html = str_replace('{OWNER_NAME}', $estData['get_est_fullData']['estimate_data']['claimant'], $html);
            $html = str_replace('{PART_NAME}', $estData['get_est_fullData']['vehicle_info']['vehicle_name'], $html);
            /*if(isset($estData['get_est_fullData']['part_info']) && !empty($estData['get_est_fullData']['part_info'])){
                $abbre = '<div class="row" style="font-size:14px;font-weight:500;page-break-before: always;">'.$pdfSettings['abbreviation'].'</div>';
                $html = str_replace('{ABBREVIATION}',$abbre,$html);
            }else{
                $html = str_replace('{ABBREVIATION}','',$html);
            }*/

            $companyName = $estData['get_est_fullData']['appraisal_data']['appraisal_company'];
            $companyEmailAddress = $estData['get_est_fullData']['appraisal_data']['email_id'];
            $companyAddress = $estData['get_est_fullData']['appraisal_data']['address'];
            $comPhone = $estData['get_est_fullData']['appraisal_data']['phone_number'];
            $comFax = $estData['get_est_fullData']['appraisal_data']['fax'];
            $written_by = $estData['get_est_fullData']['appraisal_data']['written_by'];
            $adjuster_name = $estData['get_est_fullData']['estimate_data']['adjuster_name'];
            $adjuster_phone = $estData['get_est_fullData']['estimate_data']['adjuster_phone'];
            $ownerNam = ($estData['get_est_fullData']['estimate_data']['owner_identity'] != 1) ? $estData['get_est_fullData']['estimate_data']['claimant'] : $estData['get_est_fullData']['estimate_data']['insured'];
            ///////////////////// Adding First Page Data ////////////////////////////
            $dateLoss = '';
            $REPAIRABLE = '';
            if (isset($estData['report']) && !empty($estData['report'])) {
                if ($estData['report'][0]['borderline_total_loss']) {
                    $REPAIRABLE = 'BORDERLINE TOTAL LOSS';
                } elseif ($estData['report'][0]['total_loss']) {
                    $REPAIRABLE = 'TOTAL LOSS';
                } elseif ($estData['report'][0]['supplement']) {
                    $REPAIRABLE = 'SUPPLEMENT';
                } else {
                    $REPAIRABLE = 'REPAIRABLE';
                }
                $finalReportData = $this->Muser->get_estimates_final_report($estID);

                $deductibleAmnt = $estData['get_est_fullData']['estimate_data']['deductive_amount'] ? $estData['get_est_fullData']['estimate_data']['deductive_amount'] : 0;
                $estimageCost = (isset($finalReportData["total_cost_repairs"]) && $finalReportData["total_cost_repairs"] != '') ? $finalReportData["total_cost_repairs"] : 0;
                $netEstimageCost = $estimageCost -  $deductibleAmnt;
                $calledVal = ($estData['report'][0]['called_in']) ? 'Yes' : 'No';
                $sinceVal = ($estData['report'][0]['since'] != '0000-00-00') ? date('m/d/Y', strtotime($estData['report'][0]['since'])) : '';
                $dateLoss = ($estData['get_est_fullData']['estimate_data']['loss_date'] != '0000-00-00 00:00:00') ? date('m/d/Y', strtotime($estData['get_est_fullData']['estimate_data']['loss_date'])) : '';
                $estReport = '';
                $collectionStorage = ($estData['report'][0]['collection_storage']) ? $estData['report'][0]['per_day'] : '';
                $repairFacility = '';
                if (isset($estData['get_est_fullData']['estimate_data']['site_type']) && trim($estData['get_est_fullData']['estimate_data']['site_type']) == 'Repair Facility') {
                    $repairFacility = 'Repair Facility: ' . $estData['get_est_fullData']['estimate_data']['inspections_name'] . '<br>
                                    Address: ' . $estData['get_est_fullData']['estimate_data']['inspections_address'] . '<br>
                                    Tax ID #: ' . $estData['get_est_fullData']['estimate_data']['inspections_tax_id'] . '<br><br>';
                }
                $estReport .= '<div class="row">
        <div style="text-align:center;margin-top:-30px;font-family: TimesNewRoman, Times, Baskerville, Georgia, serif;">
         <h2 style="font-weight:700;font-size:30px;margin-bottom:15px">' . $companyName . '</h2>
         <p style="font-size:14px;"><b style="font-family:helvetica;">' . $companyAddress . '<br>Ph: ' . preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $comPhone) . ' Fax: ' . preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $comFax) . '</b></p>
         <h2 style="font-weight:700;padding-bottom:5px;margin-top:20px;width:100%;border-bottom:4px solid #89a2b9;">CLAIM SUMMARY REPORT</h2>
         <table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:15px; line-height:25px;margin-left:5px;">
            <tbody>
              <tr>
                <td valign="middle" width="70%"><strong><span style="padding-bottom:5px;margin-bottom:5px;display: inline-block;font-family:helvetica;">COMPANY: </span></strong><span style="padding-bottom:5px;margin-bottom:5px;display: inline-block;border:1px solid #000;width:203px;padding-left:5px;margin-left:5px;">' . $estData['get_est_fullData']['estimate_data']['insurance_company'] . '&nbsp;</span></td>
                <td valign="middle" width="70%"><strong><span style="padding-bottom:5px;margin-bottom:5px;display: inline-block;font-family:helvetica;">INSURED: </span></strong><span style="padding-bottom:5px;margin-bottom:5px;display: inline-block;border:1px solid #000;width:333px;padding-left:5px;margin-left:5px;">' . $estData['get_est_fullData']['estimate_data']['insured'] . '&nbsp;</span></td>
              </tr> 
              <tr>
                <td valign="middle" width="70%"><strong><span style="padding-bottom:5px;margin-bottom:5px;display: inline-block;font-family:helvetica;">' . $pdf_claim_number . '</span></strong><span style="padding-bottom:5px;margin-bottom:5px;display: inline-block;border:1px solid #000;width:160px;padding-left:5px;margin-left:5px;">' . $estData['get_est_fullData']['estimate_data']['claim_number'] . '&nbsp;</span></td>
                <td valign="middle" width="70%"><strong><span style="padding-bottom:5px;margin-bottom:5px;display: inline-block;font-family:helvetica;">CLAIMANT: </span></strong><span style="padding-bottom:5px;margin-bottom:5px;display: inline-block;border:1px solid #000;width:318px;padding-left:5px;margin-left:5px;">' . $estData['get_est_fullData']['estimate_data']['claimant'] . '&nbsp;</span></td>
              </tr> 
              <tr>
                <td valign="middle" width="70%"><strong><span style="padding-bottom:5px;margin-bottom:5px;display: inline-block;font-family:helvetica;">ADJUSTER: </span></strong><span style="padding-bottom:5px;margin-bottom:5px;display: inline-block;border:1px solid #000;width:202px;padding-left:5px;margin-left:5px;">' . $estData['get_est_fullData']['estimate_data']['adjuster_name'] . '&nbsp;</span></td>
                <td valign="middle" width="70%"><strong><span style="padding-bottom:5px;margin-bottom:5px;display: inline-block;font-family:helvetica;">DATE OF LOSS: </span></strong><span style="padding-bottom:5px;margin-bottom:5px;display: inline-block;border:1px solid #000;width:292px;padding-left:5px;margin-left:5px;">' . $dateLoss . '&nbsp;</span></td>
              </tr>  
              <tr>
                <td valign="middle" width="70%"><strong><span style="padding-bottom:5px;margin-bottom:5px;display: inline-block;font-family:helvetica;">INSPECTION DATE: </span></strong><span style="padding-bottom:5px;margin-bottom:5px;display: inline-block;border:1px solid #000;width:142px;padding-left:5px;margin-left:5px;">' . $estData['report'][0]['inspection_date'] . '&nbsp;</span></td>
                <td valign="middle" width="70%"><strong><span style="padding-bottom:5px;margin-bottom:5px;display: inline-block;font-family:helvetica;">VEHICLE: </span></strong><span style="padding-bottom:5px;margin-bottom:5px;display: inline-block;border:1px solid #000;width:331px;padding-left:5px;margin-left:5px;">' . $estData['get_est_fullData']['vehicle_info']['vehicle_name'] . '&nbsp;</span></td>
              </tr>  
              <tr>
                 <td valign="middle" width="70%"><strong style="font-family:helvetica;">INSPECTION SITE: </strong><b>' . $estData['get_est_fullData']['estimate_data']['site_type'] . '</b></td>
                <td valign="middle" width="100%"><strong style="font-family:helvetica;">WRITTEN BY: </strong><b>' . $written_by . '</b></td>
              </tr>';
                if ($estData['report'][0]['drivable']) {
                    $estReport .= '<tr><td colspan="2" valign="middle" width="100%"><strong style="font-family:helvetica;">Drivable: </strong><b style="font-family:helvetica;">Yes</b></td></tr>';
                } else {
                    $estReport .= '<tr><td colspan="2" valign="middle" width="100%"><strong style="font-family:helvetica;">Drivable: </strong><b style="font-family:helvetica;">No</b></td></tr>';
                }
                $estReport .= '</tbody>
          </table>
          <h2 style="font-weight:700;padding-bottom:5px;margin-top:0px;width:100%;border-bottom:4px solid #89a2b9;margin-bottom:10px">' . $REPAIRABLE . '</h2>
          <table width="95%" border="0" cellspacing="0" cellpadding="0" style="margin-left:5px;font-size:14px;">
            <tbody>
              <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:15px; line-height:20px">
            <tbody>';
                if ($estData['get_est_fullData']['estimate_data']['is_supplement'] == 1) {
                    $finalSupReportDataN = $this->Muser->get_supplement_summary($estID);
                    $estReport .= '<tr>
                <td valign="middle" width="30%" style="line-height:17px;font-size:15px;">Supplement Total: $' . @number_format($finalSupReportDataN['final_report_sup']["total_cost_repairs"], 2) . ' </td>
                <td valign="middle" width="70%" style="line-height:17px;font-size:15px;"></td>
              </tr>';
                }
                $estReport .=  '<tr>
                <td valign="middle" width="30%" style="line-height:17px;font-size:15px;">Gross Estimate Amount: $' . @number_format($estimageCost, 2) . ' </td>
                <td valign="middle" width="70%" style="line-height:17px;font-size:15px;">Open Amount: $' . $estData['report'][0]['open_amount'] . '</td>
              </tr>    
               <tr>
                <td valign="middle" width="70%" style="line-height:17px;font-size:15px;">Speculative Days to Repair: ' . $totalcalculatedrepairdays . '</td>
                <td valign="middle" width="30%" style="line-height:17px;font-size:15px;">Deductible: $' . $estData['get_est_fullData']['estimate_data']['deductive_amount'] . '</td>
              </tr>';
                if ($estData['get_est_fullData']['estimate_data']['is_supplement'] == 1) {
                    $finalSupReportDataN = $this->Muser->get_supplement_summary($estID);
                    $estReport .= '<tr>
                <td colspan="2" valign="middle" width="100%" style="line-height:0px;font-size:18px;margin:0px;padding:0"><h4><b>Net Supplement Total: $' . @number_format($finalSupReportDataN['final_report_sup']["total_cost_repairs"], 2) . '</b></h4> </td>
              </tr>';
                } else {
                    $estReport .= '<tr>
                <td colspan="2" valign="middle" width="100%" style="line-height:0px;font-size:18px;margin:0px;padding:0"><h4><b style="font-family:helvetica;">Net Estimate Total: $' . @number_format($netEstimageCost, 2) . '</b></h4> </td>
              </tr>';
                }
                $estReport .= '<tr>
                <td valign="middle" colspan="2" width="100%" style="line-height:17px;font-size:15px;">Inspection Location: ' . $estData['get_est_fullData']['estimate_data']['inspections_name'] . ', ' . $estData['get_est_fullData']['estimate_data']['inspections_address'] . ' Ph: ' . preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $estData['get_est_fullData']['estimate_data']['inspections_phone']) . ' Fax: ' . preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $estData['get_est_fullData']['estimate_data']['inspections_fax']) . '</td>
              </tr> 
              <tr>
                <td valign="middle" colspan="2" width="100%" style="line-height:17px;font-size:15px;">Open items for possible Supplement: ' . $estData['report'][0]['open_item_possible_supl'] . '.</td>
              </tr> 
               <tr>
                <td valign="middle" colspan="2" width="100%" style="line-height:17px;font-size:15px;">Advance Charges: $' . $estData['report'][0]['advanced_charges'] . '</td>
              </tr> 
              <tr>
                <td valign="middle" width="30%" style="line-height:17px">
                      <div style="font-size:15px;height:320px;padding-top:10px">
                          Collecting Storage $' . $collectionStorage . ' day, Since:' . $sinceVal . '<br>
                          <b>Vehicle Base Retail Value: $' . @number_format($estData['report'][0]['vehicle_retail_value'], 2) . '</b><br>
                          Evaluation Method: ' . $estData['report'][0]['evalucation_method'] . '<br>
                          CALLED IN: ' . $calledVal . '<br>
                          <b>Request #: ' . $estData['report'][0]['request_number'] . '</b><br>
                          Evaluation Amount: <b>' . @number_format($estData['report'][0]['evaulation_amount'], 2) . '</b><br>';
                $estReport .= $repairFacility;
                $estReport .= '<b>Alternative Part Searches:</b><br>';
                $altPartSearch = json_decode($estData['report'][0]['alternative_part_searches']);
                if (isset($altPartSearch) && !empty($altPartSearch)) {
                    foreach ($altPartSearch as $val) {
                        $estReport .= $val . '<br>';
                    }
                }
                $estReport .= '</div>
                      </td>
                      <td valign="middle" width="70%" style="line-height:17px">
                          <div style="padding:0 10px;border:1px solid black;height:320px;">
                              <table width="100%" style="padding:0px;margin:0px" border="0" cellspacing="0" cellpadding="0">
                                <tbody>
                                <tr>
                                  <td style="font-size:15px; line-height:20px">
                                  <p><b>Remarks:</b><br>';
                $remarksData = json_decode($estData['report'][0]['remarks'], TRUE);
                if (isset($remarksData) && !empty($remarksData)) {
                    foreach ($remarksData as $val) {
                        if ($val != '' && $val != ' ') {
                            $val1 = str_replace("\n", '<br>', $val);
                            $estReport .= $val1 . '<br>';
                        }
                    }
                }
                $estReport .= '</p>
                                  </td>
                                </tr>                                 
                                </tbody>
                              </table>
                          </div>
                      </td>
                      </tr>            
                    </tbody>
                  </table>
                  </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>';
                $breakPage = 'page-break-before: always;';
            } else {
                $estReport = '';
                $breakPage = '';
            }
            $html = str_replace('{EST_REPORT}', $estReport, $html);
            $html = str_replace('{BREAK_PAGE}', $breakPage, $html);

            ///////////////////// Adding Second Page Data ////////////////////////////

            $secondPageHtml  = '<h1 style="margin:0;text-align:center;font-weight:900;margin-top:-40px;font-size:28px">' . strtoupper($companyName) . '</h1>';
            $secondPageHtml .= '<p style="margin:0;font-size:12px;text-align:center;">' . $companyEmailAddress . '</p>';
            $secondPageHtml .= '<p style="margin:0;font-size:12px;text-align:center;">' . strtoupper($companyAddress) . '</p>';
            $secondPageHtml .= '<p style="margin:0;font-size:12px;text-align:center;">Phone: ' . preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $comPhone) . ', Fax: ' . preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $comFax) . '</p>';
            $secondPageHtml .= '<p style="margin:0;font-size:12px;text-align:center;">Written By: ' . $written_by . '</p>';
            $secondPageHtml .= '<br><p style="padding:4px 0;margin:0;text-align:center;font-size:16px;border-top:4px solid #89a2b9;border-bottom:4px solid #89a2b9;"><b>' . $estData['get_est_fullData']['estimate_data']['status'] . '</b></p>';

            $secondPageHtml .= '<br><table style="font-size:14px;margin-left:10px;line-height:22px;">
      <tr><td width="35%"><b>Insured: </b>' . $estData['get_est_fullData']['estimate_data']['insured'] . '</td><td width="35%"> <b>Insurance Company: </b>' . $estData['get_est_fullData']['estimate_data']['insurance_company'] . '</td></tr>
      <tr><td width="35%"><b>Claimant: </b>' . $estData['get_est_fullData']['estimate_data']['claimant'] . '</td><td width="35%"> <b>Adjuster: </b>' . $adjuster_name . '</td></tr>
      <tr><td width="35%"><b>Type of Loss: </b>' . $estData['get_est_fullData']['estimate_data']['loss_type'] . '</td><td width="35%">  <b style="font-family:helvetica;">Claim Number: </b>' . $estData['get_est_fullData']['estimate_data']['claim_number'] . '</td></tr>
      <tr><td width="35%"><b>Date of Loss: </b> ' . $dateLoss . '</td><td width="35%"><b>Policy: </b>' . $estData['get_est_fullData']['estimate_data']['policy_number'] . '</td></tr>
      <tr><td width="35%"><b>Days to Repair: </b>' . $totalcalculatedrepairdays . '</td><td  width="35%"><b>Point of Impact: </b>' . $estData['get_est_fullData']['estimate_data']['point_of_impact'] . '</td></tr>
      </table>';
            $secondPageHtml .= '<table style="font-size:14px;margin-left:10px;"><tr><td width="33%"><b>Vehicle Owner:</b></td><td width="33%"><b>Inspection Location:</b></td></tr><tr><td>
        ' . $ownerNam . '<br>' . $estData['get_est_fullData']['estimate_data']['vehicle_owner'] . '<br>' . preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $estData['get_est_fullData']['estimate_data']['vehicle_owner_phone']) . '
        </td><td>
        ' . $estData['get_est_fullData']['estimate_data']['inspections_name'] . '<br>' . $estData['get_est_fullData']['estimate_data']['inspections_address'] . '<br>' . preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $estData['get_est_fullData']['estimate_data']['inspections_phone']) . '
        </td></tr></table>';
            $secondPageHtml .= '<p style="text-align:center;font-size:16px;border-top:4px solid #89a2b9;border-bottom:4px solid #89a2b9;padding:3px 0 4px;margin:0"><b>Vehicle Information</b></p>';
            $secondPageHtml .= '<p style="font-size:14px;margin-left:10px;"><b>' . $estData['get_est_fullData']['vehicle_info']['vehicle_name'] . '</b></p>';
            $secondPageHtml .= '<table style="font-size:12px;margin-left:10px;">
        <tr><td style="widht:30%;"><b>VIN:</b> ' . $estData['get_est_fullData']['vehicle_info']['vin_number'] . '</td><td><b>PRODUCTION DATE: </b> ' . $estData['get_est_fullData']['vehicle_info']['production_plate'] . '</td><td></td></tr>
        <tr><td style="widht:30%;"><b>LICENSE PLATE: </b>' . $estData['get_est_fullData']['vehicle_info']['license_plate'] . '</td><td><b>MILEAGE: </b>' . $estData['get_est_fullData']['vehicle_info']['mileage'] . '</td><td><b>COLOR: </b>' . $estData['get_est_fullData']['vehicle_info']['vehicle_color'] . '</td></tr>
        </table>';
            $secondPageHtml .= '<p style="padding-bottom:2px;margin:0;margin-top:10px;text-align:center;font-size:16px;font-weight:900;border-bottom:4px solid #89a2b9;"></p>';
            if (isset($estData['get_est_fullData']['vehicle_option']) && !empty($estData['get_est_fullData']['vehicle_option'])) {
                foreach ($estData['get_est_fullData']['vehicle_option'] as $vehicleOptionVal) {
                    foreach ($vehicleOptionVal as $k => $v)
                        $ValueHandlerArray[] = $v;
                }
                $loopCounter = ceil(count($ValueHandlerArray) / 4);
                $secondPageHtml .= '<table style="font-size:12px;margin-left:-10px;"><tr>';
                for ($j = 0; $j <= 3; $j++) {
                    $counter = $loopCounter * $j;
                    $secondPageHtml .= '<td style="vertical-align:top;"><ul style="list-style-type: none;">';
                    for ($i = $counter; $i < ($loopCounter + $counter); $i++) {
                        @$secondPageHtml .= '<li>' . $ValueHandlerArray[$i] . '</li>';
                    }
                    $secondPageHtml .= '</ul></td>';
                }
                $secondPageHtml  .= '</tr></table>';
            }

            $html = str_replace('{SECOND_PAGE}', $secondPageHtml, $html);

            /////////////////////// Adding Estimate List ///////////////////

            $suplementNumber = '';
            $trDetails = '<div class="row" style="page-break-before: always;"><table class="table main-table" style="border-collapse: collapse;" cellpadding="0" cellspacing="0" width="100%;"><tr><th>Line</th><th>Operation</th><th></th><th>Description</th><th>Part Number</th><th>Qty</th><th>Price</th><th>Labor</th><th>Refinish</th></tr>';
            $counterVal = 1;
            $holdTabName = array();
            $subletPartsListPrice = 0;

            if (isset($estData['get_est_fullData']['part_info']) && !empty($estData['get_est_fullData']['part_info'])) {
                $underLineArray = $this->Muser->underline_keys($estID);

                $inclOverlapData = $this->Muser->get_incl_overlap_parts($estID);
                $refinishRuleData = $this->Muser->get_refinish_rule_data($estID);
                $refinishRuleAdjData = $this->Muser->get_refinish_adj_rule_data($estID);

                foreach ($estData['get_est_fullData']['part_info'] as $dData) {
                    /*************************************/
                    $suplementPassNext = '';
                    $inclSublMessage = '';
                    $refinishFormulaHtml = '';
                    $refinishAdjFormulaHtml = '';
                    if ((trim($dData['oper']) == 'Subl' || trim($dData['oper']) == 'Repl') && trim($dData['markup']) == 1) {
                        $inclSublMessage = '<br><span class="font-size:8px;">+25%</span>';
                    }
                    if (isset($refinishRuleAdjData[$dData['id']])) {
                        $roundRefinishRuleAdjData = ($refinishRuleAdjData[$dData['id']]['paint'] != 'INCL') ? round($refinishRuleAdjData[$dData['id']]['paint'], 1) : $refinishRuleAdjData[$dData['id']]['paint'];
                        $refinishAdjFormulaHtml = '<tr><td></td><td></td><td></td><td><span>' . $refinishRuleAdjData[$dData['id']]['msg'] . '</span></td><td></td><td></td><td><span></span></td><td><span></span></td><td><span>' . $roundRefinishRuleAdjData . '</span></td></tr>';
                    }
                    if (isset($refinishRuleData[$dData['id']])) {
                        $roundRefinishRuleData = ($refinishRuleData[$dData['id']]['paint'] != 'INCL') ? round($refinishRuleData[$dData['id']]['paint'], 1) : $refinishRuleData[$dData['id']]['paint'];
                        $refinishFormulaHtml = '<tr><td></td><td></td><td></td><td><span>' . $refinishRuleData[$dData['id']]['msg'] . '</span></td><td></td><td></td><td><span></span></td><td><span></span></td><td><span>' . $roundRefinishRuleData . '</span></td></tr>';
                    }
                    /*************************************/
                    $overlapDectionval = '';
                    $inclMessage = '';
                    $laborValNew = '';
                    $extra = '';
                    if (isset($dData['glass']) && $dData['glass'] != '' && $dData['glass'] != 0) {
                        $laborValNew = $dData['glass'];
                        $extra =  ' G';
                    }
                    if (isset($dData['structual']) && $dData['structual'] != '' && $dData['structual'] != 0) {
                        $laborValNew = $dData['structual'];
                        $extra =  ' S';
                    }
                    if (isset($dData['frame']) && $dData['frame'] != '' && $dData['frame'] != 0) {
                        $laborValNew = $dData['frame'];
                        $extra =  ' F';
                    }
                    if (isset($dData['user_1']) && $dData['user_1'] != '' && $dData['user_1'] != 0) {
                        $laborValNew = $dData['user_1'];
                        $extra =  ' A';
                    }
                    if (isset($dData['user_2']) && $dData['user_2'] != '' && $dData['user_2'] != 0) {
                        $laborValNew = $dData['user_2'];
                        $extra =  ' B';
                    }
                    if (isset($dData['user_3']) && $dData['user_3'] != '' && $dData['user_3'] != 0) {
                        $laborValNew = $dData['user_3'];
                        $extra =  ' C';
                    }
                    if (isset($dData['labor']) && $dData['labor'] != '' && $dData['labor'] != 0) {
                        $laborValNew = $dData['labor'];
                    }
                    if (isset($dData['mech']) && $dData['mech'] != '' && $dData['mech'] != 0) {
                        $laborValNew = $dData['mech'];
                        $extra =  ' M';
                    }
                    if (isset($inclOverlapData['ids'])) {
                        if (in_array($dData['id'], $inclOverlapData['ids'])) {
                            if ($inclOverlapData['data'][$dData['id']]['mech'] != '') {
                                $overlapDectionval = '<br><span class="font-size:8px;"> -' . $inclOverlapData['data'][$dData['id']]['mech'] . ' M</span>';
                            } else {
                                $laborValNew = 'INCL';
                            }
                            $inclMessage = '<br><span class="font-size:8px;">' . $inclOverlapData['data'][$dData['id']]['pdf_show_msg'] . '</span>';
                        }
                    }
                    /*************************************/
                    // $inclChecker = false;

                    // if ($inclMessage) {
                    //   if (str_contains($inclMessage, 'INCL')) {
                    //     $inclArr = explode('INCL', $inclMessage);
                    //     $restPart = implode(" ", $inclArr);
                    //     $inclChecker = true;
                    //     $inclMessage = '';
                    //   } else {
                    //     $inclMessage = '<br><span style="font-size:8px">' . $inclMessage . '</span>';
                    //   }
                    // }

                    // commented on oct 6 2022 by shubham
                    // if ($estData['get_est_fullData']['estimate_data']['is_supplement'] == 1 && $estData['get_est_fullData']['estimate_data']['estimate_id'] == $dData['estimate_id']) {
                    //   $suplementPassNext = 'S' . $estData['get_est_fullData']['estimate_data']['supplement_number'];
                    // } else
                    if ($estData['get_est_fullData']['estimate_data']['is_supplement'] == 1) {

                        $allSupplements = $this->db->order_by('estimate_id', 'DESC')->get_where('ca_estimates', array('parent_estimate_id' =>  $estData['get_est_fullData']['estimate_data']['parent_estimate_id'], 'is_supplement' => '1'))->result_array();
                        // echo '<pre>';
                        // print_r($allSupplements);
                        // echo '<pre>';
                        // die;

                        foreach ($allSupplements as $all) {
                            // echo $all['estimate_id'].' ';
                            // die;
                            $checkSup = $this->db->get_where('ca_estimate_select_parts_added', array('estimate_id' =>  $all['estimate_id'], 'part_id' => $dData['part_id']))->row_array();
                            if (count($checkSup) > 0) {
                                $checkSup[0]['supplement_number'] = $all['supplement_number'];
                                break;
                            }
                            $checkSup = $this->db->get_where('ca_estimate_after_part_change', array('new_estimate_id' =>  $all['estimate_id'], 'part_id' => $dData['id']))->row_array();
                            if (count($checkSup) > 0) {
                                $checkSup[0]['supplement_number'] = $all['supplement_number'];
                                break;
                            }
                        }
                        // echo '<pre>';
                        // print_r($checkSup);
                        // echo '<pre>';
                        // die;

                        // die;
                        if (count($checkSup) > 0) {
                            $suplementPassNext = 'S' . $checkSup[0]['supplement_number'];
                        }


                        // die;
                    }
                    $suplementNumber = @$estData['get_est_fullData']['supplement_no'][$dData['estimate_id']];
                    /*************************************/
                    $laborLine = $nameLine = $priceLine = $paintLine = '';
                    $showIcon = '';
                    if (isset($underLineArray[$dData['id']]) && !empty($underLineArray[$dData['id']])) {
                        $laborLine = (in_array('labor', $underLineArray[$dData['id']])) ? 'under-line' : '';
                        $nameLine = (in_array('part_name', $underLineArray[$dData['id']])) ? 'under-line' : '';
                        $priceLine = (in_array('list_price', $underLineArray[$dData['id']])) ? 'under-line' : '';
                        $paintLine = (in_array('paint', $underLineArray[$dData['id']])) ? 'under-line' : '';
                        $showIcon = '*';
                    }
                    /*************************************/
                    $qty = '';
                    if (trim($dData['oper']) == 'Repl' || trim($dData['oper']) == 'Subl') {
                        $qty = $dData['qty'];
                    }

                    if (trim($dData['oper']) == 'Subl' && $dData['markup'] == 1) {
                        $totalValPercent = ($dData['list_price'] * $dData['qty'] * 25) / 100; // Getting 25% for it
                        $finalPartPrice = $dData['list_price'] * $dData['qty'] + $totalValPercent;
                        $subletPartsListPrice += $finalPartPrice;
                    } else {
                        $finalPartPrice = $dData['list_price'] * $dData['qty'];
                        if (trim($dData['oper']) == 'Subl') {
                            $subletPartsListPrice += $finalPartPrice;
                        }
                    }
                    $finalPartPrice = ($finalPartPrice != 0) ? $finalPartPrice : '';
                    if (trim($dData['oper']) == 'Blnd') {
                        $selectedPaintOption = $this->db->get_where('ca_estimate_vehicle_options', array('estimate_id' => $estID, 'cat_id' => 11))->result_array();
                        $paintRefinishFormula = $selectedPaintOption[0]['part_id'];
                        if ($paintRefinishFormula == 39 && $dData['paint'] != '' && $dData['paint'] != 0) {
                            $finalPaintVal = ($dData['paint'] * 50) / 100;
                        } elseif ($paintRefinishFormula == 102 && $dData['paint'] != '' && $dData['paint'] != 0) {
                            $finalPaintVal = ($dData['paint'] * 70) / 100;
                        } else {
                            $finalPaintVal = ($dData['paint'] != 0) ? $dData['paint'] : '';
                        }
                    } else {
                        $finalPaintVal = ($dData['paint'] != 0) ? $dData['paint'] : '';
                    }
                    /*************************************/
                    if (!in_array($dData['tab_modify_name'], $holdTabName)) {
                        array_push($holdTabName, $dData['tab_modify_name']);
                        $TABNAME = ($dData['tab_modify_name'] != 'ZZ') ? $dData['tab_modify_name'] : '';
                        $trDetails .= '<tr><td class="border-bttm"></td><td class="border-bttm"></td><td class="border-bttm"></td><td class="border-bttm"><b>' . $TABNAME . '</b></td><td class="border-bttm"></td><td class="border-bttm"></td><td class="border-bttm"></td><td class="border-bttm"></td><td class="border-bttm"></td><td class="border-bttm"></td></tr>';
                        $trDetails .= '<tr><td>' . $counterVal . '</td><td>' . $dData['oper'] . '</td><td>' . $suplementPassNext . '</td><td><span class="' . $nameLine . '">' . $dData['note'] . ' ' . $dData['part_name'] . $inclSublMessage . $inclMessage . '</span></td><td>' . $dData['part_number'] . '</td><td>' . $qty . '</td><td><span class="' . $priceLine . '">' . @number_format($finalPartPrice, 2) . '</span></td><td><span class="' . $laborLine . '">' . ($laborValNew == "INCL" ? $laborValNew : @number_format($laborValNew, 1)) . $extra  . '</span></td><td><span class="' . $paintLine . '">' . @number_format($finalPaintVal, 1) . '</span></td></tr>';
                        // if ($inclChecker) {
                        //   $trDetails .= '<tr><td></td><td></td><td></td><td><span class="font-size:8px;">' . $restPart . '</span></td><td></td><td></td><td></td><td>INCL</td><td></td></tr>';
                        // }
                    } else {
                        $trDetails .= '<tr><td>' . $counterVal . '</td><td>' . $dData['oper'] . '</td><td>' . $suplementPassNext . '</td><td><span class="' . $nameLine . '">' . $dData['note'] . ' ' . $dData['part_name'] . $inclSublMessage . $inclMessage . '</span></td><td>' . $dData['part_number'] . '</td><td>' . $qty . '</td><td><span class="' . $priceLine . '">' .  @number_format($finalPartPrice, 2) . '</span></td><td><span class="' . $laborLine . '">' . ($laborValNew == "INCL" ? $laborValNew : @number_format($laborValNew, 1)) . $extra  . '</span></td><td><span class="' . $paintLine . '">' . @number_format($finalPaintVal, 1) . '</span></td></tr>';
                        // if ($inclChecker) {
                        //   $trDetails .= '<tr><td></td><td></td><td></td><td><span class="font-size:8px;">' . $restPart . '</span></td><td></td><td></td><td></td><td>INCL</td><td></td></tr>';
                        // }
                    }
                    $trDetails .= $refinishAdjFormulaHtml;
                    $trDetails .= $refinishFormulaHtml;
                    $counterVal++;
                }
                $trDetails .= '</table></div>';
                //$subTotalRow ='<tr><td class="end-table"></td><td class="end-table"></td><td class="end-table">SUBTOTALS</td><td class="end-table"></td><td class="end-table">'.$totalCost.'</td><td class="end-table">'.$totalLabor.'</td><td class="end-table">'.$totalPaint.'</td></tr>';
                $html = str_replace('{PART_LISTS}', $trDetails, $html);
                //$html = str_replace('{PART_SUBTOTALS}',$subTotalRow,$html);
            } else {
                $html = str_replace('{PART_LISTS}', '', $html);
                //$html = str_replace('{PART_SUBTOTALS}','',$html);
            }



            ////////////// Adding Final Calculation ////////////
            $netCostVal = 0;
            if (isset($estData['get_est_fullData']['part_info']) && !empty($estData['get_est_fullData']['part_info'])) {
                $finalReportData = $this->Muser->get_estimates_final_report($estID);
                $finalCal = '<div class="row" style="padding-bottom:5px;margin-bottom:40px;margin-top:20px;border-bottom:4px solid #89a2b9;clear:both;"></div><div style="margin-right:10px;margin-left:15px;margin-top:0px"><div class="new-break"><p style="color:#000;font-size:19px;margin-bottom:15px">ESTIMATE TOTALS:  </p>';
                if (isset($finalReportData) && !empty($finalReportData)) {

                    if ($estData['get_est_fullData']['estimate_data']['deductive_amount']) {
                        $deductibleAmt =   $estData['get_est_fullData']['estimate_data']['deductive_amount'];
                    } else {
                        $deductibleAmt = 0;
                    }

                    $netCostVal = $finalReportData["total_cost_repairs"] - $deductibleAmt;
                    $totalBLabor = $finalReportData["body_labor"] * $finalReportData["body_labor_rate"];
                    $totalPLabor = $finalReportData["paint_labor"] * $finalReportData["paint_labor_rate"];
                    $totalPSLabor = $finalReportData["paint_supplies"] * $finalReportData["paint_supplies_rate"];
                    $totalMLabor = $finalReportData["mechanical_labor"] * $finalReportData["mechanical_labor_rate"];
                    $totalFLabor = $finalReportData["frame_labor"] * $finalReportData["frame_labor_rate"];
                    $totalSLabor = $finalReportData["structual_labor"] * $finalReportData["structual_labor_rate"];
                    $totalGLabor = $finalReportData["glass_labor"] * $finalReportData["glass_labor_rate"];
                    $totalU1Labor = $finalReportData["user_1"] * $finalReportData["user_1_rate"];
                    $totalU2Labor = $finalReportData["user_2"] * $finalReportData["user_2_rate"];
                    $totalU3Labor = $finalReportData["user_3"] * $finalReportData["user_3_rate"];
                    $salesTaxCal = ($finalReportData["sales_tax"] * $finalReportData["sales_tax_percent"]) / 100;
                    $finalCal .=   '<p style="font-size:14px">Body Labor: ' . @number_format($finalReportData["body_labor"], 2) . ' hrs @ $' . @number_format($finalReportData["body_labor_rate"], 2) . ' /hr &nbsp;&nbsp;' . @number_format($totalBLabor, 2) . '</p>
                       <p style="font-size:14px">Paint Labor: ' . @number_format($finalReportData["paint_labor"], 2) . ' hrs @ $' . @number_format($finalReportData["paint_labor_rate"], 2) . ' /hr &nbsp;&nbsp;' . @number_format($totalPLabor, 2) . '</p>
                       <p style="font-size:14px">Mechanical Labor: ' . @number_format($finalReportData["mechanical_labor"], 2) . ' hrs @ $' . @number_format($finalReportData["mechanical_labor_rate"], 2) . ' /hr &nbsp;&nbsp;' . @number_format($totalMLabor, 2) . '</p>
                       <p style="font-size:14px">Frame Labor: ' . @number_format($finalReportData["frame_labor"], 2) . ' hrs @ $' . @number_format($finalReportData["frame_labor_rate"], 2) . ' /hr &nbsp;&nbsp;' . @number_format($totalFLabor, 2) . '</p>
                       <p style="font-size:14px">Structual Labor: ' . @number_format($finalReportData["structual_labor"], 2) . ' hrs @ $' . @number_format($finalReportData["structual_labor_rate"], 2) . ' /hr &nbsp;&nbsp;' . @number_format($totalSLabor, 2) . '</p>
                       <p style="font-size:14px">Glass Labor: ' . @number_format($finalReportData["glass_labor"], 2) . ' hrs @ $' . @number_format($finalReportData["glass_labor_rate"], 2) . ' /hr &nbsp;&nbsp;' . @number_format($totalGLabor, 2) . '</p>

                       <p style="font-size:14px">' . ($days_to_repair_value[0]['userdefined1_head'] ? $days_to_repair_value[0]['userdefined1_head'] : 'User Defined A') . ': ' . @number_format($finalReportData["user_1"], 2) . ' hrs @ $' . @number_format($finalReportData["user_1_rate"], 2) . ' /hr &nbsp;&nbsp;' . @number_format($totalU1Labor, 2) . '</p>
                       <p style="font-size:14px">' . ($days_to_repair_value[0]['userdefined2_head'] ? $days_to_repair_value[0]['userdefined2_head'] : 'User Defined B') . ': ' . @number_format($finalReportData["user_2"], 2) . ' hrs @ $' . @number_format($finalReportData["user_2_rate"], 2) . ' /hr &nbsp;&nbsp;' . @number_format($totalU2Labor, 2) . '</p>
                       <p style="font-size:14px">' . ($days_to_repair_value[0]['userdefined3_head'] ? $days_to_repair_value[0]['userdefined3_head'] : 'User Defined C') . ': ' . @number_format($finalReportData["user_3"], 2) . ' hrs @ $' . @number_format($finalReportData["user_3_rate"], 2) . ' /hr &nbsp;&nbsp;' . @number_format($totalU3Labor, 2) . '</p>

                       <p style="font-size:14px">Paint Supplies: ' . @number_format($finalReportData["paint_supplies"], 2) . ' hrs @ $' . @number_format($finalReportData["paint_supplies_rate"], 2) . ' /hr &nbsp;&nbsp;' . @number_format($totalPSLabor, 2) . '</p>
                       <p style="font-size:14px">Parts: $' . @number_format(($finalReportData["parts"] - $subletPartsListPrice), 2) . '</p>
                       <p style="font-size:14px">Sublet: $' . @number_format($subletPartsListPrice, 2) . '</p>
                       <p style="font-size:14px">Subtotal: $' . @number_format(($finalReportData["parts"] + $totalU3Labor + $totalU2Labor + $totalU1Labor + $totalBLabor + $totalPLabor + $totalMLabor + $totalFLabor + $totalSLabor + $totalGLabor + $totalPSLabor), 2) . ' </p>
                       <p style="font-size:14px">Sales Tax: $' . @number_format($finalReportData["sales_tax"], 2) . ' @' . $finalReportData["sales_tax_percent"] . '% &nbsp;&nbsp;$' . @number_format($salesTaxCal, 2) . '</p>
                       <p style="font-size:14px">Total Cost of Repairs: $' . @number_format($finalReportData["total_cost_repairs"], 2) . ' </p>
                       <p style="font-size:14px">Deductible: $' . @number_format($deductibleAmt, 2) . '</p>
                       <p style="color:#000;font-size:18px;margin-top:-4px">Net Cost of Repairs: $' . @number_format($netCostVal, 2) . ' </p>';
                    $finalCal .= '</div></div>';
                }
                $html = str_replace('{FINAL_CALCULATION}', $finalCal, $html);
            } else {
                $html = str_replace('{FINAL_CALCULATION}', '', $html);
            }

            /////////////////// Adding New Content In the Pdf /////////////////


            if (isset($estData['get_est_fullData']['part_info']) && !empty($estData['get_est_fullData']['part_info'])) {
                $newContent = '<div class="new-break-1" style="font-size:12px;font-family:helvetica;margin-top:60px;padding-right:15px;margin-left:15px">
                        <p style="font-size:16px;"><b>Terms & Abbreviations</b></p>
                       <p><u><strong>Underlined</strong></u> items indicate item has been manually changed.</p>
                        <p><strong>OEM:</strong> Indicates <strong>O</strong>riginal <strong>E</strong>quipment <strong>M</strong>anufacturer. This is a brand new part from the dealership.</p>
                        <p><strong>A/M:</strong> Indicates an aftermarket part, that is a part manufactured by a company other than the vehicle manufacturer.</p>
                        <p><strong>LKQ:</strong> Indicates <strong>L</strong>ike <strong>K</strong>ind <strong>Q</strong>uality. Typically this is another term for a used/salvage OEM part.</p>
                        <p><strong>RECOND:</strong> Indicates a reconditioned/refurbished OEM part. This is a part that was previously damaged in some way and has been
                        restored into working order.</p>
                        <p><strong>LABOR CODES:</strong> M indicates a Mechanical operation, S indicates a Structural operation and F indicates a Frame operation.</p>
                        <p><strong>LABOR ABBREVIATIONS:</strong> R&I is Remove & Install, Repl is Replace, Rpr is Repair, Ref is Refinish, Blnd is Blend, Subl is Sublet.</p>
                        <p>Quicksheet Mobile Collision Estimator is a product of EZ-DV,LLC.</p>
                        <p>© ' . date('Y') . ' EZ-DV, LLC. All Rights Reserved</p>
                       </div>';

                $newContent .= '<table style="font-size:12px;"><tr>';
                $newContent .= '<td style="vertical-align:top;" colspan="2"><ul style="list-style-type: none;">';

                $newContent .=  "<br><br><br> <p><strong><span style='margin-bottom:5px'> Work Authorization:</span><br>
                          I hereby authorize this repair shop and/or individual(s) named on estimate to make necessary
                          repairs in accordance with<br> this written
                             estimate or that written by the insurance company referenced above. This estimate of repairs
                         includes parts, labor and diagnosis. Parts prices quoted are current, but are subject to change
                          upon notice by manufacturer. If upon<br>further inspection additional parts and/or repairs are
                            needed, I will be contacted for authorization.<br/><br/> </strong></p>";
                $newContent .= '</ul></td></tr>';

                $newContent .=  '<tr><td style="vertical-align:top;"><ul style="list-style-type: none;">     <b>X______________________________  </b>                </td> </ul><td style="vertical-align:top;"><ul style="list-style-type: none;">   <b>_________________________  </b>                 </td> </ul>    </tr>';


                $newContent .=  '<tr><td style="vertical-align:top;"><ul style="list-style-type: none;"> <b>Signature of Vehicle Owner</b></td> </ul><td style="vertical-align:top;"><ul style="list-style-type: none;"><b>Date</b></td> </ul></tr>';


                $newContent  .= '</table>';



                $html = str_replace('{CONTENT_MSG}', $newContent, $html);
            } else {
                $html = str_replace('{CONTENT_MSG}', '', $html);
            }

            ////////////////// Adding Supplement Summary ///////////////////////

            if ($estData['get_est_fullData']['estimate_data']['is_supplement'] == 1) {
                $holdTabName = array();
                $finalSupReportData = $this->Muser->get_supplement_summary($estID);
                $finalCal = '';
                $supplementHtml = '';
                $subletPartsListPrice1 = 0;
                // if (isset($finalSupReportData['part_info_sup']) && !empty($finalSupReportData['part_info_sup'])) {
                $underLineArray1 = $this->Muser->underline_keys($estID);
                $refinishRuleData1 = $this->Muser->get_refinish_rule_data($estID);
                $refinishRuleAdjData1 = $this->Muser->get_refinish_adj_rule_data($estID);
                $inclOverlapData1 = $finalSupReportData['overlap_sup'];
                $suplementPassNext = $estData['get_est_fullData']['estimate_data']['supplement_number'];

                $supplementHtml = '<br><br><p style="page-break-before: always;text-align:center;font-size:16px;"><b>SUPPLEMENT SUMMARY</b></p>';

                $cont = 1;

                if (isset($changeditem) && !empty($changeditem)) {

                    $supplementHtml .= '<h4 style="margin-top:20px;margin-bottom:8px">Changed Items</h4>';
                    $supplementHtml .=   '     <table class="table" style="border-collapse: collapse;width:100%;" cellpadding="0" cellspacing="0" ">
            <tr style="font-size:12px;border-bottom:4px solid #89a2b9;border-top:4px solid #89a2b9;padding:5px 0">
            <th style="padding: 0 5px; text-align:left;">Line</th>
            <th style="padding: 0 5px; text-align:left;">Operation</th>
            <th style="padding: 0 5px; text-align:left;">Description</th>
            <th style="padding: 0 5px; text-align:left;">Part Number</th>
            <th style="padding: 0 5px; text-align:left;">Qty</th>
            <th style="padding: 0 5px; text-align:left;">Price</th>
            <th style="padding: 0 5px; text-align:left;">Labor</th>
            <th style="padding: 0 5px; text-align:left;">Refinish</th>
            </tr>';



                    foreach ($changeditem as $pinfo) {
                        if (isset($underLineArray[$pinfo['id']]) && !empty($underLineArray[$pinfo['id']])) {
                            $laborLine = (in_array('labor', $underLineArray[$pinfo['id']])) ? 'under-line' : '';
                            $nameLine = (in_array('part_name', $underLineArray[$pinfo['id']])) ? 'under-line' : '';
                            $priceLine = (in_array('list_price', $underLineArray[$pinfo['id']])) ? 'under-line' : '';
                            $paintLine = (in_array('paint', $underLineArray[$pinfo['id']])) ? 'under-line' : '';
                            $showIcon = '*';
                        }
                        $extraStr = '';
                        $laborValNew = null;
                        $csuplementPassNext = '';
                        $allSupplements = $this->db->order_by('estimate_id', 'DESC')->get_where('ca_estimates', array('parent_estimate_id' =>  $estData['get_est_fullData']['estimate_data']['parent_estimate_id'], 'is_supplement' => '1'))->result_array();
                        // echo '<pre>';
                        // print_r($allSupplements);
                        // echo '<pre>';
                        // die;

                        foreach ($allSupplements as $all) {
                            // echo $all['estimate_id'].' ';
                            // die;
                            // $checkSup = $this->db->get_where('ca_estimate_select_parts_added', array('estimate_id' =>  $all['estimate_id'], 'part_id' => $dData['part_id']))->row_array();
                            // if (count($checkSup) > 0) {
                            //   $checkSup[0]['supplement_number'] = $all['supplement_number'];
                            //   break;
                            // }
                            $checkSup = $this->db->get_where('ca_estimate_after_part_change', array('new_estimate_id' =>  $all['estimate_id'], 'part_id' => $pinfo['id']))->row_array();
                            if (count($checkSup) > 0) {
                                $checkSup[0]['supplement_number'] = $all['supplement_number'];
                                break;
                            }
                        }

                        if (count($checkSup) > 0) {
                            $csuplementPassNext = 'S' . $checkSup[0]['supplement_number'];
                        }

                        if (isset($pinfo['glass']) && $pinfo['glass'] != '' && $pinfo['glass'] != 0) {
                            $extraStr = ' G';
                            $laborValNew = $pinfo['glass'];
                        }
                        if (isset($pinfo['structual']) && $pinfo['structual'] != '' && $pinfo['structual'] != 0) {
                            $laborValNew = $pinfo['structual'];
                            $extraStr = ' S';
                        }
                        if (isset($pinfo['frame']) && $pinfo['frame'] != '' && $pinfo['frame'] != 0) {
                            $extraStr = ' F';
                            $laborValNew = $pinfo['frame'];
                        }
                        if (isset($pinfo['user_1']) && $pinfo['user_1'] != '' && $pinfo['user_1'] != 0) {
                            $extraStr = ' A';
                            $laborValNew = $pinfo['user_1'];
                        }
                        if (isset($pinfo['user_2']) && $pinfo['user_2'] != '' && $pinfo['user_2'] != 0) {
                            $extraStr = ' B';
                            $laborValNew = $pinfo['user_2'];
                        }
                        if (isset($pinfo['user_3']) && $pinfo['user_3'] != '' && $pinfo['user_3'] != 0) {
                            $extraStr = ' C';
                            $laborValNew = $pinfo['user_3'];
                        }
                        if (isset($pinfo['labor']) && $pinfo['labor'] != '' && $pinfo['labor'] != 0) {
                            $laborValNew = $pinfo['labor'];
                            $extraStr = '';
                        }

                        $supplementHtml .=   '<tr style="font-size:12px">';
                        $supplementHtml .= '<td scope="row">' . $cont . '</td>';
                        $supplementHtml .= '<td>' . $pinfo['oper'] . '</td>';
                        $supplementHtml .= '<td><span class=' . $nameLine . '>' . ($csuplementPassNext ? $csuplementPassNext . ' ' : '') . $pinfo['part_name'] . '</span></td>';
                        $supplementHtml .= '<td>' . $pinfo['part_number'] . '</td>';
                        $supplementHtml .= '<td>';
                        if (strtolower(trim($pinfo['oper'])) == 'repl' || strtolower(trim($pinfo['oper'])) == 'subl') {
                            $supplementHtml .=  $pinfo['qty'];
                        } else {
                            $supplementHtml .= '<p class="pl-3">' . $pinfo['qty'] . '</p>';
                        }
                        $supplementHtml .= '</td>';
                        if (($pinfo['oper'] == "Rpr" || $pinfo['oper'] == "Ref") && !$pinfo['list_price']) {
                            $pinfo['list_price'] = null;
                            $priceLine = '';
                        } else {
                            $pinfo['list_price'] = @number_format($pinfo['list_price'], 2);
                        }
                        if ($pinfo['oper'] == "Ref" && !$laborValNew) {
                            $laborValNew = null;
                            $laborLine = '';
                        } else {
                            $laborValNew = @number_format($laborValNew, 1);
                        }
                        $supplementHtml .= '<td><span class=' . $priceLine . '>' . $pinfo['list_price'] . '</span></td>';
                        $supplementHtml .= '<td><span class=' . $laborLine . '>' . $laborValNew . $extraStr . '</span></td>';
                        $supplementHtml .= '<td><span class=' . $showIcon . '>' . @number_format($pinfo['paint'], 1) . '</span></td>';
                        $supplementHtml .= '</tr>';
                        $cont++;
                    }

                    $supplementHtml .=   '</table>';
                }







                if (isset($deleteditem) && !empty($deleteditem)) {
                    $supplementHtml .= '<h4 style="margin-bottom:8px">Deleted Items</h4>';
                    $supplementHtml .=   '<table class="table" style="border-collapse: collapse;width:100%;" cellpadding="0" cellspacing="0" ">
            <tr style="font-size:12px;border-bottom:4px solid #89a2b9;border-top:4px solid #89a2b9;padding:5px 0">
            <th style="padding: 0 5px; text-align:left;">Line</th>
            <th style="padding: 0 5px; text-align:left;">Operation</th>
            <th style="padding: 0 5px; text-align:left;">Description</th>
            <th style="padding: 0 5px; text-align:left;">Part Number</th>
            <th style="padding: 0 5px; text-align:left;">Qty</th>
            <th style="padding: 0 5px; text-align:left;">Price</th>
            <th style="padding: 0 5px; text-align:left;">Labor</th>
            <th style="padding: 0 5px; text-align:left;">Refinish</th>
            </tr>';
                    foreach ($deleteditem as $pinfo) {
                        if (isset($underLineArray[$pinfo['id']]) && !empty($underLineArray[$pinfo['id']])) {
                            $laborLine = (in_array('labor', $underLineArray[$pinfo['id']])) ? 'under-line' : '';
                            $nameLine = (in_array('part_name', $underLineArray[$pinfo['id']])) ? 'under-line' : '';
                            $priceLine = (in_array('list_price', $underLineArray[$pinfo['id']])) ? 'under-line' : '';
                            $paintLine = (in_array('paint', $underLineArray[$pinfo['id']])) ? 'under-line' : '';
                            $showIcon = '*';
                        }
                        $csuplementPassNext = '';
                        foreach ($allSupplements as $all) {
                            // echo $all['estimate_id'].' ';
                            // die;
                            $checkSup = $this->db->get_where('ca_estimate_select_parts_deleted', array('estimate_id' =>  $all['estimate_id'], 'part_id' => $pinfo['part_id']))->row_array();
                            if (count($checkSup) > 0) {
                                $checkSup[0]['supplement_number'] = $all['supplement_number'];
                                break;
                            }
                            // $checkSup = $this->db->get_where('ca_estimate_after_part_change', array('new_estimate_id' =>  $all['estimate_id'], 'part_id' => $pinfo['id']))->row_array();
                            // if (count($checkSup) > 0) {
                            //   $checkSup[0]['supplement_number'] = $all['supplement_number'];
                            //   break;
                            // }
                        }

                        if (count($checkSup) > 0) {
                            $csuplementPassNext = 'S' . $checkSup[0]['supplement_number'];
                        }
                        $extraStr = '';
                        $laborValNew = null;
                        if (isset($pinfo['glass']) && $pinfo['glass'] != '' && $pinfo['glass'] != 0) {
                            $extraStr = ' G';
                            $laborValNew = $pinfo['glass'];
                        }
                        if (isset($pinfo['structual']) && $pinfo['structual'] != '' && $pinfo['structual'] != 0) {
                            $laborValNew = $pinfo['structual'];
                            $extraStr = ' S';
                        }
                        if (isset($pinfo['frame']) && $pinfo['frame'] != '' && $pinfo['frame'] != 0) {
                            $extraStr = ' F';
                            $laborValNew = $pinfo['frame'];
                        }
                        if (isset($pinfo['user_1']) && $pinfo['user_1'] != '' && $pinfo['user_1'] != 0) {
                            $extraStr = ' A';
                            $laborValNew = $pinfo['user_1'];
                        }
                        if (isset($pinfo['user_2']) && $pinfo['user_2'] != '' && $pinfo['user_2'] != 0) {
                            $extraStr = ' B';
                            $laborValNew = $pinfo['user_2'];
                        }
                        if (isset($pinfo['user_3']) && $pinfo['user_3'] != '' && $pinfo['user_3'] != 0) {
                            $extraStr = ' C';
                            $laborValNew = $pinfo['user_3'];
                        }
                        if (isset($pinfo['labor']) && $pinfo['labor'] != '' && $pinfo['labor'] != 0) {
                            $laborValNew = $pinfo['labor'];
                            $extraStr = '';
                        }

                        $supplementHtml .=   '<tr style="font-size:12px">';
                        $supplementHtml .= '<td scope="row">' . $cont . '</td>';
                        $supplementHtml .= '<td>' . $pinfo['oper'] . '</td>';
                        $supplementHtml .= '<td><span class=' . $nameLine . '>' . ($csuplementPassNext ? $csuplementPassNext . ' ' : '') . $pinfo['part_name'] . '</span></td>';
                        $supplementHtml .= '<td>' . $pinfo['part_number'] . '</td>';
                        $supplementHtml .= '<td>';
                        if (strtolower(trim($pinfo['oper'])) == 'repl' || strtolower(trim($pinfo['oper'])) == 'subl') {
                            $supplementHtml .=  $pinfo['qty'];
                        } else {
                            $supplementHtml .= '<p class="pl-3">' . $pinfo['qty'] . '</p>';
                        }
                        $supplementHtml .= '</td>';
                        if (($pinfo['oper'] == "Rpr" || $pinfo['oper'] == "Ref") && !$pinfo['list_price']) {
                            $pinfo['list_price'] = null;
                            $priceLine = '';
                        } else {
                            $pinfo['list_price'] = @number_format($pinfo['list_price'], 2);
                        }
                        if ($pinfo['oper'] == "Ref" && !$laborValNew) {
                            $laborValNew = null;
                            $laborLine = '';
                        } else {
                            $laborValNew = @number_format($laborValNew, 1);
                        }
                        $supplementHtml .= '<td><span class=' . $priceLine . '>' . $pinfo['list_price'] . '</span></td>';
                        $supplementHtml .= '<td><span class=' . $laborLine . '>' . $laborValNew . $extraStr . '</span></td>';
                        $supplementHtml .= '<td><span class=' . $showIcon . '>' . @number_format($pinfo['paint'], 1) . '</span></td>';
                        $supplementHtml .= '</tr>';
                        $cont++;
                    }
                    $supplementHtml .= '</table>';
                }








                if (isset($addeditem) && !empty($addeditem)) {
                    $supplementHtml .= '<h4 style="margin-bottom:8px">Added Items</h4>';
                    $supplementHtml .=   '<table class="table" style="border-collapse: collapse;width:100%;" cellpadding="0" cellspacing="0" ">
            <tr style="font-size:12px;border-bottom:4px solid #89a2b9;border-top:4px solid #89a2b9;padding:5px 0">
            <th style="padding: 0 5px; text-align:left;">Line</th>
            <th style="padding: 0 5px; text-align:left;">Operation</th>
            <th style="padding: 0 5px; text-align:left;">Description</th>
            <th style="padding: 0 5px; text-align:left;">Part Number</th>
            <th style="padding: 0 5px; text-align:left;">Qty</th>
            <th style="padding: 0 5px; text-align:left;">Price</th>
            <th style="padding: 0 5px; text-align:left;">Labor</th>
            <th style="padding: 0 5px; text-align:left;">Refinish</th>
            </tr>';


                    foreach ($addeditem as $pinfo) {
                        if (isset($underLineArray[$pinfo['id']]) && !empty($underLineArray[$pinfo['id']])) {
                            $laborLine = (in_array('labor', $underLineArray[$pinfo['id']])) ? 'under-line' : '';
                            $nameLine = (in_array('part_name', $underLineArray[$pinfo['id']])) ? 'under-line' : '';
                            $priceLine = (in_array('list_price', $underLineArray[$pinfo['id']])) ? 'under-line' : '';
                            $paintLine = (in_array('paint', $underLineArray[$pinfo['id']])) ? 'under-line' : '';
                            $showIcon = '*';
                        }
                        $csuplementPassNext = '';

                        foreach ($allSupplements as $all) {
                            // echo $all['estimate_id'].' ';
                            // die;
                            $checkSup = $this->db->get_where('ca_estimate_select_parts_added', array('estimate_id' =>  $all['estimate_id'], 'part_id' => $pinfo['part_id']))->row_array();
                            if (count($checkSup) > 0) {
                                $checkSup[0]['supplement_number'] = $all['supplement_number'];
                                break;
                            }
                            // $checkSup = $this->db->get_where('ca_estimate_after_part_change', array('new_estimate_id' =>  $all['estimate_id'], 'part_id' => $dData['id']))->row_array();
                            // if (count($checkSup) > 0) {
                            //   $checkSup[0]['supplement_number'] = $all['supplement_number'];
                            //   break;
                            // }
                        }

                        if (count($checkSup) > 0) {
                            $csuplementPassNext = 'S' . $checkSup[0]['supplement_number'];
                        }
                        $extraStr = '';
                        $laborValNew = null;
                        if (isset($pinfo['glass']) && $pinfo['glass'] != '' && $pinfo['glass'] != 0) {
                            $extraStr = ' G';
                            $laborValNew = $pinfo['glass'];
                        }
                        if (isset($pinfo['structual']) && $pinfo['structual'] != '' && $pinfo['structual'] != 0) {
                            $laborValNew = $pinfo['structual'];
                            $extraStr = ' S';
                        }
                        if (isset($pinfo['frame']) && $pinfo['frame'] != '' && $pinfo['frame'] != 0) {
                            $extraStr = ' F';
                            $laborValNew = $pinfo['frame'];
                        }
                        if (isset($pinfo['user_1']) && $pinfo['user_1'] != '' && $pinfo['user_1'] != 0) {
                            $extraStr = ' A';
                            $laborValNew = $pinfo['user_1'];
                        }
                        if (isset($pinfo['user_2']) && $pinfo['user_2'] != '' && $pinfo['user_2'] != 0) {
                            $extraStr = ' B';
                            $laborValNew = $pinfo['user_2'];
                        }
                        if (isset($pinfo['user_3']) && $pinfo['user_3'] != '' && $pinfo['user_3'] != 0) {
                            $extraStr = ' C';
                            $laborValNew = $pinfo['user_3'];
                        }
                        if (isset($pinfo['labor']) && $pinfo['labor'] != '' && $pinfo['labor'] != 0) {
                            $laborValNew = $pinfo['labor'];
                            $extraStr = '';
                        }

                        $supplementHtml .=   '<tr style="font-size:12px">';
                        $supplementHtml .= '<td scope="row">' . $cont . '</td>';
                        $supplementHtml .= '<td>' . $pinfo['oper'] . '</td>';
                        $supplementHtml .= '<td><span class=' . $nameLine . '>' . ($csuplementPassNext ? $csuplementPassNext . ' ' : '') . $pinfo['part_name'] . '</span></td>';
                        $supplementHtml .= '<td>' . $pinfo['part_number'] . '</td>';
                        $supplementHtml .= '<td>';
                        if (strtolower(trim($pinfo['oper'])) == 'repl' || strtolower(trim($pinfo['oper'])) == 'subl') {
                            $supplementHtml .=  $pinfo['qty'];
                        } else {
                            $supplementHtml .= '<p class="pl-3">' . $pinfo['qty'] . '</p>';
                        }
                        $supplementHtml .= '</td>';
                        if (($pinfo['oper'] == "Rpr" || $pinfo['oper'] == "Ref") && !$pinfo['list_price']) {
                            $pinfo['list_price'] = null;
                            $priceLine = '';
                        } else {
                            $pinfo['list_price'] = @number_format($pinfo['list_price'], 2);
                        }
                        if ($pinfo['oper'] == "Ref" && !$laborValNew) {
                            $laborValNew = null;
                            $laborLine = '';
                        } else {
                            $laborValNew = @number_format($laborValNew, 1);
                        }
                        $supplementHtml .= '<td><span class=' . $priceLine . '>' . $pinfo['list_price'] . '</span></td>';
                        $supplementHtml .= '<td><span class=' . $laborLine . '>' . $laborValNew . $extraStr . '</span></td>';
                        $supplementHtml .= '<td><span class=' . $showIcon . '>' . @number_format($pinfo['paint'], 1) . '</span></td>';
                        $supplementHtml .= '</tr>';
                        $cont++;
                    }

                    $supplementHtml .= '</table>';
                }

                // 08 July deleted item ends 

                $supplementHtml .= '</table>';
                $supplementHtml .= '<div style="width:480px;font-size:14px;border:2px solid #2A2732;padding:10px;color:#2A2732;page-break-inside:avoid;display: inline-block;margin-left:15px;margin-top:15px" class="final-report-css">
          <p style="color:#000;font-size:19px;margin-bottom:15px">Supplement Totals Summary:  </p>';
                $netCostVal1 = $finalSupReportData['final_report_sup']["total_cost_repairs"];
                $totalBLabor1 = $finalSupReportData['final_report_sup']["body_labor"] * $finalSupReportData['final_report_sup']["body_labor_rate"];
                $totalPLabor1 = $finalSupReportData['final_report_sup']["paint_labor"] * $finalSupReportData['final_report_sup']["paint_labor_rate"];
                $totalPSLabor1 = $finalSupReportData['final_report_sup']["paint_supplies"] * $finalSupReportData['final_report_sup']["paint_supplies_rate"];
                $totalMLabor1 = $finalSupReportData['final_report_sup']["mechanical_labor"] * $finalSupReportData['final_report_sup']["mechanical_labor_rate"];
                $totalFLabor1 = $finalSupReportData['final_report_sup']["frame_labor"] * $finalSupReportData['final_report_sup']["frame_labor_rate"];
                $totalSLabor1 = $finalSupReportData['final_report_sup']["structual_labor"] * $finalSupReportData['final_report_sup']["structual_labor_rate"];
                $totalGLabor1 = $finalSupReportData['final_report_sup']["glass_labor"] * $finalSupReportData['final_report_sup']["glass_labor_rate"];
                $totalU1Labor1 = $finalSupReportData['final_report_sup']["user_1"] * $finalSupReportData['final_report_sup']["user_1_rate"];
                $totalU2Labor1 = $finalSupReportData['final_report_sup']["user_2"] * $finalSupReportData['final_report_sup']["user_2_rate"];
                $totalU3Labor1 = $finalSupReportData['final_report_sup']["user_3"] * $finalSupReportData['final_report_sup']["user_3_rate"];
                $salesTaxCal1 = ($finalSupReportData['final_report_sup']["sales_tax"] * $finalSupReportData['final_report_sup']["sales_tax_percent"]) / 100;
                $supplementHtml  .=   '<p>Body Labor: ' . @number_format($finalSupReportData['final_report_sup']["body_labor"], 2) . ' hrs @ $' . @number_format($finalSupReportData['final_report_sup']["body_labor_rate"], 2) . ' /hr &nbsp;&nbsp;' . @number_format($totalBLabor1, 2) . '</p>
 <p>Paint Labor: ' . @number_format($finalSupReportData['final_report_sup']["paint_labor"], 2) . ' hrs @ $' . @number_format($finalSupReportData['final_report_sup']["paint_labor_rate"], 2) . ' /hr &nbsp;&nbsp;' . @number_format($totalPLabor1, 2) . '</p>
 <p>Mechanical Labor: ' . @number_format($finalSupReportData['final_report_sup']["mechanical_labor"], 2) . ' hrs @ $' . @number_format($finalSupReportData['final_report_sup']["mechanical_labor_rate"], 2) . ' /hr &nbsp;&nbsp;' . @number_format($totalMLabor1, 2) . '</p>
 <p>Frame Labor: ' . @number_format($finalSupReportData['final_report_sup']["frame_labor"], 2) . ' hrs @ $' . @number_format($finalSupReportData['final_report_sup']["frame_labor_rate"], 2) . ' /hr &nbsp;&nbsp;' . @number_format($totalFLabor1, 2) . '</p>
 <p>Structual Labor: ' . @number_format($finalSupReportData['final_report_sup']["structual_labor"], 2) . ' hrs @ $' . @number_format($finalSupReportData['final_report_sup']["structual_labor_rate"], 2) . ' /hr &nbsp;&nbsp;' . @number_format($totalSLabor1, 2) . '</p>
 <p>Glass Labor: ' . @number_format($finalSupReportData['final_report_sup']["glass_labor"], 2) . ' hrs @ $' . @number_format($finalSupReportData['final_report_sup']["glass_labor_rate"], 2) . ' /hr &nbsp;&nbsp;' . @number_format($totalGLabor1, 2) . '</p>
 <p>' . ($days_to_repair_value[0]['userdefined1_head'] ? $days_to_repair_value[0]['userdefined1_head'] : 'User Defined A') . ': ' . @number_format($finalSupReportData['final_report_sup']["user_1"], 2) . ' hrs @ $' . @number_format($finalSupReportData['final_report_sup']["user_1_rate"], 2) . ' /hr &nbsp;&nbsp;' . @number_format($totalU1Labor1, 2) . '</p>
 <p>' . ($days_to_repair_value[0]['userdefined2_head'] ? $days_to_repair_value[0]['userdefined2_head'] : 'User Defined B') . ': ' . @number_format($finalSupReportData['final_report_sup']["user_2"], 2) . ' hrs @ $' . @number_format($finalSupReportData['final_report_sup']["user_2_rate"], 2) . ' /hr &nbsp;&nbsp;' . @number_format($totalU2Labor1, 2) . '</p>
 <p>' . ($days_to_repair_value[0]['userdefined3_head'] ? $days_to_repair_value[0]['userdefined3_head'] : 'User Defined C') . ': ' . @number_format($finalSupReportData['final_report_sup']["user_3"], 2) . ' hrs @ $' . @number_format($finalSupReportData['final_report_sup']["user_3_rate"], 2) . ' /hr &nbsp;&nbsp;' . @number_format($totalU3Labor1, 2) . '</p>
 
 <p>Paint Supplies: ' . @number_format($finalSupReportData['final_report_sup']["paint_supplies"], 2) . ' hrs @ $' . @number_format($finalSupReportData['final_report_sup']["paint_supplies_rate"], 2) . ' /hr &nbsp;&nbsp;' . @number_format($totalPSLabor1, 2) . '</p>
 <p>Parts: $' . @number_format(($finalSupReportData['final_report_sup']["parts"] - $subletPartsListPrice1), 2) . '</p>
 <p>Sublet: $' . @number_format($subletPartsListPrice1, 2) . '</p>
 <p>Subtotal: $' . @number_format(($finalSupReportData['final_report_sup']["parts"] + $totalU1Labor1 + $totalU2Labor1 + $totalU3Labor1 + $totalBLabor1 + $totalPLabor1 + $totalMLabor1 + $totalFLabor1 + $totalSLabor1 + $totalGLabor1 + $totalPSLabor1), 2) . ' </p>
 <p>Sales Tax: $' . @number_format($finalSupReportData['final_report_sup']["sales_tax"], 2) . ' @' . $finalSupReportData['final_report_sup']["sales_tax_percent"] . '% &nbsp;&nbsp;$' . @number_format($salesTaxCal1, 2) . '</p>
 <p>Total Cost of Repairs: $' . @number_format($netCostVal, 2) . ' </p>
 <p style="color:#000;font-size:18px;margin-bottom:0;margin-top:-4px">Net Cost of Supplement: $' . @number_format($netCostVal1, 2) . ' </p>';
                $supplementHtml .= '</div>';
                // }

                $supplementDiffer = '<br><br><div style="text-align:center;page-break-inside:avoid"><p style="text-align:center;font-size:16px;"><b>ESTIMATE AND SUPPLEMENT(S) TOTAL</b></p>';
                $supplementDiffer .= '<p style="padding-bottom:2px;margin:0;text-align:center;font-size:16px;font-weight:900;border-bottom:4px solid #89a2b9;"></p><br><table style="font-size:15px;">';
                $supplementDiffer .= '<tr><td width="25%"></td><td width="25%">Estimate</td><td width="15%">$' . @number_format(($netCostVal - $netCostVal1), 2) . '</td><td width="20%">&nbsp;&nbsp;' . $written_by . '</td><td width="15%"></td></tr>';
                $supplementDiffer .= '<tr><td width="25%"></td><td width="25%">Supplement ' . $suplementPassNext . '</td><td width="15%" style="border-bottom:1px solid #000;">$' . @number_format($netCostVal1, 2) . '</td><td width="20%">&nbsp;&nbsp;' . $written_by . '</td><td width="15%"></td></tr>';
                $supplementDiffer .= '<tr><td width="25%"></td><td width="25%"></td><td width="15%"></td><td width="20%"></td><td width="15%"></td></tr>';
                $supplementDiffer .= '<tr><td width="25%" height="40"></td><td width="25%" height="40"><b>NET COST OF REPAIRS :</b></td><td width="15%" height="40"><b>$' . @number_format($netCostVal, 2) . '</b></td><td width="20%" height="40"></td><td width="15%" height="40"></td></tr>';
                $supplementDiffer .= '</table></div>';
                $html = str_replace('{SUPPLEMENT_SUMMARY}', $supplementHtml, $html);
                $html = str_replace('{SUPPLEMENT_EST_DIFF}', $supplementDiffer, $html);
            } else {
                $html = str_replace('{SUPPLEMENT_SUMMARY}', '', $html);
                $html = str_replace('{SUPPLEMENT_EST_DIFF}', '', $html);
            }


            ///////////////// Adding Photos In Pdf /////////////
            $groupUploadsImage = '';
            if (isset($estData['photos']) && !empty($estData['photos'])) {
                $counter = 1;
                foreach ($estData['photos'] as $pht) {
                    if ($counter % 6 == 1 || $counter == 1) {
                        $groupUploadsImage .= '<div class="row" style="page-break-before: always;margin:auto;text-align:center;margin-top:30px;padding:0px;">';
                    }
                    if ($counter % 2 == 1) {
                        $groupUploadsImage .= '<div class="col-md-10" style="text-align:left;top:0px;margin:0px;padding:0px;">';
                    }
                    $groupUploadsImage .= '<img style="width:360px;height:260px;margin:0px;padding:0px;" src="' . $pht['photo'] . '">';
                    //  $groupUploadsImage .= '<img style="width:360px;height:260px;margin:0px;padding:0px;" src="https://beebom-redkapmedia.netdna-ssl.com/wp-content/uploads/2016/01/Reverse-Image-Search-Engines-Apps-And-Its-Uses-2016.jpg">';
                    if (($counter % 2) == 0) {
                        $groupUploadsImage .= '</div>';
                    }
                    if (($counter % 6) == 0) {
                        $groupUploadsImage .= '</div>';
                    }
                    $counter++;
                }
                if ($counter % 2 != 1) {
                    $groupUploadsImage .= '&nbsp;</div>';
                }
                if ($counter % 6 != 1) {
                    $groupUploadsImage .= '&nbsp;</div>';
                }

                //echo $groupUploadsImage; die;

                $html = str_replace('{UPLOAD_PHOTOS}', $groupUploadsImage, $html);
            } else {
                $html = str_replace('{UPLOAD_PHOTOS}', '', $html);
            }

            //ECHO $html; die;

            /////////////////////// Adding Appriasla Invoice ///////////////////////

            $estInvoice = '';
            /*if($estData['get_est_fullData']['estimate_data']['is_supplement'] == 1){
          $saleTaxInvoic = isset($finalSupReportData['final_report_sup']["sales_tax_percent"])?$finalSupReportData['final_report_sup']["sales_tax_percent"]:0;
        }else{
           $saleTaxInvoic = isset($finalReportData["sales_tax_percent"])?$finalReportData["sales_tax_percent"]:0;
        }*/
            $taxData = $this->db->get_where('ca_labor_taxs', array('user_id' => $userID))->row_array();
            $saleTaxInvoic = $taxData['sales_tax_percent'];
            if (isset($estData['invoice']) && !empty($estData['invoice'])) {
                $commentVal = (isset($estData['invoice'][0]['comment']) && $estData['invoice'][0]['comment'] != "") ? $estData['invoice'][0]['comment'] : '<p style="color:#B7B7B7;">Additional Comments:</p>';
                $appraisalVal = (isset($estData['invoice'][0]['appraisal_service_type']) && $estData['invoice'][0]['appraisal_service_type'] != "") ? json_decode($estData['invoice'][0]['appraisal_service_type'], true) : array('slug' => '', 'label' => '', 'value' => 0);
                $additionalVal = (isset($estData['invoice'][0]['additional_charges']) && $estData['invoice'][0]['additional_charges'] != "") ? $estData['invoice'][0]['additional_charges'] : 0;
                $invoiceTotalVal = (isset($estData['invoice'][0]['invoice_total']) && $estData['invoice'][0]['invoice_total'] != "") ? $estData['invoice'][0]['invoice_total'] : 0;
                $taxVal = (isset($estData['invoice'][0]['tax_total']) && $estData['invoice'][0]['tax_total'] != "" && $estData['invoice'][0]['tax_total'] != "0.00" && $estData['invoice'][0]['tax_total'] != "0.0") ? $estData['invoice'][0]['tax_total'] : 0;
                $estInvoice = '<div class="row" style="page-break-before: always;font-family: TimesNewRoman, Times, Baskerville, Georgia, serif;">
              <div style="text-align:center;margin-top:-30px;">
              <h2 style="font-weight:700;font-size:30px;margin-bottom:15px">' . $companyName . '</h2>
               <p style="font-size:14px;"><b style="font-family:helvetica;">' . $companyAddress . '<br>Ph: ' . preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $comPhone) . ' Fax: ' . preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $comFax) . '<br>' . $companyEmailAddress . '</b></p>
               <h2 style="font-weight:700;padding-bottom:5px;margin-top:30px;width:100%;border-bottom:4px solid #89a2b9;font-family:helvetica;">SERVICE INVOICE</h2>
               <table width="80%" border="0" cellspacing="0" cellpadding="0" style="margin-left:30px;font-size:16px; line-height:35px;">
                  <tbody>
                    <tr><td valign="middle" width="70%"><strong style="font-family:helvetica;">Invoice Date: </strong>' . date('m/d/Y') . '</td>
                      <td valign="middle" width="70%"><strong style="font-family:helvetica;">Bill To:</strong> ' . $estData['get_est_fullData']['estimate_data']['insurance_company'] . '</td></tr>
                      <tr><td valign="middle" width="70%"><strong style="font-family:helvetica;">Claim Number:</strong> ' . $estData['get_est_fullData']['estimate_data']['claim_number'] . ' </td>
                      <td valign="middle" width="70%"><strong style="font-family:helvetica;">Adjuster:</strong> ' . $estData['get_est_fullData']['estimate_data']['adjuster_name'] . ' </td></tr>
                      <tr><td valign="middle" width="70%" style="font-family:helvetica;"><strong>Vehicle Owner:</strong> ' . $ownerNam . '</td>
                      <td valign="middle" width="70%"><strong style="font-family:helvetica;">Vehicle:</strong> ' . $estData['get_est_fullData']['vehicle_info']['vehicle_name'] . '</td>
                    </tr> 
                  </tbody>
                </table> 
               <h3 style="font-weight:700;padding-bottom:5px;margin-top:10px;width:100%;border-bottom:4px solid #89a2b9;"></h3>
               <table width="80%" border="0" cellspacing="0" cellpadding="5" style="margin-left:30px;font-size:16px; line-height:25px;">
                  <tbody>
                    <tr><td valign="middle" width="70%"><strong>' . $appraisalVal['label'] . ': $' . @number_format($appraisalVal['value'], 2) . '</strong></td></tr>
                      <tr><td valign="middle" width="70%"><strong style="font-family:helvetica;">Additional Charges: $' . @number_format($additionalVal, 2) . '</strong></td></tr>
                      <tr><td valign="middle" width="70%"><strong style="font-family:helvetica;">Sales Tax @ ' . $saleTaxInvoic . '%: $' . @number_format($taxVal, 2) . ' </strong></td></tr>
                      <tr><td valign="middle" width="70%"><h1 style="text-decoration:underline;font-weight:400;margin-top:50px;font-family:helvetica;">Invoice Total: $' . @number_format(($invoiceTotalVal), 2) . '</h1></td></tr>
                    </tr> 
                  </tbody>
                </table>
                <div style="padding:5px 10px;width:90%;height:170px;border:1px solid #B7B7B7;margin:0 auto;text-align:left;">' . $commentVal . '</div>
                <br>
                <table width="80%" border="0" cellspacing="0" cellpadding="0" style="margin-left:30px;font-size:16px; line-height:0px;margin-top:20px">
                  <tbody><tr><td valign="middle" width="70%"><h3 margin-bottom:15px><b>Thank you for your business!</b></h3></td></tr></tbody></table>
                <h3 style="font-weight:700;margin-top:0px;padding-bottom:5px;width:100%;border-bottom:4px solid #89a2b9;"></h3> 
              </div>
            </div>';
            }
            // for image
            // if ($estData['parent'] == false) {
            //   $estInvoice .= '<table style="font-size:12px;margin-left:10px;font-family:roboto;"><tr><td style="widht:80%;"><img src="' . $imglink . '" ></td></tr></table>';
            // }



            // for image ends  
            $html = str_replace('{EST_INVOICE}', $estInvoice, $html);






            ////////////////////////////////////////////////////////////////////////

            $html = preg_replace('/>\s+</', "><", $html);
            // print_r($html);
            // die;
            $dompdf->loadHtml($html);


            if ($estData['get_est_fullData']['estimate_data']['owner_identity'] == 1) {
                $filename = $estData['get_est_fullData']['estimate_data']['insured'] . ' - ' . $estData['get_est_fullData']['estimate_data']['claim_number'];
            } else {
                $filename = $estData['get_est_fullData']['estimate_data']['claimant'] . ' - ' . $estData['get_est_fullData']['estimate_data']['claim_number'];
            }
            $filename = ($filename != ' ') ? $filename : 'Estimate PDf File';
            $filepdfUrlsVal = $this->seo_friendly_url(trim($filename));
            $createFolderName = $this->generateRandomString(25);
            @set_time_limit(-1);
            $path = FCPATH . "uploads/PDF/EST" . $estID . "-" . $userID . "-" . $createFolderName;
            if (!is_dir($path)) { //create the folder if it's not already exists
                mkdir($path, 0777, TRUE);
            }
            $dompdf->setPaper("portrait");
            $dompdf->render();
            //$date = date('m/d/Y h:i:s A');
            $date = $userPhoneDate;
            // $logoImage = BASE_URL.'assets/images/'.$companyData['logo'];
            //$logoImage = BASE_URL.'assets/images/QUICKSHEET-LOGO-DARK-BG.png';
            //06 july  $logoImage = $_SERVER['DOCUMENT_ROOT'].'/quicksheet/assets/images/QUICKSHEET-LOGO-DARK-BG.png';
            $logoImage = base_url() . "assets/images/QUICKSHEET-LOGO-DARK-BG.png";


            $font = $dompdf->getFontMetrics()->get_font("helvetica", "normal");
            $dompdf->getCanvas()->page_text(30, 760, $date, $font, 9, array(0, 0, 0));
            $dompdf->getCanvas()->page_text(258, 760, "Powered By:", $font, 10, array(0, 0, 0));
            //$dompdf->getCanvas()->image($logoImage,315, 760, 80, 17);
            $dompdf->getCanvas()->page_script('
              $pdf->image("' . $logoImage . '", 317, 760, 70, 15);
            ');
            $dompdf->getCanvas()->page_text(522, 760, "Page {PAGE_NUM}", $font, 9, array(0, 0, 0));
            $pdf = $dompdf->output();
            $file_location = $_SERVER['DOCUMENT_ROOT'] . "/quicksheet/uploads/PDF/EST" . $estID . "-" . $userID . "-" . $createFolderName . "/" . $filepdfUrlsVal . ".pdf";

            // $file_location = base_url()."/quicksheet/uploads/PDF/EST".$estID."-".$userID."-".$createFolderName."/".$filepdfUrlsVal.".pdf"; 


            if (file_put_contents($file_location, $pdf)) {
                $pdfUrlVal['url'] = base_url() . "uploads/PDF/EST" . $estID . "-" . $userID . "-" . $createFolderName . "/" . $filepdfUrlsVal . ".pdf";
                $pdfUrlVal['filename'] = trim($filename);
                $this->Muser->update_pdf_url($estID, $pdfUrlVal);
                return $pdfUrlVal;
            } else {
                $pdfUrlVal['url'] = "";
                $pdfUrlVal['filename'] = "";
                return $pdfUrlVal;
            }
        }
    }






    function seo_friendly_url($string)
    {
        $string = str_replace(array('[\', \']'), '', $string);
        $string = preg_replace('/\[.*\]/U', '', $string);
        $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
        $string = htmlentities($string, ENT_COMPAT, 'utf-8');
        $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string);
        $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/'), '-', $string);
        return strtolower(trim($string, '-'));
    }

    ////////////////////// Update Preliminary Est Parts  ///////////////////
    public function checkValidEstimate($token, $user_id)
    {
        $currentEstimate = $this->db->limit(1)->get_where('ca_estimates', ['estimate_id' => $token, 'user_id' => $user_id])->row();
        if (empty($currentEstimate)) {
            $response['success'] = false;
            $response['msg']     = 'no permission';
            $response['code']   = 400;
            echo json_encode($response);
            exit();
        } else {
            return $currentEstimate;
        }
    }
    public function update_est_part()
    {
        $fields = array(
            'user_id',
            'id',
            'estimate_id'
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);
        $allLabors = ['frame', 'mech', 'structual', 'glass', 'labor', 'user_1', 'user_2', 'user_3'];
        $currentEstimate = $this->checkValidEstimate($this->jsonvalue['estimate_id'], $this->jsonvalue['user_id']);

        $fields = ['list_price' => $this->jsonvalue['list_price'], 'labor' => $this->jsonvalue['labor'], 'paint' => $this->jsonvalue['paint'], 'qty' => $this->jsonvalue['qty'] , 'part_number' => $this->jsonvalue['part_number']];

        foreach ($fields as $key => $value) {
            $col = $key;
            $updateData['id'] = $this->jsonvalue['id'];
            $updateData[$col] = $value;

            $old = $this->Muser->getDatabyCondition("ca_estimate_select_parts", array("id" => $updateData['id']));
            $returnStatus = $this->Muser->update_est_part($updateData);


            if ($col == 'labor') {
                $partData['labor'] = '';
                $partData['mech'] = '';
                $partData['frame'] = '';
                $partData['structual'] = '';
                $partData['glass'] = '';
                $partData['user_1'] = '';
                $partData['user_2'] = '';
                $partData['user_3'] = '';
                $pos = strpos(strtoupper($updateData['labor']), 'M');
                $pos1 = strpos(strtoupper($updateData['labor']), 'F');
                $pos2 = strpos(strtoupper($updateData['labor']), 'S');
                $pos3 = strpos(strtoupper($updateData['labor']), 'G');
                $pos4 = strpos(strtoupper($updateData['labor']), 'A');
                $pos5 = strpos(strtoupper($updateData['labor']), 'B');
                $pos6 = strpos(strtoupper($updateData['labor']), 'C');
                if ($pos) {
                    $partData['mech'] = $updateData['labor'];
                    $column = 'mech';
                } else if ($pos1) {
                    $partData['frame'] = $updateData['labor'];
                    $column = 'frame';
                } else if ($pos2) {
                    $partData['structual'] = $updateData['labor'];
                    $column = 'structual';
                } else if ($pos3) {
                    $partData['glass'] = $updateData['labor'];
                    $column = 'glass';
                } else if ($pos4) {
                    $partData['user_1'] = $updateData['labor'];
                    $column = 'user_1';
                } else if ($pos5) {
                    $partData['user_2'] = $updateData['labor'];
                    $column = 'user_2';
                } else if ($pos6) {
                    $partData['user_3'] = $updateData['labor'];
                    $column = 'user_3';
                } else {
                    $partData['labor'] = $updateData['labor'];
                    $column = 'labor';
                }
            } else {
                $partData = $updateData;
                $column = $col;
            }


            if ($column == "labor" || $column == "mech") {
                $this->Muser->updatebycondition("ca_estimate_select_parts_incl_overlap", array('labor' => $partData['labor'], 'mech' => $partData['mech']), "select_part_id", $updateData['id']);
            }
            // 27 july for changed item
            $chngdata =  $this->Muser->getDatabyCondition("ca_estimate_select_parts_changed", array("id" => $updateData['id']));

            // $addeddata =  $this->Muser->getDatabyCondition("ca_estimate_select_parts_added", array("id" => $updateData['id']));

            $selpartdata =  $this->Muser->getDatabyCondition("ca_estimate_select_parts", array("id" => $updateData['id']));
            $selpartdata[0]['estimate_id'] = $currentEstimate->estimate_id;

            if (empty($chngdata)) {
                if ($old[0][$column] !=  $partData[$column]) {
                    $this->Muser->insert_calisteddata("ca_estimate_select_parts_changed", $selpartdata[0]);

                    if ($old[0]['estimate_id'] != $currentEstimate->estimate_id) {
                        $afterData['part_id'] = $this->jsonvalue['id'];
                        $afterData['old_estimate_id'] = $old[0]['estimate_id'];
                        $afterData['parent_id'] = $old[0]['estimate_id'];
                        $afterData['new_estimate_id'] = $currentEstimate->estimate_id;
                        $afterData['column_name'] = $column;


                        if ($column != 'qty' && $column != "list_price") {
                            if ($column != 'labor' && $column != 'mech') {
                                $afterData['old_value'] = $old[0][$column];
                                $afterData['new_value'] =  $partData[$column];
                            } else {
                                $included =  $this->Muser->getDatabyCondition("ca_estimate_select_parts_incl_overlap", array("select_part_id" => $updateData['id']));

                                if (@$included[0]) {
                                    $afterData['old_value'] = 0;
                                    $afterData['new_value'] = 0;
                                } else {
                                    $afterData['old_value'] = $old[0][$column];
                                    $afterData['new_value'] =  $partData[$column];
                                }
                            }
                        } else {
                            if ($column == "qty") {
                                $afterData['old_value'] = $old[0][$column] * $old[0]['list_price'];
                                $afterData['new_value'] =  $partData[$column] * $old[0]['list_price'];
                            } else {
                                $afterData['old_value'] = $old[0][$column] * $old[0]['qty'];
                                $afterData['new_value'] =  $partData[$column] * $old[0]['qty'];
                            }
                        }
                        // print_r($afterData);
                        // die;
                        if ($column == "labor" || $column == "frame" || $column == "mech" || $column == "glass" || $column == "structual" || $column == "user_1" || $column == "user_2" || $column == "user_3") {
                            foreach ($allLabors as $labors) {
                                if ($column != $labors) {
                                    $laborsChange['part_id'] = $this->input->post('pid');
                                    $laborsChange['old_estimate_id'] = $old[0]['estimate_id'];
                                    $laborsChange['parent_id'] = $old[0]['estimate_id'];
                                    $laborsChange['new_estimate_id'] = $currentEstimate->estimate_id;
                                    $laborsChange['column_name'] = $labors;
                                    $laborsChange['old_value'] = $old[0][$labors];
                                    $laborsChange['new_value'] = 0;
                                    $this->db->insert("ca_estimate_after_part_change", $laborsChange);
                                }
                            }
                        }
                        $this->db->insert("ca_estimate_after_part_change", $afterData);
                    }
                }
            } else {
                if ($chngdata[0][$column] !=  $partData[$column]) {
                    $this->db->where('id', $updateData['id']);
                    $new = $partData;
                    $new['estimate_id'] = null;
                    $new['estimate_id'] = $currentEstimate->estimate_id;
                    $this->db->update('ca_estimate_select_parts_changed', $new);

                    if ($old[0]['estimate_id'] != $currentEstimate->estimate_id) {
                        $afterData['part_id'] = $this->jsonvalue['id'];
                        $afterData['old_estimate_id'] = $chngdata[0]['estimate_id'];
                        $afterData['parent_id'] = $old[0]['estimate_id'];
                        $afterData['new_estimate_id'] = $currentEstimate->estimate_id;
                        $afterData['column_name'] = $col;


                        if ($column != 'qty' && $column != "list_price") {
                            if ($column != 'labor' && $column != 'mech') {
                                $afterData['old_value'] = $old[0][$column];
                                $afterData['new_value'] =  $partData[$column];
                            } else {
                                $included =  $this->Muser->getDatabyCondition("ca_estimate_select_parts_incl_overlap", array("select_part_id" => $updateData['id']));
                                if (@$included[0]) {
                                    $afterData['old_value'] = 0;
                                    $afterData['new_value'] = 0;
                                } else {
                                    $afterData['old_value'] = $old[0][$column];
                                    $afterData['new_value'] =  $partData[$column];
                                }
                            }
                        } else {
                            if ($column == "qty") {
                                $afterData['old_value'] = $chngdata[0][$column] * $chngdata[0]['list_price'];
                                $afterData['new_value'] =  $partData[$column] * $chngdata[0]['list_price'];
                            } else {
                                $afterData['old_value'] = $chngdata[0][$column] * $chngdata[0]['qty'];
                                $afterData['new_value'] =  $partData[$column] * $chngdata[0]['qty'];
                            }
                        }
                        // print_r($afterData);
                        // die;
                        if ($column == "labor" || $column == "frame" || $column == "mech" || $column == "glass" || $column == "structual" || $column == "user_1" || $column == "user_2" || $column == "user_3") {
                            foreach ($allLabors as $labors) {
                                if ($column != $labors) {
                                    $laborsChange['part_id'] = $this->input->post('pid');
                                    $laborsChange['old_estimate_id'] = $chngdata[0]['estimate_id'];
                                    $laborsChange['parent_id'] = $old[0]['estimate_id'];
                                    $laborsChange['new_estimate_id'] = $currentEstimate->estimate_id;
                                    $laborsChange['column_name'] = $labors;
                                    $laborsChange['old_value'] = $old[0][$labors];
                                    $laborsChange['new_value'] = 0;
                                    $this->db->insert("ca_estimate_after_part_change", $laborsChange);
                                }
                            }
                        }
                        $this->db->insert("ca_estimate_after_part_change", $afterData);
                    }
                }
            }

            $this->db->where('id', $updateData['id']);
            $this->db->update('ca_estimate_select_parts_added', $partData);
        }
        // 27 july for changed item ends

        if ($returnStatus) {
            $result      = array(
                'success' => true,
                'data' => $partData,
                'msg' => $this->lang->line('data_update'),
                'code' => 200,
            );
        } else {
            $result = array(
                'success' => false,
                'data' => [],
                'msg' => $this->lang->line('oops_something_went_wrong'),
                'code' => 400,
            );
        }
        echo json_encode($result);
    }

    public function estimate_payment()
    {
        $fields = array(
            'user_id',
            'estimate_id',
            'card_token',
            'amount',
            'currency_code',
            'payment_for',

        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            echo json_encode($response);
            exit();
        }
        /////////////////////// 2 FEB///////////////////
        ///$this->currentLang($this->jsonvalue['user_id']);
        $msg = '';
        $error = false;
        if ($this->jsonvalue['payment_for'] == 2) {  // Monthly Subscription 
            try {
                \Stripe\Stripe::setApiKey(STRIPE_SECRET);
                $customer = \Stripe\Customer::create(array(
                    'email' => $userStripId['email_id'],
                    'source' => $this->jsonvalue['card_token']
                ));

                $cusStripeId = $customer->id;
                /////////////////////////////////////////////////
                $this->db->where(array('user_id' => $this->jsonvalue['user_id']));
                $this->db->update('ca_users', array('stripe_user_id' => $cusStripeId));
                /////////////////////////////////////////////////
                $charge = \Stripe\Subscription::create(array(
                    "customer" => $cusStripeId,
                    "items" => array(
                        array(
                            "plan" => "qs_monthly_plan",
                        ),
                    )
                ));
                @$subscribe_array = $charge->__toArray(true);
                unset($this->jsonvalue['card_token']);
                if (isset($subscribe_array) && !empty($subscribe_array)) {
                    if (isset($subscribe_array['status']) && isset($subscribe_array['current_period_end']) && $subscribe_array['status'] == 'active' && $subscribe_array['current_period_end'] != NULL && $subscribe_array['current_period_end'] != '') {
                        $this->jsonvalue['payment_status'] = 1;
                        $this->jsonvalue['transaction_id'] = '';
                        $this->jsonvalue['subscription_id'] = $subscribe_array['id'];
                        $this->jsonvalue['raw_data'] = serialize($subscribe_array);
                        $msg = 'Monthly Subscription Created Successfully.';
                    } else {
                        $subId = (isset($subscribe_array['id'])) ? $subscribe_array['id'] : '';
                        $this->jsonvalue['payment_status'] = 2;
                        $this->jsonvalue['transaction_id'] = '';
                        $this->jsonvalue['subscription_id'] = $subId;
                        $this->jsonvalue['raw_data'] = serialize($subscribe_array);
                        $msg = 'Monthly Subscription Not Create. Please try again.';
                        $error = true;
                    }
                    $this->Muser->estimate_payment($this->jsonvalue);
                }
            } catch (\Stripe\Error\Card $e) {
                $msg = $e->getMessage();
                $error = true;
            } catch (\Stripe\Error\RateLimit $e) {
                $msg = $e->getMessage();
                $error = true;
            } catch (\Stripe\Error\InvalidRequest $e) {
                $msg = $e->getMessage();
                $error = true;
            } catch (\Stripe\Error\Authentication $e) {
                $msg = $e->getMessage();
                $error = true;
            } catch (\Stripe\Error\ApiConnection $e) {
                $msg = $e->getMessage();
                $error = true;
            } catch (\Stripe\Error\Base $e) {
                $msg = $e->getMessage();
                $error = true;
            } catch (Exception $e) {
                $msg = $e->getMessage();
                $error = true;
            }
        } else {  // One Report Payment
            try {
                $amount = $this->jsonvalue['amount'] * 100; //cents
                \Stripe\Stripe::setApiKey(STRIPE_SECRET);
                $charge = \Stripe\Charge::create(array('amount' => $amount, 'currency' => strtolower($this->jsonvalue['currency_code']), 'source' => $this->jsonvalue['card_token']));
                @$customer_array = $charge->__toArray(true);
                unset($this->jsonvalue['card_token']);
                if (isset($customer_array) && !empty($customer_array)) {
                    if ($customer_array['paid'] == 1) {
                        $this->jsonvalue['payment_status'] = 3;
                        $this->jsonvalue['transaction_id'] = $customer_array['balance_transaction'];
                        $this->jsonvalue['raw_data'] = serialize($customer_array);
                        $msg = $customer_array['outcome']['seller_message'];
                    } else {
                        $this->jsonvalue['payment_status'] = 2;
                        $this->jsonvalue['transaction_id'] = $customer_array['balance_transaction'];
                        $this->jsonvalue['raw_data'] = serialize($customer_array);
                        $msg = $customer_array['outcome']['seller_message'];
                        $error = true;
                    }
                    $this->Muser->estimate_payment($this->jsonvalue);
                }
            } catch (\Stripe\Error\Card $e) {
                $msg = $e->getMessage();
                $error = true;
            } catch (\Stripe\Error\RateLimit $e) {
                $msg = $e->getMessage();
                $error = true;
            } catch (\Stripe\Error\InvalidRequest $e) {
                $msg = $e->getMessage();
                $error = true;
            } catch (\Stripe\Error\Authentication $e) {
                $msg = $e->getMessage();
                $error = true;
            } catch (\Stripe\Error\ApiConnection $e) {
                $msg = $e->getMessage();
                $error = true;
            } catch (\Stripe\Error\Base $e) {
                $msg = $e->getMessage();
                $error = true;
            } catch (Exception $e) {
                $msg = $e->getMessage();
                $error = true;
            }
        }
        //////////////////////////////////////////
        if (!$error) {
            $result      = array(
                'success' => true,
                'msg' => $msg,
                'strp' => STRIPE_SECRET,
                'code' => 200,
            );
        } else {
            $result = array(
                'success' => false,
                'msg' => $msg,
                'strp' => STRIPE_SECRET,
                'code' => 400,
            );
        }
        echo json_encode($result);
    }


    public function search_estimates()
    {
        $fields = array(
            'user_id',
            'search_value',
            'search_by',
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['data']   = array();
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);
        $returnData = $this->Muser->search_estimates($this->jsonvalue);
        if ($returnData) {
            $result      = array(
                'success' => true,
                'msg' => $this->lang->line('data_found'),
                'data' => $returnData,
                'code' => 200,
            );
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('no_data_found'),
                'data' => array(),
                'code' => 400,
            );
        }
        echo json_encode($result);
    }



    public function search_estimates_data()
    {
       
        $fields = array(
            'user_id',
            'estimate_id',
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['data']   = array();
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);
        $returnData = $this->Muser->get_estimate_data($this->jsonvalue);

        $this->currentLang($this->jsonvalue['user_id']);
        
        if ($returnData) {
            $result      = array(
                'success' => true,
                'msg' => $this->lang->line('data_found'),
                'data' => $returnData,
                'code' => 200,
            );
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('no_data_found'),
                'data' => array(),
                'code' => 400,
            );
        }
        echo json_encode($result);
    }

    public function get_card_details()
    {
        $fields = array(
            'user_id',
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['data']   = (object)array();
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);
        $returnData = $this->Muser->get_card_details($this->jsonvalue);
        if ($returnData) {
            $result      = array(
                'success' => true,
                'msg' => $this->lang->line('data_found'),
                'data' => $returnData,
                'code' => 200,
            );
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('no_data_found'),
                'data' => (object)array(),
                'code' => 400,
            );
        }
        echo json_encode($result);
    }

    public function add_supplement()
    {
        $fields = array(
            'user_id',
            'estimate_id',
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['estimate_id']   = '';
            echo json_encode($response);
            exit();
        }
        $returnData = $this->Muser->add_supplement($this->jsonvalue);
        $this->currentLang($this->jsonvalue['user_id']);
        if ($returnData) {
            if ($returnData != -1) {
                $result      = array(
                    'success' => true,
                    'msg' => $this->lang->line('supplement_created'),
                    'estimate_id' => (string)$returnData,
                    'code' => 200,
                );
            } else {
                $result      = array(
                    'success' => true,
                    'msg' => $this->lang->line('supplement_limit_over'),
                    'estimate_id' => '',
                    'code' => 400,
                );
            }
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('oops_something_went_wrong'),
                'estimate_id' => '',
                'code' => 400,
            );
        }
        echo json_encode($result);
    }

    public function update_default_parts()
    {
        $fields = array(
            'user_id',
            'estimate_id',
            'part_id',
            'oper',
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['data']   = (object)array();
            echo json_encode($response);
            exit();
        }
        if ($this->Muser->isExistEstimate($this->jsonvalue['estimate_id'], $this->jsonvalue['user_id'])) {
            $this->currentLang($this->jsonvalue['user_id']);
            $returnStatus = $this->Muser->update_default_parts($this->jsonvalue);
            if ($returnStatus) {
                $result = array(
                    'success' => true,
                    'msg' => $this->lang->line('data_saved'),
                    'code' => 200,
                    'data' => $returnStatus
                );
            } else {
                $result = array(
                    'success' => false,
                    'msg' => $this->lang->line('oops_something_went_wrong'),
                    'code' => 400,
                    'data' => (object)array()
                );
            }
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('no_premission'),
                'code' => 400,
                'data' => (object)array()
            );
        }
        echo json_encode($result);
    }

    /*
    * Get Default Part Real Data.
    * Delete Updated Default Part Data because user again select default oper (part data)
    * 
    */

    public function get_default_part_data()
    {
        $fields = array(
            'user_id',
            'part_id',
            'estimate_id'
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']    = 400;
            $response['data']    = (object)array();
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);
        $returnStatus = $this->Muser->get_default_part_data($this->jsonvalue);
        if ($returnStatus) {
            $result = array(
                'success' => true,
                'msg' => $this->lang->line('data_saved'),
                'code' => 200,
                'data' => $returnStatus
            );
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('no_data_found'),
                'code' => 400,
                'data' => (object)array()
            );
        }
        echo json_encode($result);
    }

    public function get_estimate_status()
    {
        $fields = array(
            'user_id',
            'estimate_id'
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']    = 400;
            $response['is_supplement']  = 0;
            $response['data']    = (object)array();
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);
        $returnStatus = $this->Muser->get_estimate_status($this->jsonvalue);
        $this->currentLang($this->jsonvalue['user_id']);
        $result = array(
            'success' => true,
            'msg' => $this->lang->line('data_found'),
            'code' => 200,
            'is_supplement' => $returnStatus['is_supplement'],
            'data' => (object)array()
        );

        echo json_encode($result);
    }

    public function skip_est()
    {
        $fields = array(
            'user_id',
            'estimate_id'
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']    = 400;
            $response['data']    = (object)array();
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);
        if ($this->Muser->isExistEstimate($this->jsonvalue['estimate_id'], $this->jsonvalue['user_id'])) {
            $returnStatus = $this->Muser->skip_est($this->jsonvalue);
            $result = array(
                'success' => true,
                'msg' => $this->lang->line('data_saved'),
                'code' => 200,
                'data' => (object)array()
            );
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('no_premission'),
                'code' => 400,
                'data' => (object)array()
            );
        }
        echo json_encode($result);
    }

    //////////////////////////// 2 FEB ///////////////////////////

    public function get_subscription()
    {
        $fields = array(
            'user_id',
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']    = 400;
            $response['data']    = (object)array();
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);

        $this->db->select('order_id,user_id,subscription_id');
        $this->db->where('user_id', $this->jsonvalue['user_id']);
        $this->db->where(array('payment_for' => 2, 'payment_status' => 3));
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->db->group_by('subscription_id');


        $orderData = $this->db->get('ca_orders')->result_array();

        $error = false;
        $msg = 'You don\'t have any subscription plan.';
        $subscribeId = '';

        if (isset($orderData) && !empty($orderData)) {
            foreach ($orderData as $val) {
                if ($val['subscription_id']) {
                    try {
                        \Stripe\Stripe::setApiKey(STRIPE_SECRET);
                        $subscription = \Stripe\Subscription::retrieve($val['subscription_id']);

                        @$subData = $subscription->toArray(true);
                        if (isset($subData) && $subData['status'] == 'active' && $subData['cancel_at_period_end'] == false) {
                            $subscribeId = $val['subscription_id'];
                            break;
                        }
                    } catch (Exception $e) {
                        $msg = $e->getMessage();
                        $error = true;
                    }
                }
            }
        }
        if (isset($subscribeId) && $subscribeId != '' && $error == false) {
            $result = array(
                'success' => true,
                'msg' => 'Subscription found successfully.',
                'code' => 200,
                'data' => array('subscription_id' => $subscribeId)
            );
        } else {
            $result = array(
                'success' => false,
                'msg' => $msg,
                'code' => 400,
                'data' => (object)array()
            );
        }
        echo json_encode($result);
    }

    //////////////////////////// 2 FEB ///////////////////////////

    public function subscription_cancel()
    {
        $fields = array(
            'user_id',
            'subscription_id'
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']    = 400;
            $response['data']    = (object)array();
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);
        $subscrId = $this->jsonvalue['subscription_id'];
        $error = false;
        $msg = 'Something went wrong please try again.';
        try {
            \Stripe\Stripe::setApiKey(STRIPE_SECRET);
            $subscription = \Stripe\Subscription::retrieve($subscrId);
            $returnData = $subscription->cancel(['at_period_end' => true]);
            @$cancelData = $returnData->__toArray(true);
        } catch (\Stripe\Error\Card $e) {
            $msg = $e->getMessage();
            $error = true;
        } catch (\Stripe\Error\RateLimit $e) {
            $msg = $e->getMessage();
            $error = true;
        } catch (\Stripe\Error\InvalidRequest $e) {
            $msg = $e->getMessage();
            $error = true;
        } catch (\Stripe\Error\Authentication $e) {
            $msg = $e->getMessage();
            $error = true;
        } catch (\Stripe\Error\ApiConnection $e) {
            $msg = $e->getMessage();
            $error = true;
        } catch (\Stripe\Error\Base $e) {
            $msg = $e->getMessage();
            $error = true;
        } catch (Exception $e) {
            $msg = $e->getMessage();
            $error = true;
        }
        if (isset($cancelData['cancel_at_period_end']) && $cancelData['cancel_at_period_end'] == true && $error == false) {
            $result = array(
                'success' => true,
                'msg' => 'Subscription has been cancelled successfully.',
                'code' => 200,
                'data' => (object)array()
            );
        } else {
            $result = array(
                'success' => false,
                'msg' => $msg,
                'code' => 400,
                'data' => (object)array()
            );
        }
        echo json_encode($result);
    }

    // delete stored entry on 25 may

    public function delete_stored_entry()
    {
        $fields = array(
            'id',
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            echo json_encode($response);
            exit();
        }
        $this->currentLang($this->jsonvalue['user_id']);

        // --

        $seldata =  $this->Muser->get_selectpartdata($this->jsonvalue['id']);


        $userseldata =  $this->Muser->get_userseldata($this->jsonvalue['id']);

        unset($seldata[0]['id']);
        if($seldata[0])
        {
            $insertid =  $this->Muser->insertdeleteddata($seldata[0]);
        }
        



        $this->Muser->insertdeletedselectpartdata($userseldata[0]);






        $table = 'ca_listed_vehicles_by_users';

        $this->Muser->delete_stored_entry($this->jsonvalue['id'], $table);


        //---

        $result = array(
            'success' => true,
            'msg' => "Data Deleted Successfully",
            'code' => 200
        );
        echo json_encode($result);
    }



    // delete stored entry on 25 may ends

    // update stored entry

    public function update_stored_entry()
    {
        $fields = array(
            'id',
            'part_name',
        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            echo json_encode($response);
            exit();
        }



        if (isset($this->jsonvalue['oper'])) {
            $data['oper'] = $this->jsonvalue['oper'];
        }
        if (isset($this->jsonvalue['list_price'])) {
            $data['list_price'] = $this->jsonvalue['list_price'];
        }

        if (isset($this->jsonvalue['part_name'])) {
            $data['part_name'] = $this->jsonvalue['part_name'];
        }




        $retval = $this->Muser->update_storeddata($data, $this->jsonvalue['id']);

        //echo $this->jsonvalue['id'];die;

        if (!empty($retval)) {
            $result = array(
                'success' => true,
                'msg' => "Data Updated Successfully",
                'code' => 200
            );
        } else {

            $result = array(
                'success' => false,
                'msg' => 'something went wrong',
                'code' => 400,
                'data' => (object)array()
            );
        }
        echo json_encode($result);
    }

    // update stored entry ends


    // update user define parts
    public function update_user_define_parts()
    {
        $fields = array(
            'id',
            'user_id',
            'oper',
            'part_name',

        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['data']   = array();
            echo json_encode($response);
            exit();
        }

        $currency_convert = $this->currency_convert();
        $insertData['user_id'] = $this->jsonvalue['user_id'];
        $insertData['oper'] = $this->jsonvalue['oper'];
        $insertData['part_name'] = $this->jsonvalue['part_name'];

        if (!$this->jsonvalue['type']) {
            $insertData['list_price'] = $this->jsonvalue['list_price']/$currency_convert;
            $insertData['repairhour'] = $this->jsonvalue['repairhour'];
            $insertData['refinishhour'] = $this->jsonvalue['refinishhour'];
            if ($this->jsonvalue['oper'] == 'Refn' || $this->jsonvalue['oper'] == 'Ref' || $this->jsonvalue['oper'] == 'Blnd') {
                if ($this->jsonvalue['oper'] == 'Ref') {
                    $insertData['oper'] = 'Ref';
                }
                $insertData['labor'] = '';
                $insertData['mech'] = '';
                $insertData['frame'] = '';
                $insertData['structual'] = '';
                $insertData['glass'] = '';
                //$insertData['user_1'] = '';
                //$insertData['user_2'] = '';
                //$insertData['user_3'] = '';
                $insertData['paint'] = $this->jsonvalue['labor'];
            } else {
                $pos = strpos(strtoupper($this->jsonvalue['labor']), 'M');
                $pos1 = strpos(strtoupper($this->jsonvalue['labor']), 'F');
                $pos2 = strpos(strtoupper($this->jsonvalue['labor']), 'S');
                $pos3 = strpos(strtoupper($this->jsonvalue['labor']), 'G');
                $pos4 = strpos(strtoupper($this->jsonvalue['labor']), 'A');
                $pos5 = strpos(strtoupper($this->jsonvalue['labor']), 'B');
                $pos6 = strpos(strtoupper($this->jsonvalue['labor']), 'C');
                if ($pos) {
                    $insertData['mech'] = $this->jsonvalue['labor'];
                } else if ($pos1) {
                    $insertData['frame'] = $this->jsonvalue['labor'];
                } else if ($pos2) {
                    $insertData['structual'] = $this->jsonvalue['labor'];
                } else if ($pos3) {
                    $insertData['glass'] = $this->jsonvalue['labor'];
                } else if ($pos4) {
                    $insertData['user_1'] = $this->jsonvalue['labor'];
                } else if ($pos5) {
                    $insertData['user_2'] = $this->jsonvalue['labor'];
                } else if ($pos6) {
                    $insertData['user_3'] = $this->jsonvalue['labor'];
                } else {
                    $insertData['labor'] = $this->jsonvalue['labor'];
                }
                $insertData['paint'] = $this->jsonvalue['paint'];
            }
            $insertData['markup'] = $this->jsonvalue['markup'];
            $insertData['note'] = $this->jsonvalue['note'];
        }

        $returnStatus = $this->Muser->update_user_define_parts($insertData, $this->jsonvalue['id']);


        // 27 may



        ///$insertData['id'] = $this->jsonvalue['id'];

        $table1 = "ca_listed_vehicles_by_users_updated";

        $updata =    $this->Muser->insert_calisteddata($table1, $insertData);



        // 27 may ends



        if ($returnStatus) {
            $savePdata = $this->Muser->get_user_define_parts($this->jsonvalue);
            $result = array(
                'success' => true,
                'msg' => $this->lang->line('data_saved'),
                'code' => 200,
                'data' => $savePdata
            );
        } else {
            $result = array(
                'success' => false,
                'msg' => $this->lang->line('oops_something_went_wrong'),
                'code' => 400,
                'data' => array()
            );
        }
        echo json_encode($result);
    }

    // update user define parts ends

    // deleted part data

    public function deleted_parts_data()
    {
        $fields = array(
            'estimate_id',

        );
        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['data']   = array();
            echo json_encode($response);
            exit();
        }

        $table = "ca_estimate_select_parts_deleted";
        $savePdata = $this->Muser->getdeleteddata($table, $this->jsonvalue['estimate_id']);


        if ($savePdata) {

            $result = array(
                'success' => true,
                'msg' => $this->lang->line('data_saved'),
                'code' => 200,
                'data' => $savePdata
            );
        } else {
            $result = array(
                'success' => false,
                'msg' => "No Data Found",
                'code' => 400,
                'data' => array()
            );
        }
        echo json_encode($result);
    }


    // deleted part data ends


    public function deleteparts()
    {


        //--

        $fields = array(
            'delitem',
            'estimate_id'
        );


        $errors = $this->pushnotification->getError($this->jsonvalue, $fields);
        if (!empty($errors)) {
            $response['success'] = false;
            $response['msg']     = $errors;
            $response['code']   = 400;
            $response['data']   = array();
            echo json_encode($response);
            exit();
        }
        if ($this->Muser->isExistEstimate($this->jsonvalue['estimate_id'], $this->jsonvalue['user_id'])) {
            $current =  $this->Muser->getDatabyCondition('ca_estimates', array('estimate_id' => $this->jsonvalue['estimate_id']))[0];
        } else {
            $response['success'] = false;
            $response['msg']     = "Estimate doesn't exists";
            $response['code']   = 400;
            $response['data']   = array();
            echo json_encode($response);
            exit();
        }


        //---

        $val = $this->jsonvalue['delitem'];



        $table = "ca_estimate_select_parts";

        $table1 = "ca_estimate_select_parts_deleted";
        $field = 'id';

        for ($i = 0; $i < count($val); $i++) {
            $id = $val[$i];

            $where = array("id" => $id);


            $result = $this->Muser->getDatabyCondition($table, $where);

            $data = $result[0];

            if ($data) {
                $data['old_estimate_id'] = $data['estimate_id'];
                unset($data['id']);
                $data['estimate_id'] = $current['estimate_id'];
                $this->Muser->insertdeletepartsdata($data, $table, $table1, $id, $field);
                $this->Muser->deletedata("ca_estimate_select_parts_changed", $id, $field);
                $this->Muser->deletedata("ca_estimate_after_part_change", $id, 'part_id');
                $this->Muser->deletedata("ca_estimate_refinish_rule_data", $id, 'part_id');
                $incl = $this->Muser->getDatabyCondition('ca_estimate_select_parts_incl_overlap', array('select_parent_part_id' => $id));

                if ($incl[0]) {

                    if ($incl[0]['labor']) {
                        $afterData['part_id'] = $incl[0]['select_part_id'];
                        $afterData['old_estimate_id'] = $incl[0]['estimate_id'];
                        $afterData['parent_id'] = $incl[0]['estimate_id'];
                        $afterData['new_estimate_id'] = $current['estimate_id'];
                        $afterData['column_name'] = 'labor';
                        $afterData['old_value'] = 0;
                        $afterData['new_value'] = $incl[0]['labor'];
                        $this->db->insert("ca_estimate_after_part_change", $afterData);
                    }

                    if ($incl[0]['mech']) {
                        $afterData['part_id'] = $incl[0]['select_part_id'];
                        $afterData['old_estimate_id'] = $incl[0]['estimate_id'];
                        $afterData['parent_id'] = $incl[0]['estimate_id'];
                        $afterData['new_estimate_id'] = $current['estimate_id'];
                        $afterData['column_name'] = 'mech';
                        $afterData['old_value'] = 0;
                        $afterData['new_value'] = $incl[0]['mech'];
                        $this->db->insert("ca_estimate_after_part_change", $afterData);
                    }

                    // print_r($afterData);
                    // die;
                    $this->Muser->deletedata("ca_estimate_select_parts_incl_overlap", $id, 'select_parent_part_id');
                }
            }
        }


        //---




        /* if ($returnStatus) { */

        $result = array(
            'success' => true,
            'msg' => $this->lang->line('Data Deleted Successfully'),
            'code' => 200,
            'data' => array()
        );
        /* } else {
                    $result = array(
                        'success' => false,
                        'msg' => "No Data Found",
                        'code' => 400,
                        'data' => array()
                    );
        } */
        echo json_encode($result);


        //---



    }
}
