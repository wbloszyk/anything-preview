<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderRecord;
use App\Form\OrderRecordType;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/order')]
class OrderController extends AbstractController
{
    #[Route('/', name: 'app_order_index', methods: ['GET'])]
    public function index(OrderRepository $orderRepository): Response
    {
        return $this->render('order/index.html.twig', [
            'orders' => $orderRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_order_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($order);
            $entityManager->flush();

            return $this->redirectToRoute('app_order_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('order/new.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_order_show', methods: ['GET'])]
    public function show(Order $order): Response
    {
        return $this->render('order/show.html.twig', [
            'order' => $order,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_order_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Order $order, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_order_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('order/edit.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/record/new', name: 'app_order_record_new', methods: ['GET', 'POST'])]
    public function newRecord(Request $request, Order $order, EntityManagerInterface $entityManager): Response
    {
        $orderRecord = new OrderRecord();
        $orderRecord->setAddedTo($order);

        $form = $this->createForm(OrderRecordType::class, $orderRecord);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($orderRecord);
            $entityManager->flush();

            return $this->redirectToRoute('app_order_record_new', ['id' => $order->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('order/record/new.html.twig', [
            'order' => $order,
            'order_record' => $orderRecord,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/record/{recordId}/edit', name: 'app_order_record_edit', methods: ['GET', 'POST'])]
    public function editRecord(Request $request, Order $order, OrderRecord $orderRecord, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OrderRecordType::class, $orderRecord);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_order_show', ['id' => $order->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('order/record/edit.html.twig', [
            'order_record' => $orderRecord,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/record/{recordId}/delete', name: 'app_order_record_delete', methods: ['POST'])]
    public function deleteRecord(Request $request, Order $order, OrderRecord $orderRecord, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$orderRecord->getId(), $request->request->get('_token'))) {
            $entityManager->remove($orderRecord);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_order_show', ['id' => $order->getId()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_order_delete', methods: ['POST'])]
    public function delete(Request $request, Order $order, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $entityManager->remove($order);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_order_index', [], Response::HTTP_SEE_OTHER);
    }
}
