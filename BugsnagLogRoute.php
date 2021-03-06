<?php
/**
 * @copyright Copyright (c) 2018 Ivan Orlov
 * @license   https://github.com/demisang/yii1-bugsnag/blob/master/LICENSE
 * @link      https://github.com/demisang/yii1-bugsnag#readme
 * @author    Ivan Orlov <gnasimed@gmail.com>
 */

namespace demi\bugsnag\yii1;

use Yii;
use CLogRoute;

/**
 * Bugsnag log route class
 * Send log messages to bugsnag
 */
class BugsnagLogRoute extends CLogRoute
{
    /**
     * Name of bugsnag component: Yii::app()->bugsnag
     *
     * @var string
     */
    public $bugsnagComponentName = 'bugsnag';
    /**
     * @inheritdoc
     */
    public $levels = 'error, warning';
    /**
     * Do not log exception messages
     *
     * @var array
     */
    public $except = ['exception.*'];

    /**
     * Send log messages to bugsnag.
     *
     * @param array $logs list of log messages
     *
     * @throws \Exception
     */
    protected function processLogs($logs)
    {
        /** @var \demi\bugsnag\yii1\BugsnagComponent $bugsnag */
        $bugsnag = Yii::app()->getComponent($this->bugsnagComponentName);

        foreach ($logs as $log) {
            list($message, $level, $category, $timestamp) = $log;

            $bugsnag->notifyError($category, $message, null, $level);
        }
    }
}
