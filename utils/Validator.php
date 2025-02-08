<?php
class Validator {
    private $errors = [];
    private $data = [];

    public function __construct($data) {
        $this->data = $data;
    }

    public function required($field, $message = null) {
        if (empty($this->data[$field])) {
            $this->errors[$field] = $message ?? "The {$field} field is required.";
        }
        return $this;
    }

    public function email($field, $message = null) {
        if (!empty($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = $message ?? "The {$field} must be a valid email address.";
        }
        return $this;
    }

    public function minLength($field, $length, $message = null) {
        if (!empty($this->data[$field]) && strlen($this->data[$field]) < $length) {
            $this->errors[$field] = $message ?? "The {$field} must be at least {$length} characters.";
        }
        return $this;
    }

    public function maxLength($field, $length, $message = null) {
        if (!empty($this->data[$field]) && strlen($this->data[$field]) > $length) {
            $this->errors[$field] = $message ?? "The {$field} must not exceed {$length} characters.";
        }
        return $this;
    }

    public function pattern($field, $pattern, $message = null) {
        if (!empty($this->data[$field]) && !preg_match($pattern, $this->data[$field])) {
            $this->errors[$field] = $message ?? "The {$field} format is invalid.";
        }
        return $this;
    }

    public function hasErrors() {
        return !empty($this->errors);
    }

    public function getErrors() {
        return $this->errors;
    }
} 