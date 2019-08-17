<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
/**
 * @Route("/importer", name="importer_")
 */
class ImporterController extends AbstractController
{
    /**
     * @Route("/brand", name="brand")
     */
    public function brand()
    {
        exit();
        $em = $this->getDoctrine()->getManager();
        $project_dir = $this->getParameter('kernel.project_dir');
        $brands_images = include ($project_dir.'/import_data/brand.php');
    
        $inputFileName = $project_dir.'/import_data/structure.xlsx';
        $reader = new Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($inputFileName);
        $worksheets = $spreadsheet->getAllSheets();
        
        array_shift($worksheets);
        foreach ($worksheets as $index => $worksheet) {
            $brand_name = $worksheet->getTitle();
            $cells = $worksheet->getCellCollection();
            if ($cell = $cells->get('A2')) {
                $brand_slug = $cell->getValue();
            }else{
                echo 'Нет ячейки A2'.$brand_name;
                exit();
            }
            
            
            if (strstr($brand_slug,'Ремонт кофемашин')) {
                if ($cell = $cells->get('A3')) {
                    $brand_slug = $cell->getValue();
                }else{
                    echo 'Нет ячейки A3'.$brand_name;
                    exit();
                }
                
            }
            $brand_slug = str_replace('remont-kofemashin-','',$brand_slug);
            $brand_slug = trim($brand_slug,' /');
            $models = [];
            $row = 2;
            while ($cell = $cells->get('D'.$row)){
                $model =  new \stdClass();
                $model->name = $cell->getValue();
                $model->name = str_replace('Ремонт кофемашин '.$brand_name,'',$model->name);
                $model->name = trim($model->name);
                $models[$row] = $model;
                $row++;
            }
            $row = 2;
            while ($cell = $cells->get('E'.$row)){
                $slug = $cell->getValue();
                $slug = str_replace($brand_slug.'-','',$slug);
                $slug = trim($slug,' /-');
                if ( ! isset($models[$row])) {
                    echo 'Нет названия '.$brand_name.' '.'D'.$row;
                    exit();
                }
                $models[$row]->slug = $slug;
                $row++;
            }
            if (in_array($brand_slug,$brands_images)) {
                $brand_logo = $brand_slug.'.png';
            }
            else{
                $underscored = str_replace('-','_',$brand_slug);
                if (in_array($underscored, $brands_images)) {
                    $brand_logo = $underscored.'.png';
                }
                else{
                    $brand_logo = $brand_slug.'.png';
                }
            }
            $brand_entity = new Brand();
            $brand_entity->setName($brand_name);
            $brand_entity->setAlias($brand_slug);
            $brand_entity->setImage('bosch.png');
            $brand_entity->setLogo($brand_logo);
            $em->persist($brand_entity);
            foreach ($models as $model) {
                $model_entity = new Model();
                $model_entity->setBrand($brand_entity);
                $model_entity->setName($model->name);
                $model_entity->setAlias($model->slug);
                $em->persist($model_entity);
            }
            
        }
        $em->flush();
        echo 'ok';
        exit();
    }
}
