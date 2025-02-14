<?php
namespace App\Controllers;

use App\Models\Page;
use App\Models\Structure;
use App\Models\User;

class UserController
{
    private $userModel; 
    private $structureModel;
    private $pageModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->structureModel = new Structure();
        $this->pageModel = new Page();
        
    }
    public function userList()
    {
        $structure = $this->structureModel->getStructure();
        return $this->render("userList", [
            "users" => $this->userModel->getAllUsers(),
            "headerContent" => $structure['header'], 
            "footerContent" => $structure['footer'],
        ]);
    }

    public function delete()
    {
        if (isset($_GET['id'])){
            $this->userModel->deleteUser($_GET['id']);
            $pages = $this->pageModel->getPageByUserId($_GET['id']);
            foreach($pages as $page){
                $this->pageModel->updatePage($page['id'], $page['title'], $page['url'], $page['content'], $_SESSION['user']['id']);
            }
            header("Location: ?do=user");
            exit;
        } else {
            echo "Erreur lors de la suppression de l'utilisateur";
        }
    }

    public function render (string $filename, ?array $arguments)
    {
        if ($arguments !== null){
            extract($arguments);
        }
        require_once __DIR__ . '/../Views/'.$filename.'.php';
    }
}
