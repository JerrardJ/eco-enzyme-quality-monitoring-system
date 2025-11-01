<?php

function validatePost($post) 
{
    global $conn;
    $errors = array();
    
    if (empty($post['title'])) {
        array_push($errors, 'Title Required!');

    }
    if (empty($post['description'])) {
        array_push($errors, 'Description Required!');

    }

    $existingPost = selectOne('posts', ['title' => $post['title']]);
    if ($existingPost) {
        if (isset($post['update-post']) && $existingPost['id'] != $post=['id']) {
            array_push($errors, 'Title Exists Already!');
        }
         if (isset($post['add-post'])){
            array_push($errors, 'Title Exists Already!');
         }
    }
    return $errors;
}