<?php

class Validator {
  public static function validateTaskInput($input) {
    $errors = [];
    $maxLength = 100;

    if (!isset($input['title']) || !is_string($input['title']) || trim($input['title']) === '') {
      $errors[] = 'Title is required and cannot be empty';
    }
    if (mb_strlen($input['title']) > $maxLength) {
      $errors[] = "Title must have less than $maxLength characters";
    }
    if (!isset($input['description']) || !is_string($input['description']) || trim($input['description']) === '') {
      $errors[] = 'Description is required and must be a string';
    }
    if (mb_strlen($input['description']) > $maxLength) {
      $errors[] = "Description must have less than $maxLength characters";
    }
    if (!isset($input['status']) || !in_array($input['status'], ['pending', 'in_progress', 'done'])) {
      $errors[] = 'Status is required and must be \'pending\', \'in_progress\' or \'done\'';
    }
    if (mb_strlen($input['status']) > $maxLength) {
      $errors[] = "Status must have less than $maxLength characters";
    }

    return $errors;
  }
}