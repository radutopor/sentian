<?php
/**
 * Go! OOP&AOP PHP framework
 *
 * @copyright     Copyright 2012, Lissachenko Alexander <lisachenko.it@gmail.com>
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

namespace Aspect;

use Go\Aop\Aspect;
use Go\Core\AspectKernel;
use Go\Aop\Intercept\FieldAccess;
use Go\Aop\Intercept\MethodInvocation;
use Go\Lang\Annotation\After;
use Go\Lang\Annotation\Before;
use Go\Lang\Annotation\Around;
use Go\Lang\Annotation\Pointcut;
use Carbon\Carbon;

/**
 * Test aspect
 */
class TestAspect implements Aspect
{
    public function __construct()
    {
        ob_start();
    }

    public function __destruct()
    {
        ob_end_flush();
    }

     /**
    * @param MethodInvocation $invocation Invocation
    * @Before("execution(public ApiController->getDoc(*))") // This is our PointCut
    */
     public function beforeMethodExecution1(MethodInvocation $invocation) {
      echo "Entering method " . $invocation->getMethod()->getName() . "()\n";
  }

    /**
    * @param MethodInvocation $invocation Invocation
    * @Before("execution(public Endpoint->call(*))") // This is our PointCut
    */
    public function beforeServiceCall(MethodInvocation $invocation) {
        $methodThis = $invocation->getThis();
        $service =  $methodThis->service()->first();
        $serviceName = $service->name;
        $serviceLimit = \DB::table('limits')->where('service_id', '=', $service->id)->first();
        
        \DB::table('limits')->where('service_id', '=', $service->id)->update(
           array('current_hits' => 0  )
           );
        $serviceLimit->current_hits = 0;
        
        
        $hasLimitBeenReached = $serviceLimit->current_hits >= $serviceLimit->max_hits;
        
        if( $hasLimitBeenReached)
        {
            echo "The limit number of calls for service \"" . $serviceName . "\" have been reached \n";
            echo "Method execution stoped";
            die();
        }
        \DB::table('limits')->where('service_id', '=', $service->id)->update(
           array('current_hits' => $serviceLimit->current_hits+1)
           );
        $methodName = $invocation->getMethod()->getName();
        $methodParams = implode(', ', $invocation->getArguments());

        // echo "Calling method " . $methodName . " with params : " . $methodParams . "\n";
        // echo "Method execution continues \n";
        // echo "Method result \n";
    }
}