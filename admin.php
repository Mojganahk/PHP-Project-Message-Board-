<?php

// fake $app, $log so that Netbeans can provide suggestions while typing code
if (false) {
    $app = new \Slim\Slim();
    $log = new Logger('main');
}


//--------------------------------Admin - categories-------------------------------
$app->get('/admin/categories/list', function() use ($app) {
    if (!$_SESSION['user'] || $_SESSION['user']['role'] != 'admin') {
        $app->render('access_denied.html.twig');
        return;
    }
    //
    $categoriesList = DB::query("SELECT * FROM categories");
    $app->render('admin/categories_list.html.twig', array('list' => $categoriesList));
});
$app->get('/admin/categories/delete/:id', function($id) use ($app) {
    if (!$_SESSION['user'] || $_SESSION['user']['role'] != 'admin') {
        $app->render('access_denied.html.twig');
        return;
    }
    $categories = DB::queryFirstRow('SELECT * FROM categories WHERE id=%d', $id);
    if (!$categories) {
        $app->render('admin/not_found.html.twig');
        return;
    }
    $app->render('admin/categories_delete.html.twig', array('c' => $categories));
});
$app->post('/admin/categories/delete/:id', function($id) use ($app) {
    if (!$_SESSION['user'] || $_SESSION['user']['role'] != 'admin') {
        $app->render('access_denied.html.twig');
        return;
    }
    $confirmed = $app->request()->post('confirmed');
    if ($confirmed != 'true') {
        $app->render('admin/not_found.html.twig');
        return;
    }
    DB::delete('categories', "id=%i", $id);
    if (DB::affectedRows() == 0) {
        $app->render('admin/not_found.html.twig');
    } else {
        $app->render('admin/categories_delete_success.html.twig');
    }
});
$app->get('/admin/categories/:op(/:id)', function($op, $id = -1) use ($app) {
    if (!$_SESSION['user'] || $_SESSION['user']['role'] != 'admin') {
        $app->render('access_denied.html.twig');
        return;
    }
    if (($op == 'add' && $id != -1) || ($op == 'edit' && $id == -1)) {
        echo "INVALID REQUEST"; // FIXME on Monday - display standard 404 from slim
        return;
    }
    //
    if ($id != -1) {
        $values = DB::queryFirstRow('SELECT * FROM categories WHERE id=%i', $id);
        if (!$values) {
            echo "NOT FOUND";  // FIXME on Monday - display standard 404 from slim
            return;
        }
    } else { // nothing to load from database - adding
        $values = array();
    }
    $app->render('admin/categories_addedit.html.twig', array(
        'v' => $values,
        'isEditing' => ($id != -1)
    ));
})->conditions(array(
    'op' => '(edit|add)',
    'id' => '\d+'
));

$app->post('/admin/categories/:op(/:id)', function($op, $id = -1) use ($app, $log) {
    if (!$_SESSION['user'] || $_SESSION['user']['role'] != 'admin') {
        $app->render('access_denied.html.twig');
        return;
    }
    if (($op == 'add' && $id != -1) || ($op == 'edit' && $id == -1)) {
        echo "INVALID REQUEST"; // FIXME on Monday - display standard 404 from slim
        return;
    }
    //
    $categoryName = $app->request()->post('categoryName');
    $description = $app->request()->post('description');
    //
    $values = array('categoryName' => $categoryName, 'description' => $description);
    $errorList = array();
    //
    if (strlen($categoryName) < 2 || strlen($categoryName) > 20) {
        $values['categoryName'] = '';
        array_push($errorList, "categoryName must be between 2 and 20 characters long");
    }
    if (strlen($description) < 2 || strlen($description) > 100) {
        $values['description'] = '';
        array_push($errorList, "Description must be between 2 and 100 characters long");
    }

    $categoryImage = array();
    ///////////////////
    if ($_FILES['categoryImage']['error'] != UPLOAD_ERR_NO_FILE) {
        $categoryImage = $_FILES['categoryImage'];
        if ($categoryImage['error'] != 0) {
            array_push($errorList, "Error uploading file");
            $log->err("Error uploading file: " . print_r($categoryImage, true));
        } else {
            if (strstr($categoryImage['name'], '..')) {
                array_push($errorList, "Invalid file name");
                $log->warn("Uploaded file name with .. in it (possible attack): " . print_r($categoryImage, true));
            }
            // TODO: check if file already exists, check maximum size of the file, dimensions of the image etc.
            $info = getimagesize($categoryImage["tmp_name"]);
            if ($info == FALSE) {
                array_push($errorList, "File doesn't look like a valid image");
            } else {
                if ($info['mime'] == 'image/jpeg' || $info['mime'] == 'image/gif' || $info['mime'] == 'image/png') {
                    // image type is valid - all good
                } else {
                    array_push($errorList, "Image must be a JPG, GIF, or PNG only.");
                }
            }
        }
    } else { // no file uploaded
        if ($op == 'add') {
            array_push($errorList, "Image is required when creating new category");
        }
    }
    //
    if ($errorList) { // 3. failed submission
        $app->render('admin/categories_addedit.html.twig', array(
            'errorList' => $errorList,
            'isEditing' => ($id != -1),
            'v' => $values));
    } else { // 2. successful submission
        if ($categoryImage) {
            $imagePath = 'uploads/' . $categoryImage['name'];
            if (!move_uploaded_file($categoryImage['tmp_name'], $imagePath)) {
                $log->err("Error moving uploaded file: " . print_r($categoryImage, true));
                $app->render('internal_error.html.twig');
                return;
            }
            // TODO: if EDITING and new file is uploaded we should delete the old one in uploads
            $values['imagePath'] = "/" . $imagePath;
        }
        if ($id != -1) {
            DB::update('categories', $values, "id=%i", $id);
        } else {
            DB::insert('categories', $values);
        }
        $app->render('admin/categories_addedit_success.html.twig', array('isEditing' => ($id != -1)));
    }
})->conditions(array(
    'op' => '(edit|add)',
    'id' => '\d+'
));

//--------------------------------------admin ends--------------------------------------

