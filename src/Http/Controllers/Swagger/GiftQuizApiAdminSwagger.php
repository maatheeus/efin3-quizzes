<?php

namespace EscolaLms\TopicTypeGift\Http\Controllers\Swagger;

use EscolaLms\TopicTypeGift\Http\Requests\Admin\AdminReadGiftQuizRequest;
use Illuminate\Http\JsonResponse;

interface GiftQuizApiAdminSwagger
{
    /**
     * @OA\Get(
     *     path="/api/gift-quizes/{id}",
     *     summary="Get gift quiz by id",
     *      tags={"Gift Quiz"},
     *     security={
     *          {"passport": {}},
     *      },
     *     @OA\Parameter(
     *          name="id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successfull operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                      property="success",
     *                      type="boolean"
     *                  ),
     *                  @OA\Property(
     *                      property="data",
     *                      ref="#/components/schemas/AdminGiftQuizResource"
     *                  ),
     *                  @OA\Property(
     *                      property="message",
     *                      type="string"
     *                  )
     *              )
     *          )
     *      )
     * )
     */
    public function read(AdminReadGiftQuizRequest $request): JsonResponse;

}
