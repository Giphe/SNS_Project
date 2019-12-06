<?php

namespace MyApp\Controller;

class Calendar extends \MyApp\Controller {
  public $prev;
  public $next;
  public $yearMonth;
  protected $_thisMonth;

  public function run(){
      if(!$this->isLoggedIn()){
          header('Location: '. SITE_URL);
          exit;
      }
      if($_SERVER['REQUEST_METHOD']==='POST'){
          $this->postProcess();
      }
  }

  protected function postProcess(){
      try{
          $this->_validate();
      }catch(\MyApp\Exception\EmptyPost $e){
          $this->setErrors('login',$e->getMessage());
      }

      $this->setValues('email', $_POST['email']);

      if($this->hasError()){
          return;
      }else{
          try{
              $userModel = new \MyApp\Model\User();
              $user = $userModel->login([
                  'email' => $_POST['email'],
                  'password' => $_POST['password']
              ]);
          }catch(\MyApp\Exception\UnmatchEmailOrPassword $e){
              $this->setErrors('login', $e->getMessage());
              return;

          }
          //login処理
          session_regenerate_id(true);
          $_SESSION['me']  =$user;

          //redirect to home
          header('Location:' . SITE_URL );
          exit;
      }


  }
  private function _validate(){
      if(!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']){
          echo "Invalid Token!";
          exit;
      }
      if(!isset($_POST['email']) || !isset($_POST['password'])){
          echo "Invalid Form!";
          exit;
      }

      if($_POST['email'] === '' || $_POST['password'] === ''){
          throw new \MyApp\Exception\EmptyPost();
      }
  }


  public function __construct(){
    try{
      if(!isset($_GET['t']) || !preg_match('/\A\d{4}-\d{2}\z/',$_GET['t'])){
          throw new \Exception();
    }
    $this->_thisMonth = new \DateTime($_GET['t']);
    }catch(\Exception $e){
      $this->_thisMonth = new \DateTime('first day of this month');

    }

    $this->prev = $this->_createPrevLink();
    $this->next = $this->_createNextLink();
    $this->yearMonth = $this->_thisMonth ->format('F Y');
  }

//   public function run(){
//       if(!$this->isLoggedIn()){
//           //login
//           header('Location: '. SITE_URL . '/login.php');
//           exit;
//       }

  protected function _createPrevLink(){
    $dt = clone $this->_thisMonth;
    return $dt->modify('+1 month')->format('Y-m');

  }
  protected function _createNextLink(){
    $dt = clone $this->_thisMonth;
    return $dt->modify('-1 month')->format('Y-m');

  }

  public function show(){
    $tail = $this->_getTail();
    $body = $this->_getBody();
    $head = $this->_getHead();
    $html = '<tr>'. $tail . $body. $head. '</tr>';
    echo $html;
  }

  protected function _getTail(){
    $tail = '';
    $lastDayOfPrevMonth = new \DateTime('last day of'. $this->yearMonth. '-1 month');
    while($lastDayOfPrevMonth->format('w')<6){
      $tail = sprintf('<td class= "gray">%d</td>',
      $lastDayOfPrevMonth->format('d')) . $tail;
      $lastDayOfPrevMonth->sub(new \DateInterval('P1D'));

    }
    return $tail;
  }
  protected function _getBody(){
    $body = '';
    $period = new \DatePeriod(
      new \DateTime('first day of'. $this->yearMonth),
      new \DateInterval('P1D'),
      new \DateTime('first day of ' .$this->yearMonth. '+1 month')
    );

    $today = new \DateTime('today');

    foreach($period as $day){
      if($day->format('w') === '0'){ $body .= '</tr><tr>';}
      $todayClass = ($day->format('Y-m-d') === $today->format('Y-m-d')) ? 'today' : '';
      $body .= sprintf('<td class= "youbi_%d %s"><a href="">%d</a></td>', $day->format('w'),
      $todayClass, $day->format('d'));

    }
    return $body;
  }
  protected function _getHead(){
    $head = '';
    $firstDayOfNextMonth = new \DateTime('first day of ' .$this->yearMonth. '+1 month');
    while($firstDayOfNextMonth -> format('w') > 0){
      $head .=sprintf('<td class= "gray"><a href="">%d</a></td>',$firstDayOfNextMonth->format('d'));
      $firstDayOfNextMonth->add(new \DateInterval('P1D'));
    }
    return $head;

  }
}

