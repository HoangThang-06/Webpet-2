<?php
require_once __DIR__."/../model/DTO/Article.php";
require_once __DIR__."/../model/DAO/ArticleDAO.php";
require_once __DIR__."/DBConnection.php";
class ArticleController{

    public function addArticle(){

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            return "Invalid request!";
        }

        // Lấy dữ liệu form
        $title = $_POST["title"];
        $click = 0;

        //Xu ly file txt
        if(!isset($_FILES["conten"])||$_FILES["conten"]["error"]!==0){
            return"Loi upload file";
        }
        $txtExt=strtolower(pathinfo($_FILES["conten"]["name"],PATHINFO_EXTENSION));
        if($txtExt!="txt"){
            return"Chi nhan file txt";
        }

        $contenFoler =__DIR__. "/../../public/article/";
        if(!is_dir($contenFoler)){
            mkdir($contenFoler,0777,true);
        }

        $contenFileName=time()."_".$_FILES["conten"]["name"];
        $contenPath=$contenFoler.$contenFileName;

        if(!move_uploaded_file($_FILES["conten"]["tmp_name"],$contenPath)){
            return "Khong the luu file txt";
        }

        //Xu ly anh
        $imagePath="";
        if(isset($_FILES["image"])&&$_FILES["image"]["error"]===0){
            $imgExt=strtolower(pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION));
            $allowedImg=["jpg","jpeg","png","webp"];

            if(!in_array($imgExt,$allowedImg)){
                return "Chi cho phep anh JPG, PNG, JPEG, WEBP";
            }

            $imageFolder = __DIR__."/../../public/img/article/";
            if(!is_dir($imageFolder)){
                mkdir($imageFolder,0777, true);
            }

            $imageFileName=time()."_".$_FILES["image"]["name"];
            $imagePath=$imageFolder.$imageFileName;

            if(!move_uploaded_file($_FILES["image"]["tmp_name"],$imagePath)){
                return"Khong the luu anh";
            }
        }

        //Tao truy xuat
        $article=new ArticleDTO();
        $article->setTitle($title);
        $article->setContent($contenPath);
        $article->setImage($imagePath);
        $article->setClick($click);

        $conn=(new DBConnection())->getConnection();
        $dao=new ArticleDAO($conn);
        if($dao->addArticle($article)){
            return"Them bai bao thanh cong";
        }else{
            return "Loi them bai bao vao database";
        }
    }
}
?>