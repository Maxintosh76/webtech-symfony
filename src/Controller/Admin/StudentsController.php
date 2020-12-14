<?php

namespace App\Controller\Admin;

use App\Entity\Student;
use App\Form\StudentsType;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class StudentsController extends AbstractController
{
	/**
	 * @param StudentRepository $studentRepository
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function index(StudentRepository $studentRepository)
	{
		$students = $studentRepository->findAll();
		
		return $this->render('list.html.twig', ['students'=>$students]);
	}
	
	/**
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
	public function add(Request $request){
		$student = new Student();
		
		$form = $this->createForm(StudentsType::class, $student);
		
		$form = $form->handleRequest($request);
		
		if($form->isSubmitted() && $form->isValid()){
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($student);
			$entityManager->flush();
			
			return $this->redirectToRoute('list.students');
		}
		
		return $this->render('add.html.twig',[
			'form'=>$form->createView()
		]);
	}
	
	/**
	 * @param Student $student
	 */
	public function edit(Student $student, Request $request){
		
		$form = $this->createForm(StudentsType::class, $student);
		
		$form = $form->handleRequest($request);
		
		if($form->isSubmitted() && $form->isValid()){
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->flush();
			
			return $this->redirectToRoute('list.students');
		}
		
		return $this->render('edit.html.twig',[
			'form'=>$form->createView()
		]);
	}
}