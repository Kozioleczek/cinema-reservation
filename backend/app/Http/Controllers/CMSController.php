<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeAssignRestaurantRequest;
use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Interfaces\EmployeeInterface;
use App\Models\Employee;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class CMSController extends ApiController
{
    /**
     * @OA\Get(
     *      path="/api/employees/index",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function index(): AnonymousResourceCollection
    {
        return $this->employeeService->getEmployees();
    }

    /**
     * @OA\Post(
     *      path="/api/employees/store",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function store(EmployeeRequest $request): EmployeeResource
    {
        return $this->employeeService->storeEmployee($request);
    }

    /**
     * @OA\Get(
     *      path="/api/employees/show/{id}",
     *      @OA\Parameter(
     *          name="id",
     *          description="Employee id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function show(Employee $employee): EmployeeResource
    {
        return $this->employeeService->showEmployee($employee);
    }

    /**
     * @OA\Post(
     *      path="/api/employees/update",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function update(EmployeeRequest $request, Employee $employee): EmployeeResource
    {
        return $this->employeeService->updateEmployee($request, $employee);
    }

    /**
     * @OA\Delete(
     *      path="/api/employees/destroy",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function destroy(Employee $employee): Response
    {
        return $this->employeeService->destroyEmployee($employee);
    }

    /**
     * @OA\Post(
     *      path="/api/employees/assign/{id}/restaurant",
     *      @OA\Parameter(
     *          name="id",
     *          description="Employee id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function assignRestaurant(EmployeeAssignRestaurantRequest $request, Employee $employee): EmployeeResource
    {
        return $this->employeeService->assignRestaurant($request, $employee);
    }
}
