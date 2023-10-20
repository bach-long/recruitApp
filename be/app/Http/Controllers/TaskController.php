<?php

namespace App\Http\Controllers;

use App\Repositories\Task\TaskRepositoryInterface;
use Exception;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    //
    protected $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function index()
    {
        try {
            $data = $this->taskRepository->paginateTasks();
            if ($data) {
                return response()->json(
                    [
                        'data' => $data,
                        'message' => 'get all tasks',
                        'success' => 1,
                    ], 200
                );
            } else {
                throw new Exception('tasks not found');
            }

        } catch (Exception $err) {
            return response()->json([
                'success' => 0,
                'message' => $err->getMessage(),
            ]);
        }
    }

    public function info(Request $request)
    {
        try {
            $data = $this->taskRepository->getDetail($request);
            if ($data) {
                return response()->json(
                    [
                        'data' => $data,
                        'message' => 'get info of task',
                        'success' => 1,
                    ], 200
                );
            } else {
                throw new Exception('task not found');
            }
        } catch (Exception $err) {
            return response()->json([
                'success' => 0,
                'message' => $err->getMessage(),
            ]);
        }
    }

    public function search(Request $request)
    {
        try {
            $data = $this->taskRepository->search($request);
            if ($data) {
                return response()->json(
                    [
                        'data' => $data,
                        'message' => 'searched results',
                        'success' => 1,
                    ], 200
                );
            } else {
                throw new Exception('no tasks for requiment');
            }
        } catch (Exception $err) {
            return response()->json(
                [
                    'message' => $err->getMessage(),
                    'success' => 0,
                ]
            );
        }
    }

    public function create(Request $request)
    {
        try {
            $data = $this->taskRepository->createTask($request);
            if ($data) {
                return response()->json(
                    [
                        'data' => $data,
                        'message' => 'new task created',
                        'success' => 1,
                    ], 200
                );
            } else {
                throw new Exception('failed to create new task');
            }
        } catch (Exception $err) {
            return response()->json(
                [
                    'message' => $err->getMessage(),
                    'success' => 0,
                ]
            );
        }
    }

    public function update(Request $request)
    {
        try {
            $data = $this->taskRepository->editTask($request);
            if ($data) {
                return response()->json(
                    [
                        'data' => $data,
                        'message' => 'task updated',
                        'success' => 1,
                    ], 200
                );
            } else {
                throw new Exception('task not found / can not be updated');
            }
        } catch (Exception $err) {
            return response()->json(
                [
                    'message' => $err->getMessage(),
                    'success' => 0,
                ]
            );
        }
    }

    public function recommend(Request $request)
    {
        try {
            $data = $this->taskRepository->recommendedTasks($request);
            if ($data) {
                return response()->json(
                    [
                        'data' => $data,
                        'message' => 'get recommendation',
                        'success' => 1,
                    ], 200
                );
            } else {
                throw new Exception('not found any recommend tasks');
            }
        } catch (Exception $err) {
            return response()->json(
                [
                    'message' => $err->getMessage(),
                    'success' => 0,
                ]
            );
        }
    }

    public function delete(Request $request)
    {
        try {
            $data = $this->taskRepository->delete($request->id);
            if ($data) {
                return response()->json(
                    [
                        'data' => $data,
                        'message' => 'new task created',
                        'success' => 1,
                    ], 200
                );
            } else {
                throw new Exception('failed to create new task');
            }
        } catch (Exception $err) {
            return response()->json(
                [
                    'message' => $err->getMessage(),
                    'success' => 0,
                ]
            );
        }
    }

    public function appliers(Request $request)
    {
        try {
            $data = $this->taskRepository->getApplier($request);
            if ($data) {
                return response()->json(
                    [
                        'data' => $data,
                        'message' => 'get appliers of task',
                        'success' => 1,
                    ], 200
                );
            } else {
                throw new Exception('failed to get appliers');
            }
        } catch (Exception $err) {
            return response()->json(
                [
                    'message' => $err->getMessage(),
                    'success' => 0,
                ]
            );
        }
    }

    public function accept(Request $request)
    {
        try {
            $data = $this->taskRepository->acceptApplier($request);
            if ($data) {
                return response()->json(
                    [
                        'message' => 'applier accepted',
                        'success' => 1,
                    ], 200
                );
            } else {
                throw new Exception('failed to accept');
            }
        } catch (Exception $err) {
            return response()->json(
                [
                    'message' => $err->getMessage(),
                    'success' => 0,
                ]
            );
        }
    }

    public function reject(Request $request)
    {
        try {
            $data = $this->taskRepository->acceptApplier($request);
            if ($data) {
                return response()->json(
                    [
                        'message' => 'applier rejected',
                        'success' => 1,
                    ], 200
                );
            } else {
                throw new Exception('failed to reject');
            }
        } catch (Exception $err) {
            return response()->json(
                [
                    'message' => $err->getMessage(),
                    'success' => 0,
                ]
            );
        }
    }

    public function close(Request $request)
    {
        try {
            $data = $this->taskRepository->closeTask($request);
            if ($data) {
                return response()->json(
                    [
                        'message' => 'task closed',
                        'success' => 1,
                    ], 200
                );
            } else {
                throw new Exception('failed to close');
            }
        } catch (Exception $err) {
            return response()->json(
                [
                    'message' => $err->getMessage(),
                    'success' => 0,
                ]
            );
        }
    }
}
