<?php
    use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	require '../vendor/autoload.php';
	
	ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
	include 'config.php';
	
	session_start();

	$action = $_GET['action'];
	if($action == 'small-form'){
	    $f_name = $_POST['name'];
	    $number = $_POST['phone'];
	    $url = $_POST['url'];
		$domain = $_POST['domain'];
		$subject = $_POST['subject'];
		$return_table = insert_into_table($f_name, null, null, $number, $url, $domain, $subject, $conn, null, null, null);
		$return_param = send_mail_to_admin($f_name, null, null, $number, $url, $domain, $subject, null, null, ADMIN_EMAIL, null);
		echo json_encode(array('response' => $return_param, 'response_table' => $return_table));
	}else if($action == 'order_form'){
		$f_name = $_POST['f_name'];
		$l_name = null;
		$email = $_POST['email'];
		$number = $_POST['number'];
		$url = $_POST['url'];
		$domain = $_POST['domain'];
		$subject = $_POST['subject'];
		$message = $_POST['message'];
		if(isset($_POST['optional'])){
			$optional = $_POST['optional'];
		}else{
			$optional = null;
		}
		$return_table = insert_into_table($f_name, $l_name, $email, $number, $url, $domain, $subject, $conn, null, $message, null);
		$return_param = send_mail_to_admin($f_name, $l_name, $email, $number, $url, $domain, $subject, null, $message, ADMIN_EMAIL, $optional);
		echo json_encode(array('response' => $return_param, 'response_table' => $return_table));
	}else if($action == 'contact_form'){
		$name = $_POST['name'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$services = $_POST['services'];
		$message = $_POST['message'];
		$url = $_POST['url'];
		$domain = $_POST['domain'];
		$subject = $_POST['subject'];
		$return_table = insert_into_table($name, null, $email, $phone, $url, $domain, $subject, $conn, $services, $message, null);
		$return_param = send_mail_to_admin($name, null, $email, $phone, $url, $domain, $subject, $services, $message, ADMIN_EMAIL, null);
		echo json_encode(array('response' => $return_param, 'response_table' => $return_table));
	}else if($action == 'sidebar_form'){
		$name = $_POST['name'];
		if($_POST['email'] != ''){
		    $email = $_POST['email'];
		}else{
		    $email = 'Not Given';
		}
		$phone = $_POST['phone'];
		if($_POST['message'] != ''){
		    $message = $_POST['message'];
		}else{
		    $message = 'Not Given';
		}
		$url = $_POST['url'];
		$domain = $_POST['domain'];
		$subject = $_POST['subject'];
		if(isset($_POST['callus'])){
			$optional['callus'] = $_POST['callus'];
		}else{
			$optional['callus'] = null;
		}
		
		if(isset($_POST['scheduleacall'])){
			$optional['scheduleacall'] = $_POST['scheduleacall'];
		}else{
			$optional['scheduleacall'] = null;
		}
		
		$return_table = insert_into_table($name, null, $email, $phone, $url, $domain, $subject, $conn, null, $message, null);
		$return_param = send_mail_to_admin($name, null, $email, $phone, $url, $domain, $subject, null, $message, ADMIN_EMAIL, $optional);
		echo json_encode(array('response' => $return_param, 'response_table' => $return_table));
	}else if($action == 'popup_form'){
		$name = $_POST['name'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$message = $_POST['message'];
		$url = $_POST['url'];
		$domain = $_POST['domain'];
		$subject = $_POST['subject'];
		$return_table = insert_into_table($name, null, $email, $phone, $url, $domain, $subject, $conn, null, $message , null);
		$return_param = send_mail_to_admin($name, null, $email, $phone, $url, $domain, $subject, null, $message, ADMIN_EMAIL, null);
		echo json_encode(array('response' => $return_param, 'response_table' => $return_table));
	}else if($action == 'landing_page'){
		$name = $_POST['name'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$message = $_POST['message'];
		$url = $_POST['url'];
		$domain = $_POST['domain'];
		$subject = $_POST['subject'];
		if(isset($_POST['optional'])){
			$optional = $_POST['optional'];
		}else{
			$optional = null;
		}
		$return_table = insert_into_table($name, null, $email, $phone, $url, $domain, $subject, $conn, null, $message, $optional);
		$return_param = send_mail_to_admin($name, null, $email, $phone, $url, $domain, $subject, null, $message, ADMIN_EMAIL, $optional);
		echo json_encode(array('response' => $return_param, 'response_table' => $return_table, 'name' => $name, 'email' => $email));
	}else if($action == 'logo_brief'){
	    
	    $name = $_POST['name'];
	    $email = $_POST['email'];
	    $logo_name = $_POST['logo_name'];
	    $tagline = $_POST['tagline'];
	    $description = $_POST['description'];
	    $logo_category = $_POST['logo_category'];
	    $logo_category_string = implode(', ', $logo_category);
	    $font_style = $_POST['font_style'];
	    $additional_information = $_POST['additional_information'];
	    $message = " Name: $name <br> Email: $email <br> Logo Name: $logo_name <br> Logo Tagline: $tagline <br> Description: $description <br> Logo Category: $logo_category_string <br> Font Style: $font_style <br> Additional Information: $additional_information";
	    
	    $mail = new PHPMailer();
	    $mail->IsSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = TRUE;
        $mail->SMTPSecure = "ssl";
        $mail->Port     = 465;  
        $mail->Username = ADMIN_EMAIL;
        $mail->Password = ADMIN_APP_PASSWORD;
        $mail->Host = 'smtp.gmail.com';
        $mail->Mailer   = "smtp";
        $mail->setFrom('olivia@designsgene.com', WEBSITE_NAME);
	    $mail->addAddress('olivia@designsgene.com', WEBSITE_NAME);
	    
        $mail->Subject = 'Logo Brief Form';
        
        foreach ($_FILES["attachment"]["name"] as $k => $v) {
            $mail->AddAttachment( $_FILES["attachment"]["tmp_name"][$k], $_FILES["attachment"]["name"][$k] );
        }
        
        $mail->isHTML(true);
        $mail->Body = $message;
        
        if(!$mail->Send()) {
            echo json_encode(array('response' => false, 'response_table' => false));
        } else {
            echo json_encode(array('response' => true, 'response_table' => true));
        }
	}else if($action == 'web_brief'){
	    $name = $_POST['name'];
	    $email = $_POST['email'];
	    $company = $_POST['company'];
	    $contact = $_POST['contact'];
	    $city = $_POST['city'];
	    $website_address = $_POST['website_address'];
	    $address = $_POST['address'];
	    $decision_makers = $_POST['decision_makers'];
	    $about_company = $_POST['about_company'];
	    $purpose = $_POST['purpose'];
	    $purpose_string = implode(', ', $purpose);
	    $deadline = $_POST['deadline'];
	    $potential_clients = $_POST['potential_clients'];
	    $competitor = $_POST['competitor'];
	    $user_perform = $_POST['user_perform'];
	    $user_perform_string = implode(', ', $user_perform);
	    $page = $_POST['page'];
	    $page_string = implode(', ', $page);
	    $content_notes = $_POST['content_notes'];
	    $content_notes_string = implode(', ', $content_notes);
	    $written_content = $_POST['written_content'];
	    $copywriting_photography_services = $_POST['copywriting_photography_services'];
	    $cms_site = $_POST['cms_site'];
	    $re_design = $_POST['re_design'];
	    $working_current_site = $_POST['working_current_site'];
	    $going_to_need = $_POST['going_to_need'];
	    $going_to_need_string = implode(', ', $going_to_need);
	    $additional_features = $_POST['additional_features'];
	    $feel_about_company = $_POST['feel_about_company'];
	    $incorporated = $_POST['incorporated'];
	    $need_designed = $_POST['need_designed'];
	    $specific_look = $_POST['specific_look'];
	    $competition = $_POST['competition'];
	    $competition_string = implode(', ', $competition);
	    $websites_link = $_POST['websites_link'];
	    $websites_link_string = implode(', ', $websites_link);
	    $people_find_business = $_POST['people_find_business'];
	    $market_site = $_POST['market_site'];
	    $accounts_setup = $_POST['accounts_setup'];
	    $links_accounts_setup = $_POST['links_accounts_setup'];
	    $service_account = $_POST['service_account'];
	    $use_advertising = $_POST['use_advertising'];
	    $printed_materials = $_POST['printed_materials'];
	    $domain_name = $_POST['domain_name'];
	    $hosting_account = $_POST['hosting_account'];
	    $login_ip = $_POST['login_ip'];
	    $domain_like_name = $_POST['domain_like_name'];
	    $section_regular_updating = $_POST['section_regular_updating'];
	    $updating_yourself = $_POST['updating_yourself'];
	    $blog_written = $_POST['blog_written'];
	    $regular_basis = $_POST['regular_basis'];
	    $fugure_pages = $_POST['fugure_pages'];
	    $additional_information = $_POST['additional_information'];
	    
	    $message = " <b>Name:</b> <br>$name <br><br>";
	    $message .= " <b>Email:</b> <br>$email <br><br>";
	    $message .= " <b>Company:</b> <br>$company <br><br>";
	    $message .= " <b>Contact:</b> <br>$contact <br><br>";
	    $message .= " <b>City, St, Zip:</b> <br>$city <br><br>";
	    $message .= " <b>Website address – or desired Domain(s):</b> <br>$website_address <br><br>";
	    $message .= " <b>Address:</b> <br>$address <br><br>";
	    $message .= " <b>Are there other decision makers? Please specify:</b> <br>$decision_makers <br><br>";
	    $message .= " <b>Please give me a brief overview of the company, what you do or produce?:</b> <br>$about_company <br><br>";
	    $message .= " <b>This section should include an overview of what the general purpose and goal of the web site is.:</b> <br>$purpose_string <br><br>";
	    $message .= " <b>If you have a specific deadline, please state why?:</b> <br>$deadline <br><br>";
	    $message .= " <b>Who will visit this site? Describe your potential clients. (Young, old, demographics, etc):</b> <br>$potential_clients <br><br>";
	    $message .= " <b>Why do you believe site visitors should do business with you rather than with a competitor? What problem are you solving for them?:</b> <br>$competitor <br><br>";
	    $message .= " <b>What action(s) should the user perform when visiting your site?:</b> <br>$user_perform_string <br><br>";
	    $message .= " <b>Content Pages:</b> <br>$page_string <br><br>";
	    $message .= " <b>Content Pages Note:</b> <br>$content_notes_string <br><br>";
	    $message .= " <b>Do you have the written content and images/photographs prepared for these pages?:</b> <br>$written_content <br><br>";
	    $message .= " <b>If not, will you need copywriting and photography services?:</b> <br>$copywriting_photography_services <br><br>";
	    $message .= " <b>Are you willing to commit time/effort into learning how to use Content Management System (CMS) and edit your site?:</b> <br>$cms_site <br><br>";
	    $message .= " <b>Is this a site re-design?:</b> <br>$re_design <br><br>";
	    $message .= " <b>If yes, can you please explain what is working and not working on your current site?:</b> <br>$working_current_site <br><br>";
	    $message .= " <b>Are you going to need?:</b> <br>$going_to_need_string <br><br>";
	    $message .= " <b>Are there any additional features that you would like for your site or things that you would like to add in the future? Please be as specific and detailed as possible.:</b> <br>$additional_features <br><br>";
	    $message .= " <b>People are coming to your new site for the first time. How do you want them to feel about your company?:</b> <br>$feel_about_company <br><br>";
	    $message .= " <b>Are there corporate colors, logo, fonts etc. that should be incorporated?:</b> <br>$incorporated <br><br>";
	    $message .= " <b>If you do not already have a logo, are you going to need one designed?:</b> <br>$need_designed <br><br>";
	    $message .= " <b>Is there a specific look and feel that you have in mind?:</b> <br>$specific_look <br><br>";
	    $message .= " <b>Please include at least 3 links of sites of your competition. What do you like and don't like about them? What would you like to differently or better?:</b> <br>$competition_string <br><br>";
	    $message .= " <b>Along with putting down the site address, please comment on what you like about each site, i.e. the look and feel, functionality, colors etc. These do not have to have anything to do with your business, but could have features you like. Please include at least 3 examples.:</b> <br>$websites_link_string <br><br>";
	    $message .= " <b>How do people find out about your business right now?:</b> <br>$people_find_business <br><br>";
	    $message .= " <b>Have you thought about how you're going to market this site?:</b> <br>$market_site <br><br>";
	    $message .= " <b>Do you have any social network accounts setup? (Facebook etc):</b> <br>$accounts_setup <br><br>";
	    $message .= " <b>Do you want links to those accounts on your site?:</b> <br>$links_accounts_setup <br><br>";
	    $message .= " <b>Do you have a mail service account? (Constant Contact, MailChimpetc):</b> <br>$service_account <br><br>";
	    $message .= " <b>Will you want to build your mailing list and use it for advertising & newsletters?:</b> <br>$use_advertising <br><br>";
	    $message .= " <b>Will you want printed materials (business cards, catalog, etc.) produced as well?:</b> <br>$printed_materials <br><br>";
	    $message .= " <b>Do you already own a domain name(s)? (www.mygreatsite.com):</b> <br>$domain_name <br><br>";
	    $message .= " <b>Do you have a hosting account already? (This is where the computer files live.):</b> <br>$hosting_account <br><br>";
	    $message .= " <b>If yes, do you have the login/IP information?:</b> <br>$login_ip <br><br>";
	    $message .= " <b>If no, what name(s) would you like?:</b> <br>$domain_like_name <br><br>";
	    $message .= " <b>Will there be sections that need regular updating? Which ones?:</b> <br>$section_regular_updating <br><br>";
	    $message .= " <b>Would you like to be able to do most of the updating yourself?:</b> <br>$updating_yourself <br><br>";
	    $message .= " <b>If you’re planning on writing a blog do you already have several things written?:</b> <br>$blog_written <br><br>";
	    $message .= " <b>Do you already write on a regular basis?:</b> <br>$regular_basis <br><br>";
	    $message .= " <b>Are there any features/pages that you don’t need now but may want in the future? Please be as specific and future thinking as possible.:</b> <br>$fugure_pages <br><br>";
	    $message .= " <b>Additional information (optional):</b> <br>$additional_information <br><br>";
	    
	    $mail = new PHPMailer();
	    $mail->IsSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = TRUE;
        $mail->SMTPSecure = "ssl";
        $mail->Port     = 465;  
        $mail->Username = ADMIN_EMAIL;
        $mail->Password = ADMIN_APP_PASSWORD;
        $mail->Host = 'smtp.gmail.com';
        $mail->Mailer   = "smtp";
        $mail->setFrom('olivia@designsgene.com', WEBSITE_NAME);
	    $mail->addAddress('olivia@designsgene.com', WEBSITE_NAME);
	    
        $mail->Subject = 'Website Brief Form';
        
        foreach ($_FILES["attachment"]["name"] as $k => $v) {
            $mail->AddAttachment( $_FILES["attachment"]["tmp_name"][$k], $_FILES["attachment"]["name"][$k] );
        }
        
        $mail->isHTML(true);
        $mail->Body = $message;
        
        if(!$mail->Send()) {
            echo json_encode(array('response' => false, 'response_table' => false));
        } else {
            echo json_encode(array('response' => true, 'response_table' => true));
        }
	}

	function insert_into_table($f_name, $l_name, $email, $number, $url, $domain, $subject, $conn, $services, $message, $optional){
	    $optional = json_encode($optional);
		$sql = "INSERT INTO leads (f_name, l_name, email, phone, url, domain, subject, services, message, optional)
				VALUES ('$f_name', '$l_name', '$email', '$number', '$url', '$domain', '$subject', '$services', '$message', '$optional')";
	 	if ($conn->query($sql)) {
	 		$last_id = $conn->insert_id;
	 		$_SESSION["customer_email"] = $email;
	 		$_SESSION["customer_phone"] = $number;
	 		$_SESSION["customer_url"] = $url;
	 		$_SESSION["customer_id"] = $last_id;
	 		return $last_id;
	 	}
	 	return 0;
	}

	function send_mail_to_admin($f_name, $l_name, $email, $number, $url, $domain, $subject, $services, $param_message, $admin_email, $optional){
		$to = $admin_email;
		$subject = $subject;
		$from = $email;
		$optional = json_encode($optional);
		$headers = "From:" . $from;
		// Compose a simple HTML email message
		$message = " First Name: $f_name <br>";
		if($l_name != null){
			$message .= " Last Name: $l_name <br>";
		}
		$message .= " Email: $email <br>";
		$message .= " Number: $number <br>";
		$message .= " Url: $url <br>";
		$message .= " Domain: $domain <br>";
		if($services != null){
			$message .= " Service: $services <br>";
		}
		if($param_message != null){
			$message .= " Message: $param_message <br>";
		}
		if($optional != null){
			$message .= " Optional: $optional";	
		}
		
		if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
	        $url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	    }else{
	        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	    }
		
	    $mail = new PHPMailer(true);

		try {
			
			$mail->SMTPOptions = array(
			    'ssl' => array(
			        'verify_peer' => false,
			        'verify_peer_name' => false,
			        'allow_self_signed' => true
			    )
			);
		    
		    $mail->SMTPDebug = 0;
		    $mail->isSMTP();
		    $mail->Host       = 'smtp.gmail.com';
		    $mail->SMTPAuth   = true;
		    $mail->Username   = ADMIN_EMAIL_SENDER;
		    $mail->Password   = ADMIN_APP_PASSWORD;
		    $mail->SMTPSecure = 'ssl';
		    $mail->Port       = 465;

		    $mail->setFrom($to, WEBSITE_NAME);
		    $mail->addAddress($to, WEBSITE_NAME);
		    

		    $mail->isHTML(true);
		    $mail->Subject = $subject;
		    $mail->Body    = $message;
		    $mail->send();
		} catch (Exception $e) {
			
		}
		
	
		return true;
	}
?>