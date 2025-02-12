<?php
require_once __DIR__ . '/../Models/Page.php';

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
        $pages = $this->pageModel->getAllPages();
        require_once __DIR__ . '/../Views/Pages/pagesList.php';
    }

    // Afficher une page 
    public function show()
    {
        if (!isset($_GET['id'])){
            echo "Page introuvable";
            return; 
        }

        $page = $this->pageModel->getPageById($_GET['id']);
        require_once __DIR__ . '/../Views/Pages/show.php';
    }

    // Création d'une page
    public function create()
    {
        require_once __DIR__ . '/../Views/pages/create.php';

        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $title = filter_input(INPUT_POST, 'title');
            $url = filter_input(INPUT_POST, 'url');
            $content = filter_input(INPUT_POST, 'content');
            $user = filter_input(INPUT_POST, 'user');

            if (!empty($title) && !empty($url) && !empty($content) && !empty($user)) {
                if ($this->pageModel->createPage($title, $url, $content, $user)) {
                    header("Location: ?do=pages");
                } else {
                    echo "Remplissez correctement les champs";
                }
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

        $page = $this->pageModel->getPageById($_GET['id']);
        require_once __DIR__ . '/../Views/pages/edit.php';

        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $id = filter_input(INPUT_POST, 'id');
            $title = filter_input(INPUT_POST, 'title');
            $url = filter_input(INPUT_POST, 'url');
            $content = filter_input(INPUT_POST, 'content');
            $user = filter_input(INPUT_POST, 'user');

            if (!empty($title) && !empty($url) && !empty($content) && !empty($user)) {
                if ($this->pageModel->updatePage($id, $title, $url, $content, $user)) {
                    header("Location: ?do=pages");
                } else {
                    echo "Remplissez correctement les champs";
                }
            }
        }
    }

    public function delete()
    {
        if (isset($_GET['id'])){
            if ($this->pageModel->deletePage($_GET['id'])){
                header("Location: ?do=pages");
                exit;
            } else {
                echo "Erreur lors de la suppression de la page";
            }
        }
    }
}

?>