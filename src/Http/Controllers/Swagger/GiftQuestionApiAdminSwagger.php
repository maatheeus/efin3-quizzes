<?php

namespace EscolaLms\TopicTypeGift\Http\Controllers\Swagger;

use EscolaLms\TopicTypeGift\Http\Requests\Admin\AdminCreateGiftQuestionRequest;
use EscolaLms\TopicTypeGift\Http\Requests\Admin\AdminDeleteGiftQuestionRequest;
use EscolaLms\TopicTypeGift\Http\Requests\Admin\AdminSortGiftQuestionRequest;
use EscolaLms\TopicTypeGift\Http\Requests\Admin\AdminUpdateGiftQuestionRequest;
use Illuminate\Http\JsonResponse;

interface GiftQuestionApiAdminSwagger
{
    /**
     * @OA\Post(
     *      path="/api/admin/gift-questions",
     *      summary="Store a newly Gift Question",
     *      tags={"Admin Gift Question"},
     *      description="Store Gift Question",
     *      security={
     *          {"passport": {}},
     *      },
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/AdminGiftQuestionRequest")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=201,
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
     *                      ref="#/components/schemas/AdminGiftQuestionResource"
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
    public function create(AdminCreateGiftQuestionRequest $request): JsonResponse;

    /**
     * @OA\Put(
     *      path="/api/admin/gift-questions/{id}",
     *      summary="Update Gift Question",
     *      tags={"Admin Gift Question"},
     *      description="Update Gift Question",
     *      security={
     *          {"passport": {}},
     *      },
     *       @OA\Parameter(
     *          name="id",
     *          description="ID",
     *          @OA\Schema(
     *             type="integer",
     *         ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/AdminGiftQuestionRequest")
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
     *                      ref="#/components/schemas/AdminGiftQuestionResource"
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
    public function update(AdminUpdateGiftQuestionRequest $request): JsonResponse;

    /**
     * @OA\Delete(
     *      path="/api/admin/gift-questions/{id}",
     *      summary="Remove the specified Gift Question",
     *      tags={"Admin Gift Question"},
     *      description="Delete Gift Question",
     *      security={
     *          {"passport": {}},
     *      },
     *      @OA\Parameter(
     *          name="id",
     *          description="ID",
     *          @OA\Schema(
     *             type="integer",
     *         ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\MediaType(
     *              mediaType="application/json"
     *          ),
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function delete(AdminDeleteGiftQuestionRequest $request): JsonResponse;

    /**
     * @OA\Post(
     *      path="/api/admin/gift-questions/sort",
     *      summary="Sort Gift Questions",
     *      tags={"Admin Gift Question"},
     *      description="Sort Gift Questions",
     *      security={
     *          {"passport": {}},
     *      },
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/AdminSortGiftQuestionRequest")
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
     *                      property="message",
     *                      type="string"
     *                  )
     *              )
     *          )
     *      )
     * )
     */
    public function sort(AdminSortGiftQuestionRequest $request): JsonResponse;
}
