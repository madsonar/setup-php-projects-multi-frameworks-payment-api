<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    #[Route('/external-payment-authorizer/{transactionUuid}', name: 'external_payment_authorizer')]
    public function authorizeTransaction(string $transactionUuid): JsonResponse
    {
        // Simula uma resposta autorizada ou não autorizada aleatoriamente.
        if (rand(0, 1) === 1) {
            return new JsonResponse(['message' => 'Autorizado'], JsonResponse::HTTP_OK);
        } else {
            return new JsonResponse(['message' => 'Negado'], JsonResponse::HTTP_FORBIDDEN);
        }
    }
}
