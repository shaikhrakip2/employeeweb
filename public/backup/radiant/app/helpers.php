<?php

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Twilio\Rest\Client;

function getRoles()
{
 
    $roles = DB::table('roles')->where('id','!=',1)->where('id','!=',5)->where('id','!=',6)->pluck('display_name','id'); 
    return $roles;

} 

function getEmployeeId($user_id){

    return App\User::where('id',$user_id)->first()->employee_id;
}



function firebaseNotification($fcm_ids, $data, $setting, $image){
    if($setting['firebasekey'] != '')
    {
        $image = !empty($image)?$image:asset($setting['logo']);
        $url = "https://fcm.googleapis.com/fcm/send";
        $title = $data['title'];
        $body = $data['message'];
        $notification = array('title' =>$title ,'name'=> $setting['application_name'],'body' => $body, 'sound' => 'default', 'badge' => '1','image'=>$image);
        $arrayToSend = array('registration_ids' => $fcm_ids, 'notification' => $notification,'priority'=>'high');
      
        $json = json_encode($arrayToSend); 
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key='. $setting['firebasekey'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //Send the request
        $result = curl_exec($ch);   
        
        curl_close($ch);    
    } 
}

function imageexist($image_path)
{
    // dd($image_path);
    if ($image_path == '' || !File::exists($image_path)) {
        return asset('/public/images/default.jpg');
    } else {
        return asset($image_path);
    }
}

function get_image($path, $type = 'default', $resize = 0)
{
    $default_images = [
        'banner' => ['img' => 'public/images/default.jpg', 'width' => 1350, 'height' => 570],
        'blog' => ['img' => 'public/images/default.jpg', 'width' => 400, 'height' => 500],
        'default' => ['img' => 'public/images/default.jpg', 'width' => 213, 'height' => 245],
        'latest_blog' => ['img' => 'public/images/default.jpg', 'width' => 100, 'height' => 80],
        'contact_img' => ['img' => 'public/images/default.jpg', 'width' => 350, 'height' => 350],
        'blogs_default_image' => ['img' => 'public/images/default.jpg', 'width' => 600, 'height' => 300],
        'cms' => ['img' => 'public/images/default.jpg', 'width' => 516, 'height' => 354],
        'book_details_small' => ['img' => 'public/images/default.jpg', 'width' => 138, 'height' => 125],
        'event' => ['img' => 'public/images/default.jpg', 'width' => 400, 'height' => 200],
        'author_small' => ['img' => 'public/images/default.jpg', 'width' => 518, 'height' => 590],
        'author_books' => ['img' => 'public/images/default.jpg', 'width' => 309, 'height' => 341],
        'ecoms' => ['img' => 'public/images/default.jpg', 'width' => 136, 'height' => 122],
        'doctor_image' => ['img' => 'public/images/default.jpg', 'width' => 400, 'height' => 420],
    ];

    $type = empty($default_images[$type]) ? 'default' : $type;
    $full_path = base_path($path);
    $height = $default_images[$type]['height'];
    $width = $default_images[$type]['width'];

    if (file_exists($full_path) && !empty($path)) {
        if ($resize) {
            return image_resize($path, $width, $height);
        } else {
            return asset($path);
        }
    } else {
        if ($resize) {
            return image_resize($default_images[$type]['img'], $width, $height);
        } else {
            return asset($default_images[$type]['img']);
        }

    }
}

function image_resize($filename, $width, $height) {   

	include_once(base_path().'/image.php');
    $image_old = $filename; 

    $extension = pathinfo($filename, PATHINFO_EXTENSION);  
    $mine = mime_content_type($filename);
	$image_new = 'cache/' .$filename. '-' . (int)$width . 'x' . (int)$height . '.' . $extension;

    $root_path = base_path()."/";   

	if (!is_file($root_path. $image_new) && is_file($root_path. $image_old)) {
		// Get new dimensions
		list($width_orig, $height_orig, $image_type) = getimagesize($root_path. $image_old);
		
		$path = '';
		$directories = explode('/', dirname($image_new));
		foreach ($directories as $directory) {
			$path = $path . '/' . $directory; 
			if (!is_dir($root_path. $path)) {
				@mkdir($root_path. $path, 0777);
			}
		}

        $xpos = 0;
        $ypos = 0;
        $scale = 1;
        if ($mine == 'image/jpeg') {
            $Oldimage = imagecreatefromjpeg($root_path. $image_old);
        }elseif ($mine == 'image/png') {
            $Oldimage = imagecreatefrompng($root_path. $image_old);
        }elseif ($mine == 'image/gif') {
            $Oldimage = imagecreatefromgif($root_path. $image_old);
        }           
        $scale_w = $width / $width_orig;
        $scale_h = $height / $height_orig;
        $scale = min($scale_w, $scale_h);
        $new_width = (int)($width_orig * $scale);
        $new_height = (int)($height_orig * $scale);
        $xpos = (int)(($width - $new_width) / 2);
        $ypos = (int)(($height - $new_height) / 2);
        $newimage = imagecreatetruecolor($width, $height);
        imagealphablending($newimage, false);
        imagesavealpha($newimage, true);
        $background = imagecolorallocatealpha($newimage, 255, 255, 255, 127);
        imagecolortransparent($newimage, $background);
        imagefilledrectangle($newimage, 0, 0, $width, $height, $background);
        imagecopyresampled($newimage, $Oldimage, $xpos, $ypos, 0, 0, $new_width, $new_height, $width_orig, $height_orig);
        imagepng($newimage, $root_path. $image_new);
	}
	$image_new = str_replace(' ', '%20', $image_new);
	// dd($image_new);
    return asset($image_new);
}


function numberToWord( $num = '' )
{
    $num    = ( string ) ( ( int ) $num );
 
    if( ( int ) ( $num ) && ctype_digit( $num ) )
    {
        $words  = array( );
       
        $num    = str_replace( array( ',' , ' ' ) , '' , trim( $num ) );
       
        $list1  = array('','one','two','three','four','five','six','seven',
            'eight','nine','ten','eleven','twelve','thirteen','fourteen',
            'fifteen','sixteen','seventeen','eighteen','nineteen');
       
        $list2  = array('','ten','twenty','thirty','forty','fifty','sixty',
            'seventy','eighty','ninety','hundred');
       
        $list3  = array('','thousand','million','billion','trillion',
            'quadrillion','quintillion','sextillion','septillion',
            'octillion','nonillion','decillion','undecillion',
            'duodecillion','tredecillion','quattuordecillion',
            'quindecillion','sexdecillion','septendecillion',
            'octodecillion','novemdecillion','vigintillion');
       
        $num_length = strlen( $num );
        $levels = ( int ) ( ( $num_length + 2 ) / 3 );
        $max_length = $levels * 3;
        $num    = substr( '00'.$num , -$max_length );
        $num_levels = str_split( $num , 3 );
       
        foreach( $num_levels as $num_part )
        {
            $levels--;
            $hundreds   = ( int ) ( $num_part / 100 );
            $hundreds   = ( $hundreds ? ' ' . $list1[$hundreds] . ' Hundred' . ( $hundreds == 1 ? '' : 's' ) . ' ' : '' );
            $tens       = ( int ) ( $num_part % 100 );
            $singles    = '';
           
            if( $tens < 20 )
            {
                $tens   = ( $tens ? ' ' . $list1[$tens] . ' ' : '' );
            }
            else
            {
                $tens   = ( int ) ( $tens / 10 );
                $tens   = ' ' . $list2[$tens] . ' ';
                $singles    = ( int ) ( $num_part % 10 );
                $singles    = ' ' . $list1[$singles] . ' ';
            }
            $words[]    = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_part ) ) ? ' ' . $list3[$levels] . ' ' : '' );
        }
       
        $commas = count( $words );
       
        if( $commas > 1 )
        {
            $commas = $commas - 1;
        }
       
        $words  = implode( ', ' , $words );
       
        //Some Finishing Touch
        //Replacing multiples of spaces with one space
        $words  = trim( str_replace( ' ,' , ',' , trimAll( ucwords( $words ) ) ) , ', ' );
        if( $commas )
        {
            $words  = strReplaceLast( ',' , ' and' , $words );
        }
       
        return $words;
    }
    else if( ! ( ( int ) $num ) )
    {
        return 'Zero';
    }
    return '';
}

function validateUser($slug)
{
if($slug == Auth::user()->slug)
    return TRUE;
return FALSE;
}

function prepareBlockUserMessage($request)
{
 $request->session()->flash('Ooops..!', 'you_have_no_permission_to_access', 'error');
 return '';
}


function pageNotFound($request)
{
 $request->session()->flash('Ooops..!', 'page_not_found', 'error');
 return '';
} 

function isActive($active_class = '', $value = '')
{
    $value = isset($active_class) ? ($active_class == $value) ? 'active' : '' : '';
    if($value)
        return "class = ".$value;
    return $value; 
}

function pr($data){
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

function prd($data){
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    die();
}
    
function html_escape($var, $double_encode = TRUE)
{
    if (empty($var))
    {
        return $var;
    }

    if (is_array($var))
    {
        foreach (array_keys($var) as $key)
        {
            $var[$key] = html_escape($var[$key], $double_encode);
        }

        return $var;
    }

    return htmlspecialchars($var, ENT_QUOTES);
}    

function delete_file($filepath){
    unlink($filepath);
}


function checkPermission($current, $module_id = null)
{
    $method = Route::current()->getActionMethod();
    switch ($method) {
        case 'index':
            $current->middleware('isAllow:'.$module_id.',can_view');
            break;
        case 'create':
            $current->middleware('isAllow:'.$module_id.',can_add');
            break;
        case 'store':
            $current->middleware('isAllow:'.$module_id.',can_add');
            break;
        case 'edit':
            $current->middleware('isAllow:'.$module_id.',can_edit');
            break;
        case 'update':
            $current->middleware('isAllow:'.$module_id.',can_edit');
            break;
        case 'destroy':
            $current->middleware('isAllow:'.$module_id.',can_delete');
            break;
        case 'change_status':
            $current->middleware('isAllow:'.$module_id.',can_edit');
            break;
        case 'adddetails':
            $current->middleware('isAllow:'.$module_id.',can_edit');
            break;
    }

}

function userCan($module_id = [], $type = "can_view"): bool
{
    if (gettype($module_id) == 'array') {
        $module = (array) $module_id;
    } else {
        $module = [$module_id];
    }

    $permission = request()->permission;
    $result = array_filter($permission, function ($item) use ($module, $type) {
        if (in_array($item['module_id'], $module) && ($item['allow_all'] == 1 || $item[$type] == 1)) {
            return $item;
        }
        return false;
    });

    if (count($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function userAllowed($module_id = 0, $type = ['can_edit', 'can_delete'])
{
    $permission = request()->permission;
    $result = array_filter($permission, function ($item) use ($module_id) {
        if ($item['module_id'] == $module_id) {
            return $item;
        }
        return false;
    });

    if (count($result) > 0) {
        $item = array_values($result)[0];
        $result = array_filter($type, function ($row) use ($item) {
            if (!empty($item[$row])) {
                return $item;
            }
            return false;
        });

        if ($item['allow_all'] == 1  || count($result) > 0) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function RandcardStr($length)
{

    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    ///$codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet .= "01234567899876543210";
    $max = strlen($codeAlphabet); // edited

    for ($i = 0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max - 1)];
    }

    return $token;
}
function crypto_rand_secure($min, $max)
{
    $range = $max - $min;
    if ($range < 1) return $min; // not so random...
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd > $range);
    return $min + $rnd;
}

 