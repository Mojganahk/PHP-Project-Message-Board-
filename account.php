<?php

// fake $app, $log so that Netbeans can provide suggestions while typing code
if (false) {
    $app = new \Slim\Slim();
    $log = new Logger('main');
}


//------------------------------------Register starts-----------------------------------------

//REGISTRATION FIRST SHOW
$app->get('/register', function() use($app) {
    $app->render('register.html.twig');
});
//
//REGISTRATION SUBMISSION
$app->post('/register', function() use ($app, $log) {
//extract submission
    $name = $app->request()->post('name');
    $email = $app->request()->post('email');
    $pass1 = $app->request()->post('pass1');
    $pass2 = $app->request()->post('pass2');
    $values = array('name' => $name, 'email' => $email);
    $errorList = array();
//
    if (strlen($name) < 2 || strlen($name) > 50) {
        array_push($errorList, "Name must be between 2 and 50 characters.");
        $value['name'] = '';
    }
//
    if (filter_var($email, FILTER_VALIDATE_EMAIL) == FALSE) {
        array_push($errorList, "Email must look like a valid email.");
        $values['email'] = '';
    } else {
        $row = DB::queryFirstRow("SELECT * FROM users WHERE email=%s", $email);
        if ($row) {
            array_push($errorList, "Email already used.");
            $values['email'] = '';
        }
    }
//
    if ($pass1 != $pass2) {
        array_push($errorList, "Passwords don't match");
    } else {
        if (strlen($pass1) < 2 || strlen($pass2) > 50) {
            array_push($errorList, "Password must be between 2 and 50");
        }
    }
//
//password pattern check
    if (!preg_match('/[a-z]/', $pass1) || !preg_match('/[a-z]/', $pass1) || !preg_match('/[0-9' . preg_quote("!@#\$%^&*()_-+={}[],.<>;:'\"~`") . ']/', $pass1)) {
        array_push($errorList, "Password must have at least one lowercase, one uppercase, and one number.");
    }
//
    //POST IMAGE CHECK
    $avatar = array();
    if ($_FILES['avatar']['error'] != UPLOAD_ERR_NO_FILE) {
        $avatar = $_FILES['avatar'];
        //check for errors
        if ($avatar['error'] != 0) {
            array_push($errorList, "Error uploading file.");
            $log->err("Error uploading file: " . print_r($avatar, true));
        } else {
            if (strstr($avatar['name'], '..')) {
                array_push($errorList, "Invalid file name");
                $log->warn("Uploaded file name with .. in it (possible attack) " . print_r($avatar, true));
            }
            
            $info = getimagesize($avatar["tmp_name"]);
            if ($info == FALSE) {
                array_push($errorList, "File doesn't look like a valid image.");
            } else {
//                //CHECK IMAGE SIZE, 
                if (filesize($avatar["tmp_name"]) > 200000) {
                    array_push($errorList, "Image must be smaller than 20kb.");
                }
                //CHECK IMAGE DIMENSIONS
                if ($info[0] > 300 || $info[1] > 300) {
                    array_push($errorList, "Image must not be bigger than 300x300 pixels.");
                }
                if ($info['mime'] == 'image/jpeg' || $info['mime'] == 'image/png' || $info['mime'] == 'image/gif') {
                    //image type is valid- all good
                } else {
                    array_push($errorList, "Image must be a JPG, GIF, or PNG only.");
                }
            }
        }
    } else { //no file uploaded
        array_push($errorList, "Photo must be uploaded with new registration.");
    }


    if ($errorList) { // 3. failed submission
        $app->render('register.html.twig', array(
            'errorList' => $errorList,
            'v' => $values));
    } else { //2. successful submission
        if ($avatar) { //   '[^a-zA-Z0-9_\.-]' 
          //  $sanitizedFileName = preg_replace('[^a-zA-Z0-9_\.-]', '_', $profileImage['name']); Greg's code but he never checked it, doesn't work
            $imagePath = 'uploads/' . $avatar['name'];  // 
            if (!move_uploaded_file($avatar['tmp_name'], $imagePath)) {
                $log->err(sprintf("Error moving uploaded file: " . print_r($avatar, true)));
                $app->render('error_internal.html.twig');
                return;
            }
            //TODO: if EDITING and new file is uploaded we should delete the old one in uploads
            $values['avatarPath'] = "/" . $imagePath;
        }
//encrypted password
        $passEnc = password_hash($pass1, PASSWORD_BCRYPT);
        $values['password'] = $passEnc;
        DB::insert('users', $values);
        $app->render('register_success.html.twig', $values);
    }
});


//----------------------------------register ends----------------------------------------------
//
//-------------------------------this Email registered alreardy------------------------------------------
$app->get('/isemailregistered/:email', function($email) use ($app) {
    $row = DB::queryFirstRow("SELECT * FROM users WHERE email=%s", $email);
    echo!$row ? "" : '<span style="background-color: red; font-weight: bold;">Email already taken</span>';
});
//-------------------------------email ends------------------------------------------
//-------------------------------login Starts------------------------------------------
$app->get('/login', function() use ($app) {
    $app->render('login.html.twig');
});

$app->post('/login', function() use ($app) {
//extract data
    $email = $app->request()->post('email');
    $password = $app->request()->post('password');

    $row = DB::queryFirstRow("SELECT * FROM users WHERE email=%s", $email);
    $error = false;

    if (!$row) {
        $error = true; //user not found
    } else { //password verify
        if (!password_verify($password, $row['password'])) { //password failed
            $error = true;
        }
    }
    if ($error) {
        $app->render('login.html.twig', array('error' => true));
    } else {
        unset($row['password']);
        $_SESSION['user'] = $row;
        $app->render('login_success.html.twig', array('userSession' => $_SESSION['user'], 'email' => $email));
    }
});

//check logged in users
$app->get('/session', function() {
    print_r($_SESSION);
});
//-------------------------------login Ends------------------------------------------
//-------------------------------logout starts------------------------------------------
$app->get('/logout', function() use ($app) {
    $_SESSION['user'] = array();
    $app->render('logout.html.twig', array('userSession' => $_SESSION['user']));
});
//-------------------------------logout Ends------------------------------------------



function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$app->map('/passreset/request', function() use ($app, $log) {
    if ($app->request()->isGet()) {
        // State 1: first show
        $app->render('passreset_request.html.twig');
        return;
    }
    // in Post - receiving submission
    $email = $app->request()->post('email');
    $user = DB::queryFirstRow("SELECT * FROM users WHERE email=%s", $email);
    if ($user) {
        $secretToken = generateRandomString(50);
        /* Version 1: delete-and-insert 2 operations */
        /* DB::delete('passresets', 'userId=%d', $user['id']);
          DB::insert('passresets', array(
          'userId' => $user['id'],
          $secretToken,
          'expiryDateTime' => date("Y-m-d H:i:s", strtotime("+1 day"))
          )); */
        /* Version 2: insertUpdate */
        DB::insertUpdate('passresets', array(
            'userId' => $user['id'],
            'secretToken' => $secretToken,
            'expiryDateTime' => date("Y-m-d H:i:s", strtotime("+5 minutes"))
        ));
        $url = 'http://' . $_SERVER['SERVER_NAME'] . '/passreset/token/' . $secretToken;
        $emailBody = $app->view()->render('passreset_email.html.twig', array(
            'name' => $user['name'], // or 'username' or 'firstName'
            // 'name' => 'User', if you don't have user's name in your database
            'url' => $url
        ));
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html\r\n";
        $headers .= "From: Noreply <noreply@ipd10.com>\r\n";
        $headers .= "Date: " . date("Y-m-d H:i:s");
        $toEmail = sprintf("%s <%s>", htmlentities($user['name']), $user['email']);
        // $headers.= sprintf("To: %s\r\n", $user['email']);

        mail($toEmail, "Your password reset for " . $_SERVER['SERVER_NAME'], $emailBody, $headers);
        $log->info('Email sent for password reset for user id=' . $user['id']);
        $app->render('passreset_request_success.html.twig');
    } else { // State 3: failed request, email not registered
        $app->render('passreset_request.html.twig', array('error' => true));
    }
})->via('GET', 'POST');

$app->map('/passreset/token/:secretToken', function($secretToken) use ($app, $log) {
    $row = DB::queryFirstRow("SELECT * FROM passresets WHERE secretToken=%s", $secretToken);
    if (!$row) { // row not found
        $app->render('passreset_notfound_expired.html.twig');
        return;
    }
    if (strtotime($row['expiryDateTime']) < time()) {
        // row found but token expired
        $app->render('passreset_notfound_expired.html.twig');
        return;
    }
    //
    $user = DB::queryFirstRow("SELECT * FROM users WHERE id=%d", $row['userId']);
    if (!$user) {
        $log->err(sprintf("Passreset for token %s user id=%d not found", $row['secretToken'], $row['userId']));
        $app->render('error_internal.html.twig');
        return;
    }
    if ($app->request()->isGet()) { // State 1: first show
        $app->render('passreset_form.html.twig', array(
            'name' => $user['name'], 'email' => $user['email']
        ));
    } else { // receiving POST with new password
        $pass1 = $app->request()->post('pass1');
        $pass2 = $app->request()->post('pass2');
        // FIXME: verify quality of the new password using a function
        $errorList = array();
        if ($pass1 != $pass2) {
            array_push($errorList, "Passwords don't match");
        } else { // TODO: do a better check for password quality (lower/upper/numbers/special)
            if (strlen($pass1) < 2 || strlen($pass1) > 50) {
                array_push($errorList, "Password must be between 2 and 50 characters long");
            }
        }
        if ($errorList) { // 3. failed submission
            $app->render('passreset_form.html.twig', array(
                'errorList' => $errorList,
                'name' => $user['name'],
                'email' => $user['email']
            ));
        } else { // 2. successful submission
            DB::update('users', array('password' => $pass1), 'id=%d', $user['id']);
            $app->render('passreset_form_success.html.twig');
        }
    }
})->via('GET', 'POST');

//--------------------------------------Post starts--------------------------------------



//$app->get('/add', function() use ($app) {
//    if (!$_SESSION['user']) {
//        $app->render('access_denied.html.twig');
//        return;
//    }
//    $app->render('post_addedit.html.twig');
//});
//
//$app->post('/add', function() use ($app) {
//    if (!$_SESSION['user']) {
//        $app->render('access_denied.html.twig');
//        return;
//    }
//
//    $title = $app->request()->post('title');
////    $datePosted = $app->request()->post('datePosted');
//    $body = $app->request()->post('body');
//    //  $catId = $app->request()->post('catId');
//    //
//    $values = array('title' => $title, 'body' => $body); //'catId' => $catId
//
//    $errorList = array();
//    //
//    if (strlen($title) < 2 || strlen($title) > 50) {
//        $values['title'] = '';
//        array_push($errorList, "Task must be between 2 and 50 characters long");
//    }
//
//
//    if (strlen($body) < 2 || strlen($body) > 2000) {
//        $values['body'] = '';
//        array_push($errorList, "body must be between 2 and 50 characters long");
//    }
//
//
//    if ($errorList) { // 3. failed submission
//        $app->render('post_addedit.html.twig', array(
//            'errorList' => $errorList,
//            'v' => $values));
//    } else { // 2. successful submission
//        // import image
//        $values['authorId'] = $_SESSION['user']['id'];
//        DB::insert('posts', $values);
//        $app->render('post_addedit_success.html.twig');
//    }
//});
//
//
//$app->get('/delete/:id', function($id) use ($app) {
//    if (!$_SESSION['user']) {
//        $app->render('access_denied.html.twig');
//        return;
//    }
//    $post = DB::queryFirstRow("SELECT * FROM posts WHERE id=%i AND authorId=%i", $id, $_SESSION['user']['id']);
//    if (!$post) {
//        echo "Item not found"; // FIXME: 404, not found page
//        return;
//    }
//    $app->render('post_delete.html.twig', array('post' => $post));
//});
//
//$app->post('/delete/:id', function($id) use ($app) {
//    if (!$_SESSION['user']) {
//        $app->render('access_denied.html.twig');
//        return;
//    }
//    $confirmed = $app->request()->post('confirmed');
//    if ($confirmed != 'true') {
//        echo 'error: confirmation missing'; // post: use template
//        return;
//    }
//    DB::delete('posts', "id=%i AND authorId=%i", $id, $_SESSION['user']['id']);
//    if (DB::affectedRows() == 0) {
//        echo 'error: record not found'; // post: use template
//    } else {
//        $app->render('post_delete_success.html.twig');
//    }
//});
//
//
//
//
////--------------------------------------Post ends--------------------------------------
