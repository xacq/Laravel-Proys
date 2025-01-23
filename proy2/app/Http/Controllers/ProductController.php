<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{    // OBTENER LISTA DE PRODUCTOS
    /**
     * @OA\Get(
     *     path="/api/products",
     *     tags={"Products"},
     *     summary="Get all products",
     *     @OA\Response(response=200, description="List of products")
     * )
     */
    public function index()
    {    // RETORNA TODOS LOS PRODUCTOS CON ESTADO 200
        return response()->json(Product::all(), 200);
    }
    // CREACION DE UN PRODUCTO EN EL API
    /**
     * @OA\Post(
     *     path="/api/products",
     *     tags={"Products"},
     *     summary="Create a new product",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "price", "stock"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string", nullable=true),
     *             @OA\Property(property="price", type="number", format="float"),
     *             @OA\Property(property="stock", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Product created",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(response=400, description="Invalid input")
     * )
     */
    public function store(Request $request)
    {    //VALIDA LOS DATOS INGRESADOS SEGUN EL MODELO ESTABLECIDO
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0.01',
            'stock' => 'required|integer|min:0',
        ]);
        //CREA UN NUEVO PRODUCTO TOMANDO EN CUENTA LA VALIDACION ESTABLECIDA
        $product = Product::create($validatedData);
        //RETORNA UN JASON CON EL PRODUCTO CREADO
        return response()->json($product, 201);
    }
    // INTRUCCIONES PARA CONSEGUIR UN PRODUCTO ESPCEIFICO A TRAVES DEL ID DEL PRODUCTO USANDO DEL API
    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     tags={"Products"},
     *     summary="Get product by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product found",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(response=404, description="Product not found")
     * )
     */
    public function show($id)
    {    //BUSCA UN PRODUCTO SEUN EL ID PARAMETRIZADO EN LA FUNCION
        $product = Product::find($id);
        //CONDICIONA SU EXISTENCIA
        if (!$product) {
            //RETORNA UN MENSAJE DE NO EXISTIR
            return response()->json(['error' => 'Product not found'], 404);
        }
        //RETORNA EL REGISTRO PRODUCTO ENCONTRADO    
        return response()->json($product, 200);
    }

    /**
     * @OA\Schema(
     *     schema="Product",
     *     type="object",
     *     @OA\Property(property="id", type="integer"),
     *     @OA\Property(property="name", type="string"),
     *     @OA\Property(property="description", type="string"),
     *     @OA\Property(property="price", type="number", format="float"),
     *     @OA\Property(property="stock", type="integer")
     * )
     */
}
