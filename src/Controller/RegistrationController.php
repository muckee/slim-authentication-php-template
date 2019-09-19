<?php namespace App\Controller;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

class RegistrationController
{
  protected $pdo;
  protected $renderer;

  public function __construct($pdo, $renderer)
  {
    $this->pdo = $pdo;
    $this->renderer = $renderer;
  }

  public function view(Request $request, Response $response, array $args)
  {
    if(isset($_SESSION['loggedin'])) {
      if($_SESSION['loggedin']) {
        $errMessage = ['error' => 'You are already logged in!'];
        $response = $response->getBody()
                             ->write(json_encode($errMessage))
                             ->withHeader('Location', '/dashboard');
        return $response;
      }
    }
    $args['pageTitle'] = "register";
    return $this->renderer->render($response, 'register.phtml', $args);
  }

  public function register(Request $request, Response $response, array $args)
  {
    $form = $request->getParsedBody();
//      $args['error'] = $form['email'];
//      return $this->renderer->render($response, 'register.phtml', $args);

    $errMessage = $this->validateRegistrationForm($form);
    if($errMessage != "") {
      $args['error'] = $errMessage;
      return $this->renderer->render($response, 'register.phtml', $args);
    }
    $errMessage = $this->checkDuplicateUser($form['uname'], $form['email']);
    if($errMessage != "") {
      $args['error'] = $errMessage;
      return $this->renderer->render($response, 'register.phtml', $args);
    }
    $errMessage = $this->registerNewUser($form);
    if($errMessage != "") {
      $args['error'] = $errMessage;
      return $this->renderer->render($response, 'register.phtml', $args);
    }
    return $this->renderer->render($response, 'register-success.phtml', []);
  }

  protected function validateRegistrationForm($form)
  {
    if(isset(
      $form['uname'],
      $form['fname'],
      $form['lname'],
      $form['email'],
      $form['pass'],
      $form['pass-repeat']
    )) {

      if(strlen(trim($form['uname'])) < 5 ) {
        return "Please provide a username with at least 5 characters.";
      }
      if(strlen(trim($form['fname'])) < 1 ) {
        return "Please provide your first name.";
      }
      if(strlen(trim($form['lname'])) < 1 ) {
        return "Please provide your last name.";
      }
      if(!filter_var(trim($form['email']), FILTER_VALIDATE_EMAIL) ) {
        return "Please provide a valid e-mail address.";
      }
      if(!$this->validatePassword($form['pass']) ) {
        return "Please provide a password.";
      }
      if(strlen(trim($form['pass-repeat'])) != strlen(trim($form['pass'])) ) {
        return "Please repeat your password.";
      }
      // If all fields are valid:
      return "";
    }
    // If `isset()` returns false:
    return "Please ensure all form fields are complete.";
  }

  protected function validatePassword($password)
  {
    // Validate password strength
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);
    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
      return false;
    }
    return true;
  }

  protected function checkDuplicateUser($username, $email)
  {
    try {
      $sql = "SELECT username FROM oauth_users WHERE username=:username";
      $stmt = $this->pdo->prepare($sql);
      $params = array(
        'username' => $username
      );
      $stmt->execute($params);
      if($res = $stmt->fetch()) {
        return "This username has already been taken.";
      }
    } catch (PDOException $e) {
      return $e->getMessage();
    }
    try {
      $sql = "SELECT email FROM oauth_users WHERE email=:email";
      $stmt = $this->pdo->prepare($sql);
      $params = array(
        'email' => $email
      );
      $stmt->execute($params);
      if($res = $stmt->fetch()) {
        return "This email is already in use.";
      }
    } catch (PDOException $e) {
      return "There was an error processing your request.";
    }
    return "";
  }

  protected function registerNewUser($form)
  {
    try {
      $sql = "INSERT INTO oauth_users (username, password, first_name, last_name, email, email_verified, scope) VALUES (:uname, :password, :fname, :lname, :email, NULL, 'basic')";
      $stmt= $this->pdo->prepare($sql);
      $params = array(
        'uname' => trim($form['uname']),
        'password' => password_hash($form['pass'], PASSWORD_DEFAULT),
        'fname' => trim($form['fname']),
        'lname' => trim($form['lname']),
        'email' => trim($form['email'])
      );
      $stmt->execute($params);
    } catch (PDOException $e) {
      return $e->getMessage();
    }
    return "";
  }
}
