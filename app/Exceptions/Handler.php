<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Traits\ApiResponse;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    
     use ApiResponse;

    protected $dontFlash = [
        // 'current_password',
        // 'password',
        // 'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */

     public function render($request, Throwable $exception){
        
        if($exception instanceof MethodNotAllowedHttpException){ //para errores de metodo no permitido
            return $this->errorResponse('El metodo especificado en la peticion no es valido', 405);
        }

        if($exception instanceof TokenMismatchException){ //para errores de token
            return redirect()->back()->withInput($request->input());
        }
        // if(config('app.debug')){   //si estamos en modo debug, se muestra el error
        //     return parent::render($request, $exception);
        // }
        // return $this->errorResponse('Falla inesperada. Intente luego', 500);
     }
}
