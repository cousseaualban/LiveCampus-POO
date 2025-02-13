<?php
// require_once __DIR__ . '/../Models/Page.php';
namespace App\Controllers;
use App\Models\Page;

class PageController
{
    private $pageModel; 

    public function __construct()
    {
        $this->pageModel = new Page();
    }

    //Affiche toutes les pages
    public function pagesList()
    {
        return $this->render("pagesList", [
            "pages" => $this->pageModel->getAllPages(),
        ]);
    }

    // Afficher une page 
    public function show()
    {
        if (!isset($_GET['id'])){
            echo "Page introuvable";
            return; 
        }

        return $this->render("show", [
            "page" => $this->pageModel->getPageById($_GET['id']),
        ]);
    }

    // Création d'une page
    public function create()
    {
        $this->render("create", null);

        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $title = filter_input(INPUT_POST, 'title');
            $url = filter_input(INPUT_POST, 'url');
            $content = filter_input(INPUT_POST, 'content');
            $user = filter_input(INPUT_POST, 'user');
            if (!empty($title) && !empty($url) && !empty($content) && !empty($user)) {
                $this->pageModel->createPage($title, $url, $content, $user);
                header("Location: ?do=page");
            } else {
                echo "Remplissez correctement les champs";
            }
        }
    }

    // Modification d'une page
    public function edit()
    {
        if (!isset($_GET['id'])){
            echo "Page introuvable";
            return; 
        }

        
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $id = filter_input(INPUT_POST, 'id');
            $title = filter_input(INPUT_POST, 'title');
            $url = filter_input(INPUT_POST, 'url');
            $content = filter_input(INPUT_POST, 'content');
            $user = filter_input(INPUT_POST, 'user');

            if (!empty($title) && !empty($url) && !empty($content) && !empty($user)) {
                $this->pageModel->updatePage($id, $title, $url, $content, $user);
                header("Location: ?do=page");
            } else {
                echo "Remplissez correctement les champs";
            }
        }

        $this->render("edit", [
            "page" => $this->pageModel->getPageById($_GET['id']),
        ]);
    }

    public function delete()
    {
        if (isset($_GET['id'])){
            $this->pageModel->deletePage($_GET['id']);
            header("Location: ?do=page");
            exit;
        } else {
            echo "Erreur lors de la suppression de la page";
        }
    }

    public function render (string $filename, ?array $arguments)
    {
        if ($arguments !== null){
            extract($arguments);
        }
        require_once __DIR__ . '/../Views/pages/'.$filename.'.php';
    }
}

?>