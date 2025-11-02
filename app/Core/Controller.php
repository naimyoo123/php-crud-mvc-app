<?php

namespace App\Core;

class Controller
{
    protected function view($view, $data = [])
    {
        extract($data);
        $viewPath = __DIR__ . '/../../views/' . str_replace('.', '/', $view) . '.php';
        
        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            throw new \Exception("View {$view} not found");
        }
    }

    protected function redirect($url, $statusCode = 302)
    {
        header("Location: $url", true, $statusCode);
        exit();
    }

    protected function json($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }

    protected function validate($data, $rules)
    {
        $errors = [];

        foreach ($rules as $field => $rule) {
            $rulesArray = explode('|', $rule);
            $value = $data[$field] ?? null;

            foreach ($rulesArray as $singleRule) {
                if ($singleRule === 'required' && empty($value)) {
                    $errors[$field][] = "The {$field} field is required.";
                }

                if ($singleRule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errors[$field][] = "The {$field} must be a valid email address.";
                }

                if (strpos($singleRule, 'min:') === 0) {
                    $min = (int) str_replace('min:', '', $singleRule);
                    if (strlen($value) < $min) {
                        $errors[$field][] = "The {$field} must be at least {$min} characters.";
                    }
                }

                if (strpos($singleRule, 'max:') === 0) {
                    $max = (int) str_replace('max:', '', $singleRule);
                    if (strlen($value) > $max) {
                        $errors[$field][] = "The {$field} may not be greater than {$max} characters.";
                    }
                }

                if ($singleRule === 'numeric' && !is_numeric($value)) {
                    $errors[$field][] = "The {$field} must be a number.";
                }
            }
        }

        return $errors;
    }
}