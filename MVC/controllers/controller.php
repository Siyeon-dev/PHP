<?php
include './models/model.php';
include './board/conf.php';
session_start();

class Controller extends Board_conf {
  protected $model  = null; // model 객체를 저장할 변수
  protected $view   = null;  // view 객체를 저장할 변수

  public function __construct() {
    // 1. Model 연결
    $this->model = new model();
  }
  // Controller 실행 
  public function runController() {
    $resultRoute = $this->route();
  }

  // router
  private function route() {
    $pathInfo = explode('/', $_SERVER['REQUEST_URI']);

    if ($pathInfo[3] == 'board') {
      // 게시판 타입
      switch ($pathInfo[4]) {
        case 'write':
          $resultUrl = './views/write.php';
          include($resultUrl);
          break;
        case 'list':
          $resultUrl = './views/list.php';
          $this->list($resultUrl);
          break;
        case 'view':
          $resultUrl = './views/view.php';
          $this->viewArticle($resultUrl);
          break;
        case 'modify':
          $resultUrl = './views/modify.php';
          $this->modify($resultUrl);
          break;
      }
    }
  }

  // <<-- 게시글 수정 모듈
  public function modify($argResultUrl) {
    // 현 게시글에 대한 정보를 가지고 있는 객체
    $articleInfo = $this->model->getArticle('board_id', $_SESSION['board_id']);

    // View 출력
    $this->view = new View($argResultUrl);
    $this->view->set('article', $articleInfo);
    $this->view->output();
  }

  // <<-- 글보기 모듈
  public function viewArticle($argResultUrl) {
    // 글보기의 내부 기능 (수정, 삭제, 덧글 등록) 수행문
    if (isset($_POST['view_options'])) {
      switch ($_POST['view_options']) {
        case 'delete':
          // 해당 글 혹은 덧글 삭제
          $this->model->deletePost($_POST);
          // 게시글이 삭제된 경우 리스트로 이동
          if (!isset($_POST['board_pid']))
            header("Location: ./list");
          break;

        case 'modify':
          // 게시글 수정
          $this->model->updatePostDB($_POST);
          header("Location: ./view");
          break;

        case 'comment':
          // 덧글 생성
          $this->write();
          // F5 를 통한 덧글 무한 생성 방지
          unset($_POST);
          header("Location: ./view");
          break;
      }
    }

    // 글보기에 들어온 경우, 해당 글의 조회수를 1, 증가시킨다.
    if (!isset($_SESSION['board_id'])) {
      $_SESSION['board_id'] = $_POST['board_id'];
      $this->model->increaseHits($_SESSION);
    }
    // 페이지네이션 유지를 위해서 관련 데이터 SESSION 정보에 저장
    if (!isset($_SESSION['current_page'])) {
      $_SESSION['current_page'] = $_POST['current_page'];
      $_SESSION['current_block'] = $_POST['current_block'];
      $_SESSION['search_type'] = $_POST['search_type'];
      $_SESSION['search_text'] = $_POST['search_text'];
    }

    // Model에서 데이터 가져오기
    $articleInfo = $this->model->getArticle('board_id', $_SESSION['board_id']);  // 게시글 정보
    $commentInfo = $this->model->getArticle('board_pid', $_SESSION['board_id']); // 덧글 정보
    $resultUserValid = $this->model->checkUserValid($_SESSION['board_id']);      // 사용자 확인 정보


    // View 출력
    $this->view = new View($argResultUrl);
    $this->view->set('article', $articleInfo);             // 게시글 정보
    $this->view->set('comment', $commentInfo);             // 덧글 정보
    $this->view->set('resultUserValid', $resultUserValid); // 사용자 확인 정보
    $this->view->output();
  }

  // <<-- 리스트 모듈
  public function list($argResultUrl) {
    // '글보기' 에서 '리스트' 돌아왔을 경우, 기존의 글정보를 unset
    if (isset($_SESSION['board_id'])) {
      unset($_SESSION['board_id']);
    }


    // <<-- 로그인 관련 기능
    // 로그아웃 버튼 눌렀을 경우, 로그인 관련 세션 데이터 해제
    if (isset($_POST['logout'])) {
      unset($_SESSION['name']);
      unset($_SESSION['password']);
    }
    // 로그인 버튼 눌렀을 경우, 유저 확인
    if (isset($_POST['userId']))
      $resultUserExist = $this->model->checkUserLogin($_POST['userId'], $_POST['userPw']);
    else {
      // undefined variable 방지..
      if (!array_key_exists('name', $_SESSION)) {
        $_SESSION['name']     = false;
        $_SESSION['password'] = false;
      }
      $resultUserExist = 0;
    }
    // -->> 로그인 관련 기능


    // write 에서 글쓰기 버튼이 눌러진 경우
    if (isset($_POST['write'])) {
      $resultWrite = $this->write();
      // write POST 데이터 제거 (F5를 통해 게시글 무한 생성 방지)
      unset($_POST);
      header("Location: ./list");
    }



    // 검색 기능 (검색 버튼 선택 or Default 리스트)
    if (!array_key_exists('search_type', $_POST)) {
      $_POST['search_type'] = "";
      $_POST['search_text'] = "";

      $search[] = "";
      $search[] = "";
    } else {
      if ($_POST['search_type'] != "") {
        $search[] = $_POST['search_type'] . " LIKE ";
        $search[] = "'%" . $_POST['search_text'] . "%'";
      } else {
        $search[] = "";
        $search[] = "";
      }
    }


    // Model에서 데이터 가져오기
    $paginationObj = $this->model->getPaginationData($search);        // 페이지네이션 관련 데이터
    $listObj       = $this->model->getList($search, $paginationObj);  // 게시글 리스트 데이터


    // View 출력
    $this->view = new View($argResultUrl);
    $this->view->set('list', $listObj);               // 게시글 리스트 데이터
    $this->view->set('pagination', $paginationObj);   // 페이지네이션 관련 데이터
    $this->view->set('search', [$_POST['search_type'], $_POST['search_text']]); // 검색 기능 관련 데이터
    $this->view->output();
  }

  // <<-- 글쓰기 모듈
  public function write() {
    // 1. 데이터 유효성 검사 (별도의 함수 작성)
    $resultVaild = parent::checkInputValue($_POST);
    // 2. 모델에서 insert 작업 실행
    if ($resultVaild) {
      // 2-1. 패스워드 암호화
      // ** 애초에 암호화 된 패스워드 변수를 하나 가지고 있으면 어때? **
      //    => 필요성에 대해서 생각해 볼 것.
      $PASSWORD = password_hash($_SESSION['password'], PASSWORD_DEFAULT);

      // 2-2. 덧글인지 게시글인지 판단
      isset($_POST['board_pid']) ?
        $IS_COMMENT = $_POST['board_id'] :
        $IS_COMMENT = false;

      // 2-3. INSERT into DB
      $this->model->insertIntoDB($_POST, $IS_COMMENT, $PASSWORD);
    }

    return $resultVaild;
  }
}


class View {
  protected $_file;
  protected $_data = array();

  public function __construct($file) {
    $this->_file = $file;
  }

  public function set($key, $value) {
    $this->_data[$key] = $value;
  }

  public function get($key) {
    return $this->_data[$key];
  }

  public function output() {
    if (!file_exists($this->_file)) {
      throw new Exception("Template " . $this->_file . " doesn't exist.");
    }

    extract($this->_data);
    ob_start();
    include($this->_file);
    $output = ob_get_contents();
    ob_end_clean();
    echo $output;
  }
}
