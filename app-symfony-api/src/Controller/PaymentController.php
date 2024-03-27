<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    #[Route('/external-payment-authorizer/{transactionUuid}', name: 'external_payment_authorizer')]
    public function authorizeTransaction(string $transactionUuid): JsonResponse
    {
        return $this->randomResponse(['message' => 'Autorizado'], ['message' => 'Negado']);
    }

    #[Route('/external-send-email', name: 'send_email', methods: ['POST'])]
    public function sendEmail(Request $request): JsonResponse
    {
        $payload = json_decode($request->getContent(), true);

        return $this->randomResponse(['send' => true], ['send' => false]);
    }

    #[Route('/external-send-sms', name: 'send_sms', methods: ['POST'])]
    public function sendSms(Request $request): JsonResponse
    {
        $payload = json_decode($request->getContent(), true);

        return $this->randomResponse(['send' => true], ['send' => false]);
    }

    private function randomResponse($successResponse, $failureResponse): JsonResponse
    {
        if (rand(0, 1) === 1) {
            return new JsonResponse($successResponse, JsonResponse::HTTP_OK);
        } else {
            return new JsonResponse($failureResponse, JsonResponse::HTTP_FORBIDDEN);
        }
    }
}
