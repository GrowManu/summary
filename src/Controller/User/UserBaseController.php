<?php


namespace App\Controller\User;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserBaseController extends AbstractController{
    public function renderDefault(){
        return [
            'title' => 'Default for User',
        ];
    }
}