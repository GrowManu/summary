<?php


namespace App\Controller\User;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepositoryInterface;
use App\Service\User\UserService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserController extends UserBaseController
{
    /**
     * @Route("/user/summaries", name="user_summaries")
     * @return Response
     */

    public function index(){
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        $forRender = parent::renderDefault();
        $forRender['title'] = 'Summaries';
        $forRender['users'] = $users;
        return $this->render('user/summaries/index.html.twig', $forRender);
    }


    /**
     * @Route("/user/summaries/create", name="user_summaries_create")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return RedirectResponse|Response
     */
    public function create(Request $request, UserPasswordEncoderInterface $passwordEncoder){
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);

        if (($form->isSubmitted()) && ($form->isValid())){
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setRoles(['ROLE_USER']);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_summaries');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Form create User';
        $forRender['form'] = $form->createView();
        return $this->render('user/summaries/form.html.twig', $forRender);
    }
}